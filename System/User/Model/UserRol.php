<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Model\Term;

class UserRol {

    public function __construct($value, $parent) {        
        foreach( json_decode($value) as  $key => $rol ) {
            $this->{$key} = $rol;
        } 
        
        if( ($parents = (new Term)->getParent($parent)) != null ) {
            foreach( $parents as $parent ) {
                $this->{$parent->slug} = $parent->activated;
            }
        }
    }

    public function has($key) {
        return array_key_exists($key, ((array) $this));
    }
}