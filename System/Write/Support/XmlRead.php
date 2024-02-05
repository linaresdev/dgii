<?php
namespace DGII\Write\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Model\Hacienda;

class XmlRead
{
    protected $xml;

    private static $auth;

    protected $verifySchema = false;

    protected $errors;

    public function __construct($xml)
    {         
                 
        $this->xml = (array)(new \SimpleXMLElement( $xml ));

        list($hashRnc, $hashToken) = explode('|', $this->xml["valor"], 2);

        self::$auth["rnc"]      = base64_decode($hashRnc);
        self::$auth["token"]    = base64_decode($hashToken);
    }

    public function has()
    { 
        if( ($xmlFlag = $this->flag()) != null )
        {
            $ruls['rnc']    = "required|exists:\DGII\Model\Hacienda,rnc";
            $ruls['expire'] = "required";
            $ruls['x509']   = "required";

           if( ($V = validator($xmlFlag, $ruls))->errors()->any() )
           {
                return false;
           }
            
           return true;
        }
        
        return false;
    }

    public function rnc()
    {
        return self::$auth["rnc"];
    }

    public function token()
    {
        return self::$auth["token"];
    }

    public function date()
    {
        return $this->xml["fecha"];
    }

    public function expire()
    {
        return now()->addMinutes(66);
    }

    public function makeTempMail()
    {
        return md5($this->xml["fecha"]);
    }

    public function getX509()
    {
       if(array_key_exists("Signature", $this->xml))
       {
            if( array_key_exists("KeyInfo", ($data = (array) $this->xml["Signature"])) )
            {                
                if( array_key_exists("X509Data", ($data = (array)$data["KeyInfo"])) )
                {
                    if( array_key_exists("X509Certificate", ($data = (array) $data["X509Data"])) )
                    {
                        return $data["X509Certificate"];
                    }
                }
            }
       }
    }

    public function stack()
    {
        return (new \DGII\User\Model\UserStack)->where("token", $this->token())->first() ?? null; 
    }

    public function entity()
    {
        return \DGII\Model\Hacienda::where("rnc", $this->rnc())->first() ?? null;
    }

    public function flag()
    {
        if( ($stors = $this->stack()) != null )
        {
            $data = (array)(new \SimpleXMLElement( $stors->path ));
            list( $hashRnc, $hashToken ) = explode('|', $data["valor"], 2);

            return [
                "id"        => $stors->id,
                "rnc"       => base64_decode($hashRnc),
                "token"     => base64_decode($hashToken),
                "expire"    => now()->create($data["fecha"]),
                "x509"      => $this->getX509()                
            ];
        }
        else
        {
            list( $hashRnc, $hashToken ) = explode('|', $this->xml["valor"], 2);
            return [
                "rnc"       => base64_decode($hashRnc),
                "token"     => base64_decode($hashToken),
                "expire"    => now()->create($this->xml["fecha"]),
                "x509"      => $this->getX509()                
            ];
        }
    }
}