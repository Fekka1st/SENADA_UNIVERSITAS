<?php

namespace App\Providers;

use App\View\Composers\PengaturanComposer;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        // share data pengaturan untuk semua view
        View::composer('*', PengaturanComposer::class);

        // Pagination
        Paginator::useBootstrapFive();

        // Localization Carbon
        Carbon::setLocale(config('app.locale'));

        // Blade directive untuk permissions
        Blade::if('permission', function ($permission) {
            return Auth::check() && Auth::user()->hasPermission($permission);
        });

        // Blade directive untuk multiple permissions (any)
        Blade::if('anypermission', function (...$permissions) {
            return Auth::check() && Auth::user()->hasAnyPermission($permissions);
        });

        // Blade directive untuk multiple permissions (all)
        Blade::if('allpermissions', function (...$permissions) {
            return Auth::check() && Auth::user()->hasAllPermissions($permissions);
        });
    }
}
