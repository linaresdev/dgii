<?php

## DATABASE
$this->loadMigrationsFrom( __path("{migrations}") );

## ENVIRONMENT
if( env("APP_START") ):

    ## PATH
    Dgii::addPath([
        "{cdn}"     => "{public}/cdn",
        "{assets}"  => "{dgii}/System/Public"
    ]);

    ## URLS
    Dgii::addUrl([

    ]);
   
    ## MIDDLEWARE
    $this->loadMiddleware( new \DGII\Http\Middleware\Handler() );

    ## Validations
    Validator::extend("isRnc", "\DGII\Http\Request\DgiiRequest@isRNC");
    Validator::extend("isEncf", "\DGII\Http\Request\DgiiRequest@isENCF");

    ## Views 
    $this->loadViewsFrom(__DIR__.'/Views', 'dgii');

    ## Publishes
    $this->publishes([
        __path("{assets}") => __path("{public}"),
    ], "dgii");

endif;