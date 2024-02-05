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
    return view("dgii::authsoa", [
        "title"     => "LOGIN SOAP",
        "urlSeed"   => "api/101011939/testecf/emisorreceptor/fe/Autenticacion/api/Semilla",
        "urlAuth"   => "101011939/testecf/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado" 
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

    // dd("NO");
    // $method         = Signer::getMethod(6);
    // $canonical      = Signer::getCanonical(true, false);
    // $digestValue    = Signer::getDigestValue($canonical, $method);

    // dd($digestValue);
 
    // dd( Signer::load() );

    ## XML Custom
    // $don = new DOMDocument;
    // $don->preserveWhiteSpace = false;
    // $don->formatOutput = true;

    // $don->loadXML($semilla);

    // $don = $don->documentElement;
    // ## CANONICAL DATA
    // $canonical = $don->C14N(true, false);

    // ## Method --
    // $métodos    = openssl_get_md_methods(true);
    // $method     = $métodos[6];

    // ## DigestValue
    // $digestValue = openssl_digest($canonical, $method);

    // ## Codificamos ele DigestValue a base64
    // $digestValue = base64_encode($digestValue);

    // dd($digestValue);
    ## END Xml Custom

    ## Custom x509
    // if(openssl_pkcs12_read($p12, $info, "Delta939"))
    // {
    //     ## Almacenar el certificado  y la llave privada en variables.
    //     $cert = $info["cert"];
    //     $pkey = $info["pkey"];

    //     ## Occeder a la llave publica
    //     $pubKey = openssl_get_publickey($cert);

    //     ## Detalle publicos del certificado.
    //     $pubKeyData = openssl_pkey_get_details($pubKey);

    //     ## Exportar certificado 509
    //     openssl_x509_export($cert, $cer509, true);
    //     ## Libermaos de moria el certificado generado 
    //    // openssl_x509_free($cer509);
        

    //   //  dd($cer509);

    //     ## Acceder al pkeyID a partir de la clave privata pkey
    //     $pkeyID = openssl_pkey_get_private($pkey);

    //     # Firma digital a partir del pkeyID
    //     openssl_sign($semilla, $sign, $pkeyID);

    //     ## Liberar la clave de la memoria
    //     openssl_free_key($pkeyID);

    //     $signaturValue = base64_encode($sign);

    //     dd($signaturValue);
    // }
    ## END Custom


//     $xsig = new \DGII\XmlSig\Otro\XmlDigitalSignature;
//     $xsig->setCryptoAlgorithm(\DGII\XmlSig\Otro\XmlDigitalSignature::RSA_ALGORITHM);
//     $xsig->setDigestMethod(\DGII\XmlSig\Otro\XmlDigitalSignature::DIGEST_SHA256);
//     $xsig->forceStandalone();

  // $xsig->loadPrivateKey($p12, 'Delta939', false);
    // if(openssl_pkcs12_read($p12, $cert, "Delta939"))
    // {
    //     $xsig->loadPrivateKey($cert["pkey"], 'Delta939', false);
    //     $xsig->loadPublicKey($cert["cert"], false);

    //     $fakeXml = new \DOMDocument();

    //     $xsig->addObject("dsar");
    //     $xsig->sign();

    //     dd($xsig->getSignedDocument());
    // }

    

    // $privateKeyStore = new \DGII\XmlSig\PrivateKeyStore();
    // $privateKeyStore->loadFromPkcs12($p12, 'Delta939');
    
    // $algorithm = new \DGII\XmlSig\Algorithm(\DGII\XmlSig\Algorithm::METHOD_SHA256);
    // dd(\DGII\XmlSig\Algorithm::METHOD_SHA256);
    // $cryptoSigner = new DGII\XmlSig\CryptoSigner($privateKeyStore, $algorithm);
    
    // $xmlSigner = new \DGII\XmlSig\XmlSigner($cryptoSigner);
    // $signedXml = $xmlSigner->signXml($semilla);

    // dd($signedXml);

    // $xml = new DOMDocument();
    // $xml->preserveWhiteSpace = true;
    // $xml->formatOutput = false;
    // $xml->loadXML($semilla);
    //$signedXml = $xmlSigner->signDocument($xml);

    //app("files")->put("$seedSig/AuthSeed.xml", $signedXml);

    //return $signedXml;
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


    ## Login
    if( $item == "login" )
    { 
        return view("dgii::form", [
            "title" => "Login",
            "url" => "api/101011939/testecf/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado",
            "urlRecepcion" => "api/101011939/testecf/emisorreceptor/fe/Recepcion/api/ecf"
        ]);
    }

    ## Emision Comprobante Electronico
    if( $item == "EmisionComprobantes")
    {       
        $url = "192.168.10.18/api/101011939/testecf/emisorreceptor/api/Emision/EmisionComprobantes";

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
        
        $url =  "192.168.10.18/api/101011939/testecf/emisorreceptor/fe/AprobacionComercial/api/ecf";
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
        
        $url =  "192.168.10.18/api/101011939/testecf/emisorreceptor/fe/Recepcion/api/ecf";
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