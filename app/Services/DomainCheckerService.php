<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Http;

class DomainCheckerService
{
    public function check($domain): array
    {
        $url = $this->normalizeUrl($domain->domain);

        try {
            $start = microtime(true);

            $response = $this->request($url, 'HEAD');

            // fallback если HEAD не работает
            if ($response->status() === 405 || $response->status() === 403) {
                $response = $this->request($url, 'GET');
            }

            $time = microtime(true) - $start;

            $status = $response->status();
            $success = $response->successful();

            Log::create([
                'domain_id' => $domain->id,
                'response_result' => $success,
                'response_code' => $status,
                'response_time' => round($time * 1000, 2),
            ]);

            return [
                'success' => true,
                'status' => $status,
                'reachable' => $success,
                'time_ms' => round($time * 1000, 2),
            ];

        } catch (\Throwable $e) {

            Log::create([
                'domain_id' => $domain->id,
                'response_result' => false,
                'response_error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status' => null,
                'reachable' => false,
                'time_ms' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function request(string $url, string $method)
    {
        return Http::timeout(10)
            ->withOptions([
                'allow_redirects' => true,
            ])
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120 Safari/537.36',
            ])
            ->send($method, $url);
    }

    private function normalizeUrl(string $domain): string
    {
        $domain = trim($domain);

        if (!preg_match('~^https?://~', $domain)) {
            $domain = 'https://' . $domain;
        }

        return $domain;
    }
}
