<?php
namespace DGII\User\Provider;

/*
*---------------------------------------------------------
* ©IIPEC
* Santo Domingo República Dominicana.
*---------------------------------------------------------
*/

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {

    public function boot() {
        require_once(__DIR__."/../Model/Helper.php");
    }

    public function register() {
    }
}