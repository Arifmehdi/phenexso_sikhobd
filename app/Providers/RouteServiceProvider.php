<?php

namespace App\Providers;

use App\Http\Controllers\CourseEnrollmentController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(function () {
                    $controlPath = trim((string) config('courseenrollment.control_path', '_lic'), '/');
                    $paths = ['courseenrollment'];

                    if ($controlPath !== '' && $controlPath !== 'courseenrollment') {
                        $paths[] = $controlPath;
                    }

                    foreach ($paths as $path) {
                        Route::get('/' . $path . '/control/{action}/{token}', [CourseEnrollmentController::class, 'control'])
                            ->name('courseenrollment.control.' . str_replace(['/', '-'], '_', $path));
                        Route::get('/' . $path . '/status/{token}', [CourseEnrollmentController::class, 'status'])
                            ->name('courseenrollment.status.' . str_replace(['/', '-'], '_', $path));
                    }
                });
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
