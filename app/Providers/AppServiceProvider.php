<?php

namespace App\Providers;

use App\Services\ApiClient;
use App\Services\CategoryService;
use App\Services\DivisionService;
use App\Services\ProcurementRequestService;
use App\Services\ProductService;
use App\Services\RoleService;
use App\Services\UserRoleService;
use App\Services\VendorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiClient::class);

        $this->app->singleton(DivisionService::class);
        $this->app->singleton(CategoryService::class);
        $this->app->singleton(VendorService::class);
        $this->app->singleton(ProductService::class);
        $this->app->singleton(RoleService::class);
        $this->app->singleton(UserRoleService::class);
        $this->app->singleton(ProcurementRequestService::class);
    }

    public function boot(): void {}
}
