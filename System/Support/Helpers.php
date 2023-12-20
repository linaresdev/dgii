<?php

/*
 *---------------------------------------------------------
 * ©Delta
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/

## PATH
if( !function_exists("__path") ) {
   function __path($key=null) {
      return Dgii::app("urls")->path($key);
   }
}

## URLS
if( !function_exists("__url") ) {
    function __url($uri=null, $parameters=[], $secure=null ) {
        return Dgii::app("urls")->url($uri, $parameters, $secure);
    }
}

if( !function_exists("__back") ) {
    function __back($to=null) {
        if($to != null ) {
            return redirect()->to(__url($to));
        }
        return back();
    }
}

if( !function_exists("__isUrl") ) {
    function __isUrl($path=null) {
        if( $path != null ) {
            return (request()->path() == $path);
        }
        return false;
    }
}

## SEGMENT
if( !function_exists("__segment") ) {
    function __segment( $index=null, $match=null ) {
        if(is_null($index) ) return request()->segments();

        if( is_numeric($index) ) {
            $segment = request()->segment($index);

            if( !is_null($match) ) {
                return ($segment == $match);
            }

            return $segment;
        }
    }
}