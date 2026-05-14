<?php

namespace App\Services;

use App\Constants\ApiUrl;
use App\DTOs\ApiResponse;

class RoleService
{
    public function __construct(private ApiClient $client) {}

    public function getDatatable(array $params): ApiResponse
    {
        return $this->client->post(ApiUrl::ROLES->value, $params);
    }

    public function createRole(array $data): ApiResponse
    {
        return $this->client->post(ApiUrl::ROLES_CREATE->value, $data);
    }

    public function getRole(string $id): ApiResponse
    {
        return $this->client->get(ApiUrl::ROLES_CREATE->value . '/' . $id);
    }

    public function updateRole(string $id, array $data): ApiResponse
    {
        return $this->client->put(ApiUrl::ROLES_CREATE->value . '/' . $id, $data);
    }

    public function deleteRole(string $id): ApiResponse
    {
        return $this->client->delete(ApiUrl::ROLES_CREATE->value . '/' . $id);
    }

    public function getRoleMenus(string $roleId): ApiResponse
    {
        return $this->client->get(ApiUrl::ROLES_CREATE->value . '/' . $roleId . '/menus');
    }

    public function assignMenus(string $roleId, array $menuIds): ApiResponse
    {
        return $this->client->post(ApiUrl::ROLES_CREATE->value . '/' . $roleId . '/menus', ['menuIds' => $menuIds]);
    }

    public function removeMenu(string $roleId, string $menuId): ApiResponse
    {
        return $this->client->delete(ApiUrl::ROLES_CREATE->value . '/' . $roleId . '/menus/' . $menuId);
    }

    public function availableMenus(): array
    {
        return [
            ['id' => 'dashboard', 'name' => 'Dashboard',  'group' => 'General'],
            ['id' => 'division',  'name' => 'Division',   'group' => 'Master Data'],
            ['id' => 'category',  'name' => 'Category',   'group' => 'Master Data'],
            ['id' => 'vendor',    'name' => 'Vendor',     'group' => 'Master Data'],
            ['id' => 'product',   'name' => 'Product',    'group' => 'Master Data'],
            ['id' => 'role',      'name' => 'Roles',      'group' => 'Settings'],
        ];
    }
}
