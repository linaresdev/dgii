<?php
namespace DGII\Navy\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Group {

    protected $name;

    protected $stors = [];
    
    public function __construct( $name ) {
        $this->name = $name;
    }

    public function all() {
        return $this->stors;
    }

    public function add($slug) {
        if( !array_key_exists($slug, $this->stors) ) {
            $this->stors[] = $slug;
        }
    }
}