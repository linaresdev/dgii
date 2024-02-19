<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class XML {

    protected $xml;

    protected $entity;

    protected $signs;

    protected $referenceUri;

    private static $sign;

    public function __construct( $entity )
    {
        $this->entity   = $entity;
        self::$sign     = ($signs = (new \DGII\Write\Signer));
        

        ## CONFIG SIGN
        $signs->from($this->entity);
        $signs->method(OPENSSL_ALGO_SHA256);

        ## LOADS
        $this->signs["canonialurl"]     = $signs->getCanonicalUrl();

        $this->signs["signmethod"]      = $signs->getSignMethod();
        $this->signs["algomethod"]      = $signs->getAlgoUrl();
        $this->signs["trasforms"]       = "http://www.w3.org/2000/09/xmldsig#enveloped-signature";
        $this->signs["digestmethod"]    = "http://www.w3.org/2001/04/xmlenc#sha256";
        $this->signs["signaturevalue"]  = $signs->getSignatureValue();
        
        $this->signs["X509Certificate"] = $signs->getX509();
    }

    public function xml( $xml=null )
    {
        $this->xml = new \DOMDocument( env("XML_VERSION", 1.0), env("XML_ENCODE", "utf-8"));

        $this->xml->preserveWhiteSpace = env("XML_SPACE", true);
        $this->xml->formatOutput = env("XML_FORMAT", false);

        $this->xml->loadXML($xml); 

        $canonical    = $this->xml->documentElement;
        $canonical    = $canonical->C14N(
            env("XML_CANONICAL_EXCLUSIVE", true), env("XML_CANONICAL_COMMENT", false)
        );
        $this->signs["diguestvalue"]   = self::$sign->getDigestValue( $canonical );
        
        return $this;
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

    public function sign( $format=false )
    {
        $xml = $this->xml;
        
        $signatureElement = $xml->createElement('Signature');
        $signatureElement->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
        $xml->documentElement->appendChild($signatureElement);

        $signedInfoElement = $xml->createElement('SignedInfo');
        $signatureElement->appendChild($signedInfoElement);

        $canonicalizationMethodElement = $xml->createElement('CanonicalizationMethod');
        $canonicalizationMethodElement->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
        $signedInfoElement->appendChild($canonicalizationMethodElement);

        $signatureMethodElement = $xml->createElement('SignatureMethod');
        $signatureMethodElement->setAttribute(
            'Algorithm',
            $this->signs["signmethod"]
        );
        $signedInfoElement->appendChild($signatureMethodElement);

        $referenceElement = $xml->createElement('Reference');
        $referenceElement->setAttribute('URI', $this->referenceUri);
        $signedInfoElement->appendChild($referenceElement);

        $transformsElement = $xml->createElement('Transforms');
        $referenceElement->appendChild($transformsElement);

        // Enveloped: the <Signature> node is inside the XML we want to sign
        $transformElement = $xml->createElement('Transform');
        $transformElement->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
        $transformsElement->appendChild($transformElement);

        $digestMethodElement = $xml->createElement('DigestMethod');
        $digestMethodElement->setAttribute('Algorithm', $this->signs["digestmethod"]);
        $referenceElement->appendChild($digestMethodElement);

        $digestValueElement = $xml->createElement('DigestValue', $this->signs["diguestvalue"]);
        $referenceElement->appendChild($digestValueElement); 

        $signatureValueElement = $xml->createElement('SignatureValue', '');
        $signatureElement->appendChild($signatureValueElement);
        
        $c14nSignedInfo = $signedInfoElement->C14N(true, false);
        $signatureValue = self::$sign->signatureValue($c14nSignedInfo);
         
        $xpath = new \DOMXpath($xml);
        $signatureValueElement = $this->queryDomNode($xpath, '//SignatureValue', $signatureElement);
        $signatureValueElement->nodeValue = base64_encode($signatureValue);

        $keyInfoElement = $xml->createElement('KeyInfo');
        $signatureElement->appendChild($keyInfoElement);       

        $keyValueElement = $xml->createElement('KeyValue');
        $keyInfoElement->appendChild($keyValueElement);

        $x509DataElement = $xml->createElement('X509Data');
        $keyInfoElement->appendChild($x509DataElement);
        $x509CertificateElement = $xml->createElement('X509Certificate', $this->signs["X509Certificate"]);
        $x509DataElement->appendChild($x509CertificateElement);

        return $this->xml->saveXML();
    }
}