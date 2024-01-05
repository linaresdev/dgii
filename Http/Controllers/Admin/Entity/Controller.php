<?php
namespace DGII\Http\Controllers\Admin\Entity;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/


use DGII\Http\Controllers\Admin\Controller as BaseController;

class Controller extends BaseController {
    
    protected $path = "dgii::admin.entity.";

    public function setLayout() {
        return [
            "container" => "col-xl-6 offset-xl-3 col-md-10 offset-md-1"
        ];
    }
}