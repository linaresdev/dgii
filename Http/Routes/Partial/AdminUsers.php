<?php

Route::get("/", "UserController@index");

Route::get("/new", "UserController@register");

Route::prefix("groups")->group(function(){
    Route::get("/", "UserGroupController@index");
});