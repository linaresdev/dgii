<?php
namespace DGII;

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
            'name'          => 'DGII',
            'author'        => 'Ramon Anulfo Linares Febles',
            'email'         => 'rlinareslf@gmail.com',
            'license'       => 'Privativa',
            'support'       => 'https://github.com/linaresdev/dgii',
            'version'       => 'V-0.1',
            'description'   => 'Api DGII 0.1'
        ];
    }

    public function app()
    {
        return [
            'type'      => 'package',
            'slug'      => 'dgii',
            'driver'    => \DGII\Driver::class,
            'token'     => NULL,
            'activated' => 1
        ];
    }

    public function providers()
    {
        return [
            \DGII\Providers\RouteServiceProvider::class
        ];
    }
    
    public function alias() { 
        return [
            "Alert" => \DGII\Facade\Alert::class
        ]; 
    }

    public function install($app) { }
    public function destroy($app) {}

}