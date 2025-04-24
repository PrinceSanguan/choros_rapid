<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin_dashboard';

    /**
     * Role-specific home pages
     */
    public static function redirectTo()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check user role and redirect accordingly
        if ($user) {
            $position = $user->position;

            if ($position === 'admin') {
                return '/admin_dashboard';
            }

            if ($position === 'project-manager') {
                return '/projects/registration';
            } elseif ($position === 'accountant') {
                return '/billings';
            } elseif ($position === 'inventory-staff') {
                return '/inventory';
            } elseif ($position === 'supplier') {
                return '/projects';
            }
        }

        // Default redirect path
        return self::HOME;
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
