<?php
namespace DGII\Http\Request\Admin;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest 
{
    public function authorize() {
        return true;
    }

    public function rules()
    {
        return [
            "firstname"   	=> "required",
            "lastname"      => "required",
            "email"       	=> "required|email|unique:users,email",
            "password"      => "required"
        ];
    }

    public function attributes() {
        return [
            "firstname" 	=> __("words.firstname"),
            "lastname" 		=> __("words.lastname"),
            "email" 		=> __("words.email"),
            "password" 		=> __("words.password")
        ];
    }

    public function messages() {
        return [
        	"email"	=> __("validate.bad.email")
        ];
    }

    // public function validatorInstance() {
    //     return $this->validator;
    // }

    // public function getCertifyContent()
    // {
    //     if($this->hasFile("certify"))
    //     {
    //         return $this->file("certify")->getContent();
    //     }
    // }

    // public function moveCertify($path, $name) {
    //     $this->certify->move($path, $name);
    // }

    // public function news( $field, $message )
    // {
    //     $validate = $this->validatorInstance();
    //     $validate->errors()->add($field, $message);
    //     return back()->withErrors($validate)->withInput();
    // }
}