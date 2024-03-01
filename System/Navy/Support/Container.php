<?php
namespace DGII\Navy\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Navy\Support\Group;

class Container {

    protected $name;

    protected $stors = [];

    public function __construct($name="Empty Name") {
        $this->name = $name;
    }

    public function has($group) {
        return array_key_exists(\Str::slug($group), $this->stors);
    }

    public function get( $slug ) {
        if( array_key_exists( ($slug = \Str::slug($slug)), $this->stors) ) {
            return $this->stors[$slug];
        }
    }

    public function add( $group=null, $data=null ) {
        if( !$this->has($group) ) {
           $this->stors[\Str::slug($group)] = new Group($group);
        }  
    }
}