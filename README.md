# DGII
Api Corporativa para la DGII.
Esta api es la intermediaria entre un punto de venta corporativo, la DGII y el Cliente.

### INSTALACIÓN
#### Instalación a traves de composer

```bash
composer require rlinaresdev/dgii
```

#### Seeder

```bash
php artisan db:seed --class="DGII\\Database\\Seeds\\DGIISeeds"
```

### ENVIRONMENTS

El ambiente de trabajo por defecto es testecf
Estas variables deben agregarse en el archivo .env de Laravel 

```
DGII_ENV=testecf
DGII_AUTH_TIMEOUT=120
```

### END POINT
#### Autenticación
```php
# Solicitud de Semilla XML para la firma.
# curl -X 'GET' \
#  'https://tudominio-aqui/testecf/emisorreceptor/fe/Autenticacion/api/Semilla' \
#  -H 'accept: application/json'

Route::get("{env}/emisorreceptor/fe/Autenticacion/api/Semilla","AuthController@getSeed");

# Autenticación a travez de la Semilla firmada.
# curl -X 'POST' \
#  'https://tudominio-aqui/testecf/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado' \
#  -H 'accept: application/json' \
#  -H 'Content-Type: multipart/form-data' \
#  -F 'xml=@SemillaSigned.xml;type=text/xml'

Route::post("{env}/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado","AuthController@postGuest");
```
#### Emisión

```php
# Envio de comprovante o factura a la Recepción del Contribuyente.
#curl -X 'POST' \
#  'https://tudominio-aqui/testecf/emisorreceptor/api/Emision/EmisionComprobantes' \
#  -H 'accept: */*' \
#  -H 'Content-Type: application/json-patch+json' \
#  -d '{
#  "rnc": "string",
#  "tipoEncf": "string",
#  "urlRecepcion": "string",
#  "urlAutenticacion": "string"
#}'

Route::post("{env}/emisorreceptor/api/Emision/EmisionComprobantes","EnviarComprobanteController@index");

# Consulta estado o acuse de recibo del eCF a partir del RNC, E-NCF
#curl -X 'GET' \
#  'https://tudominio-aqui/testecf/emisorreceptor/api/Emision/ConsultaAcuseRecibo?Rnc=ad&Encf=ad' \
#  -H 'accept: application/json'

Route::get("{env}/emisorreceptor/api/Emision/ConsultaAcuseRecibo?Rnc=ad&Encf=ad","ConsultaReciboController@index");

# Envio de la Aprobación Comercial a la url de recepción del contribuyente.
#curl -X 'POST' \
#  'https://tudominio-aqui/testecf/emisorreceptor/api/Emision/EnvioAprobacionComercial' \
#  -H 'accept: application/json' \
#  -H 'Content-Type: application/json-patch+json' \
#  -d '{
#  "urlAprobacionComercial": "string",
#  "urlAutenticacion": "string",
#  "rnc": "string",
#  "encf": "string",
#  "estadoAprobacion": "string"
#}'

Route::post("{env}/emisorreceptor/api/Emision/EnvioAprobacionComercial","EnviarAprobacionComercialController@index");
```

#### Recepción

```php
# Recepción de la Aprobación Comercial, enviada por el Emisor.
#curl -X 'POST' \
#  'https://tudominio-aqui/testecf/emisorreceptor/fe/AprobacionComercial/api/ecf' \
#  -H 'accept: */*' \
#  -H 'Content-Type: multipart/form-data' \
#  -F 'xml=@ECF.xml;type=text/xml'

Route::post("{env}/emisorreceptor/fe/AprobacionComercial/api/ecf","RecepcionComprobanteController@index");

# Recepción del comprobante o factura, enviada por el Emisor.
#curl -X 'POST' \
#  'https://tudominio-aqui/testecf/emisorreceptor/fe/Recepcion/api/ecf' \
#  -H 'accept: */*' \
#  -H 'Content-Type: multipart/form-data' \
#  -F 'xml=@Certify(2).xml;type=text/xml'

Route::get("{env}/emisorreceptor/fe/Recepcion/api/ecf","RecepcionECFController@index");
```