<?php
namespace DGII\Http\Support\Entity;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class Home
{
    public function index()
    {
        $data['title'] = __("words.entities");

        $data["container"] = "col-xl-8 offset-xl-2 col-lg-10 offset-lg-1";

        return $data;
    }
}