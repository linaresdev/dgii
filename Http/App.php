<?php

## IoC
$this->app->bind("Alert", function($app) {
    return new \DGII\Support\Alert($app);
});

## GRAMMARIES
$this->loadGrammary("es");

## DATABASE
$this->loadMigrationsFrom( __path("{migrations}") );

##CONSOLER
if( $this->app->runningInConsole() ):
    if( is_object( ($console = anonymous(__path("{system}/Console/Handle.php"))) ) ):
        $this->commands($console->commands());
    endif;
endif;

## ENVIRONMENT
if( env("APP_START") ):

    ## CONFIG ELOQUENT PROVIDERS
    $this->app["config"]->set(
        "auth.providers.users.model", \DGII\User\Model\Store::class
    );

    ## PATH
    $entity = __segment(2);
    $env    = env("DGII_ENV");
    $year   = now()->format("Y");
    $month  = now()->format("m");

    Dgii::addPath([
        "{cdn}"                 => "{public}/cdn",
        "{assets}"              => "{dgii}/System/Public",
        "{hacienda}"            => "{base}/Hacienda",
        "{AprobacionComercial}" => "{hacienda}/$entity/$env/AprobacionComercial/$year/$month",
        "{Recepcion}"           => "{hacienda}/$entity/$env/Recepcion/$year/$month",
        "{ARECF}"               => "{hacienda}/$entity/$env/ARECF/$year/$month",
        "{ACECF}"               => "{hacienda}/$entity/$env/ACECF/$year/$month",
    ]);

    ## URLS
    Dgii::addUrl([
        "{current}" => request()->path(),        
    ]);

    ## DGII PATH 
    Dgii::addPath([
        "{dgii}"                => env('DGII_DOMAIN').'/'.env('DGII_ENV'),
        "{dgii_get_seed}"       => '{dgii}/'.env('DGII_URL_SEED'),
        "{dgii_post_auth}"      => '{dgii}/'.env('DGII_URL_AUTH'),
        "{dgii_client_info}"    => '{dgii}/'.env('DGII_CLIENT_INFO'),
    ]);

    ## MIDDLEWARE
    $this->loadMiddleware( new \DGII\Http\Middleware\Handler() );

    ## Validations
    Validator::extend("isRnc", "\DGII\Http\Request\DgiiRequest@isRNC");
    Validator::extend("encf", "\DGII\Http\Request\DgiiRequest@isENCF");    
    
    ## Entities Policies
    $entitiesPolicies = [
        "owner", "view", "insert", "update", "delete",
        "exceptOwner", 
    ];

    foreach($entitiesPolicies as $policy) {
        \Gate::define($policy, [\DGII\Http\Policy\User::class, $policy]);
        \Gate::define("ent-$policy", [\DGII\Http\Policy\Entity::class, $policy]);
    }

    /*
    * API POLICIES */
    \Gate::define("isexpire", [\DGII\Http\Policy\EntityGuard::class, "isExpire"]);

    ## Views 
    $this->loadViewsFrom(__DIR__.'/Views', 'dgii');

    ## PAGIANATOR
    Illuminate\Pagination\Paginator::useBootstrap();

    ## MENU ADMIN ENTITY
    Nav::save(function($nav)
    {
        $seg2 = __segment(2);

        $nav->add("group", "Area nav 0");
        $nav->add("tag", "entity-contab");
        $nav->add("route", "entity*");

        $nav->addFilters("style", [
            ":node0" => "nav"
        ]);
        
        if( count(__segment()) >= 2 )
        {
            $nav->addItem([
                "icon"   => "mdi mdi-file-document-multiple-outline",
                "label"  => "ECF",
                "url"    => "entity/$seg2"
            ]);
    
            $nav->addItem([
                "icon"   => "mdi mdi-file-document-multiple-outline",
                "label"  => "ARECF",
                "url"    => "entity/$seg2/arecf"
            ]);
    
            $nav->addItem([
                "icon"   => "mdi mdi-file-document-multiple-outline",
                "label"  => "ACECF",
                "url"    => "entity/$seg2/acecf"
            ]);
        }
    });


    ## NAVBAR SUPPORT
    $mainURL = '/';
    if( __segment(1, "admin") ) $mainURL = '/admin';
    Dgii::addUrl(["mainURL" => $mainURL]);

    ## Publishes
    $this->publishes([
        __path("{assets}") => __path("{public}"),
    ], "dgii");

endif;
//dd(openssl_get_md_methods(true));
//RSA-SHA256