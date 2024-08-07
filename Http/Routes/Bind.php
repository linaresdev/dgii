<?php

Route::bind("usrID", function($ID){
    return (new \DGII\User\Model\Store)->find($ID) ?? abort(404);
});

Route::bind("stackID", function($ID){
    return (new \DGII\User\Model\UserStack)->find($ID) ?? abort(404);
});

## BIND FROM ENTITY ID
Route::bind("entID", function($ID) { 
    return (new \DGII\Model\Hacienda)->find($ID) ?? abort(404); 
});

Route::bind("arecfID", function($ID) { 
    return (new \DGII\Model\ARECF)->find($ID) ?? abort(404); 
});

Route::bind('rnc', function( $rnc ) {
    $data = (new \DGII\Model\Hacienda)->where("rnc", $rnc)->first() ?? abort(404);
    
    foreach( $data->getConfig() as $key => $value )
    {
        app("config")->set($key, $value);
    }

    return $data;
});

Route::bind('ecfID', function($ID){
    return (new \DGII\Model\ARECF)->find($ID) ?? abort(404); 
});