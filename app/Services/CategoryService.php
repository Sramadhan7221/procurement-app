<?php

namespace App\Services;

use App\Constants\ApiUrl;
use App\DTOs\ApiResponse;

class CategoryService
{
    public function __construct(private ApiClient $client) {}

    public function datatable(array $params): ApiResponse
    {
        return $this->client->post(ApiUrl::CATEGORIES->value, $params);
    }

    public function create(array $data): ApiResponse
    {
        return $this->client->post(ApiUrl::CATEGORIES_CREATE->value, $data);
    }

    public function update(int|string $id, array $data): ApiResponse
    {
        return $this->client->put(ApiUrl::CATEGORIES_CREATE->value . '/' . $id, $data);
    }

    public function destroy(int|string $id): ApiResponse
    {
        return $this->client->delete(ApiUrl::CATEGORIES_CREATE->value . '/' . $id);
    }
}
