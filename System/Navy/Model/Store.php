<?php
namespace DGII\Navy\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class Navy extends Model {

    protected $table = 'navies';

    protected $fillable = [
        "id",
        "parent",
        "icon",
        "label",
        "url"
    ];

    public function items() {
        return $this->belongsToMany(Term::class, "taxonomies", "obj_id", "term_id")->withPivot(
           "meta"
        );//->using(\DGII\User\Model\UserGroupPivot::class);
    }

    public function syncItem( $termID=0, $meta=null ) {
        return  $this->taxonomies()->attach($termID, ["meta" => $meta]);
    }
}