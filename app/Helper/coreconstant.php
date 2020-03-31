<?php
const REVIEW = 1;
const RATING = 2;

const COMMENT_PENDING = 0;
const COMMENT_APPROVED = 1;
const COMMENT_REJECTED = 2;
//Product Type
const PRODUCT_TYPE_REGULAR=1;
const PRODUCT_TYPE_BUNDLE=2;
// User Role Type
const USER_ROLE_ADMIN = 1;
const USER_ROLE_USER = 2;
const USER_ROLE_CHEF_MANAGER = 3;
const USER_ROLE_DELIVERY_MANAGER = 4;

//price rate type
const PRICE_ABOVE = 10000;
const PRICE_HIGH = 450;
const PRICE_MEDIUM = 250;
const PRICE_LOW = 50;

// User  Type
const USER_TYPE_ADMIN = 1;
const USER_TYPE_USER = 2;

// Addon  Type
const ADDON_TYPE_ADDON = 1;
const ADDON_TYPE_SUPPLEMENT = 2;

// Slider status
const STATUS_ACTIVE=1;
const STATUS_DEACTIVE=0;

// stock status
const IN_STOCK = 1;
const OUT_OF_STOCK = 2;

const IS_SPECIAL =1;
const IS_NOT_SPECIAL =0;

//wishlist
const IS_WISHLISTED= 1;
const IS_FAVORITE= 2;

// type
const FRONTEND =2;
const BACKEND =1;
// Status
const STATUS_PENDING=0;
const STATUS_SUCCESS=1;
const STATUS_SUSPENDED=2;
const STATUS_REJECT=3;
const STATUS_FINISHED=5;
const STATUS_DELETED=6;

// list of days
const DAY_OF_WEEK_MONDAY=1;
const DAY_OF_WEEK_TUESDAY=2;
const DAY_OF_WEEK_WEDNESDAY=3;
const DAY_OF_WEEK_THURSDAY=4;
const DAY_OF_WEEK_FRIDAY=5;
const DAY_OF_WEEK_SATURDAY=6;
const DAY_OF_WEEK_SUNDAY=7;

// Gender
const GENDER_MALE=1;
const GENDER_FEMALE=2;
const GENDER_OTHER=3;

//Varification send Type
const Mail=1;
const PHONE=2;

// User Activity
const USER_ACTIVITY_LOGIN=1;

const CASH_ON_DALIVERY = 1;
const CREDIT_CARD = 2;

//Discount Type
const DISCOUNT_TYPE_FIXED=1;
const DISCOUNT_TYPE_PERCENTAGE=2;

// admin order Status
const NEW_ORDER = 0;
const ACCEPT_FOOD_MANAGER = 1;
const OUT_TO_DELIVER = 2;
const ORDER_DELIVERED = 3;
const ORDER_CANCELED = 4;
const YPTO_BUY='ypto_buy';
const YPTO_PAY='ypto_pay';
const YPTO_COIN='ypto_coin';

// notification type
const ORDER =1;
// File Type
const FILE_TYPE_VIDEO=1;
const FILE_TYPE_IMAGE=2;

// Actions
const ACTION_DASHBOARD_VIEW = 'action_dashboard_view';
const ACTION_USER_VIEW = 'action_user_view';
const ACTION_USER_ADD = 'action_user_add';
const ACTION_USER_EDIT = 'action_user_edit';
const ACTION_USER_DELETE = 'action_user_delete';

const ACTION_USER_MANAGEMENT = 'action_user_management';
const ACTION_ADMIN_SETTING = 'action_admin_setting';

const ACTION_ROLE_VIEW = 'action_role_view';
const ACTION_ROLE_ADD = 'action_role_add';
const ACTION_ROLE_EDIT = 'action_role_edit';
const ACTION_ROLE_DELETE = 'action_role_delete';

const ACTION_OFFER_VIEW = 'action_offer_view';
const ACTION_OFFER_ADD = 'action_offer_add';
const ACTION_OFFER_EDIT = 'action_offer_edit';
const ACTION_OFFER_DELETE = 'action_offer_delete';

const ACTION_PRODUCT_VIEW = 'action_product_view';
const ACTION_PRODUCT_ADD = 'action_product_add';
const ACTION_PRODUCT_EDIT = 'action_product_edit';
const ACTION_PRODUCT_DELETE = 'action_product_delete';

const ACTION_ORDER_VIEW = 'action_order_view';
const ACTION_PENDING_ORDER_VIEW = 'action_pending_order_view';
const ACTION_DELIVERED_ORDER_VIEW = 'action_delivered_order_view';
const ACTION_FAILED_ORDER_VIEW = 'action_failed_order_view';

const ACTION_CATEGORY_VIEW = 'action_category_view';
const ACTION_SUB_CATEGORY_VIEW = 'action_sub_category_view';
const ACTION_CATEGORY_ADD = 'action_category_add';
const ACTION_CATEGORY_EDIT = 'action_category_edit';
const ACTION_CATEGORY_DELETE = 'action_category_delete';

const ACTION_CUPON_VIEW = 'action_cupon_view';
const ACTION_CUPON_ADD = 'action_cupon_add';
const ACTION_CUPON_EDIT = 'action_cupon_edit';
const ACTION_CUPON_DELETE = 'action_cupon_delete';

const ACTION_COST_VIEW = 'action_cost_view';
const ACTION_COST_ADD = 'action_cost_add';
const ACTION_COST_EDIT = 'action_cost_edit';
const ACTION_COST_DELETE = 'action_cost_delete';

const ACTION_COST_EXCEL_UPLOAD = 'action_cost_excel_upload';

// for api page type
const TYPE_HOME = 1;
const TYPE_ALL = 2;
