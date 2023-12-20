<?php
namespace DGII\Http\Request;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class DgiiRequest 
{

    public function note($request, $message) {
        $validator->replace("isRNC", function($message, $attribute, $rule, $parameters) {
            return "La lonfitud del campo {$attribute} no es valido";
        });
    }
    public function isRNC($attribute, $value, $parameters, $validator)
    {
        // $validator->replace("isRNC", function($message, $attribute, $rule, $parameters) {
        //     return "La lonfitud del campo {$attribute} no es valido";
        // });

        return in_array(strlen($value), [9, 11]);
    }

    public function isENCF($attribute, $value, $parameters, $validator)
    {
        if(strlen($value) != 13 ) return false;
        if(!in_array(substr($value, 0, 3), ['E31','E33','E34','E44'])) return false;

        return true;
    }
}