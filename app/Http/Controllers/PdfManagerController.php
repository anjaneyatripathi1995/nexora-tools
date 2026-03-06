<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class PdfManagerController extends Controller
{
    /**
     * Generate a PDF from a Blade view and return the result as a stream response.
     *
     * @param  array  $data   Data that will be passed to the view
     * @param  string $view   The view name (dot notation) to render
     * @return \Illuminate\Http\Response
     */
    public function generateFromView(array $data, string $view = 'pdf.template'): Response
    {
        // ensure temp directory exists
        Storage::makeDirectory('temp');

        $pdf = Pdf::loadView($view, $data);

        // configure dompdf for shared hosting
        $pdf->setOptions([
            'isRemoteEnabled' => true,                     // allow remote images/URLs
            'tempDir'         => storage_path('app/temp'),  // writable temp path
            'chroot'          => storage_path('app'),       // restrict file access
        ]);

        return $pdf->stream();
    }

    /**
     * Merge several existing PDF files into one and return for download.
     *
     * @param  string[] $filePaths  Storage-relative paths of existing PDFs
     * @param  string   $filename   Download filename for the merged document
     * @return \Illuminate\Http\Response
     */
    public function mergePDFs(array $filePaths, string $filename = 'merged.pdf'): Response
    {
        $fpdi = new Fpdi();

        foreach ($filePaths as $relative) {
            $full = Storage::path($relative);
            $pageCount = $fpdi->setSourceFile($full);

            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($tpl);

                $fpdi->AddPage(
                    $size['orientation'],
                    [$size['width'], $size['height']]
                );
                $fpdi->useTemplate($tpl);
            }
        }

        $output = $fpdi->Output('S'); // return string

        return response($output, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
