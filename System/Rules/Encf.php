<?php
 
namespace DGII\Rules;
 
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
 
class Encf implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if( (strlen($value) != 13)  OR (!in_array(substr($value, 0, 3), ['E31','E33','E34','E44', 'E45'])) )
        {
            $fail('El '.$attribute.' no valido');
        }
    }
}