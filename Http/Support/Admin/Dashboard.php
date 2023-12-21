<?php
namespace DGII\Http\Support\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Dashboard {

    public function index() {

        $data['title'] = 'Administración';

        return $data;
    }
}