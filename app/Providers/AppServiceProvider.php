<?php

namespace App\Providers;

use App\View\Composers\AdminHeaderComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.admin-header', AdminHeaderComposer::class);

        // Laravel's built-in pagination view lives inside vendor/laravel/framework,
        // which is gitignored — so Tailwind's content scanner never sees the
        // utility classes it uses (h-5 w-5 etc.), and the prev/next arrow SVGs
        // render completely unstyled/unsized (the "giant arrow" bug). This app
        // also already has its own hand-built .pagination CSS in components.css
        // that a Tailwind-based view was never using anyway. Using our own
        // plain view for every ->links() call fixes both issues app-wide.
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');
    }
}
