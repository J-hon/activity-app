<?php

namespace App\Http\Requests;

use App\Rules\MaxActivityRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateActivityRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title'       => ['required', Rule::unique('activities')->where(
                function ($query) {
                    return $query->where('created_at', '=', now());
                }
            )],
            'description' => ['required'],
            'image'       => ['required'],
            'due_date'    => ['required', 'date_format:Y-m-d', new MaxActivityRule()],
            'is_global'   => ['required', 'boolean'],
            'user_id'     => ['required_if:is_global,false', 'exists:users,id']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
