<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider AS ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Models\User;
use App\Policies\DashboardPolicy;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\ItemPenjualan;
use App\Policies\ItemPenjualanPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\ProdukPolicy;
use App\Models\Kategori;
use App\Policies\KategoriPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Policy mappings for the application.
     */
    protected $policies = [
        Produk::class=> ProdukPolicy::class,
        Penjualan::class => PenjualanPolicy::class,
        ItemPenjualan::class => ItemPenjualanPolicy::class,
        Kategori::class => KategoriPolicy::class
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');
        $this->registerPolicies();

        Gate::define('viewRevenue', function ($user) {
            return $user->role->name === 'admin';
        });

    }
}