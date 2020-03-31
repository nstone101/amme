<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AchievementRequest;
use App\Http\Requests\Admin\SettingRequest;
use App\Http\Requests\Admin\WebSettingRequest;
use App\Model\AdminSetting;
use App\Services\SettingService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    private function update_or_create($slug,$value){
        return AdminSetting::updateOrCreate(['slug'=>$slug],['slug'=>$slug,'value'=>$value]);
    }
    // Admin setting view
    public function adminSettings(){
        $data['pageTitle']=__('General Settings');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'general';
        $data['adm_setting'] = allsetting();

        return view('admin.setting.setting',$data);
    }
    // Website setting view
    public function webSettings(){
        $data['pageTitle']=__('Website Settings');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'website';
        $data['adm_setting'] = allsetting();

        return view('admin.setting.web.setting',$data);
    }
    // about setting view
    public function aboutSettings(){
        $data['pageTitle']=__('About Us');
        $data['menu'] = 'about';
        $data['adm_setting'] = allsetting();

        return view('admin.setting.about',$data);
    }

    // save the basic setting
    public function saveSettings(Request $request){
        $rules=[
            'app_title'=>'required|max:256'
            ,'copyright_text'=>'required|max:256'
            ,'primary_email'=>'required|email|max:256'
//            ,'currency_symbol'=>'required|max:5'
        ];
        if ($request->contact_number) {
            $rules['contact_number'] = 'numeric|phone_number';
        }
        $this->validate($request,$rules);
//        dd($request->all());
        if(!empty($request->app_title)){
            $update = $this->update_or_create('app_title',$request->app_title);
        }
        if(!empty($request->copyright_text)){
            $update= $this->update_or_create('copyright_text',$request->copyright_text);
        }
        if(!empty($request->primary_email)){
            $update= $this->update_or_create('primary_email',$request->primary_email);
        }
        if(!empty($request->contact_number)){
            $update= $this->update_or_create('contact_number',$request->contact_number);
        }
        if(!empty($request->address)){
            $update= $this->update_or_create('address',$request->address);
        }
        if(!empty($request->currency_symbol)){
            $update= $this->update_or_create('currency_symbol',$request->currency_symbol);
        }
        if(!empty($request->lang)){
            $update= $this->update_or_create('lang',$request->lang);
        }
        if(!empty($request->signup_text)){
            $update= $this->update_or_create('signup_text',$request->signup_text);
        }
        if(!empty($request->login_text)){
            $update= $this->update_or_create('login_text',$request->login_text);
        }
        if(!empty($request->front_base_color)){
            $update= $this->update_or_create('front_base_color',$request->front_base_color);
        }
        if(!empty($request->google_capcha_site_key)){
            $update= $this->update_or_create('google_capcha_site_key',$request->google_capcha_site_key);
        }

        if(isset($update)){
            return redirect()->back()->with(['success'=>__('Updated Successfully.')]);
        } else {
            return redirect()->back()->with(['success'=>__('Nothing to update.')]);
        }
    }
    // save the payment setting
    public function adminPaymentSettingsSave(Request $request)
    {
        $rules=[
            'braintree_env' => 'required'
        ];

        $this->validate($request,$rules);
//        dd($request->all());
        if(!empty($request->braintree_env)){
            $update = $this->update_or_create('braintree_env',$request->braintree_env);
        }
        if(!empty($request->braintree_marchant_id)){
            $update= $this->update_or_create('braintree_marchant_id',$request->braintree_marchant_id);
        }
        if(!empty($request->braintree_public_key)){
            $update= $this->update_or_create('braintree_public_key',$request->braintree_public_key);
        }
        if(!empty($request->braintree_private_key)){
            $update= $this->update_or_create('braintree_private_key',$request->braintree_private_key);
        }
        if(!empty($request->braintree_client_token)){
            $update= $this->update_or_create('braintree_client_token',$request->braintree_client_token);
        }
        if(!empty($request->google_pay_marchent_id)){
            $update= $this->update_or_create('google_pay_marchent_id',$request->google_pay_marchent_id);
        }

        if(isset($update)){
            return redirect()->back()->with(['success'=>__('Updated Successfully.')]);
        }else{
            return redirect()->back()->with(['success'=>__('Nothing to update.')]);
        }
    }
    // save the logo setting
    public function adminImageUploadSave(SettingRequest $request){

        try {
            if(!empty($request->privacy_policy)){
                $update = $this->update_or_create('privacy_policy',$request->privacy_policy);
            }
            if(!empty($request->terms_conditions)){
                $update = $this->update_or_create('terms_conditions',$request->terms_conditions);
            }
            if (isset($request->logo)) {
                AdminSetting::updateOrCreate(['slug' => 'logo'], ['value' => fileUpload($request['logo'], path_image(), allSetting()['logo'])]);
            }
            if (isset($request->favicon)) {
                AdminSetting::updateOrCreate(['slug' => 'favicon'], ['value' => fileUpload($request['favicon'], path_image(), allSetting()['favicon'])]);
            }
            if (isset($request->app_logo)) {
                AdminSetting::updateOrCreate(['slug' => 'app_logo'], ['value' => fileUpload($request['app_logo'], path_image(), allSetting()['app_logo'])]);
            }
            if (isset($request->login_logo)) {
                AdminSetting::updateOrCreate(['slug' => 'login_logo'], ['value' => fileUpload($request['login_logo'], path_image(), allSetting()['login_logo'])]);
            }
            if (isset($request->login_side_image)) {
                AdminSetting::updateOrCreate(['slug' => 'login_side_image'],['value' => fileUpload($request['login_side_image'], path_image(),
                    isset(allSetting()['login_side_image']) ? allSetting()['login_side_image'] : '')]);            }

            return redirect()->back()->with(['success'=>__('Updated Successfully.')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['dismiss'=>__('Nothing to update.')]);
        }

    }
    // save the about setting
    public function adminAboutSettingsSave(WebSettingRequest $request){
        try {
            if(!empty($request->about_banner_title)){
                $this->update_or_create('about_banner_title',$request->about_banner_title);
            }
            if(!empty($request->about_title)){
                $this->update_or_create('about_title',$request->about_title);
            }
            if(!empty($request->about_video_id)){
                $this->update_or_create('about_video_id',$request->about_video_id);
            }
            if(!empty($request->about_section_title1)){
                $this->update_or_create('about_section_title1',$request->about_section_title1);
            }
            if(!empty($request->about_section_des1)){
                $this->update_or_create('about_section_des1',$request->about_section_des1);
            }
            if(!empty($request->about_section_title2)){
                $this->update_or_create('about_section_title2',$request->about_section_title2);
            }
            if(!empty($request->about_section_des2)){
                $this->update_or_create('about_section_des2',$request->about_section_des2);
            }
            if(!empty($request->about_section_title3)){
                $this->update_or_create('about_section_title3',$request->about_section_title3);
            }
            if(!empty($request->about_section_des3)){
                $this->update_or_create('about_section_des3',$request->about_section_des3);
            }
            if(!empty($request->about_section_title4)){
                $this->update_or_create('about_section_title4',$request->about_section_title4);
            }
            if(!empty($request->about_section_des4)){
                $this->update_or_create('about_section_des4',$request->about_section_des4);
            }
            if(!empty($request->about_sub_title)){
                $this->update_or_create('about_sub_title',$request->about_sub_title);
            }
            if(!empty($request->about_description)){
                $this->update_or_create('about_description',$request->about_description);
            }
            if(!empty($request->about_last_section_header_title)){
                $this->update_or_create('about_last_section_header_title',$request->about_last_section_header_title);
            }
            if(!empty($request->about_last_section_title)){
                $this->update_or_create('about_last_section_title',$request->about_last_section_title);
            }
            if(!empty($request->about_last_section_sub_title)){
                $this->update_or_create('about_last_section_sub_title',$request->about_last_section_sub_title);
            }
            if(!empty($request->about_last_description)){
                $this->update_or_create('about_last_description',$request->about_last_description);
            }
            if (isset($request->about_right_image)) {
                AdminSetting::updateOrCreate(['slug' => 'about_right_image'],['value' => fileUpload($request['about_right_image'], path_image(),
                    isset(allSetting()['about_right_image']) ? allSetting()['about_right_image'] : '')]);
            }
            if (isset($request->about_banner_image)) {
                AdminSetting::updateOrCreate(['slug' => 'about_banner_image'],['value' => fileUpload($request['about_banner_image'], path_image(),
                    isset(allSetting()['about_banner_image']) ? allSetting()['about_banner_image'] : '')]);
            }
            if (isset($request->about_left_image)) {
                AdminSetting::updateOrCreate(['slug' => 'about_left_image'],['value' => fileUpload($request['about_left_image'], path_image(),
                    isset(allSetting()['about_left_image']) ? allSetting()['about_left_image'] : '')]);
            }
            if (isset($request->about_last_image)) {
                AdminSetting::updateOrCreate(['slug' => 'about_last_image'],['value' => fileUpload($request['about_last_image'], path_image(),
                    isset(allSetting()['about_last_image']) ? allSetting()['about_last_image'] : '')]);
            }

            return redirect()->back()->with(['success'=>__('Updated Successfully.')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['dismiss'=> $e->getMessage()]);
//            return redirect()->back()->with(['dismiss'=>__('Nothing to update.')]);
        }

    }

    // save website setting
    public function saveWebSettings(WebSettingRequest $request)
    {
        try {
            $response = app(SettingService::class)->saveWebsiteSetting($request);
            if ($response) {
                if ($response['success'] == true) {
                    return redirect()->back()->withInput()->with('success', $response['message']);
                } else {
                    return redirect()->back()->withInput()->with('dismiss', $response['message']);
                }
            } else {
                return redirect()->back()->withInput()->with('dismiss', __('Something went wrong'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('success', $e->getMessage());
        }
    }

    // save achievement setting
    public function saveAchievementSettings(AchievementRequest $request)
    {
        try {
            $response = app(SettingService::class)->saveWebsiteSetting($request);
            if ($response) {
                if ($response['success'] == true) {
                    return redirect()->back()->withInput()->with('success', $response['message']);
                } else {
                    return redirect()->back()->withInput()->with('dismiss', $response['message']);
                }
            } else {
                return redirect()->back()->withInput()->with('dismiss', __('Something went wrong'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('success', $e->getMessage());
        }
    }
}
