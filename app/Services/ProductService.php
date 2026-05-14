<?php

namespace App\Services;

use App\Constants\ApiUrl;
use App\DTOs\ApiResponse;

class ProductService
{
    public function __construct(private ApiClient $client) {}

    public function datatable(array $params): ApiResponse
    {
        return $this->client->post(ApiUrl::PRODUCTS->value, $params);
    }

    public function create(array $data, array $files = []): ApiResponse
    {
        if (!empty($files)) {
            return $this->client->postMultipart(ApiUrl::PRODUCTS_CREATE->value, $data, $files);
        }

        return $this->client->post(ApiUrl::PRODUCTS_CREATE->value, $data);
    }

    public function update(int|string $id, array $data, array $files = []): ApiResponse
    {
        return $this->client->putMultipart(ApiUrl::PRODUCTS_CREATE->value . '/' . $id, $data, $files);
    }

    public function destroy(int|string $id): ApiResponse
    {
        return $this->client->delete(ApiUrl::PRODUCTS_CREATE->value . '/' . $id);
    }

    public function getCategories($search = null): ApiResponse
    {
        $params = $search ? ['name' => $search] : [];
        return $this->client->get(ApiUrl::CATEGORIES_CREATE->value, $params);
    }

    public function getVendors($searchQuery = null): ApiResponse
    {
        $params = $searchQuery ? ['searchQuery' => $searchQuery] : [];
        return $this->client->get(ApiUrl::VENDORS_CREATE->value, $params);
    }
}
