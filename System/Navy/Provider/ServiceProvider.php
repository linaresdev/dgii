<?php
namespace DGII\Navy\Provider;

/*
*---------------------------------------------------------
* ©IIPEC
* Santo Domingo República Dominicana.
*---------------------------------------------------------
*/

use DGII\Navy\Facade\Nav;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Translation\Translator;
use Illuminate\Support\ServiceProvider as Providers;

class ServiceProvider extends Providers {

    public function boot() {
        require_once( __DIR__."/../App.php" );
    }

    public function register() {
        $this->app->bind( "Nav", function($app) {
            return new \DGII\Navy\Support\Factory($app);
        });
    }
}