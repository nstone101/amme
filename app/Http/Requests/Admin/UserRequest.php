<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|max:256'
            ,'email'=>'required|email|max:256'
            ,'role'=>'required|exists:roles,id|max:256'
            ,'country'=>'required|max:256'
        ];
        if(!empty($this->phone)){
            $rules['phone']='numeric|phone_number|max:13';
        }
        if(empty($this->edit_id)){
            $rules['password']='required|confirmed|min:8';
            $rules['password_confirmation']='required';
            $rules['email']='unique:users,email';
        }
        return $rules;
    }
    public function messages()
    {
        $message=[
            'name.required'=>__('Name field can\'t be empty.')
            ,'name.max'=>__('Name can\'t be more than 255 character.')
            ,'email.required'=>__('Email field can\'t be empty.')
            ,'email.email'=>__('Invalid Email formate.')
            ,'email.max'=>__('Email can\'t be more than 255 character.')
            ,'role.required'=>__('Role field can\'t be empty.')
            ,'country.required'=>__('Country field can\'t be empty.')
        ];
        if(!empty($this->phone)){
            $message['phone.max']=__('Phone can\'t be more than 13 character.');
        }
        if(empty($this->edit_id)){
            $message['password.required']=__('Password field can\'t be empty.');
            $message['password.confirmed']=__('Password doesn\'t matched.');
        }
        return $message;
    }
}
