<?php

namespace App\DTOs;

readonly class ApiResponse
{
    public function __construct(
        public bool $success,
        public mixed $data,
        public ?string $message = null,
        public int $statusCode = 200,
    ) {}

    public static function success(mixed $data, int $statusCode = 200): self
    {
        return new self(success: true, data: $data, statusCode: $statusCode);
    }

    public static function failure(string $message, int $statusCode = 500): self
    {
        return new self(success: false, data: null, message: $message, statusCode: $statusCode);
    }
}
