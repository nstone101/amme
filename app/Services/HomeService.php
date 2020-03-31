<?php

namespace App\Services;

use App\Model\AdminSetting;
use App\Model\Blog;
use App\Model\Contact;
use App\Model\Menu;
use App\Model\Portfolio;
use App\Model\Service;
use App\Model\Subscriber;
use App\Model\Team;
use App\Repository\PlanRepository;
use App\Repository\PortfolioRepository;
use App\Repository\ServiceRepository;
use App\Repository\TeamRepository;
use App\Repository\TestimonialRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeService
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

    // home page data
    public function apiDashboardData()
    {
        try {
            $data['success'] = true;
            $data['message'] = __('Data get successfully');
            $adm_setting = allSetting();
            $data['home_banner_title'] = isset($adm_setting['home_banner_title']) ? $adm_setting['home_banner_title'] : '';
            $data['home_banner_sub_title'] = isset($adm_setting['home_banner_sub_title']) ? $adm_setting['home_banner_sub_title'] : '';
            $data['home_banner_des'] = isset($adm_setting['home_banner_des']) ? $adm_setting['home_banner_des'] : '';
            $data['home_banner_image'] = isset($adm_setting['home_banner_image']) && (!empty($adm_setting['home_banner_image'])) ? asset(path_image().$adm_setting['home_banner_image']) : '';
            $data['service_list'] = app(ServiceRepository::class)->serviceList(TYPE_HOME)['service_list'];
            $data['about_title'] = isset($adm_setting['about_title']) ? $adm_setting['about_title'] : '';
            $data['about_sub_title'] = isset($adm_setting['about_sub_title']) ? $adm_setting['about_sub_title'] : '';
            $data['about_description'] = isset($adm_setting['about_description']) ? $adm_setting['about_description'] : '';
            $data['about_left_image'] = isset($adm_setting['about_left_image']) && (!empty($adm_setting['about_left_image'])) ? asset(path_image().$adm_setting['about_left_image']) : '';
            $data['achievement_title'] = isset($adm_setting['achievement_title']) ? $adm_setting['achievement_title'] : '';
            $data['achievement_sub_title'] = isset($adm_setting['achievement_sub_title']) ? $adm_setting['achievement_sub_title'] : '';
            $data['achievement_des'] = isset($adm_setting['achievement_des']) ? $adm_setting['achievement_des'] : '';
            $data['achievement_list1_title'] = isset($adm_setting['achievement_list1_title']) ? $adm_setting['achievement_list1_title'] : '';
            $data['achievement_list2_title'] = isset($adm_setting['achievement_list2_title']) ? $adm_setting['achievement_list2_title'] : '';
            $data['achievement_list3_title'] = isset($adm_setting['achievement_list3_title']) ? $adm_setting['achievement_list3_title'] : '';
            $data['achievement_list4_title'] = isset($adm_setting['achievement_list4_title']) ? $adm_setting['achievement_list4_title'] : '';
            $data['achievement_list5_title'] = isset($adm_setting['achievement_list5_title']) ? $adm_setting['achievement_list5_title'] : '';
            $data['achievement_list1_count'] = isset($adm_setting['achievement_list1_count']) ? $adm_setting['achievement_list1_count'] : '';
            $data['achievement_list2_count'] = isset($adm_setting['achievement_list2_count']) ? $adm_setting['achievement_list2_count'] : '';
            $data['achievement_list3_count'] = isset($adm_setting['achievement_list3_count']) ? $adm_setting['achievement_list3_count'] : '';
            $data['achievement_list4_count'] = isset($adm_setting['achievement_list4_count']) ? $adm_setting['achievement_list4_count'] : '';
            $data['achievement_list5_count'] = isset($adm_setting['achievement_list5_count']) ? $adm_setting['achievement_list5_count'] : '';
            $data['home_testimonial_title'] = isset($adm_setting['home_testimonial_title']) ? $adm_setting['home_testimonial_title'] : '';
            $data['home_blog_title'] = isset($adm_setting['home_blog_title']) ? $adm_setting['home_blog_title'] : '';
            $data['team_list'] = app(TeamRepository::class)->teamList()['team_list'];
            $data['plan_list'] = app(PlanRepository::class)->planList(TYPE_HOME)['plan_list'];
            $data['testimonial_list'] = app(TestimonialRepository::class)->testimonialList()['testimonial_list'];
            $data['blog_list'] = [];
            $blogs = Blog::where('status', STATUS_ACTIVE)->orderBy('id', 'desc')->limit(10)->get();
            if (isset($blogs[0])) {
                foreach ($blogs as $blog) {
                    $blog->author_name = isset($blog->user->name) ? $blog->user->name : '';
                    $blog->encrypt_id = $blog->slug;
                    unset($blog->user);
                }
                $data['blog_list'] = $blogs;
            }

        } catch (\Exception $e) {
            $data['success'] = true;
            $data['message'] = $e->getMessage();
            return $data;
        }

        return $data;

    }
    // header data
    public function apiHeaderData()
    {
        try {
            $data['success'] = true;
            $data['message'] = __('Data get successfully');
            $adm_setting = allSetting();
            $data['app_title'] = isset($adm_setting['app_title']) ? $adm_setting['app_title'] : '';
            $data['primary_email'] = isset($adm_setting['primary_email']) ? $adm_setting['primary_email'] : '';
            $data['contact_number'] = isset($adm_setting['contact_number']) ? $adm_setting['contact_number'] : '';
            $data['address'] = isset($adm_setting['address']) ? $adm_setting['address'] : '';
            $data['logo'] = isset($adm_setting['logo']) && (!empty($adm_setting['logo'])) ? asset(path_image().$adm_setting['logo']) : '';
            $data['favicon'] = isset($adm_setting['favicon']) && (!empty($adm_setting['favicon'])) ? asset(path_image().$adm_setting['favicon']) : '';
            $data['app_logo'] = isset($adm_setting['app_logo']) && (!empty($adm_setting['app_logo'])) ? asset(path_image().$adm_setting['app_logo']) : '';
            $data['front_base_color'] = isset($adm_setting['front_base_color']) ? $adm_setting['front_base_color'] : '';
            $data['google_capcha_site_key'] = isset($adm_setting['google_capcha_site_key']) ? $adm_setting['google_capcha_site_key'] : '';
            $data['menu_list'] = [];
            $menus = Menu::where(['status' => STATUS_ACTIVE])->orderBy('data_order', 'ASC')->get();
            if (isset($menus[0])) {
                $data['menu_list'] = $menus;
            }

        } catch (\Exception $e) {
            $data['success'] = true;
            $data['message'] = __('Something went wrong');
            return $data;
        }

        return $data;

    }
    // about us page data
    public function apiAboutData()
    {
        try {
            $data['success'] = true;
            $data['message'] = __('Data get successfully');
            $adm_setting = allSetting();
            $data['about_banner_title'] = isset($adm_setting['about_banner_title']) ? $adm_setting['about_banner_title'] : '';
            $data['about_feature_left_image'] = isset($adm_setting['about_banner_image']) && (!empty($adm_setting['about_banner_image'])) ? asset(path_image().$adm_setting['about_banner_image']) : '';
            $data['about_feature_title1'] = isset($adm_setting['about_section_title1']) ? $adm_setting['about_section_title1'] : '';
            $data['about_feature_title2'] = isset($adm_setting['about_section_title2']) ? $adm_setting['about_section_title2'] : '';
            $data['about_feature_title3'] = isset($adm_setting['about_section_title3']) ? $adm_setting['about_section_title3'] : '';
            $data['about_feature_title4'] = isset($adm_setting['about_section_title4']) ? $adm_setting['about_section_title4'] : '';

            $data['about_feature_des1'] = isset($adm_setting['about_section_des1']) ? $adm_setting['about_section_des1'] : '';
            $data['about_feature_des2'] = isset($adm_setting['about_section_des2']) ? $adm_setting['about_section_des2'] : '';
            $data['about_feature_des3'] = isset($adm_setting['about_section_des3']) ? $adm_setting['about_section_des3'] : '';
            $data['about_feature_des4'] = isset($adm_setting['about_section_des4']) ? $adm_setting['about_section_des4'] : '';

            $data['about_title'] = isset($adm_setting['about_title']) ? $adm_setting['about_title'] : '';
            $data['about_sub_title'] = isset($adm_setting['about_sub_title']) ? $adm_setting['about_sub_title'] : '';
            $data['about_description'] = isset($adm_setting['about_description']) ? $adm_setting['about_description'] : '';
            $data['about_left_image'] = isset($adm_setting['about_left_image']) && (!empty($adm_setting['about_left_image'])) ? asset(path_image().$adm_setting['about_left_image']) : '';

            $data['team_list'] = app(TeamRepository::class)->teamList()['team_list'];

            $data['about_section2_title'] = isset($adm_setting['about_last_section_title']) ? $adm_setting['about_last_section_title'] : '';
            $data['about_section2_sub_title'] = isset($adm_setting['about_last_section_sub_title']) ? $adm_setting['about_last_section_sub_title'] : '';
            $data['about_section2_header_title'] = isset($adm_setting['about_last_section_header_title']) ? $adm_setting['about_last_section_header_title'] : '';
            $data['about_section2_description'] = isset($adm_setting['about_last_description']) ? $adm_setting['about_last_description'] : '';
            $data['about_section2_right_image'] = isset($adm_setting['about_right_image']) && (!empty($adm_setting['about_right_image'])) ? asset(path_image().$adm_setting['about_right_image']) : '';
//            $data['about_last_image'] = isset($adm_setting['about_last_image']) && (!empty($adm_setting['about_last_image'])) ? asset(path_image().$adm_setting['about_last_image']) : '';

            $data['achievement_title'] = isset($adm_setting['achievement_title']) ? $adm_setting['achievement_title'] : '';
            $data['achievement_sub_title'] = isset($adm_setting['achievement_sub_title']) ? $adm_setting['achievement_sub_title'] : '';
            $data['achievement_des'] = isset($adm_setting['achievement_des']) ? $adm_setting['achievement_des'] : '';
            $data['achievement_list1_title'] = isset($adm_setting['achievement_list1_title']) ? $adm_setting['achievement_list1_title'] : '';
            $data['achievement_list2_title'] = isset($adm_setting['achievement_list2_title']) ? $adm_setting['achievement_list2_title'] : '';
            $data['achievement_list3_title'] = isset($adm_setting['achievement_list3_title']) ? $adm_setting['achievement_list3_title'] : '';
            $data['achievement_list4_title'] = isset($adm_setting['achievement_list4_title']) ? $adm_setting['achievement_list4_title'] : '';
            $data['achievement_list5_title'] = isset($adm_setting['achievement_list5_title']) ? $adm_setting['achievement_list5_title'] : '';
            $data['achievement_list1_count'] = isset($adm_setting['achievement_list1_count']) ? $adm_setting['achievement_list1_count'] : '';
            $data['achievement_list2_count'] = isset($adm_setting['achievement_list2_count']) ? $adm_setting['achievement_list2_count'] : '';
            $data['achievement_list3_count'] = isset($adm_setting['achievement_list3_count']) ? $adm_setting['achievement_list3_count'] : '';
            $data['achievement_list4_count'] = isset($adm_setting['achievement_list4_count']) ? $adm_setting['achievement_list4_count'] : '';
            $data['achievement_list5_count'] = isset($adm_setting['achievement_list5_count']) ? $adm_setting['achievement_list5_count'] : '';


        } catch (\Exception $e) {
            $data['success'] = true;
            $data['message'] = $e->getMessage();
            return $data;
        }

        return $data;

    }

    // send contact message
    public function contactProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'description' => $request->description,
            ];
            $save = Contact::create($data);
            if ($save) {
                if (isset(allsetting()['primary_email'])) {
                    $mailTemplet= 'email.contact_mail';
                    $userName = '';
                    $adminEmail = allsetting()['primary_email'];
                    $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Ammelias');
                    $subject = $request->subject.'|' .$companyName ;
                    $data['subject'] = $request->subject;
                    $data['description'] = $request->description;

                    $userMail = $request->email;
                    $name = $request->name;
                    try {
                        Mail::send($mailTemplet, $data, function ($message) use ($userName, $adminEmail, $subject,$userMail, $name) {
                            $message->to($adminEmail, $userName)->subject($subject)->replyTo(
                                $userMail, $name
                            );
                            $message->from($userMail, $name);

                        });

                    } catch (\Exception $e){
                        return $e->getMessage();
                    }

                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Mail not found')
                    ];
                }

                $response = ['success' => true, 'message' => __('Message sent to admin')];
            }

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => __('Something went wrong')];
            return $response;
        }

        return $response;
    }

    // subscription process
    public function subscriberProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];

        try {
            $data = [
                'email' => $request->email,
            ];
            $save = Subscriber::create($data);
            if ($save) {
                $response = ['success' => true, 'message' => __('Subscription successful')];
            }

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => __('Something went wrong')];
            return $response;
        }

        return $response;
    }
}
