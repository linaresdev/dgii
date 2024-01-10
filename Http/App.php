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
    Dgii::addPath([
        "{cdn}"     => "{public}/cdn",
        "{assets}"  => "{dgii}/System/Public",
        "{hacienda}" => "{base}/Hacienda/",
    ]);

    ## URLS
    Dgii::addUrl([
        "{current}" => request()->path()
    ]);

    ## MIDDLEWARE
    $this->loadMiddleware( new \DGII\Http\Middleware\Handler() );

    ## Validations
    Validator::extend("isRnc", "\DGII\Http\Request\DgiiRequest@isRNC");
    Validator::extend("isEncf", "\DGII\Http\Request\DgiiRequest@isENCF");

    ## Entities Policies
    $entitiesPolicies = [
        "owner", "view", "insert", "update", "delete",
        "exceptOwner", 
    ];

    foreach($entitiesPolicies as $policy) {
        \Gate::define($policy, [\DGII\Http\Policy\User::class, $policy]);
        \Gate::define("ent-$policy", [\DGII\Http\Policy\Entity::class, $policy]);
    }


    ## Views 
    $this->loadViewsFrom(__DIR__.'/Views', 'dgii');

    ## NAVBAR SUPPORT
    $mainURL = '/';
    if( __segment(1, "admin") ) $mainURL = '/admin';
    Dgii::addUrl(["mainURL" => $mainURL]);

    ## Publishes
    $this->publishes([
        __path("{assets}") => __path("{public}"),
    ], "dgii");

endif;

