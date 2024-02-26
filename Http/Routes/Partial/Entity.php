<?php

Route::get("/", "HomeController@index");

Route::prefix("{rnc}")->group(function()
{
    Route::get("/", "EntityController@index");
    Route::prefix("ecf")->group(function()
    {
        Route::get("{ecfID}/send/arecf", "EntityController@ARECF");
        Route::post("{ecfID}/send/arecf", "EntityController@sendARECF");
    });
    
});