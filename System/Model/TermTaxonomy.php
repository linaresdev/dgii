<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model {

    protected $table = 'termstaxonomies';

    protected $fillable = [
        "id",
        "term_id",
        "obj_id",
        "meta",
        "created_at",
        "updated_at"
    ];

    public function taxonomy() {
        return $this->belongsToMany(Term::class, "taxonomies", "term_id", "obj_id")->withPivot(
            "meta"
        );
    }

}