<?php
namespace DGII\Http\Request\Admin;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Foundation\Http\FormRequest;

class EntityRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules()
    {
        return [
            "name"      => "required",
            "rnc"       => "required|numeric|isRnc|unique:\DGII\Model\Hacienda,rnc",
            "certify"   => "required",
            "pwd"       => "required"
        ];
    }

    public function attributes() {
        return [
            "name"  => __("business.name"),
            "rnc"   => "RNC",
            "certify" => __("words.certify"),
            "pwd" => __("words.password")
        ];
    }

    public function messages() {
        return [
            "required"  => __('validation.required'),
            "unique"    => __("validator.name.business")
        ];
    }

    public function validatorInstance() {
        return $this->validator;
    }

    public function getCertifyContent()
    {
        if($this->hasFile("certify"))
        {
            return $this->file("certify")->getContent();
        }
    }

    public function moveCertify($path, $name) {
        $this->certify->move($path, $name);
    }

    public function news($field, $message) {
        $validate = $this->validatorInstance();
        $validate->errors()->add($field, $message);
        return back()->withErrors($validate)->withInput();
    }

}