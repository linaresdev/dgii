<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class P12Certify
{
    private static $validate;

    private static $stors;

    public function __construct( $data )
    {
        $X509       = openssl_x509_read($data["cert"]);
        $CONTENT    = openssl_x509_parse($X509, false);

        self::$stors["contry"]       = $CONTENT["subject"]['countryName'];
        self::$stors["firstname"]    = $CONTENT["subject"]['surname'];
        self::$stors["lastname"]     = $CONTENT["subject"]['givenName'];
        self::$stors["fullname"]     = $CONTENT["subject"]['commonName'];

        self::$stors["serial"]       = $CONTENT["subject"]['serialNumber'];
        self::$stors["validTo"]      = $CONTENT["validTo"];
      
        $ruls["contry"]         = "required";
        $ruls["firstname"]      = "required";
        $ruls["lastname"]       = "required";
        $ruls["fullname"]       = "required";
        $ruls["serial"]         = "required";
        $ruls["validTo"]        = "required";
        

        self::$validate  = validator(self::$stors, $ruls);
    }

    public function passes() {
        return self::$validate->passes();
    }

    public function contents() {
        return self::$stors;
    }

    public function serial() {
        return self::$stors["serial"];
    }

    public function slug() {
        return strtoupper(str_replace('-', null, $this->serial()));
    }

    public function email($domain="entity.lc") {
        return $this->slug()."@$domain";
    }

    public function fileName() {
        return $this->slug().".p12";
    }

    public function directory() {
        return __path("{hacienda}/".$this->slug().'/'.env('DGII_ENV'));
    }

    public function getData($request)
    {
        return [
            "name"      => $request->name,
            "serial"    => $this->serial(),
            "slug"      => $this->slug(),
            "password"  => $request->pwd
        ];
    }    

    public function dataValidate($request)
    {
        $ruls["name"]     = "required";
        $ruls["serial"]   = "required|unique:\DGII\Model\Hacienda,serial";
        $ruls["slug"]     = "required|unique:\DGII\Model\Hacienda,slug";
        $ruls["password"] = "required";
        $attributes["serial"]   = __("words.serial");
        $attributes["slug"]     = __("words.slug");
        $msg["unique"]          = __("validation.has.entity");

        return validator($this->getData($request), $ruls, $msg, $attributes);
    }

    public function makeResources($request) {

        if( !app("files")->exists(($directory = __path("{hacienda}/".$this->slug()))) )
        {
            app("files")->makeDirectory($directory, 0750, true);

            $request->moveCertify($directory, 'certify.p12');

            if( app("files")->exists("$directory/certify.p12") )
            {
                return true;
            }

            return false;
        }

        return true;
    }

    public function workGroup($name) {
        return [
            "type" => "user-group",
            "slug" => $this->slug(),
            "name" => $name,
            "description" => __("corporate.group")
        ];
    }
    public function accountData($name)
    {
        return [
            "type"        => "entity",
            "name"        => $name,
            "user"        => $this->slug(),
            "email"       => $this->email(),
            "password"    => $this->serial(), 
            "activated"   => 1
        ];
    }

}