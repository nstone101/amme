<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebSettingRequest extends FormRequest
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
        $rules=[];
        if (isset($this->about_banner_image)) {
            $rules['about_banner_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->about_left_image)) {
            $rules['about_left_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->about_right_image)) {
            $rules['about_right_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->about_last_image)) {
            $rules['about_last_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->home_banner_image)) {
            $rules['home_banner_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->home_second_section_image)) {
            $rules['home_second_section_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->service_banner_image)) {
            $rules['service_banner_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->team_banner_image)) {
            $rules['team_banner_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->portfolio_banner_image)) {
            $rules['portfolio_banner_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->gallery_banner_image)) {
            $rules['gallery_banner_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->work_image)) {
            $rules['work_image']='required|image|mimes:jpg,jpeg,png|max:3000';
        }

        return $rules;
    }
}
