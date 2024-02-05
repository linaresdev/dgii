<?php
namespace DGII\Console\Command\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Install {

    public function make($app)
    {
        $app->info(" DELTA COMERCIAL, S. A.");
        $app->info(" ".__("install.description"));
        $app->info( ' '.str_repeat("==", 25) );

        if( env("APP_START") == true ) {
            return $app->error(' '.__("install.installed").'!');
        }
        
        ## Configuramos el ambiente de trabajo.
        $this->makeConfig();

        ## Lanzamos las migraciones
        $this->runMigrate();

        ## Instalamos los datos basicos
        $this->runSeeds();
    }

    public function makeConfig(){}

    public function runMigrate(){
        \Artisan::call("migrate");
    }

    public function runSeeds(){
        \Artisan::call("db:seed", ["--class" => \DGII\Database\Seeds\DGIISeeds::class]);
    }
}