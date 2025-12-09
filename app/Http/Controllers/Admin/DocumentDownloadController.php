<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentDownload;
use Illuminate\Http\Request;

class DocumentDownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentDownload::with('document')->orderBy('created_at', 'desc');
        
        // Filter by document
        if ($request->filled('document_id')) {
            $query->where('document_id', $request->document_id);
        }
        
        // Search functionality
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_lengkap', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_perusahaan', 'like', "%{$searchTerm}%")
                  ->orWhere('no_telpon', 'like', "%{$searchTerm}%");
            });
        }
        
        $downloads = $query->paginate(20)->withQueryString();
        $documents = Document::orderBy('title')->get();
        
        return view('admin.document-downloads.index', compact('downloads', 'documents'));
    }

    public function show(DocumentDownload $documentDownload)
    {
        $documentDownload->load('document');
        return view('admin.document-downloads.show', compact('documentDownload'));
    }

    public function destroy(DocumentDownload $documentDownload)
    {
        $documentDownload->delete();
        return redirect()->route('admin.document-downloads.index')->with('success', 'Data tracking berhasil dihapus.');
    }
}

