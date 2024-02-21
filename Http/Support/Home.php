<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/
use Iluminate\Http\Request;

class Home
{
    public function data()
    {
        $data['title'] = __("words.home");
        // /$user = 
        //dd(request()->user()->isGroup(101011939));

        return $data;
    }
}