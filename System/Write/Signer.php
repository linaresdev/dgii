<?php
namespace DGII\Write;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Write\Support\XmlRead;

class Signer
{
    protected $seed;

    protected $entity;

    protected $algoMethod;

    protected $algoUrl;

    protected $canonicalUrl;

    private static $data;

    private static $loged = false;

    protected $algorithm = [
    ];

    public function load($key=null)
    {
        return $this;
    }

    public function from($entity)
    {
        if( openssl_pkcs12_read($entity->p12, $data, $entity->password) )
        {
            self::$loged    = true;
            self::$data     = $data;
        }

        return $this;
    }

    public function before( $tag=null, $xml=null )
    {
        if( ($this->check() == true ) && !empty($tag) && !empty($xml) )
        {
            $dom = new \DOMDocument;

            $dom->preserveWhiteSpace    = false;
            $dom->formatOutput          = true;
            $dom->loadXML($xml);

            $this->seed = $dom;

            return $this->method(OPENSSL_ALGO_SHA256)->sign($tag, true);
        }
    }


    public function isValid($xml)
    {
        $xmlReader = new \XMLReader();
        $xmlReader->xml($xml);
        $xmlReader->setParserProperty(\XMLReader::VALIDATE, true);
        
        return $xmlReader->isValid();
    }

    public function entity($xml)
    {
        if( $this->isValid($xml) )
        { 
            if( ($ent = (new XmlRead($xml))->entity()) != null )
            { 
                if( openssl_pkcs12_read($ent->p12, $data, $ent->password) )
                {
                    self::$loged    = true;
                    self::$data     = $data;
                    
                    $dom                        = new \DOMDocument;
                    $dom->preserveWhiteSpace    = false;
                    
                    $dom->loadXML($xml);
            
                    $this->seed = $dom;
                }
            }
        }

        return $this;
    }
    public function xml($xml=null)
    {
        $xmlReader = new \XMLReader();
        $xmlReader->xml($xml);
        $xmlReader->setParserProperty(\XMLReader::VALIDATE, true);

        if( $xmlReader->isValid() )
        {
            $dom                        = new \DOMDocument;
            $dom->preserveWhiteSpace    = false;
            
            $dom->loadXML($xml);
    
            $this->seed = $dom;
        }

        return $this;
    }

    public function certify($certContent=null, $password=null)
    {
        if( openssl_pkcs12_read($certContent, $data, $password) )
        {
            self::$loged    = true;
            self::$data     = $data;
        }

        return $this;
    }

    public function loadCertData( $data )
    {
        self::$loged    = true;
        self::$data     = $data;

        return $this;
    }

    public function check()
    {
        return self::$loged;
    }

    public function method( $typeAlgorithm=OPENSSL_ALGO_SHA1 )
    {
        switch ( $typeAlgorithm )
        {
            case 6:
                $this->algoMethod   = OPENSSL_ALGO_SHA224;
                $this->canonicalUrl = "http://www.w3.org/TR/2001/REC-xml-c14n-20010315";
                $this->algoUrl      = "http://www.w3.org/2001/04/xmldsig-more#sha224";
                break;
            case 7:
                $this->algoMethod   = OPENSSL_ALGO_SHA256;
                $this->canonicalUrl = "http://www.w3.org/TR/2001/REC-xml-c14n-20010315";
                $this->algoUrl      = "http://www.w3.org/2001/04/xmldsig-more#rsa-sha256";
                break;
        }

        return $this;
    }

    public function getEntity()
    {
        return $this->entity;
    }
    
    public function getMethod()
    {
        if(array_key_exists($this->algoMethod, ($methods = openssl_get_md_methods(true))) )
        {
            return $methods[$this->algoMethod];
        }
    }

    public function getCanonical( $exclusive=true, $comment=false )
    {
        if( !empty( $this->seed ) )
        {
            if( ($element = $this->seed->documentElement) != null )
            {
                return $element->C14N($exclusive, $comment);
            }
        }
    }

    public function getDigestValue($canonical=null, $method=null)
    {
        if( !empty(($canonical = $this->getCanonical())) && !empty(($method = $this->getMethod())) )
        {
            return base64_encode(openssl_digest($canonical, $method));
        }
    }

    public function getCanonicalUrl()
    {
        return $this->canonicalUrl;
    }
    public function getCanonicalMethod()
    {
        return $this->canonicalMethod();
    }
    public function getSignatureMethod()
    {
        return $this->algoUrl;
    }

    public function getSignatureValue()
    {
        $pkey   = openssl_get_publickey(self::$data["cert"]);
        $pkeyID = openssl_pkey_get_private(self::$data["pkey"]);
        
        if(openssl_sign($this->getCanonical(false), $sign, $pkeyID, $this->algoMethod))
        {
            openssl_free_key($pkeyID);
            return base64_encode($sign);
        }        
    }

    public function getX509( $detail=true )
    {
        if(openssl_x509_export(self::$data["cert"], $x509, $detail))
        {
            $x509 = str_replace("-----BEGIN CERTIFICATE-----\n", '', $x509);
            $x509 = str_replace("-----END CERTIFICATE-----\n", '', $x509);
            return $x509;
        }        
    }

    public function sign($reemplace='</SemillaModel>', $format=false)
    {
        $stubSigner = app("files")->get(__DIR__."/Stubs/xmlsig.txt");
        //$this->seed->formatOutput = $format;

        $data['{CanonicalizationMethod}'] = $this->getCanonicalUrl();
        $data['{SignatureMethod}'] = $this->getSignatureMethod();
        $data['{Reference}'] = "";
        //$data['{DigestMethod}'] = $this->getDigestMethod();
        $data['{DigestValue}'] = $this->getDigestValue();
        $data['{SignatureValue}'] = $this->getSignatureValue();
        $data['{X509Certificate}'] = $this->getX509();

        foreach($data as $key => $value )
        {
            $stubSigner = str_replace($key, $value, $stubSigner);
        }
        $this->seed->formatOutput = true;
        $seed = $this->seed->saveXML();

        $sign = str_replace($reemplace, $stubSigner, $seed);
        $sign .= $reemplace;

        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;

        $dom->formatOutput = $format;
        $dom->loadXML($sign);

        return $dom->saveXML();       
    }
}