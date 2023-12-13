<?php
namespace DGII\Providers;

/*
*---------------------------------------------------------
* ©IIPEC
* Santo Domingo República Dominicana.
*---------------------------------------------------------
*/

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {

    public const HOME = '/home';

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(__DIR__."/../../Http/Routes/Api.php");

            Route::middleware('web')
                ->group(__DIR__."/../../Http/Routes/Web.php");
        });
    }

}