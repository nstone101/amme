<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
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
            'description'=>'required',
            'category_id'=>'required|exists:blog_categories,id',
            'status'=>'required'
        ];

        if(!empty($this->image)){
            $rules['image']='image|mimes:jpg,png,jpeg|max:3000';
        }

        return $rules;
    }
}
