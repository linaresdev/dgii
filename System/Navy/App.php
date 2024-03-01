<?php
/*
*---------------------------------------------------------
* ©DGII
*---------------------------------------------------------
*/

/*
* Disponibilidad en laravel */
$this->app["nav"] = Nav::load();

/*
* CONTAINER DEFAULT */
$this->app["nav"]->addContainer("Routers");
$this->app["nav"]->addContainer("Taggs");

## TEMPLATE
$this->app["nav"]->template([
   "bs5" => \DGII\Navy\Template\Bootstrap::class
]);

/*
* HELPER:: Tabulador */
if( !function_exists("__t") ) {
   function __t( $multiplier=0, $input=" " ) {
      return str_repeat( $input, $multiplier );
   }
}

/*
* HELPER:: Icon */
if( !function_exists("icon") )
{
   function icon($slug=null)
   {
      if( empty($slug) ):
			return NULL;
		elseif($slug == "icon-toggle-nav"):
			return '<i class="mdi mdi-segment"></i> ';
		elseif( preg_match('/^mdi/', $slug) ) :
			return '<i class="mdi '.$slug.'"></i> ';
		elseif( preg_match('/^glyphicon/', $slug) ):
			return '<span class="'.$slug.'"></span> ';
		elseif ( preg_match('/[jpg|png|svg|gif]/i', $slug) ):
			return '<img src="'.__url($slug).'" class="navicon" alt="Image"> ';
		endif;

		return NULL;
   }
}

