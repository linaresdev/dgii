<?php
namespace DGII\Navy\Template;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Bootstrap extends Accessor {


    public function boot($data=null) {
        foreach( ((array) $data) as $key => $value ) {
            $this->{$key} = $value;
        }

        return $this;
    }

    public function nav( $index ) {
        if( !empty($this->items) ) {

            $html  = null;
            $html .= '<ul class="'.$this->css(":node0").'">'."\n";
   
            foreach ($this->items as $Y0 => $X0 ) {
               if( !is_array($X0["url"]) ) {
                  $html .= __t($index+4);
                  $html .= '<li class="nav-item">'."\n";
                  $html .= $this->link($X0, $index+8);
                  $html .= __t($index+4);
                  $html .= "</li>\n";
               }
               elseif( is_array($X0["url"]) ) {
                  $html .= $this->tab($index+4);
                  $html .= '<li class="nav-item '.$this->css(":node1").'">'."\n";
   
                  $html .= $this->dropdown($X0, $index+8);
                  $html .= __t($index+4);
                  $html .= "</li>\n";
               }
            }
   
            $html .= __t($index);
            $html .= "</ul>\n";
   
            return $html;
         }

    }
}