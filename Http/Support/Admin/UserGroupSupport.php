<?php
namespace DGII\Http\Support\Admin;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Model\Term;

class UserGroupSupport
{
    protected $term;

    public function __construct( Term $term) {
        $this->term = $term;
    }

    public function index()
    {
        $data['title']      = __("words.accounts-users");
        $data['subtitle']   = __("words.groups");

        $data["groups"]     = $this->getGroups(15);

        return $data;
    }

    public function getGroups($perpage) {
        return $this->term->paginate($perpage);
    }
}