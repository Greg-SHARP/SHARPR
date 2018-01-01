<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Types implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //create allowed type array
        $allowed_type = ['instructor', 'student', 'institution'];

        //if not allowed user type, throw arror
        if(!in_array($value, $allowed_type)){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User type not allowed';
    }
}
