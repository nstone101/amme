<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'title'=>'required|max:255'
        ];
//        if(!empty($this->parent_id)){
//            $rules['parent_id']='exists:categories,id';
//        }
        if(empty($this->edit_id)){
            $rules['image']='required|image|mimes:jpg,png,jpeg|max:3000|dimensions:min_width=260,min_height=210';
        }else{
            if(!empty($this->image)){
                $rules['image']='image|mimes:jpg,png,jpeg|max:3000|dimensions:min_width=260,min_height=210';
            }
        }
        return $rules;
    }
    public function messages()
    {
        $messages=[
            'title.required'=>__('Title field can\'t be empty.')
            ,'title.max'=>__('Title field can\'t be more than 255 character.')
        ];
        if(empty($this->edit_id)){
            $messages['image.required']=__('Image field can\'t be empty.');
            $messages['image.image']=__('Image must be in jpg,jpeg or png format');
            $messages['image.mimes']=__('Image must be in jpg,jpeg or png format');
            $messages['image.max']=__('Image size can\'t be more than 2MB.');
        }else{
            if(!empty($this->image)){
                $messages['image.image']=__('Image must be in jpg,jpeg or png format');
                $messages['image.mimes']=__('Image must be in jpg,jpeg or png format');
                $messages['image.max']=__('Image size can\'t be more than 2MB.');
                $messages['image.dimensions']=__('Image dimensions should greater than 260*210 px.');
            }
        }
        return $messages;
    }
}
