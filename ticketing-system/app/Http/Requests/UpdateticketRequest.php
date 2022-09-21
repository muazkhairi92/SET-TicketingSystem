<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateticketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'categories_id'=>'exists:categories,id',
            'priority_levels_id'=>'exists:priority_levels,id',
            'statuses_id'=>'exists:statuses,id',
        ];
    }
}
