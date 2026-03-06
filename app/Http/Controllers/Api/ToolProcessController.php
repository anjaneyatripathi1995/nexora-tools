<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ToolProcessController extends Controller
{
    /**
     * Proxy for LanguageTool grammar check (avoids CORS).
     */
    public function grammarCheck(Request $request)
    {
        $text = $request->input('text', '');
        if (strlen($text) > 20000) {
            return response()->json(['matches' => [], 'error' => 'Text too long']);
        }
        try {
            $res = Http::asForm()->timeout(10)->post('https://api.languagetool.org/v2/check', [
                'text'     => $text,
                'language' => 'en',
            ]);
            if ($res->successful()) {
                return response()->json($res->json());
            }
            return response()->json(['matches' => [], 'error' => 'Grammar API unavailable']);
        } catch (\Throwable $e) {
            return response()->json(['matches' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Remove image background via remove.bg API when REMOVEBG_API_KEY is set.
     */
    public function backgroundRemover(Request $request)
    {
        $request->validate(['image' => 'required|file|image|max:10240']);
        $apiKey = config('services.removebg.api_key');
        if (empty($apiKey)) {
            return response()->json([
                'error' => 'Background removal is not configured. Add REMOVEBG_API_KEY to your .env file.',
            ], 503);
        }
        $file = $request->file('image');
        try {
            $response = Http::withHeaders(['X-Api-Key' => $apiKey])
                ->timeout(60)
                ->attach('image_file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post('https://api.remove.bg/v1.0/removebg', ['size' => 'auto']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Service error: ' . $e->getMessage()], 502);
        }
        if (!$response->successful()) {
            $body = $response->json();
            $msg  = $body['errors'][0]['title'] ?? $response->body();
            return response()->json(['error' => $msg], $response->status());
        }
        $contentType = $response->header('Content-Type') ?: 'image/png';
        return response($response->body(), 200, [
            'Content-Type'        => $contentType,
            'Content-Disposition' => 'attachment; filename="no-bg.png"',
        ]);
    }

    /**
     * Convert PDF to DOCX using local LibreOffice (soffice).
     * Responds with a temporary download URL.
     */
    public function pdfToWord(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:30720', // 30MB
        ]);

        // Ensure storage path
        $inputDir = storage_path('app/tmp');
        $outputDir = storage_path('app/public/conversions');
        if (!is_dir($inputDir)) mkdir($inputDir, 0775, true);
        if (!is_dir($outputDir)) mkdir($outputDir, 0775, true);

        $pdf = $request->file('file');
        $inputName = Str::uuid()->toString() . '.pdf';
        $inputPath = $inputDir . DIRECTORY_SEPARATOR . $inputName;
        $pdf->move($inputDir, $inputName);

        $outputName = pathinfo($inputName, PATHINFO_FILENAME) . '.docx';

        // Choose soffice command
        $soffice = env('SOFFICE_PATH', 'soffice');
        $process = new Process([
            $soffice,
            '--headless',
            '--convert-to', 'docx',
            '--outdir', $outputDir,
            $inputPath,
        ]);
        $process->setTimeout(60);

        try {
            $process->mustRun();
        } catch (\Throwable $e) {
            @unlink($inputPath);
            return response()->json([
                'error' => 'Conversion service unavailable. Install LibreOffice and set SOFFICE_PATH if needed. ' . $e->getMessage(),
            ], 503);
        }

        @unlink($inputPath);

        $outputPath = $outputDir . DIRECTORY_SEPARATOR . $outputName;
        if (!file_exists($outputPath)) {
            return response()->json(['error' => 'Conversion failed to produce output.'], 500);
        }

        // Make accessible via storage symlink (public/storage)
        $publicUrl = asset('storage/conversions/' . $outputName);

        // Optionally schedule cleanup later (simple TTL hint to frontend)
        return response()->json([
            'download_url' => $publicUrl,
            'filename' => $outputName,
            'message' => 'Conversion complete. Download your DOCX.',
        ]);
    }
}
