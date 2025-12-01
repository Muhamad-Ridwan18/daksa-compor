<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Services\PdfExtractionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ReExtractDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:re-extract {--id= : Re-extract specific document ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-extract HTML content from PDF files with improved alignment detection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pdfExtractor = new PdfExtractionService();
        
        if ($this->option('id')) {
            $documents = Document::where('id', $this->option('id'))->get();
        } else {
            $documents = Document::whereNotNull('document_file')->get();
        }
        
        if ($documents->isEmpty()) {
            $this->info('No documents found to re-extract.');
            return;
        }
        
        $this->info("Found {$documents->count()} document(s) to re-extract.");
        
        $bar = $this->output->createProgressBar($documents->count());
        $bar->start();
        
        $success = 0;
        $failed = 0;
        
        foreach ($documents as $document) {
            try {
                if (!Storage::disk('public')->exists($document->document_file)) {
                    $this->newLine();
                    $this->warn("PDF file not found for document: {$document->title}");
                    $failed++;
                    $bar->advance();
                    continue;
                }
                
                $html = $pdfExtractor->extractToHtml($document->document_file);
                
                if (!empty($html)) {
                    $document->content_html = $html;
                    $document->save();
                    $success++;
                } else {
                    $this->newLine();
                    $this->warn("Failed to extract content for: {$document->title}");
                    $failed++;
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Error processing {$document->title}: " . $e->getMessage());
                $failed++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        $this->info("Re-extraction complete!");
        $this->info("Success: {$success}, Failed: {$failed}");
    }
}
