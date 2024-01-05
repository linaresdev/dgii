<?php
namespace DGII\Http\Request;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules()
    {
        return [
            "email"     => "required",
            "password"  => "required"
        ];
    }

    public function attributes()
    {
        return [
            "email"     => __("words.email"),
            "password"  => __("words.password")
        ];
    }

    public function messages()
    {
        return [
            "required" => __("validation.required")
        ];
    }

}