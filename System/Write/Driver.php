<?php
namespace DGII\Write;
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
            'name'          => 'Write',
            'author'        => 'ING. Ramon A Linares Febles',
            'email'         => 'rlinareslf@gmail.com',
            'license'       => 'Mit',
            'support'       => 'https://support.lc',
            'version'       => 'V-0.1',
            'description'   => 'Sign && Signer Document'
        ];
    }

    public function app() 
    {
        return [
            'type'      => 'library',
            'slug'      => 'write',
            'driver'    => \DGII\Write\Driver::class,
            'token'     => NULL,
            'activated' => 1
        ];
    }

    public function providers()
    { 
        return [
            \DGII\Write\Provider\WriteServiceProvider::class,
        ]; 
    }

    public function alias()
    { 
        return [
            "Signer"    => \DGII\Write\Facade\Signer::class,
        ]; 
    }

    public function handler($app)
    {
        ## PATH
        $app["dgii"]->addPath([
            "{xmlstub}"         => __DIR__."/Stubs",
            "{writetemp}"       => __DIR__."/Temps",
            "{wvalidate}"       => __DIR__."/Validate",
        ]);

        ## IoC
        $app->bind("Signer", function($app)
        {
            return new \DGII\Write\Signer($app);
        });
        $app["signer"]    = \DGII\Write\Facade\Signer::load();

        $app->bind("XmlSeed", function($app)
        {
            return new \DGII\Write\Support\XmlSeed( $app["files"] );
        });
        $app["xmlseed"]    = \DGII\Write\Facade\XmlSeed::load();
    }

    public function install($app) { }
    public function destroy($app) { }
}