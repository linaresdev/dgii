<?php

## IoC
$this->app->bind("Dgii", function($app){
    return new \DGII\Support\Dgii( new \DGII\Support\BootLoader($app) );
});

$this->app["dgii"] = Dgii::app();

## CONFIGS
$configs = $this->app["files"]->requireOnce(__DIR__."/Config/app.php");

foreach( $configs as $key => $value ) {
    $this->app["config"]->set("app.$key", $value);
}

## CORE LIBS
Dgii::app("load", new \DGII\Support\Loader($this->app));
Dgii::app("urls", new \DGII\Support\Urls($this->app));
Dgii::app("agent", new \DGII\Support\Guard($this->app));

## HELPERS
require_once(__DIR__."/Support/Helpers.php");

## PATHS
Dgii::addPath([
    "{base}"        => base_path(),
    "{private}"     => str_replace(base_path('/'), null, base_path("DGII")),
    "{public}"      => str_replace(base_path('/'), null, base_path("public/app")),
    "{dgii}"        => realpath(__DIR__."/../"),

    "{migrations}"  => "{dgii}/System/Database/Migration",
    "{seeds}"       => "{dgii}/System/Database/Seeders",
]);

## URLS
Dgii::addUrl([    
]);


## DRIVERS
if( env("APP_INSTALLED", FALSE) )
{
    Dgii::app("load")->run(new \DGII\Driver());
    Dgii::app("load")->run(new \DGII\User\Driver());
}
