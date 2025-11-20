<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Setting;
use App\Services\SeoService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('author');
        
        // Search functionality
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }
        
        // Sorting functionality
        if ($request->sort === 'popular') {
            $query->orderBy('views', 'desc');
        } else {
            $query->orderBy('published_at', 'desc');
        }
        
        $articles = $query->paginate(3)->withQueryString();
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'blog.index', [
            'meta_title' => 'Blog - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Baca artikel terbaru dari ' . ($settings['company_name'] ?? 'Daksa'),
        ]);
        
        return view('frontend.blog.index', compact('articles', 'settings', 'seoData'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with(['author', 'approvedComments'])
            ->firstOrFail();
        
        // Increment views
        $article->incrementViews();
        
        // Get related articles
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
        
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data for article
        $seoData = SeoService::getArticleSeo($article, $settings);
        
        return view('frontend.blog.show', compact('article', 'relatedArticles', 'settings', 'seoData'));
    }

    public function storeComment(Request $request, Article $article)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'article_id' => $article->id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'is_approved' => true, // Needs admin approval
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Komentar Anda akan ditampilkan setelah disetujui admin.');
    }
}

