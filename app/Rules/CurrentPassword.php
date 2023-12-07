<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrentPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if($attribute == "password")
        {
            if(Hash::check($value, auth()->user()->password))
            {
                $fail("The new password cannot be the same as the current one.");
            }
        }
        if($attribute == "current_password")
        {
            if(!Hash::check($value, auth()->user()->password))
            {
                $fail("These credentials do not match our records.");
            }
        }
    }
}
