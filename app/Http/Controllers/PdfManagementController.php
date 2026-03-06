<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class PdfManagementController extends Controller
{
    /**
     * Generate a PDF from a Blade view and stream it.
     *
     * @param array $data  Data to pass into the view
     * @param string $view Blade view name (default: pdf.sample)
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function generateFromView(array $data, string $view = 'pdf.sample')
    {
        // Shared hosting: keep DomPDF within storage for temp and chroot.
        config([
            'dompdf.options.tempDir' => storage_path('app/tmp'),
            'dompdf.options.chroot'  => storage_path('app'),
        ]);

        Storage::makeDirectory('tmp');

        $pdf = Pdf::loadView($view, $data);
        return $pdf->stream('document.pdf');
    }

    /**
     * Merge multiple existing PDFs into a single PDF using FPDI.
     *
     * @param array $filePaths Absolute paths or storage-relative paths.
     * @return string Path to merged PDF inside storage/app/tmp
     */
    public function mergePDFs(array $filePaths): string
    {
        $storageRoot = storage_path('app');
        $tmpDir = storage_path('app/tmp');
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0775, true);
        }

        $outputPath = $tmpDir . '/merged-' . uniqid() . '.pdf';
        $fpdi = new Fpdi();

        foreach ($filePaths as $path) {
            $fullPath = str_starts_with($path, $storageRoot)
                ? $path
                : $storageRoot . '/' . ltrim($path, '/');

            if (!file_exists($fullPath)) {
                continue; // skip missing files; change to throw if desired
            }

            $pageCount = $fpdi->setSourceFile($fullPath);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }
        }

        $fpdi->Output($outputPath, 'F');
        return $outputPath;
    }
}
