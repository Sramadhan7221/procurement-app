<?php

namespace App\Services;

use App\Constants\ApiUrl;
use App\DTOs\ApiResponse;

class ProcurementRequestService
{
    public function __construct(private ApiClient $client) {}

    public function datatable(array $params): ApiResponse
    {
        return $this->client->post(ApiUrl::PROCUREMENT_REQUESTS_DATATABLE->value, $params);
    }

    public function create(array $data): ApiResponse
    {
        return $this->client->post(ApiUrl::PROCUREMENT_REQUESTS->value, $data);
    }

    public function find(string $id): ApiResponse
    {
        return $this->client->get(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id);
    }

    public function managerReview(string $id, array $data): ApiResponse
    {
        return $this->client->put(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . '/manager-review', $data);
    }

    public function adminReview(string $id, array $data): ApiResponse
    {
        return $this->client->put(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . '/admin-review', $data);
    }

    public function progress(string $id, array $data): ApiResponse
    {
        return $this->client->put(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . '/progress', $data);
    }

    public function productsDataTable(array $params): ApiResponse
    {
        return $this->client->post(ApiUrl::PRODUCTS->value, $params);
    }

    public function getCategories(): ApiResponse
    {
        return $this->client->get(ApiUrl::CATEGORIES_CREATE->value);
    }
}
