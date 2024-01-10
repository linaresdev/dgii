<?php
namespace DGII\Http\Policy;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\User\Model\Store;

class Entity {

    public function view($user) {        
    }

    public function insert($user) {
        dd($user->groups);
    }

    public function update($user) {
    }
    
    public function delete($user) {
    }
}