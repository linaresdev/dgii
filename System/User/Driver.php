<?php
namespace DGII\User;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Model\Term;
use DGII\User\Model\Store;

class Driver {

    public function info()
    {
        return [
            'name'          => 'User',
            'author'        => "Ing. Ramón A Linares Febles",
            'email'         => 'rlinareslf@gmail.com',
            'license'       => 'Mit',
            'support'       => 'https://support.lc',
            'version'       => 'V-0.1',
            'description'   => 'Librería XUser'
        ];
    }

    public function app() {
        return [
            'type'      => 'library',
            'slug'      => 'xuser',
            'driver'    => \DGII\User\Driver::class,
            'token'     => NULL,
            'activated' => 1
        ];
    }

    public function providers()
    { 
        return [
            \DGII\User\Provider\UserServiceProvider::class
        ]; 
    }

    public function alias() { 
        return [
            "User" => \DGII\User\Facade\User::class,
        ]; 
    }

    public function adminRols() {
        return [
          "view"      => 1, 
          "insert"    => 1, 
          "update"    => 1, 
          "delete"    => 1,
          
          "user-view"     => 1,
          "user-insert"   => 1,
          "user-update"   => 1,
          "user-delete"   => 1,
          
          "group-view"     => 1,
          "group-insert"   => 1,
          "group-update"   => 1,
          "group-delete"   => 1,
        ];
    }

    public function createAdminUser($term)
    {
        ## Contadores de las transacciones de usuarios
        $metrics = [
            ["type" => "user-counter", "slug" => "saved", "name" => "words.saved","description" => "user.saved"],
            ["type" => "user-counter", "slug" => "inactive", "name" => "words.inactive","description" => "user.inactive"],
            ["type" => "user-counter", "slug" => "activated", "name" => "words.activated","description" => "user.activated"],
            ["type" => "user-counter", "slug" => "locked", "name" => "words.locked","description" => "user.locked"],
            ["type" => "user-counter", "slug" => "legal", "name" => "words.legal","description" => "user.legal"],
            ["type" => "user-counter", "slug" => "delete", "name" => "words.delete","description" => "user.delete"],

            ["type" => "user-group", "slug" => "owner", "name" => "words.owner","description" => "user.owner"],
            ["type" => "user-group", "slug" => "admin", "name" => "words.admin","description" => "user.admin"],
        ];

        foreach($metrics as $metric) {
            $term->create($metric);
        }

        $user = (new \DGII\User\Model\Store)->create([
            "type"      => "local",
            "name"      => "Admin",
            "firstname" => "Web",
            "lastname"  => "Master",
            "fullname"  => "Web Master",
            "user"      => "admin",
            "email"     => "admin@webmaster.lc",
            "password"  => "\Str::random(12)",
            "activated" => 1
        ]);

        $user->syncGroup( "owner", $this->adminRols() );
        $user->syncGroup("admin", $this->adminRols());
    }

    public function install( Term $term )
    {
        ## TERM
        $this->createAdminUser($term); 
    }

    public function destroy($app) { }

    public function handler( $app ) {    
    }

}