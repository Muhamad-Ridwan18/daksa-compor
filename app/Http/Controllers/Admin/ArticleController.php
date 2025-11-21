<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10024',
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'is_published']);
        $data['author_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title);
        
        // Clean improper nested list structure from content
        if (isset($data['content'])) {
            $data['content'] = $this->cleanNestedListHtml($data['content']);
        }
        
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($request->is_published) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10024',
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'is_published']);
        $data['slug'] = Str::slug($request->title);
        
        // Clean improper nested list structure from content
        if (isset($data['content'])) {
            $data['content'] = $this->cleanNestedListHtml($data['content']);
        }
        
        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Set published_at when article is published for the first time
        if ($request->is_published && !$article->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('articles/images', 'public');
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }

    /**
     * Clean improper nested list HTML structure and remove unnecessary wrappers/styles
     * Removes <ol><li> at the beginning of content
     * Removes unnecessary div wrappers but keeps inline styles
     */
    private function cleanNestedListHtml($html)
    {
        // First, remove unnecessary div wrappers (especially pagelayer divs)
        $html = preg_replace('/<div[^>]*>\s*(<div[^>]*>\s*)?(<div[^>]*pagelayer[^>]*>)/i', '', $html);
        $html = preg_replace('/<\/div>\s*(<\/div>\s*)?(<\/div>\s*)?$/i', '', $html);
        
        // Remove pagelayer class and unnecessary attributes
        $html = preg_replace('/\s*class="[^"]*pagelayer[^"]*"/i', '', $html);
        $html = preg_replace('/\s*pagelayer-id="[^"]*"/i', '', $html);
        
        // Remove Tailwind CSS variables from inline styles but keep other styles
        $html = preg_replace_callback('/style="([^"]*)"/i', function($matches) {
            $style = $matches[1];
            // Remove Tailwind CSS variables
            $style = preg_replace('/--tw-[^;]*;?/i', '', $style);
            // Remove transition
            $style = preg_replace('/transition:\s*[^;]*;?/i', '', $style);
            // Remove width
            $style = preg_replace('/width:\s*[^;]*;?/i', '', $style);
            // Clean up
            $style = preg_replace('/;\s*;/', ';', $style);
            $style = trim($style, '; ');
            if (empty($style)) {
                return '';
            }
            return 'style="' . $style . '"';
        }, $html);
        
        // Remove empty style attributes
        $html = preg_replace('/\s*style="\s*"/i', '', $html);
        
        // Remove unnecessary div wrappers that only contain content
        $html = preg_replace('/<div[^>]*>\s*(<div[^>]*>\s*)?/i', '', $html);
        $html = preg_replace('/\s*<\/div>\s*(<\/div>\s*)?$/i', '', $html);
        
        // Remove <ol><li> at the beginning of content - unwrap the content
        // Pattern: <ol><li>content</li></ol> at start -> just content
        $html = preg_replace('/^<ol[^>]*>\s*<li[^>]*>(.*?)<\/li>\s*<\/ol>/is', '$1', $html);
        
        // Also handle multiple <li> in <ol> at the beginning - unwrap all content
        if (preg_match('/^<ol[^>]*>/i', $html)) {
            // Extract all <li> content
            preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $html, $matches);
            if (!empty($matches[1])) {
                $content = '';
                foreach ($matches[1] as $liContent) {
                    $liContent = trim($liContent);
                    if (!empty($liContent)) {
                        $content .= $liContent;
                    }
                }
                // Remove the <ol> wrapper and replace with unwrapped content
                $html = preg_replace('/^<ol[^>]*>.*?<\/ol>/is', $content, $html);
            }
        }
        
        // Use DOMDocument for more reliable HTML parsing
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        
        // Wrap in a container div to handle fragments
        $wrappedHtml = '<div>' . $html . '</div>';
        $dom->loadHTML(mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Remove unnecessary inline styles from all elements
        $xpath = new \DOMXPath($dom);
        $allElements = $xpath->query('//*[@style]');
        foreach ($allElements as $element) {
            $style = $element->getAttribute('style');
            // Remove Tailwind CSS variables
            $style = preg_replace('/--tw-[^;]*;?/i', '', $style);
            // Remove transition
            $style = preg_replace('/transition:\s*[^;]*;?/i', '', $style);
            // Remove width (usually from pagelayer)
            $style = preg_replace('/width:\s*[^;]*;?/i', '', $style);
            // Remove all CSS custom properties
            $style = preg_replace('/--[^;]*;?/i', '', $style);
            // Clean up
            $style = preg_replace('/;\s*;/', ';', $style);
            $style = trim($style, '; ');
            if (empty($style)) {
                $element->removeAttribute('style');
            } else {
                $element->setAttribute('style', $style);
            }
        }
        
        // Remove pagelayer class from all elements
        $allElementsWithClass = $xpath->query('//*[@class]');
        foreach ($allElementsWithClass as $element) {
            $class = $element->getAttribute('class');
            // Remove pagelayer classes
            $class = preg_replace('/\s*pagelayer[^\s]*/i', '', $class);
            $class = preg_replace('/\s*p-[^\s]*/i', '', $class);
            $class = trim($class);
            if (empty($class)) {
                $element->removeAttribute('class');
            } else {
                $element->setAttribute('class', $class);
            }
        }
        
        // Remove pagelayer-id attributes
        $allElementsWithId = $xpath->query('//*[@pagelayer-id]');
        foreach ($allElementsWithId as $element) {
            $element->removeAttribute('pagelayer-id');
        }
        
        // Remove empty div wrappers
        $divs = $xpath->query('//div');
        $divsToRemove = [];
        foreach ($divs as $div) {
            // Check if div has no attributes or only has removed attributes
            $hasAttributes = false;
            foreach ($div->attributes as $attr) {
                if ($attr->name !== 'style' && $attr->name !== 'class' && $attr->name !== 'pagelayer-id') {
                    $hasAttributes = true;
                    break;
                }
            }
            // If div has no meaningful attributes and is a wrapper, mark for removal
            if (!$hasAttributes && $div->parentNode && $div->parentNode->nodeName === 'div') {
                $divsToRemove[] = $div;
            }
        }
        
        // Remove wrapper divs
        foreach ($divsToRemove as $div) {
            $parent = $div->parentNode;
            while ($div->firstChild) {
                $parent->insertBefore($div->firstChild, $div);
            }
            $parent->removeChild($div);
        }

        // Find all ul elements
        $ulElements = $dom->getElementsByTagName('ul');
        $ulsToReplace = [];
        
        foreach ($ulElements as $ul) {
            $liElements = $ul->getElementsByTagName('li');
            
            // Check if ul has only one li
            if ($liElements->length === 1) {
                $li = $liElements->item(0);
                $childNodes = $li->childNodes;
                
                // Check if li has only one child which is an ol
                $olCount = 0;
                $olElement = null;
                $hasOtherContent = false;
                
                foreach ($childNodes as $child) {
                    if ($child->nodeType === XML_ELEMENT_NODE) {
                        if ($child->nodeName === 'ol') {
                            $olCount++;
                            $olElement = $child;
                        } else {
                            $hasOtherContent = true;
                        }
                    } elseif ($child->nodeType === XML_TEXT_NODE && trim($child->textContent) !== '') {
                        $hasOtherContent = true;
                    }
                }
                
                // If li contains only ol, replace ul with ol
                if ($olCount === 1 && !$hasOtherContent && $olElement) {
                    $ulsToReplace[] = ['ul' => $ul, 'ol' => $olElement];
                }
            }
        }
        
        // Replace ul with ol
        foreach ($ulsToReplace as $item) {
            $newOl = $item['ol']->cloneNode(true);
            $item['ul']->parentNode->replaceChild($newOl, $item['ul']);
        }

        // Get cleaned HTML from the wrapper div
        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body) {
            $cleanedHtml = '';
            foreach ($body->childNodes as $node) {
                $cleanedHtml .= $dom->saveHTML($node);
            }
        } else {
            $cleanedHtml = $dom->saveHTML();
        }
        
        // Final cleanup - remove any remaining wrapper divs
        $cleanedHtml = preg_replace('/^<div[^>]*>/i', '', $cleanedHtml);
        $cleanedHtml = preg_replace('/<\/div>$/i', '', $cleanedHtml);
        
        return trim($cleanedHtml);
    }
}

