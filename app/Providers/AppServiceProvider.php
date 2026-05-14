<?php

namespace App\Providers;

use App\Services\ApiClient;
use App\Services\DivisionService;
use App\Services\UserRoleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiClient::class);

        $this->app->singleton(DivisionService::class);

        $this->app->singleton(UserRoleService::class);
    }

    public function boot(): void {}
}
