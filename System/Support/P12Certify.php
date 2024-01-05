<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class P12Certify {

    private static $stors;

    public function __construct( $data )
    {
        $X509       = openssl_x509_read($data["cert"]);
        $CONTENT    = openssl_x509_parse($X509, false);

        //dd($CONTENT);

        self::$stors["contry"]       = $CONTENT["subject"]['countryName'];
        self::$stors["firstname"]    = $CONTENT["subject"]['surname'];
        self::$stors["lastname"]     = $CONTENT["subject"]['givenName'];
        self::$stors["fullname"]     = $CONTENT["subject"]['commonName'];

        self::$stors["serial"]       = $CONTENT["subject"]['serialNumber'];
        self::$stors["validTo"]      = $CONTENT["validTo"];
    }

    public function contents() {
        return self::$stors;
    }

    public function serial() {
        return self::$stors["serial"];
    }

    public function user() {
        return strtoupper(str_replace('-', null, $this->serial()));
    }

    public function email($domain="entity.lc") {
        return $this->user()."@$domain";
    }

    public function fileName() {
        return $this->user().".p12";
    }

    public function directory() {
        return __path("{hacienda}/".$this->user().'/'.env('DGII_ENV'));
    }
}