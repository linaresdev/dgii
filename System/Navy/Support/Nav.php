<?php
namespace DGII\Navy\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Nav {
    

    public function __construct( $data=null ) {
        if( is_array($data) ) {
            $this->loadFromArray($data);
        }
        elseif(is_object($data) ) {
            $this->loadFromObject($data);
        }
    }

    public function authKeys() {
        return [
            "attrs", "filters", "items", "skin"
        ];     
    }

    public function loadFromArray( $data ) {
        foreach($this->authKeys() as $key ) {
            if( array_key_exists($key, $data) ) {
                if( !empty( ($value = $data[$key]) ) ) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function loadFromObject($menu) {
        foreach($this->authKeys() as $key ) {
            if( !empty( ($value = $menu->get($key))) ) {
                $this->{$key} = $value;
            }
        }
    }

    /*
    * Miselanio */
    public function authorize($key=null) {
        return in_array($key, [
            "group",
            "route",
            "tag",
            "attrs", 
            "filters", 
            "items", 
            "skin"
        ]);
    }

    /*
    * ADD */
    public function add( $key=null, $value=null ) {
        if( $this->authorize($key) ) {
            $this->{$key} = $value;
        }
    }

    public function addfilters($key=null, $data=null) {
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

    public function itemRow($key=0, $data=null) {
        if( is_numeric($key) && $data != null ) {
            $this->items[$key] = $data;
            ksort($this->items);           
        }
    }

    public function subItemRow( $parent=null, $key=null, $data=null ) {       
        if( array_key_exists($parent, $this->items) && !empty($data) ) {
            $this->items[$parent]["url"][$key] = $data;   
            
            ksort($this->items[$parent]["url"]);
        }
    }

    /*
    * UPDATE */
    public function updateItem($key=null, $data=null ) {
        if(is_array($data) ) {
            foreach($data as $slug => $value) {
                $this->items[$key][$slug] = $value;
            }
        }
    }

    /*
    * DENY */
    public function rejectItem($key=null) {
        if( array_key_exists($key, $this->items) ) {
            unset($this->items[$key]);
        }
    }

    /*
    * SKIN */
    public function theme($skin="bs5") {        
        if(isset($this->skin)) {
            return ($this->skin);
        }

        return $skin;
    }
}