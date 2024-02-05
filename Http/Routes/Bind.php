<?php

## BIND FROM ENTITY ID
Route::bind("entID", function($ID) {
    return (new \DGII\Model\Hacienda)->find($ID) ?? abort(404); 
});

Route::bind('rnc', function($rnc){
    return (new \DGII\Model\Hacienda)->where("rnc", $rnc)->first() ?? abort(404); 
});