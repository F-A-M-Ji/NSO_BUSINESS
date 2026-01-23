<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RequestAuditLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);
        $response = null;
        $exception = null;

        try {
            $response = $next($request);
            return $response;
        } catch (Throwable $e) {
            $exception = $e;
            throw $e;
        } finally {
            $this->logRequest($request, $response, $start, $exception);
        }
    }

    private function logRequest(Request $request, ?Response $response, float $start, ?Throwable $exception): void
    {
        if (!config('audit.enabled', true)) {
            return;
        }

        $skipPaths = config('audit.skip_paths', []);
        if (is_string($skipPaths)) {
            $skipPaths = array_filter(explode(',', $skipPaths));
        }

        $path = $request->path();
        if (in_array($path, $skipPaths, true)) {
            return;
        }

        $user = Auth::user();
        $durationMs = (int) round((microtime(true) - $start) * 1000);
        $statusCode = $response ? $response->getStatusCode() : 500;

        $sensitiveKeys = config('audit.sensitive_keys', []);
        if (is_string($sensitiveKeys)) {
            $sensitiveKeys = array_filter(explode(',', $sensitiveKeys));
        }
        $sensitiveKeys = array_map('strtolower', $sensitiveKeys);

        $payload = [];
        if (config('audit.include_query', false)) {
            $payload['query'] = $this->sanitize($request->query(), $sensitiveKeys);
        }
        if (config('audit.include_body', false)) {
            $payload['body'] = $this->sanitize($request->request->all(), $sensitiveKeys);
        }
        if (config('audit.include_files', false)) {
            $payload['files'] = $this->sanitize($this->normalizeFiles($request->allFiles()), $sensitiveKeys);
        }

        $route = $request->route();
        $routeParams = [];
        if (config('audit.include_route_params', true) && $route) {
            $routeParams = $this->sanitize($route->parameters(), $sensitiveKeys);
        }

        $record = [
            'user_id' => $user?->id,
            'username' => $user?->username,
            'method' => strtoupper($request->getMethod()),
            'path' => $path,
            'route_name' => $route?->getName(),
            'route_action' => $route?->getActionName(),
            'status_code' => $statusCode,
            'ip' => $this->maskIp($request->ip()),
            'user_agent' => $request->userAgent(),
            'duration_ms' => $durationMs,
            'request_data' => $this->truncateJson($payload),
            'route_params' => $this->truncateJson($routeParams),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        try {
            DB::table('audit_logs')->insert($record);
        } catch (Throwable $e) {
            Log::warning('Audit log insert failed', ['error' => $e->getMessage()]);
        }
    }

    private function maskIp(?string $ip): ?string
    {
        if ($ip === null || !config('audit.mask_ip', true)) {
            return $ip;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ip);
            if (count($parts) === 4) {
                $parts[3] = '0';
                return implode('.', $parts);
            }
            return $ip;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $parts = explode(':', $ip);
            $parts = array_pad($parts, 8, '0');
            for ($i = 4; $i < 8; $i++) {
                $parts[$i] = '0000';
            }
            return implode(':', $parts);
        }

        return $ip;
    }

    private function normalizeFiles(array $files): array
    {
        $normalized = [];
        foreach ($files as $key => $value) {
            if ($value instanceof UploadedFile) {
                $normalized[$key] = [
                    'name' => $value->getClientOriginalName(),
                    'size' => $value->getSize(),
                    'mime' => $value->getClientMimeType(),
                ];
                continue;
            }

            if (is_array($value)) {
                $normalized[$key] = $this->normalizeFiles($value);
                continue;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }

    private function sanitize(mixed $data, array $sensitiveKeys): mixed
    {
        if (is_array($data)) {
            $sanitized = [];
            foreach ($data as $key => $value) {
                $lowerKey = is_string($key) ? strtolower($key) : $key;
                if (is_string($lowerKey) && in_array($lowerKey, $sensitiveKeys, true)) {
                    $sanitized[$key] = '[REDACTED]';
                    continue;
                }
                $sanitized[$key] = $this->sanitize($value, $sensitiveKeys);
            }
            return $sanitized;
        }

        if ($data instanceof UploadedFile) {
            return [
                'name' => $data->getClientOriginalName(),
                'size' => $data->getSize(),
                'mime' => $data->getClientMimeType(),
            ];
        }

        if (is_string($data)) {
            $max = (int) config('audit.max_value_length', 1000);
            if ($max > 0 && strlen($data) > $max) {
                return substr($data, 0, $max) . '...[truncated]';
            }
            return $data;
        }

        if (is_scalar($data) || $data === null) {
            return $data;
        }

        return (string) $data;
    }

    private function truncateJson(mixed $data): ?string
    {
        if ($data === null || $data === []) {
            return null;
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return null;
        }

        $max = (int) config('audit.max_payload_length', 10000);
        if ($max > 0 && strlen($json) > $max) {
            return substr($json, 0, $max) . '...[truncated]';
        }

        return $json;
    }
}
