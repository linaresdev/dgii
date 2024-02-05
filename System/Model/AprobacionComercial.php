<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class AprobacionComercial extends Model {

    protected $table = 'APROBACIONCOMERCIAL';

    protected $fillable = [
        "id",
        "hacienda_id",
        "RNCEmisor",
        "eNCF",
        "FechaEmision",
        "RNCComprador",
        "filename",
        "path",
        "state",
        "created_at",
        "updated_at"
    ];
}