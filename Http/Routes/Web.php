<?php

Route::prefix("admin")->group(function($route) {
    Route::get("/", "DashboardController@index");
});