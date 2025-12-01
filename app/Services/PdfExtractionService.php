<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class PdfExtractionService
{
    /**
     * Extract text from PDF file and convert to HTML.
     *
     * @param string $filePath Path to PDF file (storage path)
     * @return string HTML content
     */
    public function extractToHtml($filePath)
    {
        try {
            $fullPath = Storage::disk('public')->path($filePath);
            
            if (!file_exists($fullPath)) {
                return '';
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($fullPath);
            
            // Extract text from all pages
            $text = $pdf->getText();
            
            // Convert text to HTML with proper formatting
            $html = $this->formatTextToHtml($text);
            
            return $html;
        } catch (\Exception $e) {
            \Log::error('PDF Extraction Error: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Format plain text to HTML with proper structure.
     *
     * @param string $text Plain text from PDF
     * @return string Formatted HTML
     */
    protected function formatTextToHtml($text)
    {
        // Clean up text
        $text = trim($text);
        
        // Split into lines
        $lines = explode("\n", $text);
        
        $html = '<div class="document-content">';
        $inParagraph = false;
        $currentParagraph = '';
        $inList = false;
        $listType = null; // 'ol' or 'ul'
        $listItems = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip empty lines
            if (empty($line)) {
                if ($inParagraph) {
                    $html .= '<p>' . $this->escapeHtml($currentParagraph) . '</p>';
                    $currentParagraph = '';
                    $inParagraph = false;
                }
                // Close list if empty line
                if ($inList) {
                    $html .= $this->renderList($listType, $listItems);
                    $listItems = [];
                    $inList = false;
                    $listType = null;
                }
                continue;
            }
            
            // Check if line looks like a heading (all caps, short, or has specific patterns)
            if ($this->isHeading($line)) {
                if ($inParagraph) {
                    $html .= '<p>' . $this->escapeHtml($currentParagraph) . '</p>';
                    $currentParagraph = '';
                    $inParagraph = false;
                }
                // Close list if heading found
                if ($inList) {
                    $html .= $this->renderList($listType, $listItems);
                    $listItems = [];
                    $inList = false;
                    $listType = null;
                }
                // Center align headings that are likely titles
                $alignment = $this->detectAlignment($line);
                $html .= '<h2 class="text-xl font-bold mb-4 mt-6 ' . $alignment . '">' . $this->escapeHtml($line) . '</h2>';
                continue;
            }
            
            // Check if line is a numbered list item (1., 2., 3., etc.)
            if (preg_match('/^(\d+)[\.\)]\s+(.+)$/', $line, $matches)) {
                if ($inParagraph) {
                    $html .= '<p>' . $this->escapeHtml($currentParagraph) . '</p>';
                    $currentParagraph = '';
                    $inParagraph = false;
                }
                // If we were in a different list type, close it
                if ($inList && $listType !== 'ol') {
                    $html .= $this->renderList($listType, $listItems);
                    $listItems = [];
                }
                $inList = true;
                $listType = 'ol';
                $listItems[] = $matches[2]; // Store just the content without number
                continue;
            }
            
            // Check if line is a bullet list item (-, •, *, etc.)
            if (preg_match('/^([-•*])\s+(.+)$/', $line, $matches)) {
                if ($inParagraph) {
                    $html .= '<p>' . $this->escapeHtml($currentParagraph) . '</p>';
                    $currentParagraph = '';
                    $inParagraph = false;
                }
                // If we were in a different list type, close it
                if ($inList && $listType !== 'ul') {
                    $html .= $this->renderList($listType, $listItems);
                    $listItems = [];
                }
                $inList = true;
                $listType = 'ul';
                $listItems[] = $matches[2]; // Store just the content without bullet
                continue;
            }
            
            // If we're in a list but this line is not a list item, close the list
            if ($inList) {
                $html .= $this->renderList($listType, $listItems);
                $listItems = [];
                $inList = false;
                $listType = null;
            }
            
            // Check if line should be centered
            $alignment = $this->detectAlignment($line);
            
            // Regular paragraph text
            if (!$inParagraph) {
                $inParagraph = true;
                $currentParagraph = $line;
                $currentAlignment = $alignment;
            } else {
                // If alignment changes, close current paragraph
                if ($alignment !== $currentAlignment) {
                    $alignClass = $currentAlignment ? ' class="' . $currentAlignment . '"' : '';
                    $html .= '<p' . $alignClass . '>' . $this->escapeHtml($currentParagraph) . '</p>';
                    $currentParagraph = $line;
                    $currentAlignment = $alignment;
                } else {
                    $currentParagraph .= ' ' . $line;
                }
            }
        }
        
        // Close last paragraph
        if ($inParagraph && !empty($currentParagraph)) {
            $alignClass = isset($currentAlignment) && $currentAlignment ? ' class="' . $currentAlignment . '"' : '';
            $html .= '<p' . $alignClass . '>' . $this->escapeHtml($currentParagraph) . '</p>';
        }
        
        // Close any remaining list
        if ($inList) {
            $html .= $this->renderList($listType, $listItems);
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Detect text alignment based on patterns and content.
     *
     * @param string $line
     * @return string CSS class for alignment
     */
    protected function detectAlignment($line)
    {
        $lineLength = strlen($line);
        $lineUpper = strtoupper($line);
        
        // Center alignment patterns
        $centerPatterns = [
            // Document titles (all caps, relatively short)
            '/^(KEPUTUSAN|PERATURAN|SURAT EDARAN|PERATURAN MENTERI|KEPUTUSAN MENTERI)/i',
            // Lines with "TENTANG" (usually centered in Indonesian documents)
            '/^TENTANG$/i',
            // Document numbers (usually centered)
            '/^NOMOR\s+[0-9\/\-\.]+$/i',
            // Signatory lines (short, all caps)
            '/^(MENTERI|DIREKTUR|GUBERNUR|BUPATI|WALIKOTA)\s+[A-Z\s]+$/i',
            // Section headers that are short and all caps
            '/^(MENIMBANG|MENGINGAT|MEMUTUSKAN|MENETAPKAN):?$/i',
            // REPUBLIK INDONESIA (usually centered)
            '/^REPUBLIK INDONESIA$/i',
        ];
        
        foreach ($centerPatterns as $pattern) {
            if (preg_match($pattern, $line)) {
                return 'text-center';
            }
        }
        
        // Additional check: if line is all caps and relatively short, likely centered
        if ($lineUpper === $line && $lineLength < 80 && $lineLength > 5 && !preg_match('/[a-z]/', $line)) {
            // Exclude if it looks like a list item or numbered
            if (!preg_match('/^(\d+[\.\)]|[-•])/', $line)) {
                return 'text-center';
            }
        }
        
        // Check for short all-caps lines (likely centered titles)
        if ($lineUpper === $line && $lineLength < 60 && $lineLength > 3 && !preg_match('/[a-z]/', $line)) {
            // Exclude if it looks like a list item or numbered
            if (!preg_match('/^(\d+[\.\)]|[-•])/', $line)) {
                return 'text-center';
            }
        }
        
        // Right alignment patterns (less common in Indonesian documents)
        $rightPatterns = [
            // Dates at the end of line
            '/^\d{1,2}\s+(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)\s+\d{4}$/i',
        ];
        
        foreach ($rightPatterns as $pattern) {
            if (preg_match($pattern, $line)) {
                return 'text-right';
            }
        }
        
        // Default: left aligned
        return '';
    }

    /**
     * Check if a line looks like a heading.
     *
     * @param string $line
     * @return bool
     */
    protected function isHeading($line)
    {
        // All caps and relatively short
        if (strlen($line) < 100 && strtoupper($line) === $line && strlen($line) > 5) {
            return true;
        }
        
        // Common heading patterns
        $headingPatterns = [
            '/^(KEPUTUSAN|PERATURAN|SURAT EDARAN|PERATURAN MENTERI|KEPUTUSAN MENTERI)/i',
            '/^(Menimbang|Mengingat|Memutuskan|Menetapkan|Dasar Hukum)/i',
            '/^(Pasal \d+)/i',
            '/^(BAB \d+)/i',
        ];
        
        foreach ($headingPatterns as $pattern) {
            if (preg_match($pattern, $line)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Render list (ordered or unordered).
     *
     * @param string $type 'ol' or 'ul'
     * @param array $items Array of list item contents
     * @return string HTML list
     */
    protected function renderList($type, $items)
    {
        if (empty($items)) {
            return '';
        }
        
        $html = '<' . $type . ' class="mb-4 ml-6">';
        foreach ($items as $item) {
            $html .= '<li class="mb-2">' . $this->escapeHtml($item) . '</li>';
        }
        $html .= '</' . $type . '>';
        
        return $html;
    }

    /**
     * Escape HTML special characters.
     *
     * @param string $text
     * @return string
     */
    protected function escapeHtml($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

