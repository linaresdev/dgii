<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class Term extends Model {

    protected $table = 'terms';

    protected $fillable = [
        "id",
        "type",
        "parent",
        "slug",
        "name",
        "activated",
        "aling",
        "counter",
        "created_at",
        "updated_at"
    ];

    public function taxonomy() {
        return $this->belongsToMany(TermTaxonomy::class, "relations", "term_id", "tax_id")->withPivot(
            "meta"
        )->using(\XMalla\XUser\Model\UserGroupPivot::class);
    }

    public function syncObject($objID, ) {
        $this->taxonomy()->attach($this->id, $rols);
    }

    public function addParent($data) {

        if( $this->id > 0 ) {
            $data["parent"] = $this->id;           
            $this->create($data);
        }

        return $this;
    }

    public function getParent($parent) {
        return $this->where("type", "users-rols")->where("parent", $parent)->get();
    }
    
    public function syncTax(array $rols) {
        $this->taxonomy()->attach($this->id, $rols);
    }

    public function setMetaAttribute($value) {        
    }

    /*
    * QUERY */
    public function tax($type, $slug) {
       return  $this->where("type", $type)->where("slug", $slug)->first() ?? null;
    }

    public function deleteTax($type, $slug) 
    {
        if( ($tax = $this->tax($type, $slug)) != null ) {
            return $tax->delete();
        }

        return false;
    }

    public function meta() {
        return $this->pivot->meta;
    }

}