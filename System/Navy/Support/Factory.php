<?php
namespace DGII\Navy\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Navy\Support\Container;

class Factory {

    protected $routers  = [];

    protected $taggs    = [];

    protected $groups   = [];

    protected $template = [];

    /*
    * LOAD */
    public function load( $key=null, $closure=null ) {

        if( !empty($key) ) {
            if( isset($this->{$key}) && $closure == null ) {
                return $this->{$key};
            }
        }

        return $this;
    }

    /*
    * WHERE */
    public function whereRoute( $route=null, $closure=null ) {
        if( array_key_exists($route, $this->routers) ) {
            if( $closure instanceof \Closure ) {
                $closure($this->routers[$route] );
            }
        }
    }

    public function whereTag($tag=null, $closure=null ) {
        if( array_key_exists($tag, $this->taggs) ) {
            if( $closure instanceof \Closure ) {
                $closure($this->taggs[$tag] );
            }
        }
    }

    /*
    * Add */
    public function addContainer($name=null) {
        if( !empty($name) && is_string($name) ) {
            $slug = \Str::slug($name);

            if( !array_key_exists( $slug, $this->groups ) ) {
                $this->groups[$slug] = new \DGII\Navy\Support\Container($name);
            }
        }
    }

    public function template( $templates=null ) {
        if( !empty($templates) && is_array($templates) ) {
            foreach( $templates as $slug => $template ) {
                if( is_object($template) ) {
                    $this->template[$slug] = $template;
                }
                elseif( is_string($template) ) {
                    if( class_exists($template) ) {
                        $this->template[$slug] = new $template;
                    }
                }
            }
        }
    }

    /*
    * SAVE MENU */
    public function save( $nav=null, $closure=null ) {
        if( !empty($nav) ) {
            ## FROM ARRAY
            if( is_array($nav) ) {
                return $this->saveFromArray($nav);
            }

            ## FROM CLOSURE
            if( $nav instanceof \Closure ) { 
                return $this->saveFromClosure($nav);
            }

            ## FROM OBJECT
            if( is_object($nav) ) {
                return $this->saveFromObject($nav);
            }

            ## FROM JSON
            if( is_json($nav) ) {
                return $this->saveFromJson($nav);
            }
        }
    }

    /*
    * Registro desde un arreglo */    
    public function saveGroup($type=null, $group=null, $slug=null ) {
        if( array_key_exists($type, $this->groups) ) {
            if(!empty($group)) $this->groups[$type]->add($group);
            if(!empty($slug)) $this->groups[$type]->get($group)->add($slug);
        }
    }

    public function saveFromArray( $data=null ) {

        if(array_key_exists("tag", $data) ) {
            if( !empty( ($tag = $data["tag"]) ) ) {
                $this->taggs[$tag] = new \DGII\Navy\Support\Nav($data);

                if( array_key_exists("group", $data) ) {
                    $this->saveGroup("taggs", $data["group"], $tag);
                }
            }
        }

        if( array_key_exists("route", $data) ) {
            if( !empty( ($route = $data["route"])) ) {
                $this->routers[$route] = new \DGII\Navy\Support\Nav($data);
            }

            if( array_key_exists("group", $data) ) {
                $this->saveGroup("routers", $data["group"], $route);
            }
        }
    }

    /*
    * Registro desde un closure */
    public function saveFromClosure($closure=null) {
        if( $closure instanceof \Closure ) {
            $nav = new \DGII\Navy\Support\Nav();
            $closure($nav);  
            $this->saveFromArray((array) $nav);
        }
    }

    /*
    * Registro desde un objecto */
    public function saveFromObject($menu=null) {
        if( !empty(($tag = $menu->get("tag"))) ) {
            $this->taggs[$tag] = new \DGII\Navy\Support\Nav($menu);

            if( !empty(($group = $menu->get("group"))) ) {
                $this->saveGroup("taggs", $group, $tag);
            }
        }

        if( !empty(($route = $menu->get("route"))) ) {
            $this->routers[$route] = new \DGII\Navy\Support\Nav($menu);
            if( !empty(($group = $menu->get("group"))) ) {
                $this->saveGroup("routers", $group, $route);
            }
        }
    }

    /*
    * Registro desde un objecto */
    public function saveFromJson($nav=null, $closure=null) {}

    /*
    * RENDER  REQUEST MONITOR */    
    public function route($index=4){
        $currentURL = request()->path();
        if( !empty($this->routers) ) {
            foreach( $this->routers as $route => $nav ) {               
                if( \Str::is($route, request()->path()) ) {
                    if( array_key_exists(($skin = $nav->theme()), $this->template) ) {
                        return ($this->template[$skin])->boot($nav)->nav($index);
                    }
                }
            }
        }
    }

    /*
    * RENDER  FROM TAG */
    public function tag($slug=null, $index=4) {

        if( array_key_exists($slug, $this->taggs) ) {
            if( !empty( ($skin = ($nav = $this->taggs[$slug])->theme() )) ) {

                if( array_key_exists( $skin, $this->template) ) {
                    return ($this->template[$skin])->boot($nav)->nav($index);
                }

            }
        }
    }

    /*
    * RENDER GROUPS REQUEST MONITOR */
    public function getInstanceFromRoute($route=null, $index) {
        if( array_key_exists($route, $this->routers) ) {
            if( !empty( ($skin = ( $node = $this->routers[$route])->theme()) ) ) {
                if( array_key_exists($skin, $this->template) ) {
                    return $this->template[$skin]->boot($node)->nav($index);
                }
            }
        }
    }    
    public function groupRoute( $group = null, $index=4 ) {

        $navs = null;

        if( ($router = $this->groups["routers"])->has($group) ) {
            if( !empty(($routers = $router->get($group)->all()) ) ) {
                foreach($routers as $route ) {
                    if( \Str::is($route, request()->path()) ) {
                        $navs .= $this->getInstanceFromRoute($route, $index);
                    }
                }
            }
        }

        return $navs;
    }

    /*
    * RENDER FROM GROUP TAGGS */
    public function groupTag( $group=null, $index=4 ) {

        $navs = null;

        if( ($taggs = $this->groups["taggs"])->has($group) ) {
            if( !empty(($taggs = $taggs->get($group)->all())) ) {
                foreach( $taggs as $tag ) {
                    if( array_key_exists($tag, $this->taggs) ) {
                        if( !empty( ($skin = ($node = $this->taggs[$tag])->theme()) ) ) {
                            if( array_key_exists($skin, $this->template) ) {
                                $navs .= $this->template[$skin]->boot($node)->nav($index);
                            }
                        }                        
                    }
                }
            }
        }

        return $navs;
    }

}