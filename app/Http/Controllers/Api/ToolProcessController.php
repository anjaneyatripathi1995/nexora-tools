<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

// additional PDF/Word libraries
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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
        // verify upload
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:30720', // 30MB
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        // attempt to convert using LibreOffice (soffice) which does a much
        // better job preserving layout. if the binary isn't available or the
        // conversion fails we'll fall back to either an external API or simple
        // text parser.
        $targetDir       = storage_path('app/temp');
        $uuid            = Str::uuid();
        $outputPath      = "$targetDir/{$uuid}.docx";
        $soffice         = config('nexora.soffice_path', 'soffice');
        $fallbackWarning = null;

        try {
            $process = new Process([$soffice, '--headless', '--convert-to', 'docx', '--outdir', $targetDir, $path]);
            $process->setTimeout(300); // allow a few minutes for large files
            $process->run();

            if ($process->isSuccessful() && file_exists($outputPath)) {
                $response = response()->download($outputPath, 'converted.docx');
                if ($fallbackWarning) {
                    $response->headers->set('X-Fallback-Warning', $fallbackWarning);
                }
                $response->deleteFileAfterSend(true);
                return $response;
            }

            throw new \RuntimeException('LibreOffice conversion failed: ' . ($process->getErrorOutput() ?: $process->getOutput()));
        } catch (\Throwable $e) {
            // log and continue - we may have an external service configured
            \Log::warning('soffice conversion failed, considering alternatives', ['error' => $e->getMessage()]);
            $fallbackWarning = 'LibreOffice not available or failed; attempting online service.';
        }

        // if an external conversion service is configured, try that next
        $apiKey = config('services.pdf2word.api_key');
        if (!empty($apiKey)) {
            try {
                // CloudConvert example; you could adapt to any REST API.
                $client = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept'        => 'application/json',
                ])->timeout(120);

                $resp = $client->attach('file', file_get_contents($path), $file->getClientOriginalName())
                    ->post(config('services.pdf2word.endpoint', 'https://api.cloudconvert.com/v2/convert'), [
                        'inputformat'  => 'pdf',
                        'outputformat' => 'docx',
                    ]);

                if ($resp->successful() && isset($resp['data']['output']['url'])) {
                    // fetch converted file
                    $fileUrl = $resp['data']['output']['url'];
                    $fileResp = Http::timeout(120)->get($fileUrl);
                    if ($fileResp->successful()) {
                        // build download response
                        $download = response($fileResp->body(), 200, [
                            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'Content-Disposition' => 'attachment; filename="converted.docx"',
                        ]);
                        if (!empty($fallbackWarning)) {
                            $download->headers->set('X-Fallback-Warning', $fallbackWarning . ' (used online service)');
                        }
                        return $download;
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('external pdf2word service failed', ['error' => $e->getMessage()]);
                // fall through to text parser if service didn't work
            }
        }

        // Parse PDF text with Smalot/pdfparser as a fallback
        try {
            $parser = new Parser();
            $pdf    = $parser->parseFile($path);
            $text   = $pdf->getText();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Unable to read PDF: ' . $e->getMessage()], 500);
        }

        // create a Word document using PhpWord
        try {
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();

            // break text into lines to preserve some formatting
            foreach (preg_split('/\r?\n/', trim($text)) as $line) {
                $section->addText($line);
            }

            $docxPath = storage_path('app/temp/' . Str::uuid() . '.docx');
            $writer   = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($docxPath);

            $response = response()->download($docxPath, 'converted.docx');
            if (!empty($fallbackWarning)) {
                $response->headers->set('X-Fallback-Warning', $fallbackWarning);
            }
            $response->deleteFileAfterSend(true);
            return $response;
        } catch (\Throwable $e) {
            // log for later inspection, but return JSON so front‑end can surface message
            \Log::error('pdfToWord write failed', ['exception' => $e]);
            return response()->json(['error' => 'Failed to generate DOCX: ' . $e->getMessage()], 500);
        }
    }
}
