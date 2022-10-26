<?php

namespace App\Rules;

use App\Models\Activity;
use Illuminate\Contracts\Validation\Rule;

class MaxActivityRule implements Rule
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
        if (Activity::where('due_date', '=', $value)->count() >= 4) {
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
        return "Maximum limit of 4 activities reached for each day";
    }
}
