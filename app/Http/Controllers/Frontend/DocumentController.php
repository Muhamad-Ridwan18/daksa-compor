<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentDownload;
use App\Models\Setting;
use App\Services\PdfGenerationService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
     * View document (with tracking) - convert HTML to PDF dan download.
     */
    public function viewDocument(Request $request, $slug)
    {
        $document = Document::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Validate request
        $validator = Validator::make($request->all(), [
            'document_id' => 'required|uuid|exists:documents,id',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telpon' => 'required|string|max:20',
            'nama_perusahaan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Verify document_id matches the slug
        if ($document->id !== $request->document_id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'errors' => ['document_id' => ['Document ID tidak valid.']]
                ], 422);
            }
            abort(400, 'Document ID tidak valid');
        }

        // Save download record (tracking untuk view/download)
        DocumentDownload::create([
            'document_id' => $document->id,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telpon' => $request->no_telpon,
            'nama_perusahaan' => $request->nama_perusahaan,
        ]);

        // Generate PDF from HTML content
        if ($document->content_html) {
            $pdfService = new PdfGenerationService();
            $pdfContent = $pdfService->generateFromHtml($document->content_html, $document->title);
            
            $filename = $document->slug . '.pdf';
            
            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Length', strlen($pdfContent));
        }
        
        // Fallback: jika ada document_file, download file asli
        if ($document->document_file && Storage::disk('public')->exists($document->document_file)) {
            return Storage::disk('public')->download($document->document_file, $document->slug . '.pdf');
        }
        
        abort(404, 'Konten dokumen tidak tersedia.');
    }

    /**
     * Download PDF file.
     */
    public function downloadPdf(Request $request, $slug)
    {
        $document = Document::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Validate request if POST (with form data)
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'document_id' => 'required|uuid|exists:documents,id',
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_telpon' => 'required|string|max:20',
                'nama_perusahaan' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            // Verify document_id matches the slug
            if ($document->id !== $request->document_id) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'errors' => ['document_id' => ['Document ID tidak valid.']]
                    ], 422);
                }
                abort(400, 'Document ID tidak valid');
            }

            // Save download record
            DocumentDownload::create([
                'document_id' => $document->id,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telpon' => $request->no_telpon,
                'nama_perusahaan' => $request->nama_perusahaan,
            ]);
        }
        
        if ($document->document_file && Storage::disk('public')->exists($document->document_file)) {
            return Storage::disk('public')->download($document->document_file, $document->slug . '.pdf');
        }
        
        abort(404, 'File tidak ditemukan');
    }
}
