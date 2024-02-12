<?php

// $env = env("DGII_ENV");

// Route::get("form", function(){
//     return view("dgii::form");
// });

// Dgii::addUrl([
//     "{form}" => $env."/emisorreceptor/fe/AprobacionComercial/api/ecf"
// ]);

Route::get("/hacienda", function()
{
    //return "Oky";
    $token = "26|ZkCxSWSk3WJRX7fr4COr17EDf8G3yyxIXbLgnr6z31294850";

    return Http::withToken($token)->get("192.168.10.18/api/101011939/testecf/wepa")->body();
});

Route::get("nologin", function(Request $request)
{
    return response("Unauthorized", 401);
});

## AUTH
Route::get("/login-api","AuthController@noLogin")->name("login");

Route::prefix("{rnc}")->group(function($route)
{
    Route::prefix(env("DGII_ENV"))->group(function($route)
    {      

        Route::get("/emisorreceptor/fe/Autenticacion/api/Semilla","AuthController@getSeed");
        Route::post("emisorreceptor/fe/Autenticacion/api/ValidacionCertificado","AuthController@guestAuth");
        
        ## Emision
        Route::middleware('auth:sanctum')->group(function()
        {
            Route::post("emisorreceptor/api/Emision/EmisionComprobantes","EnviarComprobanteController@index");
            Route::get("emisorreceptor/api/Emision/ConsultaAcuseRecibo?Rnc=ad&Encf=ad","ConsultaReciboController@index");
            Route::post("emisorreceptor/api/Emision/EnvioAprobacionComercial","EnviarAprobacionComercialController@index");
    
            ## Recepción
            Route::post("emisorreceptor/fe/AprobacionComercial/api/ecf","RecepcionComprobanteController@index");
            Route::post("emisorreceptor/fe/Recepcion/api/ecf","RecepcionECFController@index");
        });
    });
});


