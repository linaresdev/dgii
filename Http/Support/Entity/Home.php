<?php
namespace DGII\Http\Support\Entity;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Home
{

    public function  user() {
        return request()->user();
    }

    public function index()
    {
        $data['title']      = __("entity.owner");
        $data["container"]  = "col-xl-6 offset-xl-3 col-lg-10 offset-lg-1";
        $data["user"]       = request()->user();
        
        return $data;
    }


}