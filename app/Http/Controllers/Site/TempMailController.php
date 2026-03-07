<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\TempMailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Proxies temp-mail requests to the mail.tm API.
 *
 * All three endpoints are called by the front-end JavaScript in
 * resources/views/tools/partials/temp-mail.blade.php.
 *
 * Routes (defined in routes/web.php):
 *   POST  /tools/temp-mail/generate
 *   GET   /tools/temp-mail/inbox
 *   GET   /tools/temp-mail/message/{id}
 */
class TempMailController extends Controller
{
    public function __construct(private readonly TempMailService $service) {}

    /* ──────────────────────────────────────────────────────────────
       POST /tools/temp-mail/generate
       Pick a domain, register an account, obtain a JWT.
       Returns: { ok, address, password, token }
    ────────────────────────────────────────────────────────────── */
    public function generate(): JsonResponse
    {
        try {
            $credentials = $this->service->generateEmail();

            return response()->json([
                'ok'       => true,
                'address'  => $credentials['address'],
                'password' => $credentials['password'],
                'token'    => $credentials['token'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────────
       GET /tools/temp-mail/inbox
       Proxies GET /messages to mail.tm using the client's JWT.
       Expects: Authorization: Bearer <token>
       Returns: { ok, messages: [...] }
    ────────────────────────────────────────────────────────────── */
    public function inbox(Request $request): JsonResponse
    {
        $token = $this->extractToken($request);

        if (! $token) {
            return response()->json(['ok' => false, 'error' => 'Missing authentication token'], 401);
        }

        try {
            $messages = $this->service->getMessages($token);

            return response()->json(['ok' => true, 'messages' => $messages]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────────
       GET /tools/temp-mail/message/{id}
       Proxies GET /messages/{id} to mail.tm using the client's JWT.
       Expects: Authorization: Bearer <token>
       Returns: { ok, message: {...} }
    ────────────────────────────────────────────────────────────── */
    public function message(Request $request, string $id): JsonResponse
    {
        $token = $this->extractToken($request);

        if (! $token) {
            return response()->json(['ok' => false, 'error' => 'Missing authentication token'], 401);
        }

        try {
            $message = $this->service->getMessage($id, $token);

            return response()->json(['ok' => true, 'message' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────────
       HELPER
    ────────────────────────────────────────────────────────────── */

    /**
     * Pull the Bearer token from the Authorization header.
     * Falls back to a ?token= query param for convenience.
     */
    private function extractToken(Request $request): ?string
    {
        $header = $request->header('Authorization', '');

        if (str_starts_with($header, 'Bearer ')) {
            return substr($header, 7);
        }

        // Fallback: allow passing token as a query/body param
        return $request->input('token') ?: null;
    }
}
