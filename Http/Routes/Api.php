<?php

$env = env("DGII_ENV");

Route::get("form", function(){
    return view("dgii::form");
});

Dgii::addUrl([
    "{form}" => $env."/emisorreceptor/fe/AprobacionComercial/api/ecf"
]);

Route::prefix($env)->group(function($route)
{
    ## AUTH
    Route::get("emisorreceptor/fe/Autenticacion/api/Semilla","AuthController@getSeed");
    Route::post("{env}/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado","AuthController@postGuest");

    ## Emision
    Route::post("emisorreceptor/api/Emision/EmisionComprobantes","EnviarComprobanteController@index");
    Route::get("emisorreceptor/api/Emision/ConsultaAcuseRecibo?Rnc=ad&Encf=ad","ConsultaReciboController@index");
    Route::post("emisorreceptor/api/Emision/EnvioAprobacionComercial","EnviarAprobacionComercialController@index");

    ## Recepción
    Route::post("emisorreceptor/fe/AprobacionComercial/api/ecf","RecepcionComprobanteController@index");
    Route::get("emisorreceptor/fe/Recepcion/api/ecf","RecepcionECFController@index");
});