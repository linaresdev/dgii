<?php

Route::get("/", "UserController@index");

Route::get("/new", "UserController@getRegister");
Route::post("/new", "UserController@postRegister");

Route::prefix("show")->group(function() {

    Route::prefix("{usrID}")->group(function($route)
    {
        Route::get("/set-state/{state}", "UserController@setState");

        Route::get("/update/credential", "UserController@getUpdateCredential");
        Route::post("/update/credential", "UserController@postUpdateCredential");

        Route::get("/update/password", "UserController@getUpdatePassword");
        Route::post("/update/password", "UserController@postUpdatePassword");

    });

});

Route::prefix("groups")->group(function(){
    Route::get("/", "UserGroupController@index");
});

