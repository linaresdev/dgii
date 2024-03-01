<?php
namespace DGII\Navy\Accessor;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/



class Nav {

    protected $tag      = null;

    protected $route    = null;

    protected $skin     = null;

    protected $filters  = [];

    public function addfilter($key=null, $data=null) {
        if( in_array($key, ["icon", "label", "style", "url"]) ) {
            foreach($data as $k => $v) {
                $this->filters[$key][$k] = $v;
            }
        }
    }

    public function addItem($data=null) {
        if( !empty($data) && is_array($data) ) {
            $this->items[] = $data;
        }
    }

    public function addItemRow($key=0, $data=null) {
        if( is_numeric($key) && $data != null ) {
            $this->items[$key] = $data;
            ksort($this->items);           
        }
    }

    public function addSubItemRow( $parent=null, $key=null, $data=null ) {       
        if( array_key_exists($parent, $this->items) && !empty($data) ) {
            
            $this->items[$parent]["url"][$key] = $data;   
            
            ksort($this->items[$parent]["url"]);
        }
    }

    public function get($key=null) {
        if( isset($this->{$key}) ) {
            return $this->{$key};
        }
        elseif( method_exists($this, $key) ) {
            return $this->{$key}();
        }
    }
}