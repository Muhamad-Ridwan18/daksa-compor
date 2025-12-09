<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerationService
{
    /**
     * Generate PDF from HTML content.
     *
     * @param string $html HTML content
     * @param string $title Document title for filename
     * @return string PDF content as string
     */
    public function generateFromHtml($html, $title = 'document')
    {
        // Set options for DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isPhpEnabled', false);
        
        // Create DomPDF instance
        $dompdf = new Dompdf($options);
        
        // Wrap HTML with proper structure
        $fullHtml = $this->wrapHtml($html);
        
        // Load HTML
        $dompdf->loadHtml($fullHtml, 'UTF-8');
        
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Return PDF as string
        return $dompdf->output();
    }
    
    /**
     * Wrap HTML content with proper structure and styling.
     *
     * @param string $html Raw HTML content
     * @return string Wrapped HTML with styles
     */
    protected function wrapHtml($html)
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            padding: 20px;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-top: 1em;
            margin-bottom: 0.5em;
            font-weight: bold;
        }
        h1 { font-size: 18pt; }
        h2 { font-size: 16pt; }
        h3 { font-size: 14pt; }
        h4 { font-size: 12pt; }
        p {
            margin-bottom: 0.8em;
            text-align: justify;
        }
        p.text-center {
            text-align: center !important;
        }
        p.text-right {
            text-align: right !important;
        }
        ul, ol {
            margin-left: 30px;
            margin-bottom: 1em;
            padding-left: 20px;
        }
        ul {
            list-style-type: disc;
        }
        ol {
            list-style-type: decimal;
        }
        li {
            margin-bottom: 0.5em;
        }
        ul ul {
            list-style-type: circle;
            margin-left: 20px;
        }
        ul ul ul {
            list-style-type: square;
        }
        ol ol {
            list-style-type: lower-alpha;
        }
        ol ol ol {
            list-style-type: lower-roman;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        @page {
            margin: 2cm;
        }
    </style>
</head>
<body>
    ' . $html . '
</body>
</html>';
    }
}

