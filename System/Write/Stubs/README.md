## HEADER
<?xml version="1.0" encoding="UTF-8"?>

## AUTH
    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
        <SignedInfo>
        <CanonicalizationMethod Algorithm="{CanonicalizationMethod}"/>
        <SignatureMethod Algorithm="{SignatureMethod}"/>
            <Reference URI="{Reference}">
                <Transforms>
                <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" />
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256" />
                <DigestValue>{DigestValue}</DigestValue>
            </Reference>
        </SignedInfo>
        <SignatureValue>{SignatureValue}</SignatureValue>
        <KeyInfo>
            <X509Data>
                <X509Certificate>{X509Certificate}</X509Certificate>
            </X509Data>
        </KeyInfo>
    </Signature>

## EMICION COMPROBANTE
<EmisionComprobanteModel>
    <rnc>{rnc}</rnc>
    <tipoEncf>{tipoEncf}</tipoEncf>
    <urlRecepcion>{urlRecepcion}</urlRecepcion>
    <urlAutenticacion>{urlAutenticacion}</urlAutenticacion>
</EmisionComprobanteModel>

## EMISION APROBACION COMERCIAL
<EnvioAprobacionComercialModel>
    <urlAprobacionComercial>{urlAprobacionComercial}</urlAprobacionComercial>
    <urlAutenticacion>{urlAutenticacion}</urlAutenticacion>
    <rnc>{rnc}</rnc>
    <encf>{encf}</encf>
    <estadoAprobacion>{estadoAprobacion}</estadoAprobacion>
</EnvioAprobacionComercialModel>

## CONSULTA
<RespuestaConsultaAcuseRecibo>
    <rnc>{rnc}</rnc>
    <encf>{encf}</encf>
    <estado>{estado}</estado>
    <mensajes>{mensajes}</mensajes>
</RespuestaConsultaAcuseRecibo>

## ARECF
<ARECF xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <DetalleAcusedeRecibo>
    <Version>1.0</Version>
    <RNCEmisor>{RNCEmisor}</RNCEmisor>
    <RNCComprador>{RNCComprador}</RNCComprador>
    <eNCF>{eNCF}</eNCF>
    <Estado>{Estado}</Estado>
    <CodigoMotivoNoRecibido>{CodigoMotivoNoRecibido}</CodigoMotivoNoRecibido>
    <FechaHoraAcuseRecibo>{FechaHoraAcuseRecibo}</FechaHoraAcuseRecibo>
  </DetalleAcusedeRecibo>
</ARECF>

https://es.stackoverflow.com/questions/379305/firmar-xml-con-php-y-javascript