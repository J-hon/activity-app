<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title'       => ['required'],
            'description' => ['required'],
            'image'       => ['required'],
            'is_global'   => ['required', 'boolean']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
