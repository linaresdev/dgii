<?php
namespace DGII\Http\Request;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function attributes()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }
}