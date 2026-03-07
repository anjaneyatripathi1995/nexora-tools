<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Server-side proxy for the mail.tm public API.
 *
 * All HTTP calls are made from the Laravel server, which eliminates
 * the browser CORS restriction that caused "No domains available".
 *
 * NOTE: mail.tm has changed its response format over time.
 *   - Old format: {"hydra:member": [...], "hydra:totalItems": N}
 *   - New format: plain JSON array [...]
 * extractList() handles both transparently.
 */
class TempMailService
{
    private const BASE    = 'https://api.mail.tm';
    private const TIMEOUT = 20;

    /* ──────────────────────────────────────────────────────────────
       PUBLIC INTERFACE
    ────────────────────────────────────────────────────────────── */

    /**
     * Full flow: pick a domain, create an account, obtain a JWT.
     * Returns ['address' => '...', 'password' => '...', 'token' => '...'].
     *
     * @throws \RuntimeException on any API failure
     */
    public function generateEmail(): array
    {
        $domains = $this->getDomains();

        if (empty($domains)) {
            throw new \RuntimeException('No domains available from mail.tm');
        }

        $domain   = $domains[array_rand($domains)]['domain'];
        $username = strtolower(Str::random(8)) . rand(100, 999);
        $address  = $username . '@' . $domain;
        $password = Str::random(16) . 'X!';

        $this->createAccount($address, $password);
        $token = $this->login($address, $password);

        return compact('address', 'password', 'token');
    }

    /**
     * Return messages for the authenticated inbox.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getMessages(string $token): array
    {
        $response = Http::timeout(self::TIMEOUT)
            ->acceptJson()
            ->withToken($token)
            ->get(self::BASE . '/messages');

        $this->assertOk($response, 'Failed to fetch messages');

        return $this->extractList($response->json());
    }

    /**
     * Return the full body of a single message.
     *
     * @return array<string, mixed>
     */
    public function getMessage(string $id, string $token): array
    {
        $response = Http::timeout(self::TIMEOUT)
            ->acceptJson()
            ->withToken($token)
            ->get(self::BASE . '/messages/' . $id);

        $this->assertOk($response, 'Failed to fetch message');

        return $response->json();
    }

    /* ──────────────────────────────────────────────────────────────
       INTERNAL HELPERS
    ────────────────────────────────────────────────────────────── */

    /**
     * Fetch available mail.tm domains (public method so controller can surface count).
     *
     * @return array<int, array<string, mixed>>
     */
    public function getDomains(): array
    {
        $response = Http::timeout(self::TIMEOUT)
            ->acceptJson()
            ->get(self::BASE . '/domains');

        $this->assertOk($response, 'Failed to fetch domains');

        return $this->extractList($response->json());
    }

    /**
     * Register a new mail.tm account.
     *
     * @throws \RuntimeException
     */
    public function createAccount(string $address, string $password): void
    {
        $response = Http::timeout(self::TIMEOUT)
            ->acceptJson()
            ->post(self::BASE . '/accounts', compact('address', 'password'));

        $this->assertOk(
            $response,
            $this->apiError($response) ?? 'Account creation failed'
        );
    }

    /**
     * Authenticate and return a JWT token.
     *
     * @throws \RuntimeException
     */
    public function login(string $address, string $password): string
    {
        $response = Http::timeout(self::TIMEOUT)
            ->acceptJson()
            ->post(self::BASE . '/token', compact('address', 'password'));

        $this->assertOk(
            $response,
            $this->apiError($response) ?? 'Authentication failed'
        );

        $token = $response->json('token');

        if (empty($token)) {
            throw new \RuntimeException('mail.tm returned an empty token');
        }

        return $token;
    }

    /**
     * Normalise the mail.tm list response.
     *
     * mail.tm has used two formats historically:
     *   New: plain array  → [{"domain":"…"}, …]
     *   Old: Hydra        → {"hydra:member": [{…}], "hydra:totalItems": N}
     *
     * @param  mixed  $body  decoded JSON
     * @return array<int, array<string, mixed>>
     */
    private function extractList(mixed $body): array
    {
        if (is_array($body)) {
            // Plain array (new format)
            if (array_is_list($body)) {
                return $body;
            }
            // Hydra envelope (old format)
            if (isset($body['hydra:member']) && is_array($body['hydra:member'])) {
                return $body['hydra:member'];
            }
        }
        return [];
    }

    /**
     * Extract a human-readable error message from a failed response.
     */
    private function apiError($response): ?string
    {
        $body = $response->json() ?? [];
        return $body['hydra:description'] ?? $body['detail'] ?? $body['message'] ?? null;
    }

    /**
     * Throw a RuntimeException if the response is not successful.
     *
     * @throws \RuntimeException
     */
    private function assertOk($response, string $fallbackMessage): void
    {
        if (! $response->successful()) {
            $detail = $this->apiError($response)
                ?? $fallbackMessage . ' (HTTP ' . $response->status() . ')';
            throw new \RuntimeException($detail);
        }
    }
}
