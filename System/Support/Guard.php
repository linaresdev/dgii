<?php
namespace DGII\Support;

class Guard {

	protected $app;

    protected static $IP;

    protected static $IPS;

    protected static $AGENT;

	public function __construct() {
        self::$IP       = request()->ip();
        self::$IPS      = request()->ips();
        self::$AGENT    = request()->userAgent();
	}

	public function getPlatform($agent=NULL) {

		if(empty($agent)) $agent = self::$AGENT;

		if( !empty( ($platforms = config("app.platforms")) ) ) {
			foreach ($platforms as $key => $value) {
				if ( preg_match('|'.preg_quote($key).'|i', $agent) ) {
					return $value;
				}
			}
		}

		return 'Unknown Platform';
	}

	public function getBrowser($agent=null) {
        
		if( empty($agent) ) $agent = self::$AGENT;

		if( !empty( ($browsers = config("app.browsers")) ) && is_array($browsers) ) {
			foreach ($browsers as $key => $value) {
				if (preg_match('|'.$key.'.*?([0-9\.]+)|i', $agent, $match)) {
					return $value.' | V-'.$match[1]; 
				}
			}
		}

		return 'Unknown Browser'; 
	}

	public function getRobot($agent=null) {
		if(empty($agent)) $agent = self::$AGENT;

		if( !empty( ($robots = config("app.robots")) ) && is_array($robots) ) {
			foreach ($robots as $key => $value) {
				if (preg_match('|'.preg_quote($key).'|i', $agent, $match))
				{
					return $value; 
				}
			}
		} 
	}

	public function getMobil($agent=NULL) {
		if(empty($agent)) $agent = self::$AGENT;
		
		if( !empty( ($mobiles = config("app.mobiles")) ) && is_array($mobiles) ) {
			foreach ($mobiles as $key => $value) {
				if( preg_match('|'.preg_quote($key).'|i', $agent, $match) ) {
					return $value; 
				}
			}
		}

		return "It is not a Mobile";
	}

	public function device( $agent=null ) {

        if(empty($agent)) $agent = self::$AGENT;

		if( !empty( $agent) ) {
			if( !empty( ($mobiles = config("app.mobiles")) ) && is_array($mobiles) ) {
				foreach ($mobiles as $key => $value) {
					if( preg_match('|'.preg_quote($key).'|i', $agent, $match) ) {
						return "Smartphone"; 
					}
				}
			}

			return "Computer";
		}

		return 'Unknown Device';
	}

}