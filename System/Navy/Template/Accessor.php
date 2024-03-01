<?php
namespace DGII\Navy\Template;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Accessor {

    public function on( $url=null, $current="link" ) {
        if(request()->path() == $url) {
            return " active";
        }
    }

    public function filter( $key=null, $value=null ) {
        
        if(  array_key_exists($key, $this->filters) ) {     
            
            if( in_array($key, ["style", "url"])) {
                foreach( $this->filters[$key] as $alia => $arg ) {
                    $value = str_replace($alia, $arg, $value);
                }
            }
            if( $key == "label" ) {
                foreach( $this->filters[$key] as $opt => $args ) {
                    if( $opt == "match" ) {
                        foreach( $this->filters[$key][$opt] as $alia => $arg ) {
                            $value = str_replace($alia, $arg, $value);
                        }
                    }
                    elseif( $opt == "dress" ) {
                        foreach( $this->filters[$key][$opt] as $alia => $skin ) {
                            $value = str_replace($alia, $value, $skin);                          
                        }
                    }
                }
            }
        }

        return $value;
    }

    public function tab($multiplier=0, $input=" ") {
		return str_repeat($input, $multiplier);
	}

    public function icon($slug) {

        if( empty($slug) ):
			return NULL;
		elseif($slug == "icon-toggle-nav"):
			return '<i class="mdi mdi-segment"></i> ';
		elseif( preg_match('/^mdi/', $slug) ) :
			return '<i class="mdi '.$slug.'"></i> ';
		elseif( preg_match('/^glyphicon/', $slug) ):
			return '<span class="'.$slug.'"></span> ';
		elseif ( preg_match('/[jpg|png|svg|gif]/i', $slug) ):
			return '<img src="'.__url($slug).'" class="'.$this->filter("style", "navicon").'" alt="@"> ';
		endif;
    }

    public function label($name) {
        return $this->filter("label", __($name));
    }

    public function url( $uri=null ) {

        $uri =  $this->filter("url", $uri); 

        return __url($uri);
    }

    public function css($data=null) {
        $data =  $this->filter("style", $data); 
        return $data;
    }

    public function link( $item=null, $index=4 ) {   

        $active = $this->on( $item['url'] );

        $html  = __t( $index+4 );
        
        $html .= '<a href="'.$this->url($item['url']).'" class="nav-link'.$this->on($item['url']).'">'."\n";

        $html .= __t($index+8);
        $html .= $this->icon($item["icon"]);
        $html .= $this->label($item["label"]);

        $html .= "\n";
        $html .= __t($index+4);
        $html .= "</a>\n";

        return $html;     
    }

    public function dropdown($items=null, $index=4) {  

        $html  = __t($index+4);
        $html .= '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown">'."\n";

        $html .= __t($index+8);
        $html .= $this->icon($items["icon"]);
        $html .= $this->label($items["label"]);

        $html .= "\n";
        $html .= __t($index+4);
        $html .= "</a>\n";

        $html .= __t($index+4);
        $html .= '<div class="'.$this->css(':node2').'">'."\n";

        foreach ( $items["url"] as $row => $item ) {
            $html .= __t($index+8);
            $html .= '<a href="'.$this->url($item['url']).'" class="dropdown-item'.$this->on($item['url']).'" >'."\n";

            $html .= __t($index+12);
            $html .= $this->icon($item["icon"]);
            $html .= $this->label($item["label"]);

            $html .= "\n";
            $html .= __t( $index+8 );
            $html .= "</a>\n";
        }

        $html .= __t($index+4);
        $html .= "<div>\n";

        return $html;      
    }
}