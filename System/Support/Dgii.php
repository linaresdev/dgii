<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Dgii {

    protected static $app;

    public function __construct( $app ) {
		self::$app = $app;
	}
    public function app( $key=NULL, $args=[], $params=[] ) {
		return self::$app->load( $this, $key, $args, $params );
	}

    public function start() {
        return 22;
    } 
    
    public function addUrl($taggs=[]) {
		return $this->app("urls")->addTag("urls", $taggs);
	}

    public function addPath($taggs=[]) {
		return $this->app("urls")->addTag("paths", $taggs);
	}
}