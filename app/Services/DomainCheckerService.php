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

            $method = $domain->check_method ?? 'HEAD';
            $timeout = $domain->timeout ?? 5;

            $response = $this->request($url, $method, $timeout);

            if ($method === 'HEAD' && in_array($response->status(), [403, 405])) {
                $response = $this->request($url, 'GET', $timeout);
            }

            $timeMs = round((microtime(true) - $start) * 1000, 2);

            $status = $response->status();
            $success = $response->successful();

            Log::create([
                'domain_id' => $domain->id,
                'response_result' => $success,
                'response_code' => $status,
                'response_time' => $timeMs,
                'response_method' => $method,
            ]);

            $domain->update([
                'last_checked_at' => now(),
                'next_check_at' => now()->addMinutes($domain->check_interval),
            ]);

            return [
                'success' => true,
                'status' => $status,
                'reachable' => $success,
                'time_ms' => $timeMs,
                'method' => $method,
            ];

        } catch (\Throwable $e) {

            $timeMs = isset($start)
                ? round((microtime(true) - $start) * 1000, 2)
                : null;

            Log::create([
                'domain_id' => $domain->id,
                'response_result' => false,
                'response_error' => $e->getMessage(),
                'response_time' => $timeMs,
                'response_method' => $domain->check_method ?? 'HEAD',
            ]);

            $domain->update([
                'last_checked_at' => now(),
                'next_check_at' => now()->addMinutes($domain->check_interval),
            ]);

            return [
                'success' => false,
                'status' => null,
                'reachable' => false,
                'time_ms' => $timeMs,
                'error' => $e->getMessage(),
                'method' => $domain->check_method ?? 'HEAD',
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
