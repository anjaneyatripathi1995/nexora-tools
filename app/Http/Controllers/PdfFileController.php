<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PdfFileController extends Controller
{
    /**
     * Create a ZIP from uploaded files and return download.
     */
    public function zipCompressor(Request $request)
    {
        $request->validate(['files' => 'required', 'files.*' => 'file|max:51200']); // 50MB each

        $files = $request->file('files');
        if (empty($files)) {
            return back()->withErrors(['files' => 'Please select at least one file.']);
        }

        $tmpDir = storage_path('app/temp/zip-' . uniqid());
        @mkdir($tmpDir, 0755, true);
        $zipPath = $tmpDir . '/archive.zip';

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->withErrors(['files' => 'Could not create ZIP.']);
        }

        foreach ($files as $i => $file) {
            $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
        }
        $zip->close();

        $name = 'download.zip';
        $response = response()->download($zipPath, $name)->deleteFileAfterSend(true);
        @rmdir($tmpDir);
        return $response;
    }

    /**
     * Merge uploaded PDFs into one and return download.
     */
    public function pdfMerger(Request $request)
    {
        $request->validate(['files' => 'required', 'files.*' => 'file|mimes:pdf|max:20480']); // 20MB

        $files = $request->file('files');
        if (empty($files) || !class_exists(\setasign\Fpdi\Fpdi::class)) {
            return back()->withErrors(['files' => 'Select PDF files to merge. FPDI may not be installed.']);
        }

        try {
            $pdf = new \setasign\Fpdi\Fpdi();
            foreach ($files as $file) {
                $pageCount = $pdf->setSourceFile($file->getRealPath());
                for ($p = 1; $p <= $pageCount; $p++) {
                    $tpl = $pdf->importPage($p);
                    $pdf->AddPage();
                    $pdf->useTemplate($tpl, 0, 0, null, null, true);
                }
            }
            $tmpPath = storage_path('app/temp/merged-' . uniqid() . '.pdf');
            @mkdir(dirname($tmpPath), 0755, true);
            $pdf->Output('F', $tmpPath);

            return response()->download($tmpPath, 'merged.pdf')->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            return back()->withErrors(['files' => 'Merge failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Split PDF into one file per page (returned as ZIP).
     */
    public function splitPdf(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:pdf|max:20480']);

        $file = $request->file('file');
        if (!class_exists(\setasign\Fpdi\Fpdi::class)) {
            return back()->withErrors(['file' => 'FPDI is not installed.']);
        }

        try {
            $pdf = new \setasign\Fpdi\Fpdi();
            $pageCount = $pdf->setSourceFile($file->getRealPath());
            $tmpDir = storage_path('app/temp/split-' . uniqid());
            @mkdir($tmpDir, 0755, true);

            for ($p = 1; $p <= $pageCount; $p++) {
                $newPdf = new \setasign\Fpdi\Fpdi();
                $newPdf->setSourceFile($file->getRealPath());
                $tpl = $newPdf->importPage($p);
                $newPdf->AddPage();
                $newPdf->useTemplate($tpl, 0, 0, null, null, true);
                $newPdf->Output('F', $tmpDir . '/page-' . $p . '.pdf');
            }

            $zipPath = $tmpDir . '/split-pages.zip';
            $zip = new ZipArchive();
            $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            foreach (glob($tmpDir . '/*.pdf') as $f) {
                $zip->addFile($f, basename($f));
            }
            $zip->close();
            foreach (glob($tmpDir . '/*.pdf') as $f) @unlink($f);

            $response = response()->download($zipPath, 'split-pages.zip')->deleteFileAfterSend(true);
            @rmdir($tmpDir);
            return $response;
        } catch (\Throwable $e) {
            return back()->withErrors(['file' => 'Split failed: ' . $e->getMessage()]);
        }
    }
}
