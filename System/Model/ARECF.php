<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class ARECF extends Model {

    protected $table = 'ARECF';

    protected $fillable = [
        "RNCEmisor",
        "RNCComprador",
        "eNCF",
        "Estado",
        "FechaHoraAcuseRecibo",
        "CodigoMotivoNoRecibido",
        "pathECF",
        "pathARECF",
        "created_at",
        "updated_at"
    ];
}