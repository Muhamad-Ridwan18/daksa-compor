<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\PdfExtractionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('author')->orderBy('published_date', 'desc')->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'description' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'published_date' => 'required|date',
            'is_new' => 'boolean',
            'document_file' => 'nullable|file|mimes:pdf|max:10240',
            'document_url' => 'nullable|url|max:255',
            'content_html' => 'nullable|string',
            'content_source' => 'nullable|in:pdf,manual',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:50',
            'source' => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:100',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'title',
            'document_number',
            'description',
            'excerpt',
            'published_date',
            'is_new',
            'document_url',
            'categories',
            'source',
            'document_type',
            'is_published',
        ]);
        
        $data['author_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title);
        
        // Handle content based on source
        $contentSource = $request->input('content_source', 'pdf');
        
        if ($contentSource === 'manual') {
            // Manual HTML input
            if ($request->filled('content_html')) {
                $data['content_html'] = $request->content_html;
            }
        } else {
            // PDF upload and extract
            if ($request->hasFile('document_file')) {
                $data['document_file'] = $request->file('document_file')->store('documents', 'public');
                
                // Extract text from PDF and convert to HTML
                $pdfExtractor = new PdfExtractionService();
                $data['content_html'] = $pdfExtractor->extractToHtml($data['document_file']);
            }
        }

        if ($request->is_published) {
            $data['published_at'] = now();
        }

        Document::create($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'description' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'published_date' => 'required|date',
            'is_new' => 'boolean',
            'document_file' => 'nullable|file|mimes:pdf|max:10240',
            'document_url' => 'nullable|url|max:255',
            'content_html' => 'nullable|string',
            'content_source' => 'nullable|in:pdf,manual',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:50',
            'source' => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:100',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'title',
            'document_number',
            'description',
            'excerpt',
            'published_date',
            'is_new',
            'document_url',
            'categories',
            'source',
            'document_type',
            'is_published',
        ]);
        
        $data['slug'] = Str::slug($request->title);
        
        // Handle content based on source
        $contentSource = $request->input('content_source', $document->document_file ? 'pdf' : 'manual');
        
        if ($contentSource === 'manual') {
            // Manual HTML input
            if ($request->filled('content_html')) {
                $data['content_html'] = $request->content_html;
            }
            // If switching from PDF to manual, don't delete PDF file (keep it for download)
        } else {
            // PDF upload and extract
            if ($request->hasFile('document_file')) {
                // Delete old file if exists
                if ($document->document_file) {
                    Storage::disk('public')->delete($document->document_file);
                }
                $data['document_file'] = $request->file('document_file')->store('documents', 'public');
                
                // Extract text from PDF and convert to HTML
                $pdfExtractor = new PdfExtractionService();
                $data['content_html'] = $pdfExtractor->extractToHtml($data['document_file']);
            }
        }

        // Set published_at when document is published for the first time
        if ($request->is_published && !$document->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if ($document->document_file) {
            Storage::disk('public')->delete($document->document_file);
        }
        
        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
