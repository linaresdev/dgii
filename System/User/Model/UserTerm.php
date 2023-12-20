<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Model\TermTaxonomy;
use Illuminate\Database\Eloquent\Model;

class UserTerm extends Model {

    protected $table = 'termtaxonomies';

    protected $fillable = [
        "id",
        "term_id",
        "obj_id",
        "meta",
        "created_at",
        "updated_at"
    ];

    public function taxonomy() {
        return $this->belongsToMany(TermTaxonomy::class, "taxonomies", "term_id", "tax_id")->withPivot(
            "meta"
        );
    }

}