<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => ['required'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/']
        ];
    }

    public function messages()
    {
        return [
            'email.required'     => 'Enter your valid E-mail address',
            'email.email'        => 'This appears to be an invalid E-mail',
            'password.required'  => 'Enter a secure password',
            'password.confirmed' => 'Passwords do not match',
            'password.min'       => 'Password cannot be less than 8 characters',
            'password.regex'     => 'Password must contain at least 1 lowercase letter, 1 uppercase letter, 1 number AND 1 symbol'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
