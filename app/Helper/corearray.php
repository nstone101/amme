<?php

//User Roles

function userRole($input = null)
{
    $output = [
        USER_ROLE_ADMIN => __('Admin'),
        USER_ROLE_USER => __('User'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
//User Activity Array
function userActivity($input = null)
{
    $output = [
        USER_ACTIVITY_LOGIN => __('Log In'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
//Discount Type array
function discount_type($input = null)
{
    $output = [
        DISCOUNT_TYPE_FIXED => __('Fixed'),
        DISCOUNT_TYPE_PERCENTAGE => __('Percentage')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function statusAction($input = null)
{
    $output = [
        STATUS_PENDING => __('Pending'),
        STATUS_SUCCESS => __('Active'),
        STATUS_FINISHED => __('Finished'),
        STATUS_SUSPENDED => __('Suspended'),
        STATUS_REJECT => __('Rejected'),
        STATUS_DELETED => __('Deleted'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function admin_order_status($input = null)
{
    $output = [
        NEW_ORDER => __('New'),
        ACCEPT_FOOD_MANAGER => __('Processing'),
        OUT_TO_DELIVER => __('Handover To Deliver'),
        ORDER_DELIVERED => __('Order Delivered'),
        ORDER_CANCELED => __('Order Cancelled'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function user_order_status($input = null)
{
    $output = [
        NEW_ORDER => __('New'),
        ACCEPT_FOOD_MANAGER => __('Processing'),
        OUT_TO_DELIVER => __('Handover To Deliver'),
        ORDER_DELIVERED => __('Delivered'),
        ORDER_CANCELED => __('Canceled'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function status($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Active'),
        STATUS_DEACTIVE => __('Deactive'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function check_special($input = null)
{
    $output = [
        IS_SPECIAL => __('Special'),
        IS_NOT_SPECIAL => __('Not Special'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function actions($input = null)
{
    if (is_null($input)) {
        return Action::all()->toArray();
    } elseif (is_array($input)) {
        return Action::whereIn('name', $input)->orWhereIn('url', $input)->get()->toArray();
    } else {
        return Action::where('name', $input)->orWhere('url', $input)->first()->toArray();
    }
}

function customPages($input=null){
    $output = [
        'faqs' => __('FAQS'),
        't_and_c' => __('T&C')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

if (!function_exists('comment_status')) {
    function comment_status($val)
    {
        $item = array(
            COMMENT_PENDING => __('Pending'),
            COMMENT_APPROVED => __('Approved'),
            COMMENT_REJECTED => __('Rejected')
        );

        return $item[$val];
    }
}

function Components($input=null){
    $output = [
        'HomePage' => __('HomePage'),
        'AboutUs' => __('AboutUs'),
        'Services' => __('Services'),
        'TeamPage' => __('TeamPage'),
        'Portfolio' => __('Portfolio'),
        'Gallery' => __('Gallery'),
        'BlogLists' => __('BlogLists'),
        'ContactUsPage' => __('ContactUsPage')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}




/*********************************************
 *        End Ststus Functions
 *********************************************/
