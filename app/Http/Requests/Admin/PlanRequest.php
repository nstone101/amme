<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
        $rules=[
            'title'=>'required|max:255',
            'price'=>'required|numeric|max:99999999|min:1',
            'duration'=>'required|numeric|integer|max:99999999|min:1',
            'status'=>'required',
            'features'=>'required|max:255'
        ];

        return $rules;
    }
}
