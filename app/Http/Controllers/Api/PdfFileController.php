<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;

class PdfFileController extends Controller
{
    /**
     * Create a ZIP from uploaded files and return download.
     */
    public function zipCompressor(Request $request)
    {
        $request->validate(['files' => 'required', 'files.*' => 'file|max:51200']);

        $files = $request->file('files');
        if (is_array($files)) {
            $files = array_values($files);
        } else {
            $files = $files ? [$files] : [];
        }
        if (empty($files)) {
            return back()->withErrors(['files' => 'Please select at least one file.']);
        }

        $tmpDir = storage_path('app/temp/zip-' . uniqid());
        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0755, true);
        }
        $zipPath = $tmpDir . '/archive.zip';

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->withErrors(['files' => 'Could not create ZIP.']);
        }

        foreach ($files as $file) {
            $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
        }
        $zip->close();

        $response = response()->download($zipPath, 'download.zip')->deleteFileAfterSend(true);
        @rmdir($tmpDir);
        return $response;
    }
}
