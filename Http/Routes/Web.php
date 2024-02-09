<?php



## ROUTES
Route::get("login", "AuthController@getWebLogin");
Route::post("login", "AuthController@postWebLogin");

Route::get("logout", "AuthController@getWebLogout");

Route::get("auth", "AuthController@getWebAuth");
Route::get("auth", "AuthController@postWebAuth");

Route::prefix("ACECF")->namespace("ACECF")->group(function($route)
{
    Route::get("/", "HomeController@index");
});

Route::prefix("admin")->namespace("Admin")->group(function($route)
{
    Route::get("/", "DashboardController@index");

    ## ACCOUNT
    Route::prefix("users")->group(function($route) {
        Route::get("/", "UserController@index");

        Route::prefix("groups")->group(function(){
            Route::get("/", "UserGroupController@index");
        });
    });

    ## ENTITIES
    Route::prefix("entities")->namespace("Entity")->group(function()
    {
        Route::get('/', "EntityController@index");

        Route::get('/show/{entID}', "EntityController@show");
        Route::post('/show/{entID}/set-env', "EntityController@setEnv");

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

Route::get("authsoa", function()
{
    $env = env("DGII_ENV");

    return view("dgii::authsoa", [
        "title"     => "LOGIN SOAP",
        "urlSeed"   => "api/101011939/$env/emisorreceptor/fe/Autenticacion/api/Semilla",
        "urlAuth"   => "101011939/$env/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado" 
    ]);
});

Route::get("xmlsig", function()
{
    $seed = '<?xml version="1.0" encoding="utf-8"?>
    <SemillaModel xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
      <valor>JCtrPBfr8izPwU1O5v5aN/M9YG+TnaC6GB0oY47KhHJWC9I/AaukcUx4kmY7jc+t5r+SLLUwM3ill7YjbKSAaZArJ87gRTyX0P5jEcVe6uUtgxzte88dBq2ZVnrg6/g/qKyrRT77p8rIFX6RheiFTQ==</valor>
      <fecha>2024-01-22T15:18:55.2330119-04:00</fecha>
    </SemillaModel>';

    $p12        = app("files")->get(__path("{hacienda}/101011939/Certify.p12"));
    $seedSig    = __path("{hacienda}/101011939");

    //dd(OPENSSL_ALGO_SHA256, openssl_get_md_methods(true) );
    //Signer::loadSeedXML($semilla);

    if( Signer::xml($seed)->certify($p12, "Delta939")->check() )
    {
        //dd(hash_algos());
        $signer = Signer::method(OPENSSL_ALGO_SHA256)->sign();

        //app("files")->put(__path("{hacienda}/101011939/Signer.xml"), $signer);
       
        //dd(Signer::getX509());

        //dd($signer);
        //dd(Signer::method(6)->sign(false));

       ## Validate XML
        //    $xmlReader = new \XMLReader();
        //    $xmlReader->xml($signer);
        //    $xmlReader->setParserProperty(XMLReader::VALIDATE, true);


      // dd( $xmlReader->isValid() );
    }

   
});

Route::get("mona/{item}", function($item=null)
{

    //$token = "28|SfoZV8JC0EgYa7ocnny2a8UZ8UViSU6Gv04BEjJJe2b94b48";
    //$token = "29|N7ci4kVxDVowArcG9xYTcyJoCPRM1gl6AkhXefXK81bd2d60";
    //$token = "30|mlQpKfWXzKFI6JTiloEFed5vIPAF897WgA0q3jpr53b6f99c";
    //$token = "32|Cuf2dYUHOnW46IAQou7EAapDVHIRXw2f28IROtLP22cba3d7";
    //$token = "33|D1Pk4jO4rOGJEiXjoShDBRHWP1XOUH6eTwhtFI3a9c09576e";
    
    $token = "34|58hX9v7yfVFjT1crso4fgnMdS9YJyLxTnjWpQ90p2dbd86a1";
    $token = "35|Ma9lk2dOmwbV0ICaBCqh2UVR264x6ZDECWM59XzG96a8d7d4";
    $token = "36|jDeAb2Km9fOJ5HjFnzu34MOKPn8smXZ8Qa8WiPY7b6e88292";
    $token = "37|YXKnPK6Qn6GuST1mAjGqikXtJO1PrqPgZeTILGHd1f624adf";
    $token = "38|YXKnPK6Qn6GuST1mAjGqikXtJO1PrqPgZeTILGHd1f624adf";
    $token = "39|N26XnA7opLKKcShGtNjNV0VaxIs0opJ0c42bGSUP20e0fd07";
    $token = "41|ExEStVIrtZzFEoe7v8B3HNAGXkYniWE0akEzfuel6fb84e78";

    $token = "1|MnGn0VcFzVh8YsI3qv5lr9y8KIbHsAWDlVSyOKFA80639650";
    $token = "1|4TuunxuRpHvYwpfovm3msfoqsqrJ4psZoktcTIZP6cfb0702";

    $envEcf = env("DGII_ENV");

   
    ## Login
    if( $item == "login" )
    { 
        return view("dgii::form", [
            "title" => "Login",
            "url" => "api/101011939/$envEcf/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado",
            "urlRecepcion" => "api/101011939/$envEcf/emisorreceptor/fe/Recepcion/api/ecf"
        ]);
    }

    ## Emision Comprobante Electronico
    if( $item == "EmisionComprobantes")
    {       
        $url = "192.168.10.18/api/101011939/$envEcf/emisorreceptor/api/Emision/EmisionComprobantes";

        return Http::withToken($token)->post($url, [
            "rnc"               => "string",
            "tipoEncf"          => "string",
            "urlRecepcion"      => "string",
            "urlAutenticacion"  => "string"
        ])->body();

        // return view("dgii::form", [
        //     "url" => "101011939/testecf/emisorreceptor/api/Emision/EmisionComprobantes",
        //     "urlRecepcion" => "101011939/testecf/emisorreceptor/fe/Recepcion/api/ecf"
        // ]);
    }

    ## Aprobacion Comercial
    if($item == "AprobacionComercial")
    {  
        $xsd        = app("files")->get(__path('{wvalidate}/AprobacionComercial.xsd'));
        $xml    = app("files")->get(base_path('XML/AprobacionComercial.xml'));
        
        $url =  "192.168.10.18/api/101011939/$envEcf/emisorreceptor/fe/AprobacionComercial/api/ecf";
        return Http::withToken($token)->attach(
            "xml", 
            $xml, 
            "ACECF.xml", 
            ["Content-Type" => "text/xml;charset=utf-8"]
        )->post($url)->body(); 
    }

    if( $item == "Recepcion" )
    {  
       // $xsd        = app("files")->get(__path('{wvalidate}/AprobacionComercial.xsd'));
       
        //$xml    = app("files")->get(base_path('XML/101011939E310000000219.xml'));
        $xml    = app("files")->get(base_path('XML/101011939E310000000057.xml'));
        
        $url =  "192.168.10.18/api/101011939/$envEcf/emisorreceptor/fe/Recepcion/api/ecf";
        return  Http::withToken($token)->attach(
            "xml", 
            $xml, 
            "101011939E310000000057.xml", 
            ["Content-Type" => "text/xml;charset=utf-8"]
        )->post($url)->body(); 

        // return response($data, 200, [
        //     "Content-Type" => "text/xml;charset=utf-8"
        // ]);
    }


    if($item == "wepa")
    {

        return Http::withToken($token)->get(
            "192.168.10.18/api/101011939/testecf/wepa"
        )->body();
    }

});