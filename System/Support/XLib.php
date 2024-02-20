<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class XLib 
{       
    const ALGORITHM         = "SHA256";

    protected $xmlNameSpace;

    protected $referenceURL;

    protected $algoMethod;

    protected $caninicalMethod;

    protected $signatureMethod;

    protected $transformURL;

    protected $digestMethodURL;

    protected $privateKey;

    protected $digestValue;

    protected $signatureValue;

    protected $X509Certificate;

    protected $DOM;

    protected $stubs;

    private static $auth = false;

    private static $certData;

    public function load($entity)
    {
        if( openssl_pkcs12_read($entity->p12, $data, $entity->password) )
        {
            ## Autorizamos firmar
            self::$auth = true;

            ## PRIVATE KEY
            $this->privateKey = openssl_pkey_get_private( $data["pkey"] );

            ## CERTIFY            
            if( openssl_x509_export( $data["cert"], $x509, true) )
            {
                //dd($x509);

                $START  = '-----BEGIN CERTIFICATE-----';
                $END    = '-----END CERTIFICATE-----';

                preg_match('/'.$START.'(.+)'.$END.'/Us', $x509, $matches);

                $this->X509Certificate =  str_replace(["\r\n", "\n"], '', trim($matches[1]));                
            }

            ## METHOD
            $this->loadMethods();
        }

        return $this;
    }

    public function loadMethods()
    {
        switch(self::ALGORITHM)
        {
            case "SHA256":
                $this->referenceURL         = '';
                $this->algoMethod           = $this->algorithm(OPENSSL_ALGO_SHA224);
                $this->xmlNameSpace         = 'http://www.w3.org/2000/09/xmldsig#';
                $this->caninicalMethod      = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
                $this->signatureMethod      = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
                $this->transformURL         = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';
                $this->digestMethodURL      = 'http://www.w3.org/2001/04/xmlenc#sha256';
                break;
        }
    }

    public function algorithm($method=0)
    {
        if( array_key_exists($method, ($methods = openssl_get_md_methods(true))) )
        {
            return $methods[$method];
        }
    }

    public function check()
    {
        return self::$auth;
    }    

    public function xml($XML) 
    {
        $this->DOM = new \DOMDocument;

        $this->DOM->preserveWhiteSpace    = env("XML_SPACE", false);
        $this->DOM->formatOutput          = env("XML_FORMAT", false);

        $this->DOM->loadXML($XML);

        $this->stubs["c14nBase"] = $this->DOM->documentElement->C14N(
            env("XML_C14NBASE_EXCLUSIVE", true), env("XML_C14NBASE_COMMENT", false)
        );

        $this->digestValue = base64_encode(
            openssl_digest( $this->stubs["c14nBase"], $this->algoMethod, true )
        );

        return $this;
    }

    public function makeSignatureValue( $c14nInfo )
    {
        $this->stubs["c14nInfo"] = $c14nInfo;

        if(openssl_sign($c14nInfo, $sign, $this->privateKey, $this->algoMethod))
        {   
            openssl_free_key($this->privateKey);
            
            $this->signatureValue = base64_encode($sign);
        } 
    }

    public function sign()
    {
        if( self::$auth ) 
        {
            $signatureElement = $this->DOM->createElement('Signature');
            $signatureElement->setAttribute('xmlns', $this->xmlNameSpace);
            $this->DOM->documentElement->appendChild($signatureElement);

            $signedInfoElement = $this->DOM->createElement('SignedInfo');
            $signatureElement->appendChild($signedInfoElement);

            $canonicalizationMethodElement = $this->DOM->createElement('CanonicalizationMethod');
            $canonicalizationMethodElement->setAttribute('Algorithm', $this->caninicalMethod);
            $signedInfoElement->appendChild($canonicalizationMethodElement);

            $signatureMethodElement = $this->DOM->createElement('SignatureMethod');
            $signatureMethodElement->setAttribute( 'Algorithm', $this->signatureMethod  );
            $signedInfoElement->appendChild($signatureMethodElement);

            $referenceElement = $this->DOM->createElement('Reference');
            $referenceElement->setAttribute('URI', $this->referenceURL);
            $signedInfoElement->appendChild($referenceElement);

            $transformsElement = $this->DOM->createElement('Transforms');
            $referenceElement->appendChild($transformsElement);

            $transformElement = $this->DOM->createElement('Transform');
            $transformElement->setAttribute('Algorithm', $this->transformURL );
            $transformsElement->appendChild($transformElement);

            $digestMethodElement = $this->DOM->createElement('DigestMethod');
            $digestMethodElement->setAttribute('Algorithm', $this->digestMethodURL);
            $referenceElement->appendChild($digestMethodElement);

            $digestValueElement = $this->DOM->createElement('DigestValue', $this->digestValue);
            $referenceElement->appendChild($digestValueElement); 

            $signatureValueElement = $this->DOM->createElement('SignatureValue', '');
            $signatureElement->appendChild($signatureValueElement);
            
            $this->makeSignatureValue( $signedInfoElement->C14N(  
                env("XML_C14NINFO_EXCLUSIVE", true), env("XML_C14NINFO_COMMENT", false)
            ));

            $xpath = new \DOMXpath( $this->DOM );
            $signatureValueElement = $this->queryDomNode($xpath, '//SignatureValue', $signatureElement);
            $signatureValueElement->nodeValue = $this->signatureValue;

            $keyInfoElement = $this->DOM->createElement('KeyInfo');
            $signatureElement->appendChild($keyInfoElement); 

            $keyValueElement = $this->DOM->createElement('KeyValue');
            $keyInfoElement->appendChild($keyValueElement);

            $x509DataElement = $this->DOM->createElement('X509Data');
            $keyInfoElement->appendChild($x509DataElement);
            $x509DataElement->appendChild(
                $this->DOM->createElement('X509Certificate', $this->X509Certificate)
            );

            return str_replace("\n", null, $this->DOM->saveXML());
        }
    }

    public function queryDomNode(\DOMXPath $xpath, string $expression, \DOMNode $contextNode): \DOMNode
    {
        $nodeList = $xpath->query($expression, $contextNode);

        if (!$nodeList) {
            throw new UnexpectedValueException('Signature value not found');
        }

        $item = $nodeList->item(0);

        if ($item === null) {
            throw new UnexpectedValueException('Signature value not found');
        }

        return $item;
    }
}