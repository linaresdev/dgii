<?php

## DATABASE
$this->loadMigrationsFrom( __path("{migrations}") );

## ENVIRONMENT
if( env("APP_START") ):
   
    ## MIDDLEWARE
    $this->loadMiddleware( new \DGII\Http\Middleware\Handler() );

endif;