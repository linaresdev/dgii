<?php

$env = env("GHII_ENV");

Route::prefix("{$env}")->group(function($route){

    Route::get("{env}/emisorreceptor/fe/Autenticacion/api/Semilla","AuthController@getSeed");
    Route::post("{env}/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado","AuthController@postGuest");
});