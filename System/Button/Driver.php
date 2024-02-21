<?php
namespace DGII\Button;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Driver 
{
    public function info()
    {
        return [
            'name'          => 'BTN',
            'author'        => "Ing. Ramón A Linares Febles",
            'email'         => 'rlinareslf@gmail.com',
            'license'       => 'Mit',
            'support'       => 'https://support.lc',
            'version'       => 'V-0.1',
            'description'   => 'Librería para botoneras'
        ];
    }

    public function app()
    {
        return [
            'type'      => 'library',
            'slug'      => 'btn',
            'driver'    => \DGII\Btn\Driver::class,
            'token'     => NULL,
            'activated' => 1
        ];
    }

    public function providers()
    { 
        return []; 
    }

    public function alias()
    { 
        return []; 
    }

    public function install( Term $term ) {}

    public function destroy($app) { }

    public function handler( $app )
    {
        $app->bind("Btn", function($app)
        {
            return new \DGII\Button\Support\Btn($app);
        });
    }
}