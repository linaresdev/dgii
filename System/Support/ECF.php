<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Validation\Rule;

class ECF {

    protected $data;

    protected $original;

    public function hasData()
    {
        return (empty($this->data) == false);
    }
    public function toArray()
    {
        return $this->data;
    }
    public function add($key=null, $value=null)
    {
        if( !empty($key) && is_string($key) )
        {
            $this->data[$key] = $value;
        }
    }
    public function get($key=null)
    {
        if( array_key_exists($key, $this->data) )
        {
            return $this->data[$key];
        }
    }

    public function getOriginData()
    {
        return $this->original;
    }

    public function path($XML)
    {
        if( app("files")->exists($XML) )
        {
            return $this->load(app("files")->get($XML));
        }
    }

    public function load($xmlContent=null)
    {
        if( $xmlContent != null )
        {
            $elements           = (new \SimpleXMLElement( $xmlContent ));
            $header             = (array) $elements->Encabezado;
            $data["Version"]    = $header["Version"];
            
            
            $IdDoc      = (array) $elements->Encabezado->IdDoc;
            $Emisor     = (array) $elements->Encabezado->Emisor;
            $Comprador  = (array) $elements->Encabezado->Comprador;
            $Totales    = (array) $elements->Encabezado->Totales;
            $Signature  = [];

            ## Collect
            $data = array_merge($data, $IdDoc);

            ## Signature
            if( isset($elements->Signature) )
            {
                $signer = (array) $elements->Signature;
                $Signer["SignedInfo"]       = $this->getSignedInfoFromECF($signer);
                $Signer["SignatureValue"]   = $this->getSignatureValueFromECF($signer);
                $Signer["X509"]   = $this->getX509CertificateFromECF($signer);
                $Signature["Signature"] = $Signer;
            }
            
            $data = array_merge($data, $Emisor);
            $data = array_merge($data, $Comprador);
            $data = array_merge($data, $Totales); 
            $data = array_merge($data, $Signature);
    
            $this->original = ($this->data = $data);
        }

        return $this;
    }

    public function getSignedInfoFromECF($signer)
    {
        $SignedInfo = null;

        if( array_key_exists("SignedInfo", $signer) )
        {
            foreach(((array) $signer["SignedInfo"]) as $key => $value )
            {
                $SignedInfo[$key] = (array) $value;
            }
        }

        return $SignedInfo;
    }
    
    public function getSignatureValueFromECF($signer)
    {
        $SignatureValue = null;

        if( array_key_exists("SignatureValue", $signer) )
        {
            $SignatureValue = $signer["SignatureValue"];
        }

        return $SignatureValue;
    }

    public function getX509CertificateFromECF($signer)
    {
        if( array_key_exists("KeyInfo", $signer) )
        {
           foreach( ((array) $signer["KeyInfo"]) as $key => $value )
           {
                if( array_key_exists("X509Certificate",($cert = (array) $value)) )
                {
                    return $cert["X509Certificate"];
                }
           }
        }
    }

    public function checkSignature()
    {
        $ruls["SignedInfo"]                 = "required";
        $ruls["SignatureValue"]             = "required";
        $ruls["X509"]                       = "required";

        return validator($this->get("Signature"), $ruls);
    }

    public function checkRNCComprador()
    {
        $ruls["RNCComprador"]   = "";
        return validator($this->data, $ruls);
    }

    public function exists() 
    {
        $ruls["pathARECF"] = "unique:\DGII\Model\ARECF,pathARECF";
        return validator($this->data, $ruls);
    }

    public function validate( $ruls=null, $messages=[], $attributes=[] )
    {
        ## RULS
        $ruls["Version"]        = "required|numeric";
        $ruls["TipoeCF"]        = ["required","numeric", Rule::in([31,33,34,44])];
        $ruls["eNCF"]           = ["required", new \DGII\Rules\Encf];
        $ruls["RNCEmisor"]      = ["required","numeric",new \DGII\Rules\RNC];
        $ruls["RNCComprador"]   = ["required","numeric",new \DGII\Rules\RNC];
        $ruls["FechaEmision"]   = "required";
        
        $ruls["MontoTotal"]     = "required|numeric";
        //$ruls["path"]           = "unique:\DGII\Model\Recepcion,path";

        return validator($this->data, $ruls);
    }

    public function makeAprobacionComercial()
    {
        if( app("files")->exists( ($pathStub = __path("{xmlstub}/AprobacionComercial.txt")) ) )
        {
            $stub = app("files")->get($pathStub);
            $stub = str_replace('{RNCEmisor}', $this->data["RNCEmisor"], $stub);
            $stub = str_replace('{eNCF}', $this->data["eNCF"], $stub);
            $stub = str_replace('{FechaEmision}', $this->data["FechaEmision"], $stub);
            $stub = str_replace('{MontoTotal}', $this->data["MontoTotal"], $stub);
            $stub = str_replace('{RNCComprador}', $this->data["RNCComprador"], $stub);
            
            return $stub;
        }
        
    }

}