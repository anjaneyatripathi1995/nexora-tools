<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
