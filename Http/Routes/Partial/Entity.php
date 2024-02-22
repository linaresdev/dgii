<?php

Route::get("/", "HomeController@index");

Route::prefix("{rnc}")->group(function()
{
    Route::get("/", "EntityController@index");
});