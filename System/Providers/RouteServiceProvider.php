<?php
namespace DGII\Providers;

/*
*---------------------------------------------------------
* ©IIPEC
* Santo Domingo República Dominicana.
*---------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    public function boot() {
        parent::boot();
    }

    public function map() {
        Route::prefix('app')->group(base_path('path/users.php'));
    }

}