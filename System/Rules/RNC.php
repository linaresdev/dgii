<?php
 
namespace DGII\Rules;
 
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
 
class RNC implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if( !in_array(strlen($value), [9, 11]) )
        {
            $fail('El '.$attribute.' no valido');
        }
    }
}