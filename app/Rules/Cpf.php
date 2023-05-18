<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpfLength = Str::length($value);

        if(is_numeric($value))
        {
            if($cpfLength == 11)
            {
                $verify = [0, 0];
                //First number verification
                for($i = 0; $i < 10; ++$i)
                {
                    if($i < 9)
                    {
                        $verify[0] += intval($value[$i]) * (10-$i);
                    }
                    $verify[1] += intval($value[$i]) * (11-$i);
                }
                //dd($verify);
                for($i = 0; $i < 2; ++$i)
                {
                    if($verify[$i]%11 < 2)
                    {
                        $verify[$i] = 0;
                    }
                    else
                    {
                        $verify[$i] = 11 - ($verify[$i] % 11);
                    }
                    if(intval($value[9 + $i]) !== $verify[$i])
                    {
                        $fail('Invalid :attribute.');
                    }
                }
            }
            else
            {
                $fail(':attribute must be 11 digits.');
            }
        }
        else
        {
            $fail(':attribute contains invalid characters.');
        }
    }
}
