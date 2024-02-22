<?php
namespace DGII\Http\Support\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class EntitySupport
{
    public function index($entity) {

        $data["icon"]   = '<span class="mdi mdi-bank"></span>';
        $data['title']  = $entity->name;

        $data["container"]  = "col-xl-8 offset-xl-2 col-lg-10 offset-lg-1";
        $data["entity"]     = $entity;
        $data["arecf"]      = $entity->arecf->take(10);

        //dd($entity->arecf[0]->pathECF);
        return $data;
    }
}