<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AchievementRequest extends FormRequest
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
        if (isset($this->achievement_list1_count)) {
            $rules['achievement_list1_count']='required|integer|min:1|max:999999999';
        }
        if (isset($this->achievement_list2_count)) {
            $rules['achievement_list2_count']='required|integer|min:1|max:999999999';
        }
        if (isset($this->achievement_list3_count)) {
            $rules['achievement_list3_count']='required|integer|min:1|max:999999999';
        }
        if (isset($this->achievement_list4_count)) {
            $rules['achievement_list4_count']='required|integer|min:1|max:999999999';
        }
        if (isset($this->achievement_list5_count)) {
            $rules['achievement_list5_count']='required|integer|min:1|max:999999999';
        }

        return $rules;;
    }
}
