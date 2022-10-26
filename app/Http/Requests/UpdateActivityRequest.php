<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title'       => ['required'],
            'description' => ['required'],
            'image'       => ['required']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
