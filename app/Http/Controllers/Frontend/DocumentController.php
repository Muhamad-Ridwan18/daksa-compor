<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Setting;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::published()->with('author');
        
        // Search functionality
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('document_number', 'like', "%{$searchTerm}%");
            });
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->whereJsonContains('categories', $request->category);
        }
        
        // Sorting
        $query->orderBy('published_date', 'desc');
        
        $documents = $query->paginate(10)->withQueryString();
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'documents.index', [
            'meta_title' => 'Dokumen & Peraturan - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Lihat dokumen dan peraturan terbaru',
        ]);
        
        return view('frontend.documents.index', compact('documents', 'settings', 'seoData'));
    }

    public function show($slug)
    {
        $document = Document::where('slug', $slug)
            ->published()
            ->with('author')
            ->firstOrFail();
        
        // Increment views
        $document->incrementViews();
        
        // Get related documents
        $relatedDocuments = Document::published()
            ->where('id', '!=', $document->id)
            ->orderBy('published_date', 'desc')
            ->limit(5)
            ->get();
        
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'documents.show', [
            'meta_title' => $document->title . ' - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $document->excerpt,
        ]);
        
        return view('frontend.documents.show', compact('document', 'relatedDocuments', 'settings', 'seoData'));
    }


    /**
     * Download PDF file.
     */
    public function downloadPdf($slug)
    {
        $document = Document::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        if ($document->document_file && Storage::disk('public')->exists($document->document_file)) {
            return Storage::disk('public')->download($document->document_file, $document->slug . '.pdf');
        }
        
        abort(404, 'File tidak ditemukan');
    }
}
