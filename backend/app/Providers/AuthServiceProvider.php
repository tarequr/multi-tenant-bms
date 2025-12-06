<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Flat::class   => \App\Policies\FlatPolicy::class,
        \App\Models\Bill::class   => \App\Policies\BillPolicy::class,
        \App\Models\Tenant::class => \App\Policies\TenantPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
