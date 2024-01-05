<?php

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

