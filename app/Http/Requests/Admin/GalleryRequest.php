<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'category_id'=>'required|exists:gallery_categories,id',
            'status'=>'required'
        ];

        if(empty($this->edit_id)){
            $rules['image']='required|image|mimes:jpg,png,jpeg|max:4000';
        }
        if(!empty($this->image)){
            $rules['image']='image|mimes:jpg,png,jpeg|max:4000';
        }

        return $rules;
    }
}
