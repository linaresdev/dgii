<?php
namespace DGII\Http\Policy;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/


use DGII\User\Model\Store;

class User
{
    public function owner($login, $user)
    {
        if($login->id != $user->id) {
            $login->news("OWNER", __("auth.rol.deny"));
            return false;
        }

        return true;
    }
    
    public function view($login, $group ) {
        if($login->rol($group)->view) {
            return true;
        }

        $user->news("VIEW", __("auth.rol.deny"));

        return false;
    }

    public function insert($login, $group ) {
        if( $login->rol($group)->insert ) {
            return true;
        }

        $login->news("INSERT", __("auth.rol.deny"));

        return false;
    }

    public function update($login, $group ) {
        if( $login->rol($group)->update ) {
            return true;
        }

        $login->news("UPDATE", __("auth.rol.deny"));
        return false;
    }

    public function delete($login, $group ) {
        
        if( $login->rol($group)->delete ) {
            return true;
        }

        $login->news( "DELETE", __("auth.rol.deny"));

        return false;
    }
}