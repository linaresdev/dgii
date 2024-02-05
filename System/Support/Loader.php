<?php
namespace DGII\Support;

/*
 *---------------------------------------------------------
 * ©Delta
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/

class Loader {

	protected static $app;

	public function __construct( $app ) {
		self::$app   = $app;
	}

    public function callInstanceStringClass( $driver )
    {
        if(is_string($driver))
        {
            if( class_exists($driver) ) {
                $driver = new $driver;
            }
        } 

        return $driver;
    }

	/*
	* ALIASES
	* Load Alias */
	public function loadAlias($alias=NULL)
    {
		if(!empty($alias) && is_array($alias))
        {
			foreach ($alias as $alia => $class) {
				\Illuminate\Foundation\AliasLoader::getInstance()->alias($alia, $class);
			}
		}
	}

	/*
	* PROVIDERS
	* Load ServiceProvider */
	public function loadProviders($providers=[]) {
		if( !empty($providers) )
        {
            if(!is_array($providers)) $providers = [$providers];

            foreach ($providers as $provider) {
                self::$app->register($provider);
            }
        }
	}

   /*
   * RUN
   * Iniciar modulo de forma manual */
    public function run($driver=NULL)
    {
        if( !empty(($driver = $this->callInstanceStringClass($driver))) )
        {            
            if( method_exists($driver, "handler") ) {
                $driver->handler(self::$app);
            }
            
            if( method_exists($driver, "providers") )
            {
                if( !empty( ($providers = $driver->providers()) ) ) {
                    $this->loadProviders( $providers );
                }
            }

            if( method_exists($driver, "alias") ) {
                $this->loadAlias( $driver->alias() );
            }

            if( method_exists($driver, "drivers") )
            {
                if( !empty(($drivers = $driver->drivers())) && is_array($drivers) )
                {
                    foreach($drivers as $subDriver)
                    {
                        $this->run($subDriver);
                    }
                }
            }
            
        }
    }
}