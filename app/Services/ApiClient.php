<?php

namespace App\Services;

use App\DTOs\ApiResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiClient
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.url');
    }

    public function get(string $endpoint, array $query = []): ApiResponse
    {
        return $this->send('get', $endpoint, $query);
    }

    public function post(string $endpoint, array $data = []): ApiResponse
    {
        return $this->send('post', $endpoint, $data);
    }

    public function put(string $endpoint, array $data = []): ApiResponse
    {
        return $this->send('put', $endpoint, $data);
    }

    public function patch(string $endpoint, array $data = []): ApiResponse
    {
        return $this->send('patch', $endpoint, $data);
    }

    public function delete(string $endpoint, array $data = []): ApiResponse
    {
        return $this->send('delete', $endpoint, $data);
    }

    public function postMultipart(string $endpoint, array $data = [], array $files = []): ApiResponse
    {
        return $this->sendMultipart('post', $endpoint, $data, $files);
    }

    public function putMultipart(string $endpoint, array $data = [], array $files = []): ApiResponse
    {
        return $this->sendMultipart('put', $endpoint, $data, $files);
    }

    private function sendMultipart(string $method, string $endpoint, array $data = [], array $files = []): ApiResponse
    {
        try {
            $multipart = [];

            foreach ($data as $key => $value) {
                $multipart[] = ['name' => $key, 'contents' => (string) ($value ?? '')];
            }

            foreach ($files as $name => $file) {
                $multipart[] = [
                    'name'     => $name,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            }

            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->baseUrl($this->baseUrl)
                ->asMultipart()
                ->$method($endpoint, $multipart);

            if ($response->failed()) {
                $this->logError($endpoint, $response);
                return ApiResponse::failure($response->body(), $response->status());
            }

            return ApiResponse::success($this->parseData($response), $response->status());
        } catch (\Exception $e) {
            Log::error("API Error at {$endpoint}: " . $e->getMessage());
            return ApiResponse::failure($e->getMessage());
        }
    }

    private function send(string $method, string $endpoint, array $data = []): ApiResponse
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->baseUrl($this->baseUrl)
                ->$method($endpoint, $data);

            if ($response->failed()) {
                $this->logError($endpoint, $response);
                return ApiResponse::failure($response->body(), $response->status());
            }

            return ApiResponse::success($this->parseData($response), $response->status());
        } catch (\Exception $e) {
            Log::error("API Error at {$endpoint}: " . $e->getMessage());
            return ApiResponse::failure($e->getMessage());
        }
    }

    private function parseData(Response $response)
    {
        $body = $response->json();
        return $body['data'] ?? [];
    }



    private function logError(string $endpoint, Response $response): void
    {
        Log::error('API Request Failed', [
            'endpoint' => $endpoint,
            'status'   => $response->status(),
            'body'     => $response->body(),
        ]);
    }
}
