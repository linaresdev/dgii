<?php

## BINDING
Route::bind("entID", function($ID) {
    return (new \DGII\Model\Hacienda)->find($ID) ?? abort(404); 
});

## ROUTES
Route::get("login", "AuthController@getWebLogin");
Route::post("login", "AuthController@postWebLogin");

Route::get("logout", "AuthController@getWebLogout");

Route::get("auth", "AuthController@getWebAuth");
Route::get("auth", "AuthController@postWebAuth");

Route::prefix("admin")->namespace("Admin")->group(function($route) {
    Route::get("/", "DashboardController@index");

    ## ENTITIES
    Route::prefix("entities")->namespace("Entity")->group(function()
    {
        Route::get('/', "EntityController@index");

        Route::get('/register', "EntityController@getEntityRegister");
        Route::post('/register', "EntityController@postEntityRegister");

        Route::prefix("{entID}")->group( function() {
            Route::get("update", "EntityController@getUpdateName");
            Route::post("update", "EntityController@postUpdateName");

            Route::get("set-state/{state}", "EntityController@setState");

            Route::get("delete", "EntityController@getDelete");
            Route::post("delete", "EntityController@postDelete");
        });

    });
});