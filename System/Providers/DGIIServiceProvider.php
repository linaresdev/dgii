<?php
namespace DGII\Providers;

/*
*---------------------------------------------------------
* ©IIPEC
* Santo Domingo República Dominicana.
*---------------------------------------------------------
*/

use DGII\Facade\Dgii;
use Illuminate\Support\ServiceProvider;

class DGIIServiceProvider extends ServiceProvider {
    public function boot() {
        require_once(__DIR__."/../../Http/App.php");
    }

    public function register() {

        require_once(__DIR__."/../Common.php");

        //$this->app->register(\DGII\Providers\RouteServiceProvider::class);
    }

    public function loadMiddleware( $store )
    {
        ## STARTED
        if( !empty( ($started = $store->init() ) ) )
        {
            foreach($started as $middleware ) {
                $this->http->pushMiddleware( $middleware );
            }
        }

        ## GROUPS
        if( !empty( ( $groups = $store->groups() ) ) )
        {
            foreach( $groups as $name => $group ) {
                $this->app["router"]->middlewareGroup($name, $group);
            }
        }

        ## ROUTES
        if( !empty( ($routes = $store->routes() ) ) )
        {
            foreach($routes as $route => $middleware ) {
                $this->app["router"]->middleware( $route, $middleware );
            }
        }
    }
}