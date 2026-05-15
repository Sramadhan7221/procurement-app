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
        // API expects: { "ManagerUserId": "uuid", "IsApproved": bool, "Comment": "string" }
        // Ref: ManagerReviewProcurementRequestCommand.cs — Id injected from route
        return $this->client->put(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . '/manager-review', [
            'ManagerUserId' => $data['managerUserId'],
            'IsApproved'    => $data['isApproved'],
            'Comment'       => $data['comment'] ?? null,
        ]);
    }

    public function adminReview(string $id, array $data): ApiResponse
    {
        // API expects: { "AdminUserId": "uuid", "IsApproved": bool, "Comment": "string" }
        // Ref: AdminReviewProcurementRequestCommand.cs — Id injected from route
        return $this->client->put(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . '/admin-review', [
            'AdminUserId' => $data['adminUserId'],
            'IsApproved'  => $data['isApproved'],
            'Comment'     => $data['comment'] ?? null,
        ]);
    }

    public function progress(string $id, array $data): ApiResponse
    {
        // API expects: { "AdminUserId": "uuid", "NewStatus": integer }
        // Ref: UpdateProcurementProgressCommand.cs — Id injected from route
        // ProcurementStatus enum values: 6=InOrderByAdmin, 7=OrderReceived, 8=Completed
        return $this->client->put(ApiUrl::PROCUREMENT_REQUESTS->value . '/' . $id . '/progress', [
            'AdminUserId' => $data['adminUserId'],
            'NewStatus'   => (int) $data['status'],
        ]);
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
