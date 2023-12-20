<?php

## DATABASE
$this->loadMigrationsFrom( __path("{migrations}") );

## ENVIRONMENT
if( env("APP_START") ):
   
    ## MIDDLEWARE
    $this->loadMiddleware( new \DGII\Http\Middleware\Handler() );

    ## Validations
    Validator::extend("isRnc", "\DGII\Http\Request\DgiiRequest@isRNC");
    Validator::extend("isEncf", "\DGII\Http\Request\DgiiRequest@isENCF");

    ## Views 
    $this->loadViewsFrom(__DIR__.'/Views', 'dgii');

endif;