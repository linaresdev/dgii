# DGII
Api Corporativa DGII.

### INSTALACIÓN
#### Instalacion a traves de composer

```bash
composer require rlinaresdev/malla
```

#### Seeder

```bash
php artisan db:seed --class="DGII\\Database\\Seeds\\DGIISeeds"
```

### END POINT
#### Autenticación
```php
# Solicitud de Semilla XML para la firma.
Route::get("{env}/emisorreceptor/fe/Autenticacion/api/Semilla","AuthController@getSeed");

# Autenticación a travez de la Semilla firmada.
Route::post("{env}/emisorreceptor/fe/Autenticacion/api/ValidacionCertificado","AuthController@postGuest");
```
#### Emisión

```php
# Envio de comprovante o factura a la recepcion del contribuyente.
Route::post("{env}/emisorreceptor/api/Emision/EmisionComprobantes","EnviarComprobanteController@index");

# Consulta estado o acuse de recibo del eCF a partir del RNC, E-NCF
Route::get("{env}/emisorreceptor/api/Emision/ConsultaAcuseRecibo?Rnc=ad&Encf=ad","ConsultaReciboController@index");

# Envio de la Aprobación Comercial a la url de recepción del contribuyente.
Route::post("{env}/emisorreceptor/api/Emision/EnvioAprobacionComercial","EnviarAprobacionComercialController@index");
```

#### Recepción

```php
# Recepción de la Aprobación Comercial, enviada por el Emisor.
Route::post("{env}/emisorreceptor/fe/AprobacionComercial/api/ecf","RecepcionComprobanteController@index");

# Recepción del comprobante o factura, enviada por el Emisor.
Route::get("{env}/emisorreceptor/fe/Recepcion/api/ecf","RecepcionECFController@index");
```