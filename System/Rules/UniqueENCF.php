<?php
 
namespace DGII\Rules;
 
use Closure;
use DGII\Model\AprobacionComercial;
use Illuminate\Contracts\Validation\ValidationRule;
 
class UniqueENCF implements ValidationRule
{
    public function __construct($entity) {
        $this->entity = $entity;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $store = new AprobacionComercial();
        
        $exists = $store->where("RNCEmisor", $this->entity["RNCEmisor"])->where("eNCF", $this->entity["eNCF"]);
       
        if( $exists->count() > 0 ) {
            $fail('El '.$attribute.' no valido');
        }
    }
}