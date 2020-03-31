<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            ,'email'=>'required|email|unique:users|max:256'
            ,'country'=>'required|max:256'
            ,'password' => 'required|confirmed|min:8|strong_pass'
            ,'password_confirmation' => 'required'
            ,'phone'=>'required|numeric|phone_number'
        ];

        return $rules;
    }
    public function messages()
    {
        $message=[
            'name.required'=>__('Name field can\'t be empty.')
            ,'phone.required'=>__('Phone field can\'t be empty.')
            ,'name.max'=>__('Name can\'t be more than 255 character.')
            ,'email.required'=>__('Email field can\'t be empty.')
            ,'email.email'=>__('Invalid Email formate.')
            ,'email.max'=>__('Email can\'t be more than 255 character.')
            ,'country.required'=>__('Country field can\'t be empty.')
            ,'password.required'=>__('Password field can\'t be empty.')
            ,'password_confirmation.required'=>__('Confirm password field can\'t be empty.')
            ,'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number')
            ,'password.confirmed'=>__('Password doesn\'t matched.')
        ];
        if(!empty($this->phone)){
            $message['phone.max']=__('Phone can\'t be more than 15 character.');
        }

        return $message;
    }
}
