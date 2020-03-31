<?php

namespace App\Services;

use App\Model\AdminSetting;
use App\Model\Menu;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingService
{
    protected $logger;

    public function __construct()
    {
        $this->logger = app(Logger::class);
    }

    public function checkValidId($id){
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            return ['success'=>false];
        }
        return $id;
    }

    private function update_or_create($slug,$value){
        return AdminSetting::updateOrCreate(['slug'=>$slug],['slug'=>$slug,'value'=>$value]);
    }

    // save website setting
    public function saveWebsiteSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            if(!empty($request->home_banner_title)){
                $this->update_or_create('home_banner_title',$request->home_banner_title);
            }
            if(!empty($request->home_banner_sub_title)){
                $this->update_or_create('home_banner_sub_title',$request->home_banner_sub_title);
            }
            if(!empty($request->home_section_title2)){
                $this->update_or_create('home_section_title2',$request->home_section_title2);
            }
            if(!empty($request->home_banner_des)){
                $this->update_or_create('home_banner_des',$request->home_banner_des);
            }
            if(!empty($request->home_section_des2)){
                $this->update_or_create('home_section_des2',$request->home_section_des2);
            }
            if(!empty($request->home_testimonial_title)){
                $this->update_or_create('home_testimonial_title',$request->home_testimonial_title);
            }
            if(!empty($request->home_blog_title)){
                $this->update_or_create('home_blog_title',$request->home_blog_title);
            }

            if(!empty($request->achievement_title)){
                $this->update_or_create('achievement_title',$request->achievement_title);
            }
            if(!empty($request->achievement_sub_title)){
                $this->update_or_create('achievement_sub_title',$request->achievement_sub_title);
            }
            if(!empty($request->achievement_des)){
                $this->update_or_create('achievement_des',$request->achievement_des);
            }
            if(!empty($request->achievement_list1_title)){
                $this->update_or_create('achievement_list1_title',$request->achievement_list1_title);
            }
            if(!empty($request->achievement_list2_title)){
                $this->update_or_create('achievement_list2_title',$request->achievement_list2_title);
            }
            if(!empty($request->achievement_list3_title)){
                $this->update_or_create('achievement_list3_title',$request->achievement_list3_title);
            }
            if(!empty($request->achievement_list4_title)){
                $this->update_or_create('achievement_list4_title',$request->achievement_list4_title);
            }
            if(!empty($request->achievement_list5_title)){
                $this->update_or_create('achievement_list5_title',$request->achievement_list5_title);
            }
            if(!empty($request->achievement_list5_count)){
                $this->update_or_create('achievement_list5_count',$request->achievement_list5_count);
            }
            if(!empty($request->achievement_list4_count)){
                $this->update_or_create('achievement_list4_count',$request->achievement_list4_count);
            }
            if(!empty($request->achievement_list3_count)){
                $this->update_or_create('achievement_list3_count',$request->achievement_list3_count);
            }
            if(!empty($request->achievement_list2_count)){
                $this->update_or_create('achievement_list2_count',$request->achievement_list2_count);
            }
            if(!empty($request->achievement_list1_count)){
                $this->update_or_create('achievement_list1_count',$request->achievement_list1_count);
            }

            if(!empty($request->service_banner_title)){
                $this->update_or_create('service_banner_title',$request->service_banner_title);
            }
            if(!empty($request->service_banner_des)){
                $this->update_or_create('service_banner_des',$request->service_banner_des);
            }

            if(!empty($request->team_banner_title)){
                $this->update_or_create('team_banner_title',$request->team_banner_title);
            }
            if(!empty($request->team_banner_des)){
                $this->update_or_create('team_banner_des',$request->team_banner_des);
            }

            if(!empty($request->portfolio_banner_title)){
                $this->update_or_create('portfolio_banner_title',$request->portfolio_banner_title);
            }
            if(!empty($request->portfolio_banner_des)){
                $this->update_or_create('portfolio_banner_des',$request->portfolio_banner_des);
            }
            if(!empty($request->gallery_banner_title)){
                $this->update_or_create('gallery_banner_title',$request->gallery_banner_title);
            }
            if(!empty($request->gallery_banner_des)){
                $this->update_or_create('gallery_banner_des',$request->gallery_banner_des);
            }

            if(!empty($request->work_header_title)){
                $this->update_or_create('work_header_title',$request->work_header_title);
            }
            if(!empty($request->work_title)){
                $this->update_or_create('work_title',$request->work_title);
            }
            if(!empty($request->work_sub_title)){
                $this->update_or_create('work_sub_title',$request->work_sub_title);
            }
            if(!empty($request->work_des)){
                $this->update_or_create('work_des',$request->work_des);
            }

            if (isset($request->home_banner_image)) {
                AdminSetting::updateOrCreate(['slug' => 'home_banner_image'],['value' => fileUpload($request['home_banner_image'], path_image(),
                    isset(allSetting()['home_banner_image']) ? allSetting()['home_banner_image'] : '')]);
            }
            if (isset($request->home_second_section_image)) {
                AdminSetting::updateOrCreate(['slug' => 'home_second_section_image'],['value' => fileUpload($request['home_second_section_image'], path_image(),
                    isset(allSetting()['home_second_section_image']) ? allSetting()['home_second_section_image'] : '')]);
            }
            if (isset($request->service_banner_image)) {
                AdminSetting::updateOrCreate(['slug' => 'service_banner_image'],['value' => fileUpload($request['service_banner_image'], path_image(),
                    isset(allSetting()['service_banner_image']) ? allSetting()['service_banner_image'] : '')]);
            }
            if (isset($request->team_banner_image)) {
                AdminSetting::updateOrCreate(['slug' => 'team_banner_image'],['value' => fileUpload($request['team_banner_image'], path_image(),
                    isset(allSetting()['team_banner_image']) ? allSetting()['team_banner_image'] : '')]);
            }
            if (isset($request->portfolio_banner_image)) {
                AdminSetting::updateOrCreate(['slug' => 'portfolio_banner_image'],['value' => fileUpload($request['portfolio_banner_image'], path_image(),
                    isset(allSetting()['portfolio_banner_image']) ? allSetting()['portfolio_banner_image'] : '')]);
            }
            if (isset($request->gallery_banner_image)) {
                AdminSetting::updateOrCreate(['slug' => 'gallery_banner_image'],['value' => fileUpload($request['gallery_banner_image'], path_image(),
                    isset(allSetting()['gallery_banner_image']) ? allSetting()['gallery_banner_image'] : '')]);
            }
            if (isset($request->work_image)) {
                AdminSetting::updateOrCreate(['slug' => 'work_image'],['value' => fileUpload($request['work_image'], path_image(),
                    isset(allSetting()['work_image']) ? allSetting()['work_image'] : '')]);
            }

            $response = [
                'success' => true,
                'message' => __('Updated Successfully.')
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $response;
    }

    // menu save process
    public function menuSaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'title' => $request->title,
                'component' => $request->component,
                'status' => $request->status,
            ];

            if (empty($request->edit_id)) {
                $data['slug'] = make_blog_slug($request->title);
            }
            if(!empty($request->edit_id)) {
                $update = Menu::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    $response = [
                        'success' => true,
                        'message' => __('Menu updated successfully')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to update')
                    ];
                }
            } else {
                $saveData= Menu::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('New menu created successfully.')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to create')
                    ];
                }
            }

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => __('Something Went wrong !')
            ];
            return $response;
        }

        return $response;
    }

    // delete menu

    public function deleteMenu($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Menu::where('id',$id)->first();
            if (isset($item)) {
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Menu deleted successfully.')
                    ];
                } else {
                    DB::rollBack();
                    $response = [
                        'success' => false,
                        'message' => __('Operation failed.')
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Menu not found.')
                ];
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }
}
