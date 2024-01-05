<?php
namespace DGII\Providers;

/*
*---------------------------------------------------------
* ©IIPEC
* Santo Domingo República Dominicana.
*---------------------------------------------------------
*/

use DGII\Facade\Dgii;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Translation\Translator;
use Illuminate\Support\ServiceProvider;

class DGIIServiceProvider extends ServiceProvider {

    public function boot( Kernel $HTTP, Translator $LANG ) 
    {
        $this->http = $HTTP;
        $this->lang = $LANG;

        require_once(__DIR__."/../../Http/App.php");
    }

    public function register() {
        require_once(__DIR__."/../Common.php");
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

    public function loadGrammary($lang)
    {
        $this->app->setLocale($lang);

        if( is_object(($locale = anonymous(__path("{locale}/$lang.php"))) ) )
        {
            if( !empty(($grammaries = $locale->body())) ) {
                $this->lang->addLines($grammaries, $locale->header()["slug"]);
            }
        }
    }
}