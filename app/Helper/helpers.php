<?php

use App\Model\AdminSetting;
use App\Model\Blog;
use App\Model\BlogComment;
use Illuminate\Support\Facades\Auth;

//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;


function checkRolePermission($userAction, $userRole)
{
    if ($userRole == USER_ROLE_ADMIN) {
        return true;
    }

    $action = Action::where('name', $userAction)->orWhere('url', $userAction)->first();
    $role = Role::where('id', $userRole)->first();

    if (!empty($role->actions) && !empty($action)) {
        if (!empty($role->actions)) {
            $tasks = array_filter(explode('|', $role->actions));
        }
        if (isset($tasks)) {
            if (in_array($action->id, $tasks)) {
                return true;
            } else {
                return false;
            }
        }
    }

    return false;
}

function allSetting($array = null)
{
    if (!isset($array[0])) {
        $allSettings = AdminSetting::get();
        if ($allSettings) {
            $output = [];
            foreach ($allSettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allSettings = AdminSetting::whereIn('slug', $array)->get();
        if ($allSettings) {
            $output = [];
            foreach ($allSettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allSettings = AdminSetting::where(['slug' => $array])->first();
        if ($allSettings) {
            $output = $allSettings->value;
            return $output;
        }
        return false;
    }
}

//Random string
function randomString($a)
{
    $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

// random number
function randomNumber($a = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

if (!function_exists('role')) {
    function role($val = null)
    {
        $myrole = array(
            1 => __('Admin'),
            2 => __('User')
        );
        if ($val == null) {
            return $myrole;
        } else {
            return $myrole[$val];
        }
        return $myrole;
    }
}
if (!function_exists('plan_duration')) {
    function plan_duration($val = null)
    {
        $item = array(
            30 => __('Monthly'),
            365 => __('Yearly')
        );
        if ($val == null) {
            return $item;
        } else {
            return $item[$val];
        }
        return $item;
    }
}
//use array key for validator
function arrKeyOnly($array, $seperator = ',', $exception = [])
{
    $string = '';
    $sep = '';
    foreach ($array as $key => $val) {
        if (in_array($key, $exception) == false) {
            $string .= $sep . $key;
            $sep = $seperator;
        }
    }
    return $string;
}
function fileUpload($new_file, $path, $old_file_name = null, $width = null, $height = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . substr($old_file_name, strrpos($old_file_name, '/') + 1))) {

        unlink($path . '/' . substr($old_file_name, strrpos($old_file_name, '/') + 1));
    }

    $input['imagename'] = uniqid() . time() . '.' . $new_file->getClientOriginalExtension();
    $imgPath = public_path($path . $input['imagename']);

    $makeImg = Image::make($new_file);
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $input['imagename'];
    }
    return false;

}

function uploadimage($img, $path, $user_file_name = null, $width = null, $height = null)
{
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
        unlink($path .'/'. $user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path . $imgName);


//    if($img->getClientOriginalExtension() != 'svg'){
    // making image
    $makeImg = Image::make($img);
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }
//    }else{
//        File::copy($imgPath);
//    }


    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}

function removeImage($path, $file_name)
{
    if (isset($file_name) && $file_name != "" && file_exists($path . $file_name)) {
        unlink($path . $file_name);
    }
//    if (isset($file_name) && $file_name != "" && file_exists($path . substr($file_name, strrpos($file_name, '/') + 1))) {
//
//        unlink($path . '/' . substr($file_name, strrpos($file_name, '/') + 1));
//    }
}

function multipleuploadimage($images,$path,$width=null,$height=null)
{
    if(isset($images[0])){
        $imgNames =[];
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        foreach($images as $img){

            // saving image in target path
            $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
            $imgPath = public_path($path . '/' . $imgName);

            // making image
            $makeImg = Image::make($img);
            if ($width != null && $height != null && is_int($width) && is_int($height)) {
                $makeImg->resize($width, $height);
                $makeImg->fit($width, $height);
            }

            if ($makeImg->save($imgPath)) {
                $imgNames[] = $imgName;
            }
        }

        return $imgNames;
    }

}
if (!function_exists('status_type')) {
    function status_type($val = null)
    {
        $data = array(
            1 => __('Active'),
            2 => __('Inactive')
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('stock_type')) {
    function stock_type($val = null)
    {
        $data = array(
            IN_STOCK => __('In Stock'),
            OUT_OF_STOCK => __('Out of Stock')
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('addon_type')) {
    function addon_type($val = null)
    {
        $data = array(
            1 => __('Addons'),
            2 => __('Supplement'),
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}
// count category product
if (!function_exists('count_category_product')) {
    function count_category_product($cat_id)
    {
        $product = 0;
        $item = Product::where(['category_id'=> $cat_id, 'status'=> STATUS_ACTIVE])->get();
        if (isset($item[0])) {
            $product = $item->count();
        }

        return $product;
    }
}

// my cart list


//Advertisement image path
function path_image()
{
    return 'uploaded_file/img/';
}

function path_slider_image()
{
    return 'uploaded_file/slider/';
}

function path_service_image()
{
    return 'uploaded_file/service/';
}

function path_user_image()
{
    return 'uploaded_file/img/user/';
}

function path_barber_image()
{
    return 'uploaded_file/barber/';
}

// Convert currency
function convertCurrency($amount, $to = 'USD', $from = 'USD')
{
    try {
        $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
        $json = file_get_contents($url); //,FALSE,$ctx);
        $jsondata = json_decode($json, TRUE);
        return $amount * $jsondata[$to];
    } catch (\Exception $e) {
        return $amount * allSetting()['coin_price'];
    }
}

if (!function_exists('all_month')) {
    function all_month($val = null)
    {
        $data = array(
            12 => 12,
            11 => 11,
            10 => 10,
            9 => 9,
            8 => 8,
            7 => 7,
            6 => 6,
            5 => 5,
            4 => 4,
            3 => 3,
            2 => 2,
            1 => 1,
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('all_months')) {
    function all_months($val = null)
    {
        $data = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12,
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

//function for getting client ip address
function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

function language()
{
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        $lang[$langName] = $langName;
    }
    return empty($lang) ? false : $lang;
}

function langName($input = null)
{
    $output = [
        'en' => 'English',
        'pt-PT' => 'Portuguese',
        'es' => 'Spanish',
        'ja' => 'Japanese',
        'zh' => 'Chinese',
        'ko' => 'Korean',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

if (!function_exists('settings')) {

    function settings($keys = null)
    {
        if ($keys && is_array($keys)) {
            return Adminsetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
        } elseif ($keys && is_string($keys)) {
            $setting = Adminsetting::where('slug', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return Adminsetting::pluck('value', 'slug')->toArray();
    }
}
//Call this in every function
function set_lang($lang)
{
    $default = settings('lang');
    $lang = strtolower($lang);
    $languages = language();
    if (in_array($lang, $languages)) {
        app()->setLocale($lang);
    } else {
        if (isset($default)) {
            $lang = $default;
            app()->setLocale($lang);
        }
    }
}

//find odd even
function oddEven($number)
{
//    dd($number);
    if ($number % 2 == 0) {
        return 'even';
    } else {
        return 'odd';
    }
}

function convert_currency($amount, $to = 'USD', $from = 'USD')
{
    $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
    $json = file_get_contents($url); //,FALSE,$ctx);
    $jsondata = json_decode($json, TRUE);
    return bcmul($amount, $jsondata[$to]);
}

// fees calculation
function calculate_fees($amount, $method)
{
    $settings = allSetting();
    try {
        if ($method == SEND_FEES_FIXED) {
            return $settings['send_fees_fixed'];
        } elseif ($method == SEND_FEES_PERCENTAGE) {
            return ($settings['send_fees_percentage'] * $amount) / 100;
        } elseif ($method == SEND_FEES_BOTH) {
            return $settings['send_fees_fixed'] + (($settings['send_fees_percentage'] * $amount) / 100);
        } else {
            return 0;
        }
    } catch (\Exception $e) {
        return 0;
    }
}


function getToastrMessage($message = null)
{
    if (!empty($message)) {

        // example
        // return redirect()->back()->with('message','warning:Invalid username or password');

        $message = explode(':', $message);
        if (isset($message[1])) {
            $data = 'toastr.' . $message[0] . '("' . $message[1] . '")';
        } else {
            $data = "toastr.error(' write ( errorType:message ) ')";
        }

        return '<script>' . $data . '</script>';

    }

}

// Html render
function edit_html($route, $id)
{
    $html = '<li class="viewuser"><a href="' . route($route, encrypt($id)) . '"><img src="'.asset('assets/images/action-icon/edit.jpg').'" alt=""></a> <span>' . __('Edit') . '</span></li>';
    return $html;
}

function view_html($route, $id)
{
    $img = asset('assets/images/action-icon/details.jpg');
    $html = '<li class="viewuser"><a href="' . route($route, encrypt($id)) . '"><img src="'.$img.'" alt=""></a> <span>' . __('View') . '</span></li>';
    return $html;
}

function view_html2($id, $review)
{

    $html = '<li class="viewuser"><a data-message="'.$review.'" href="javascript:" onclick="open_modal(this)"><i class="fa fa-eye"></i></a> <span>' . __('View') . '</span></li>';
    return $html;
}

function delete_html($route, $id)
{
    $img = asset('assets/images/action-icon/delete.jpg');
    $html = '<li class="deleteuser viewuser"><a href="#delete_' . $id . '" data-toggle="modal"><img src="'.$img.'" alt=""></a> <span>' . __('Delete') . '</span></li>';
    $html .= '<div id="delete_' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Would you want to delete ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn delete-btn"href="' . route($route, encrypt($id)) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function deactive_html($route, $id)
{
    $html = '<li class="deleteuser viewuser"><a href="#deactivate_' . $id . '" data-toggle="modal"><i class="fa fa-ban"></i></a> <span>' . __('Deactivate') . '</span></li>';
    $html .= '<div id="deactivate_' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Deactive') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Would you want to deactivate ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn delete-btn"href="' . route($route, encrypt($id)) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function activate_html($route, $id)
{
    $html = '<li class="deleteuser viewuser"><a href="#active_' . $id . '" data-toggle="modal"><i class="fa fa-check"></i></a> <span>' . __('Activate') . '</span></li>';
    $html .= '<div id="active_' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Activate') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Would you want to activate ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn delete-btn"href="' . route($route, encrypt($id)) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
function email_verify_html($route, $id)
{
    $img = asset('assets/images/action-icon/email.png');
    $html = '<li class="deleteuser viewuser"><a href="#verify_' . $id . '" data-toggle="modal"><img src="'.$img.'" alt=""></a> <span>' . __('Verify Email') . '</span></li>';
    $html .= '<div id="verify_' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Verify Email') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Would you want to verify email ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn delete-btn"href="' . route($route, encrypt($id)) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function statusChange_html($route, $status, $id)
{
    $icon = ($status != STATUS_SUCCESS) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
    $status_title = ($status != STATUS_SUCCESS) ? status(STATUS_SUCCESS) : status(STATUS_DEACTIVE);
    $html = '';
    $html .= '<li><a href="' . route($route, encrypt($id)) . '">' . $icon . '<span>' . $status_title . '</span></a> </li>';
    return $html;
}

function set_special_html($route, $status, $id)
{
    $icon = ($status != IS_NOT_SPECIAL) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
    $status_title = ($status == IS_NOT_SPECIAL) ? check_special(IS_NOT_SPECIAL) : check_special(IS_SPECIAL);
    $html = '';
    $html .= '<li><a href="' . route($route, encrypt($id)) . '">' . $icon . '<span>' . $status_title . '</span></a> </li>';
    return $html;
}

// Discount amount
function discount_amount($discount, $discount_type)
{
    $discount_amount = '';
    if (isset($discount_type) && $discount_type == DISCOUNT_TYPE_FIXED) {
        $discount_amount =  currency_symbol(allSetting()['currency']).$discount;
    } elseif (isset($discount_type) && $discount_type == DISCOUNT_TYPE_PERCENTAGE && $discount <= 100) {
        $discount_amount = $discount . ' %';
    }
    return $discount_amount;
}

function price($price, $discount, $discount_type)
{
    if (isset($discount_type) && $discount_type == DISCOUNT_TYPE_FIXED) {
        $net_price = $price - $discount;
    } elseif (isset($discount_type) && $discount_type == DISCOUNT_TYPE_FIXED) {
        $net_price = $price - ($price * $discount) / 100;
    } else {
        $net_price = $price;
    }
    return $net_price;
}

function service_item($services)
{
    $settings = allSetting();
    $html = '';
    foreach ($services as $service) {
        $html .= '<div class="col-lg-4 col-md-6 col-12 moreload">';
        $html .= '<div class="service-wrappper">';
        $html .= '<div class="service-img">';
//        $html .= '<a class="wishlist" href="#"><i class="fa fa-heart"></i></a>';
        $html .= '<img src="';
        if (empty($service->images)) {
            $html .= asset('images/default.jpg');
        } else {
            $html .= asset(path_service_image() . $service->images);
        }
        $html .= ' " alt="">';
//        $html .= '<div class="checkbox"><input type="checkbox" id="box-1"><label for="box-1"></label></div>';
        if ($service->discount > 0) $html .= '<span class="discount">' . discount_amount($service->discount, $service->discount_type) . '</span>';
        $html .= '</div>';
        $html .= '<div class="service-content">';
        $html .= '<h5>' . $settings['currency_symbol'] . price($service->price, $service->discount, $service->discount_type) . '<del>' . $settings['currency_symbol'] . $service->price . '</del></h5>';
        $html .= '<h3><a href="' . route('getServiceDetails', encrypt($service->id)) . '">' . $service->title . '</a></h3>';
        $html .= $service->description;
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }
    return $html;
}

function reservation_service_item($services)
{
    $settings = allSetting();
    $html = '';
    foreach ($services as $service) {
        $html .= '<div class="col-lg-4 col-md-6 col-12 moreload">';
        $html .= '<div class="service-wrappper">';
        $html .= '<div class="service-img">';
//        $html .= '<a class="wishlist" href="#"><i class="fa fa-heart"></i></a>';
        $html .= '<img src="';
        if (empty($service->images)) {
            $html .= asset('images/default.jpg');
        } else {
            $html .= asset(path_service_image() . $service->images);
        }
        $html .= ' " alt="">';
        $html .= '<div class="checkbox"><input type="checkbox" name="service[]" value="' . $service->id . '" id="box-' . $service->id . '"><label for="box-' . $service->id . '"></label></div>';
        if ($service->discount > 0) $html .= '<span class="discount">' . discount_amount($service->discount, $service->discount_type) . '</span>';
        $html .= '</div>';
        $html .= '<div class="service-content">';
        $html .= '<h5>' . $settings['currency_symbol'] . price($service->price, $service->discount, $service->discount_type) . '<del>' . $settings['currency_symbol'] . $service->price . '</del></h5>';
        $html .= '<h3><a href="' . route('getServiceDetails', encrypt($service->id)) . '">' . $service->title . '</a></h3>';
        $html .= $service->description;
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }
    return $html;
}

function barber_item($items)
{
    $html = '';
    foreach ($items as $item) {
        $html .= '<div class="col-lg-4 col-md-6 col-12 moreload">';
        $html .= '<div class="team-wrap">';
        $html .= '<div class="team-img">';
        $html .= '<a data-toggle="modal" data-target="#team" href="javascript:void(0);">';
        $html .= '<img src="' . asset('images/default.jpg') . '" alt="">';
        $html .= '</a>';
        $html .= '</div>';
        $html .= '<div class="team-content">';
        $html .= '<h3>' . $item->first_name . ' ' . $item->last_name . '</h3>';
        $html .= '<p>Hair Cutter</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="modal fade team-details-wrap" id="team" tabindex="-1">';
        $html .= '<div class="modal-dialog modal-dialog-centered">';
        $html .= '<div class="modal-content">';
        $html .= '<button class="close-btn" data-dismiss="modal" aria-label="Close">';
        $html .= '<span aria-hidden="true">X</span>';
        $html .= '</button>';
        $html .= '<div class="modal-body">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-6 col-12">';
        $html .= '<div class="team-details-img">';
        $html .= '<ul>';
        $html .= '<li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>';
        $html .= '<li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>';
        $html .= '<li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>';
        $html .= '<li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>';
        $html .= '<li class="skype"><a href="#"><i class="fa fa-skype"></i></a></li>';
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-6 col-12">';
        $html .= '<div class="team-details-content">';
        $html .= '<h3>Jone Doe</h3>';
        $html .= '<span>HAIR CUTTER</span>';
        $html .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, sequi doloribus autem quo, est reiciendis dignissimos cupiditate deserunt necessitatibus atque, maiores natus culpa eaque quae nemo iure voluptas placeat suscipit quis magnam odio sapiente assumenda. Possimus quasi eligendi nam</p>';
        $html .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam facilis, fugit inventore earum nemo enim, nulla asperiores eum omnis amet error sequi esse nobis ducimus.</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }
    return $html;
}

function status_search($keyword)
{
    $st = [];
    if (strpos('_active', strtolower($keyword)) != false) {
        array_push($st, STATUS_ACTIVE);
    }
    if (strpos('_deactive', strtolower($keyword)) != false) {
        array_push($st, STATUS_DEACTIVE);
    }
    return $st;
}

function currency_symbol_text($a = null)
{
    $output = [
        'AFN' => 'Afghani(؋)',
        'ANG' => 'Netherlands Antillian Guilder(ƒ)',
        'ARS' => 'Argentine Peso($)',
        'AUD' => 'Australian Dollar(A$)',
        'BRL' => 'Brazilian Real(R$)',
        'BSD' => 'Bahamian Dollar(B$)',
        'CAD' => 'Canadian Dollar($)',
        'CHF' => 'Swiss Franc(CHF)',
        'CLP' => 'CLF Chilean Peso Unidades de fomento($)',
        'CNY' => 'Yuan Renminbi(¥)',
        'COP' => 'COU Colombian Peso Unidad de Valor Real($)',
        'CZK' => 'Czech Koruna(Kč)',
        'DKK' => 'Danish Krone(kr)',
        'EUR' => 'Euro(€)',
        'FJD' => 'Fiji Dollar(FJ$)',
        'GBP' => 'Pound Sterling(£)',
        'GHS' => 'Ghanaian cedi(GH₵)',
        'GTQ' => 'Quetzal(Q)',
        'HKD' => 'Hong Kong Dollar($)',
        'HNL' => 'Lempira(L)',
        'HRK' => 'Croatian Kuna(kn)',
        'HUF' => 'Forint(Ft)',
        'IDR' => 'Rupiah(Rp)',
        'ILS' => 'New Israeli Sheqel(₪)',
        'INR' => 'Indian rupee(₹)',
        'ISK' => 'Iceland Krona(kr)',
        'JMD' => 'Jamaican Dollar(J$)',
        'JPY' => 'Yen(¥)',
        'KRW' => 'Won(₩)',
        'LKR' => 'Sri Lanka Rupee(₨)',
        'MAD' => 'Moroccan dirham(.د.م)',
        'MMK' => 'Myanmar kyat(K)',
        'MXN' => 'Mexican peso($)',
        'MYR' => 'Malaysian Ringgit(RM)',
        'NOK' => 'Norwegian Krone(kr)',
        'NZD' => 'New Zealand Dollar($)',
        'PAB' => 'USD Balboa US Dollar(B/.)',
        'PEN' => 'Nuevo Sol(S/.)',
        'PHP' => 'Philippine Peso(₱)',
        'PKR' => 'Pakistan Rupee(₨)',
        'PLN' => 'Zloty(zł)',
        'RON' => 'New Leu(lei)',
        'RSD' => 'Serbian Dinar(RSD)',
        'RUB' => 'Russian Ruble(руб)',
        'SEK' => 'Swedish Krona(kr)',
        'SGD' => 'Singapore Dollar(S$)',
        'THB' => 'Baht(฿)',
        'TND' => 'Tunisian dinar(DT)',
        'TRY' => 'Turkish lira(TL)',
        'TTD' => 'Trinidad and Tobago Dollar(TT$)',
        'TWD' => 'New Taiwan Dollar(NT$)',
        'USD' => 'US Dollar($)',
        'VEF' => 'Bolivar Fuerte(Bs)',
        'VND' => 'Dong(₫)',
        'XAF' => 'Central African CFA franc(FCFA)',
        'XCD' => 'East Caribbean Dollar($)',
        'XPF' => 'CFP franc(F)',
        'ZAR' => 'Rand(R)',
    ];
    if ($a == null) {
        return $output;
    } elseif (isset($output[$a])) {

        return $output[$a];
    } else {

        return $a;
    }
}

function currency_symbol($a = null)
{
    $output = [
        'AFN' => '؋',
        'ANG' => 'ƒ',
        'ARS' => '$',
        'AUD' => 'A$',
        'BRL' => 'R$',
        'BSD' => 'B$',
        'CAD' => '$',
        'CHF' => 'CHF',
        'CLP' => '$',
        'CNY' => '¥',
        'COP' => '$',
        'CZK' => 'Kč',
        'DKK' => 'kr',
        'EUR' => '€',
        'FJD' => 'FJ$',
        'GBP' => '£',
        'GHS' => 'GH₵',
        'GTQ' => 'Q',
        'HKD' => '$',
        'HNL' => 'L',
        'HRK' => 'kn',
        'HUF' => 'Ft',
        'IDR' => 'Rp',
        'ILS' => '₪',
        'INR' => '₹',
        'ISK' => 'kr',
        'JMD' => 'J$',
        'JPY' => '¥',
        'KRW' => '₩',
        'LKR' => '₨',
        'MAD' => '.د.م',
        'MMK' => 'K',
        'MXN' => '$',
        'MYR' => 'RM',
        'NOK' => 'kr',
        'NZD' => '$',
        'PAB' => 'B/.',
        'PEN' => 'S/.',
        'PHP' => '₱',
        'PKR' => '₨',
        'PLN' => 'zł',
        'RON' => 'lei',
        'RSD' => 'RSD',
        'RUB' => 'руб',
        'SEK' => 'kr',
        'SGD' => 'S$',
        'THB' => '฿',
        'TND' => 'DT',
        'TRY' => 'TL',
        'TTD' => 'TT$',
        'TWD' => 'NT$',
        'USD' => '$',
        'VEF' => 'Bs',
        'VND' => '₫',
        'XAF' => 'FCFA',
        'XCD' => '$',
        'XPF' => 'F',
        'ZAR' => 'R',
    ];
    if ($a == null) {
        return $output;
    } elseif (isset($output[$a])) {

        return $output[$a];
    } else {

        return $a;
    }
}

if (!function_exists('payment_methods')) {
    function payment_methods($val = null)
    {
        $data = array(
            1 => __('Cash On Delivery'),
            2 => __('Credit Card'),
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('product_is_wishlist')) {
    function product_is_wishlist($product_id)
    {
        $is_favorite = 0;
        $wishList = UserProduct::where(['user_id' => Auth::id(), 'product_id' => $product_id])->first();
        if ($wishList && ($wishList->is_wishlist == 1)) {
            $is_favorite = 1;
        }

        return $is_favorite;
    }
}


if (!function_exists('discounted_price')) {
    function discounted_price($price, $type, $discount)
    {
        $discounted_price = $price;
        if ($type == DISCOUNT_TYPE_PERCENTAGE) {
            if ($discount <= 100) {
                $discounted_price = $price - ($price * $discount)/100;
            }
        } elseif($type == DISCOUNT_TYPE_FIXED) {
            if ($price > $discount) {
                $discounted_price = $price - $discount;
            }
        }

        return $discounted_price;
    }
}
if (!function_exists('discount_price')) {
    function discount_price($price, $type, $discount)
    {
        $discount_price = 0;
        if ($type == DISCOUNT_TYPE_PERCENTAGE) {
            if ($discount <= 100) {
                $discount_price = ($price * $discount)/100;
            }
        } elseif($type == DISCOUNT_TYPE_FIXED) {
            if ($price > $discount) {
                $discount_price = $discount;
            }
        }

        return $discount_price;
    }
}

// check is offer or not
function checkIsOffer($product_id)
{
    return app(ProductRepository::class)->checkIsOffer($product_id);
}

// my cart list

// check is offer or not
function myCartList()
{
    return app(CartRepository::class)->myCartList();
}
// offered price
function offered_price($product_id)
{
    $price = 0;
    $offer = Offer::join('products', 'products.id', '=', 'offers.product_id')
        ->where(['offers.product_id' => $product_id])
        ->select('offers.*', 'products.price')
        ->first();
    if ($offer) {
        $price = discounted_price($offer->price, $offer->discount_type, $offer->discount);
    }

    return $price;
}
// product addons
function productAddons($type, $product_id)
{
    return app(AddonRepository::class)->productAddons($type, $product_id);
}
// product options
function productOptions($product_id)
{
    return app(OptionRepository::class)->productOptions($product_id);
}
// country list

function country($lang = null)
{
    $output = [
        'AF' => __('Afghanistan'),
        'AL' => __('Albania'),
        'DZ' => __('Algeria'),
        'DS' => __('American Samoa'),
        'AD' => __('Andorra'),
        'AO' => __('Angola'),
        'AI' => __('Anguilla'),
        'AQ' => __('Antarctica'),
        'AG' => __('Antigua and Barbuda'),
        'AR' => __('Argentina'),
        'AM' => __('Armenia'),
        'AW' => __('Aruba'),
        'AU' => __('Australia'),
        'AT' => __('Austria'),
        'AZ' => __('Azerbaijan'),
        'BS' => __('Bahamas'),
        'BH' => __('Bahrain'),
        'BD' => __('Bangladesh'),
        'BB' => __('Barbados'),
        'BY' => __('Belarus'),
        'BE' => __('Belgium'),
        'BZ' => __('Belize'),
        'BJ' => __('Benin'),
        'BM' => __('Bermuda'),
        'BT' => __('Bhutan'),
        'BO' => __('Bolivia'),
        'BA' => __('Bosnia and Herzegovina'),
        'BW' => __('Botswana'),
        'BV' => __('Bouvet Island'),
        'BR' => __('Brazil'),
        'IO' => __('British Indian Ocean Territory'),
        'BN' => __('Brunei Darussalam'),
        'BG' => __('Bulgaria'),
        'BF' => __('Burkina Faso'),
        'BI' => __('Burundi'),
        'KH' => __('Cambodia'),
        'CM' => __('Cameroon'),
        'CA' => __('Canada'),
        'CV' => __('Cape Verde'),
        'KY' => __('Cayman Islands'),
        'CF' => __('Central African Republic'),
        'TD' => __('Chad'),
        'CL' => __('Chile'),
        'CN' => __('China'),
        'CX' => __('Christmas Island'),
        'CC' => __('Cocos (Keeling) Islands'),
        'CO' => __('Colombia'),
        'KM' => __('Comoros'),
        'CG' => __('Congo'),
        'CK' => __('Cook Islands'),
        'CR' => __('Costa Rica'),
        'HR' => __('Croatia (Hrvatska)'),
        'CU' => __('Cuba'),
        'CY' => __('Cyprus'),
        'CZ' => __('Czech Republic'),
        'DK' => __('Denmark'),
        'DJ' => __('Djibouti'),
        'DM' => __('Dominica'),
        'DO' => __('Dominican Republic'),
        'TP' => __('East Timor'),
        'EC' => __('Ecuador'),
        'EG' => __('Egypt'),
        'SV' => __('El Salvador'),
        'GQ' => __('Equatorial Guinea'),
        'ER' => __('Eritrea'),
        'EE' => __('Estonia'),
        'ET' => __('Ethiopia'),
        'FK' => __('Falkland Islands (Malvinas)'),
        'FO' => __('Faroe Islands'),
        'FJ' => __('Fiji'),
        'FI' => __('Finland'),
        'FR' => __('France'),
        'FX' => __('France, Metropolitan'),
        'GF' => __('French Guiana'),
        'PF' => __('French Polynesia'),
        'TF' => __('French Southern Territories'),
        'GA' => __('Gabon'),
        'GM' => __('Gambia'),
        'GE' => __('Georgia'),
        'DE' => __('Germany'),
        'GH' => __('Ghana'),
        'GI' => __('Gibraltar'),
        'GK' => __('Guernsey'),
        'GR' => __('Greece'),
        'GL' => __('Greenland'),
        'GD' => __('Grenada'),
        'GP' => __('Guadeloupe'),
        'GU' => __('Guam'),
        'GT' => __('Guatemala'),
        'GN' => __('Guinea'),
        'GW' => __('Guinea-Bissau'),
        'GY' => __('Guyana'),
        'HT' => __('Haiti'),
        'HM' => __('Heard and Mc Donald Islands'),
        'HN' => __('Honduras'),
        'HK' => __('Hong Kong'),
        'HU' => __('Hungary'),
        'IS' => __('Iceland'),
        'IN' => __('India'),
        'IM' => __('Isle of Man'),
        'ID' => __('Indonesia'),
        'IR' => __('Iran (Islamic Republic of)'),
        'IQ' => __('Iraq'),
        'IE' => __('Ireland'),
        'IL' => __('Israel'),
        'IT' => __('Italy'),
        'CI' => __('Ivory Coast'),
        'JE' => __('Jersey'),
        'JM' => __('Jamaica'),
        'JP' => __('Japan'),
        'JO' => __('Jordan'),
        'KZ' => __('Kazakhstan'),
        'KE' => __('Kenya'),
        'KI' => __('Kiribati'),
        'KP' => __('Korea, Democratic People\'s Republic of'),
        'KR' => __('Korea, Republic of'),
        'XK' => __('Kosovo'),
        'KW' => __('Kuwait'),
        'KG' => __('Kyrgyzstan'),
        'LA' => __('Lao People\'s Democratic Republic'),
        'LV' => __('Latvia'),
        'LB' => __('Lebanon'),
        'LS' => __('Lesotho'),
        'LR' => __('Liberia'),
        'LY' => __('Libyan Arab Jamahiriya'),
        'LI' => __('Liechtenstein'),
        'LT' => __('Lithuania'),
        'LU' => __('Luxembourg'),
        'MO' => __('Macau'),
        'MK' => __('Macedonia'),
        'MG' => __('Madagascar'),
        'MW' => __('Malawi'),
        'MY' => __('Malaysia'),
        'MV' => __('Maldives'),
        'ML' => __('Mali'),
        'MT' => __('Malta'),
        'MH' => __('Marshall Islands'),
        'MQ' => __('Martinique'),
        'MR' => __('Mauritania'),
        'MU' => __('Mauritius'),
        'TY' => __('Mayotte'),
        'MX' => __('Mexico'),
        'FM' => __('Micronesia, Federated States of'),
        'MD' => __('Moldova, Republic of'),
        'MC' => __('Monaco'),
        'MN' => __('Mongolia'),
        'ME' => __('Montenegro'),
        'MS' => __('Montserrat'),
        'MA' => __('Morocco'),
        'MZ' => __('Mozambique'),
        'MM' => __('Myanmar'),
        'NA' => __('Namibia'),
        'NR' => __('Nauru'),
        'NP' => __('Nepal'),
        'NL' => __('Netherlands'),
        'AN' => __('Netherlands Antilles'),
        'NC' => __('New Caledonia'),
        'NZ' => __('New Zealand'),
        'NI' => __('Nicaragua'),
        'NE' => __('Niger'),
        'NG' => __('Nigeria'),
        'NU' => __('Niue'),
        'NF' => __('Norfolk Island'),
        'MP' => __('Northern Mariana Islands'),
        'NO' => __('Norway'),
        'OM' => __('Oman'),
        'PK' => __('Pakistan'),
        'PW' => __('Palau'),
        'PS' => __('Palestine'),
        'PA' => __('Panama'),
        'PG' => __('Papua New Guinea'),
        'PY' => __('Paraguay'),
        'PE' => __('Peru'),
        'PH' => __('Philippines'),
        'PN' => __('Pitcairn'),
        'PL' => __('Poland'),
        'PT' => __('Portugal'),
        'PR' => __('Puerto Rico'),
        'QA' => __('Qatar'),
        'RE' => __('Reunion'),
        'RO' => __('Romania'),
        'RU' => __('Russian Federation'),
        'RW' => __('Rwanda'),
        'KN' => __('Saint Kitts and Nevis'),
        'LC' => __('Saint Lucia'),
        'VC' => __('Saint Vincent and the Grenadines'),
        'WS' => __('Samoa'),
        'SM' => __('San Marino'),
        'ST' => __('Sao Tome and Principe'),
        'SA' => __('Saudi Arabia'),
        'SN' => __('Senegal'),
        'RS' => __('Serbia'),
        'SC' => __('Seychelles'),
        'SL' => __('Sierra Leone'),
        'SG' => __('Singapore'),
        'SK' => __('Slovakia'),
        'SI' => __('Slovenia'),
        'SB' => __('Solomon Islands'),
        'SO' => __('Somalia'),
        'ZA' => __('South Africa'),
        'GS' => __('South Georgia South Sandwich Islands'),
        'ES' => __('Spain'),
        'LK' => __('Sri Lanka'),
        'SH' => __('St. Helena'),
        'PM' => __('St. Pierre and Miquelon'),
        'SD' => __('Sudan'),
        'SR' => __('Suriname'),
        'SJ' => __('Svalbard and Jan Mayen Islands'),
        'SZ' => __('Swaziland'),
        'SE' => __('Sweden'),
        'CH' => __('Switzerland'),
        'SY' => __('Syrian Arab Republic'),
        'TW' => __('Taiwan'),
        'TJ' => __('Tajikistan'),
        'TZ' => __('Tanzania, United Republic of'),
        'TH' => __('Thailand'),
        'TG' => __('Togo'),
        'TK' => __('Tokelau'),
        'TO' => __('Tonga'),
        'TT' => __('Trinidad and Tobago'),
        'TN' => __('Tunisia'),
        'TR' => __('Turkey'),
        'TM' => __('Turkmenistan'),
        'TC' => __('Turks and Caicos Islands'),
        'TV' => __('Tuvalu'),
        'UG' => __('Uganda'),
        'UA' => __('Ukraine'),
        'AE' => __('United Arab Emirates'),
        'UK' => __('United Kingdom'),
        'US' => __('United States'),
        'UM' => __('United States minor outlying islands'),
        'UY' => __('Uruguay'),
        'UZ' => __('Uzbekistan'),
        'VU' => __('Vanuatu'),
        'VA' => __('Vatican City State'),
        'VE' => __('Venezuela'),
        'VN' => __('Vietnam'),
        'VG' => __('Virgin Islands (British)'),
        'VI' => __('Virgin Islands (U.S.)'),
        'WF' => __('Wallis and Futuna Islands'),
        'EH' => __('Western Sahara'),
        'YE' => __('Yemen'),
        'ZR' => __('Zaire'),
        'ZM' => __('Zambia'),
        'ZW' => __('Zimbabwe')
    ];

    if ($lang == null) {
        return $output;
    } else if (is_array($lang)) {
        return array_intersect($output, $lang);
    } else {
        return isset($output[$lang]) ? $output[$lang] : $lang;
    }
}

//get product shipping amount
function getProductShippingAmount($product_id, $shipping_id)
{
    $price = 0;
    $productShipping = ProductShipping::where(['product_id' => $product_id, 'shipping_id' => $shipping_id])->first();
    if (isset($productShipping)) {
        $price = $productShipping->price;
    }

    return $price;
}


function shipping_address_details($order_id) {
    $data =[];
    $shipping = OrderShippingAddress::where('order_id', $order_id)->first();
    if (isset($shipping)) {
        $data = $shipping;
    }
    return $data;
}
function billing_address_details($order_id) {
    $data =[];
    $shipping = OrderBillingAddress::where('order_id', $order_id)->first();
    if (isset($shipping)) {
        $data = $shipping;
    }
    return $data;
}


// generate order id

function generate_order_id()
{
    $orderId = 100000000;
    $order = Order::orderBy('id','desc')->first();
    if ($order) {
        $orderId = $order->order_id;
    }
    return $orderId;
}

// order option list
function get_order_option_list($sub_order_id)
{
    $data = '';
    $items = OrderProductOption::where('sub_order_id', $sub_order_id)->first();
    if (isset($items)) {
        $data = $items;
    }
    return $data;
}
// order addons list
function get_order_addons_list($sub_order_id)
{
    $data = [];
    $items = OrderProductAddon::where('sub_order_id', $sub_order_id)->get();
    if (isset($items[0])) {
        $data = $items;
    }
    return $data;
}
// order addons list
function get_order_supplements_list($sub_order_id)
{
    $data = [];
    $items = OrderProductSupplement::where('sub_order_id', $sub_order_id)->get();
    if (isset($items[0])) {
        $data = $items;
    }
    return $data;
}

// count product by price
function product_count_by_price($min,$max)
{
    $count = 0;
    $product = Product::where(['status'=> STATUS_ACTIVE])
        ->whereBetween('price', [$min, $max])
        ->get();
    if (isset($product[0])) {
       $count = $product->count();
    }

    return $count;
}

// get the image name from url
function get_image_name ($imageUrl)
{
    $url = $imageUrl;
    $keys = parse_url($url); // parse the url
    $path = explode("/", $keys['path']); // splitting the path
    $last = end($path); // get the value of the last element

    return $last;
}

// get comment count

function get_comments_count($id)
{
    $item = BlogComment::join('blogs','blogs.id','=','blog_comments.blog_id')
        ->where(['blogs.id'=>$id])
        ->count();

    return $item;
}
// get post count

function get_post_count($id)
{
    $item = Blog::join('blog_categories','blog_categories.id','=','blogs.category_id')
        ->where(['blog_categories.id'=>$id])
        ->count();

    return $item;
}

function make_blog_slug($title)
{
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '-'
    );

    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $title);

    // -- Returns the slug
    $slug = strtolower(strtr($title, $table));
    $slug = str_replace("?","",$slug);
    $blog = Blog::where('slug',$slug)->first();
    if (isset($blog)) {
        $slug = $slug.'-1';
    }

    return $slug;
}

function make_menu_slug($title)
{
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '-'
    );

    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $title);

    // -- Returns the slug
    $slug = strtolower(strtr($title, $table));
    $slug = str_replace("?","",$slug);
    $blog = Menu::where('slug',$slug)->first();
    if (isset($blog)) {
        $slug = $slug.'-1';
    }

    return $slug;
}
