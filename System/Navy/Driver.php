<?php
namespace DGII\Navy;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Driver {

    public function info() {
        return [
          "name"		    => "Navy",
          "author"		    => "Ing. Ramón A Linares Febles",
          "email"		    => "rlinareslf@gmail.com",
          "license"		    => "MIT",
          "support"		    => "http://www.iipec.net",
          "version"		    => "V-1.0",
          "description"     => "Navy V-1.0",
        ];
     }

    public function app() {

        return [
            'type'      => 'library',
            'slug'      => 'navy',
            'driver'    => \DGII\Navy\Driver::class,
            'token'     => NULL,
            'activated' => 1
        ];
    }

    public function providers() { 
        return [
            \DGII\Navy\Provider\ServiceProvider::class,
        ]; 
    }
    public function alias() { 
        return [
            "Nav" => \DGII\Navy\Facade\Nav::class
         ];
    }

    public function install($app) { 

        $path = str_replace(base_path(), null, __DIR__."/Database");

        ## REGISTRO DE LA LIBRARERIA
        $app->create($this->app())->addInfo($this->info());

        ## CREANDO LAS ENTIDADES
        \Artisan::call("migrate", ["--path" => $path."/Migration"]);

        ## LANZANDO LOS SEEDER
        \Artisan::call("db:seed", [
            "--class" => \DGII\Navy\Database\Seed\NavySeed::class
        ]);
    }
    
    public function uninstall($app) {
        $path = str_replace(
            base_path(), null, __DIR__."/Database/Migration"
        );

        \Artisan::call("migrate:reset", ["--path" => $path]);
    }

}