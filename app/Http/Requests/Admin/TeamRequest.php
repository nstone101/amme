<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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
            'name'=>'required|max:255',
            'designation'=>'required|max:255',
            'category_id'=>'required|exists:categories,id',
            'status'=>'required'
        ];

        if(!empty($this->image)){
            $rules['image']='image|mimes:jpg,png,jpeg|max:3000';
        }
        if(!empty($this->email)){
            $rules['email']= ['email','max:255',Rule::unique('teams')->ignore($this->edit_id, 'id')];
        }

        return $rules;
    }
}
