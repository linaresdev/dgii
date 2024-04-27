<?php

Route::get("/", "HomeController@index");

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

## ENTITY
Route::prefix("entity")->middleware("entity")->namespace("Entity")->group(__DIR__."/Partial/Entity.php");

Route::prefix("admin")->namespace("Admin")->group(function($route)
{
    Route::get("/", "DashboardController@index");

    ## ACCOUNT
    Route::prefix("users")->group(__DIR__."/Partial/AdminUsers.php");

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

            Route::get("update/certify", "EntityController@getUpdateCertify");
            Route::post("update/certify", "EntityController@postUpdateCertify");


            Route::get("set-state/{state}", "EntityController@setState");

            Route::get("delete", "EntityController@getDelete");
            Route::post("delete", "EntityController@postDelete");

            Route::prefix("users")->group(function($route)
            {
                Route::get("/", "EntityController@getUsers");
                Route::get("/sources/{usr}", "EntityController@getSourcesUsers");
            });
        });
    });
});

Route::get("recepcion", function()
{   
    //$host   = "https://ncf.vsdelta.com";
    $host   = "http://192.168.10.7";

    $env    = env("DGII_ENV");
    $url    =  "$host/api/101011939/$env/fe/recepcion/api/ecf";
    
    return view("dgii::form", [
        "title"     => "SOAP",
        "url"       => $url,
        "urlAuth"   => "101011939/$env/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado" 
    ]);
});

// Route::get("aprobacion", function()
// {   
//     //$host   = "https://ncf.vsdelta.com";
//     $host   = "http://192.168.10.7";

//     $env    = env("DGII_ENV");
//     $url =  "$host/api/101011939/$env/fe/aprobacioncomercial/api/ecf";
    
//     return view("dgii::form", [
//         "title"     => "SOAP",
//         "url"   => $url,
//         "urlAuth"   => "101011939/$env/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado" 
//     ]);
// });



// Route::get("mona/{item}", function($item=null)
// {
//     $host = "192.168.10.18";
//     $host = "https://ncf.vsdelta.com";
//     $envEcf = env("DGII_ENV");    

//     ## AUTH
//     if( $item == "auth" )
//     {        
//         $seed =  Http::get(
//             "$host/api/101011939/$envEcf/emisorreceptor/fe/Autenticacion/api/Semilla"    
//         )->body();

//         $signer = Hacienda::seedSigner($seed, '</SemillaModel>', true);

//         app("files")->put(__path("{hacienda}/101011939/SeedSigner.xml"), $signer);
        
//         $token = Http::attach(
//             "xml",
//             $signer,
//             "SemillaSigner.xml"
//         )->post(
//             "$host/api/101011939/$envEcf/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado"
//         )->body();

//         return $token;
//     }

//     $token = "1|4TuunxuRpHvYwpfovm3msfoqsqrJ4psZoktcTIZP6cfb0702";
//     $token = "32|qcKs6jNg0abATI1cmPNAUhmltyGUcS0xSDHK3GSo41a0d960";
//     $token = "2|DzD5dtqu0STWhWwrp9zc98d927HgPBZDkNaVXILa4d071c61"; 
//     $token = "42|KEsEBPphmwnuRn6b6Q8PMyURjcT30jJR1WMb5Z5Sb99916cb";

//     ## Emision Comprobante Electronico
//     if( $item == "EmisionComprobantes")
//     {       
//         $url = "$host/api/101011939/$envEcf/emisorreceptor/api/Emision/EmisionComprobantes";

//         return Http::withToken($token)->post($url, [
//             "rnc"               => "string",
//             "tipoEncf"          => "string",
//             "urlRecepcion"      => "string",
//             "urlAutenticacion"  => "string"
//         ])->body();

//         // return view("dgii::form", [
//         //     "url" => "101011939/testecf/emisorreceptor/api/Emision/EmisionComprobantes",
//         //     "urlRecepcion" => "101011939/testecf/emisorreceptor/fe/Recepcion/api/ecf"
//         // ]);
//     }

//     ## Emision Aprobacion Comercial
//     if( $item == "EmisionAprobacionComercial" )
//     {
//         $url            = "$host/api/101011939/$envEcf/emisorreceptor/api/Emision/EnvioAprobacionComercial";
//         $urlAprobacion  =  "$host/api/101011939/$envEcf/emisorreceptor/fe/AprobacionComercial/api/ecf";

//         $xml = app("files")->get(base_path('XML/AprobacionComercial.xml'));

//         return Http::withToken($token)->post($url, [
//             "urlAprobacionComercial"    => $urlAprobacion,
//             "urlAutenticacion"          => "",
//             "rnc"                       => "130976805",
//             "encf"                      => "E310000000057",
//             "estadoAprobacion"          => 1
//         ])->body();
//     }

//     ## Aprobacion Comercial
//     if($item == "AprobacionComercial")
//     {  
//         $xsd        = app("files")->get(__path('{wvalidate}/AprobacionComercial.xsd'));
//         $xml    = app("files")->get(base_path('XML/AprobacionComercial.xml'));
        
//         $url =  "$host/api/101011939/$envEcf/fe/aprobacioncomercial/api/ecf";
//         return Http::withToken($token)->attach(
//             "xml", 
//             $xml, 
//             "ACECF.xml", 
//             ["Content-Type" => "text/xml;charset=utf-8"]
//         )->post($url)->body(); 
//     }

//     if( $item == "Recepcion" )
//     {  
//        // $xsd        = app("files")->get(__path('{wvalidate}/AprobacionComercial.xsd'));
       
//         //$xml    = app("files")->get(base_path('XML/101011939E310000000219.xml'));
//         $xml    = app("files")->get(base_path('XML/101011939E310000000057.xml'));
        
//         $url =  "$host/api/101011939/$envEcf/fe/recepcion/api/ecf";
        
//         $out =  Http::withToken($token)->attach(
//             "xml", 
//             $xml, 
//             "101011939E310000000057.xml", 
//             ["Content-Type" => "text/xml;charset=utf-8"]
//         )->post($url)->body(); 
//         //return $out;
//         dd($out);
//         // return response($data, 200, [
//         //     "Content-Type" => "text/xml;charset=utf-8"
//         // ]);
//     }

//     if( $item == "Consulta" )
//     {
//         $url = "$host/api/101011939/$envEcf/emisorreceptor/api/Emision/ConsultaAcuseRecibo";
        
//         $data =  Http::withToken($token)->get($url, [
//             "Rnc"   => "130976805",
//             "Encf"  => "E310000000058"
//         ])->body();

//         // /return $data;

//         dd($data);
//     }

// });