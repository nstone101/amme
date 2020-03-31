<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
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
        $rule = [
            'name' => 'required|max:255',
            'country' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|strong_pass|confirmed|max:255',
            'password_confirmation' => 'required|max:255',
        ];
        if ($this->phone) {
            $rule['phone'] = 'numeric|phone_number';
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => __('Name field is required.'),
            'role.required' => __('Role field is required.'),
            'country.required' => __('Country field is required.'),
            'password.required' => __('Password field is required.'),
            'password_confirmation.required' => __('Password confirmed field is required.'),
            'password.min' => __('Password length must be minimum 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'email.required' => __('Email field is required.'),
            'email.unique' => __('Email address already exists.'),
            'email.email' => __('Invalid email address.'),
            'phone.phone_number' => __('Invalid phone number.'),
        ];
    }
}
