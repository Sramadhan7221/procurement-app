<?php

namespace App\Services;

use App\Constants\ApiUrl;
use App\DTOs\ApiResponse;

class UserRoleService
{
    public function __construct(private ApiClient $client) {}

    public function userList(): ApiResponse
    {
        return $this->client->get(ApiUrl::USERS->value);
    }
}
