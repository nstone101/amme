<?php

namespace App\Services;

use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\QuestionOption;
use App\Model\UserCoin;
use App\Model\UserInfo;
use App\Model\UserSetting;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Model\WalletAddress;
use App\Model\Withdrawal;
use App\Repository\AffiliateRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommonService
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

    public function save_login_setting($request)
    {
        $rules = [
            'password' => 'required|min:8|strong_pass|confirmed',
        ];

        $messages = [
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be above 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!')
        ];

        $request->validate($rules, $messages);
        $password = $request->password;

        $update ['password'] = Hash::make($password);

        $user = User::where(['id' => Auth::user()->id]);

        if ($user->update($update)) {
            return [
                'success' => true,
                'message' => 'Information Updated Successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Information Update Failed. Try Again!'
        ];
    }

    public function isPhoneVerified($user)
    {
        if (empty($user->phone) || $user->phone_verified == PHONE_IS_NOT_VERIFIED) {
            return ['success' => false, 'phone_verify' => false, 'message' => __('Please Verify your phone.')];
        }else{
            return ['success' => true, 'phone_verify' => true, 'message' => __('Verified phone.')];
        }
    }

    public function userRegistration($request, $mailTemplet, $mail_key)
    {
        $randno = randomNumber(6);
        try {
            DB::transaction(function () use ($request, $mailTemplet, $mail_key, $randno) {
                $user = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'country' => $request->country,
                    'password' => Hash::make($request->password),
                    'role' => isset($request->role) ? $request->role : USER_ROLE_USER,
                    'active_status' => STATUS_SUCCESS,
                    'email_verified' => STATUS_PENDING,
                    'reset_code' => md5($request->get('email') . uniqid() . randomString(5)),
                    'language' => 'en'
                ]);
                UserVerificationCode::create(
                    ['user_id' => $user->id,
                        'type' => 1,
                        'code' => $mail_key,
                        'expired_at' => date('Y-m-d', strtotime('+10 days')),
                        'status' => STATUS_PENDING]
                );
                $this->sendVerificationMail($user, $mailTemplet, $mail_key);
            });
            return [
                'success' => true,
                'message' => __('We have just sent a verification link on Email . ')
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
        }
    }


    public function sendVerificationMail($user, $mailTemplet, $mail_key)
    {

        $mailService = app(MailService::class);
        $userName = $user->name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    public function create_coin_wallet($user_id)
    {
        $coin = 0;
        if(!empty(allsetting('signup_coin'))) {
            $coin = allsetting('signup_coin');
        }
        $createCoinWallet = UserCoin::create(['user_id' => $user_id, 'coin' => $coin]);
    }

    public function user_details($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

}
