<?php
namespace DGII\Write\Support;

/*
*---------------------------------------------------------
* @Delta
*---------------------------------------------------------
*/

use XMLReader;
use DGII\Write\Facade\Signer;
use DGII\User\Model\UserStack;
use DGII\Write\Support\XmlRead;
use Illuminate\Support\Facades\Http;

class XmlSeed
{
    protected $file;

    private static $ip;

    private static $token;

    private static $rnc;

    private static $p12;

    public function __construct( $file  )
    {
        $this->file = $file;
        self::$ip   = request()->ip();
        self::$rnc  = __segment(2);

        if( $file->exists(($path = __path("{hacienda}/101011939/Certify.p12"))))
        {
            self::$p12 = $file->get($path);
        }
    }

    public function load()
    {
        return $this;
    }

    public function setRNC($rnc)
    {
        self::$rnc = $rnc; return $this;
    }

    public function stub( $data=[] )
    {
        ## Make Seed Xml
        $stub = $this->file->get(__path("{xmlstub}/xmlseed.txt"));
        $stub = str_replace("{hash}", $this->generateHash(), $stub);
        $stub = str_replace("{datetime}", now()->addHour(1)->toAtomString(), $stub);

        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($stub);

        $xml = $dom->saveXML();
        
        ## Register Canonical Seed
        $this->registerSeedRequest(
            $xml, ($dom->documentElement)->C14N(true, false)
        );

        return  $xml;        
    }

    public function registerSeedRequest($xml, $seed)
    {
        $xmlRead = new XmlRead($xml);
        
        $data = (new UserStack)->create([
            "type"      => "SeedRequest",
            "host"      => self::$ip,
            "header"    => __("api.request.session"),
            "token"     => self::$token,
            "path"      => $seed,
            "meta"      => [
                "rnc"       => $xmlRead->rnc(),
                "token"     => $xmlRead->token(),
                "expedido"  => $xmlRead->date()
            ],
            "activated" => 0           
        ]);
    }

    public function generateHash()
    {
        self::$token = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = \Str::random(40),
            hash('crc32b', $tokenEntropy)
        );

        $rncHash        = base64_encode(self::$rnc);
        $ipHash         = base64_encode(self::$token);

        return $rncHash.'|'.$ipHash ;
    }
}