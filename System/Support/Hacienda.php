<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* Delta
*---------------------------------------------------------
*/

class Hacienda 
{
    protected $file;

    protected $entity;

    public function __construct($app) 
    {
        $this->file = $app["files"];
    }

    public function load( $entity=null ) 
    {
        $this->entity = $entity;
        return $this;
    }

    public function seedSigner( $seed=null, $replace="</SemillaModel>", $format=false )
    {
        
        if( ($sign = \Signer::entity($seed))->check()  )
        {
            return $sign->method(OPENSSL_ALGO_SHA256)->sign($replace, $format);
        }

        return $seed;
    }

    public function makeSeed()
    {
        $token = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = \Str::random(40),
            hash('crc32b', $tokenEntropy)
        );

        $date   = now()->addHour(1)->toAtomString();
        $rnc    = $this->entity->rnc;

        $rncHash        = base64_encode($rnc);
        $ipHash         = base64_encode($token);

        $makeHash       = $rncHash.'|'.$ipHash ;

        ## Make Seed Xml
        $stub = $this->file->get(__path("{xmlstub}/xmlseed.txt"));
        $stub = str_replace("{hash}", $makeHash, $stub);
        $stub = str_replace("{datetime}", $date, $stub);

        ## XML
        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($stub);

        $stack =  (new \DGII\User\Model\UserStack)->create([
            "type"      => "SeedRequest",
            "host"      => request()->ip(),
            "header"    => __("api.request.session"),
            "token"     => $token,
            "path"      => ($dom->documentElement)->C14N(true, false),
            "meta"      => [
                "rnc"       => $rnc,
                "token"     => $token,
                "expedido"  => $date
            ],
            "activated" => 0           
        ]);

        if( $stack ) {
            return $dom->saveXML();
        }

        return "Ocurrion un error al procesar su solicitud";
    }
}