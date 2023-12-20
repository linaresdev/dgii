<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class TermMeta extends Model {

    protected $table = 'termsmeta';

    protected $fillable = [
        "id",
        "term_id",
        "type",
        "key",
        "value",
        "activated"
    ];

    public $timestamps = false;
}