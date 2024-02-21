<?php
namespace DGII\Button\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Button\Support\Render;

class Btn {

    protected $taggs = [];

    public function load()
    {
        return $this;
    }

    public function add( $alia=null, $args=null )
    {
        if( !empty($alia) &&  ($args instanceof \Closure) )
        {
            if( !array_key_exists($alia, $this->taggs) )
            {
                $this->taggs[$alia] = $args();
            }
        }
    }

    public function group( $alia=null, $args=null )
    {
        if( !empty($alia) &&  ($args instanceof \Closure) )
        {

        }
    }

    public function tag($alia=null)
    {
        if( array_key_exists($alia, $this->taggs) )
        {
            return (new Render($this->taggs[$alia]))->btn(12);
        }
    }
}