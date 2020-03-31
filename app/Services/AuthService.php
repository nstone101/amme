<?php
namespace App\Http\Services;
use App\Model\UserVerificationCode;
use App\Services\MailService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService{
    public function _credentials(Request $request)
    {
        $field = filter_var($request->input($this->_username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input($this->_username())]);
        return $request->only($field, 'password');
    }

    public function _username()
    {
        return 'email';
    }

    public function _checkActiveStatus()
    {
        $user = Auth::user();

        if ($user->activestatus == 3)
        {
            return [
                'status' => true,
                'message' => '',
            ];
        }
        elseif ($user->activestatus == 2)
        {
            Auth::logout();
            return [
                'status' => false,
                'message' => __('Your account is suspended Please contact our support center!')
            ];
        }
        elseif($user->activestatus == 1)
        {
            Auth::logout();
            return [
                'status' => false,
                'message' => __('Your account has been deleted')
            ];
        }
    }

    public function _checkLastLogin()
    {
        $lastLogin = Auth::user()->accacts()->where('action', strtolower('sign_in'))->first();
        $now = Carbon::now();
        $lastLogin = Carbon::parse($lastLogin);
        $checkingTime = Carbon::parse($now);

        return $checkingTime->diffInDays($lastLogin);
    }

    public function _checkEmailVerification()
    {
        $user = Auth::user();
        if ($user && $user->evs == 2)
        {
            return true;
        }

        $mailService = app(MailService::class);
        $userName = $user->fname . ' ' . $user->lname;
        $userEmail = $user->email;
        $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Trade By Trade');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $mailService->send('email.verifyemail', $data, $userEmail, $userName, $subject);

        return false;
    }

    public function _checkDeviceConfirmation()
    {
        $user = Auth::user();
        $confirmDeviceService = app(ConfirmDeviceService::class);
        $confirmedDevice = $confirmDeviceService->getConfirmedDevice();

        if(!$confirmedDevice)
        {
            // create device confirmation
            $confirmedDevice = $confirmDeviceService->createDevice(1, $user->id);
        }

        if($confirmedDevice && $confirmedDevice->is_confirmed != 2)
        {
            //send device confirmation email
            $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Trade By Trade');
            $userName = $user->fname . ' ' . $user->lname;
            $userEmail = $user->email;
            $subject = __('Device Confirmation | :companyName', ['companyName' => $companyName]);
            $data = [
                'data' => $user,
                'confdev' => $confirmedDevice,
            ];
            $mailService = app(MailService::class);
            $mailService->send('email.confdevmail', $data, $userEmail, $userName, $subject);

            return [
                'status' => false,
                'message' => ''
            ];
        }

        // get confirm device
        app(WebSessionService::class)->createWebSession($confirmedDevice->id,$user->id);
        app(ActivitiesRepository::class)->create($user->id, 'Sign In');
    }

    public function _twoStepVerification()
    {
        $user = Auth::user();
        if (
            $user->role == 2 &&
            $user->mvs == 2 &&
            !empty($user->phone) &&
            isset($user->usersetting->phn_check) &&
            $user->usersetting->phn_check == 2
        )
        {
            // random number reserve session
            $randomNumber = randomNumber(6);
            // reserving new code
            session()->put('randno',$randomNumber);
            // sent message to the number with session
            app(SmsService::class)->send($user->phone,$randomNumber);
            return true;
        }
        return false;
    }

    public function sendForgotPasswordMail($request)
    {
        try {
            $user = User::where(['email' => $request->email])->first();

            if ($user) {
                // send verifyemail
                $userName = $user->name;
                $userEmail = $request->email;
                $subject = __('Forget Password');
                $defaultmail = allSetting()['primary_email'];
                $defaultname = allSetting()['app_title'];
                $sentmail = Mail::send('email.forgetpass', ['data' => $user],
                    function ($message) use ($userName, $userEmail, $subject, $defaultmail, $defaultname) {
                        $message->to($userEmail, $userName)->subject($subject)->replyTo(
                            $defaultmail, $defaultname
                        );
                    }
                );
                return [
                    'success' => true,
                    'role' => $user->role,
                    'message' => __('Mail sent successfully')
                ];
            } else {
                return [
                    'success' => false,
                    'message' => __('Your email is not correct !!!')
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
        }
    }

    public function forgetPasswordChangeProcess($request, $reset_code)
    {
        try {
            $user = User::where(['reset_code' => $reset_code])->first();
            if ($user) {
                $update_password['reset_code'] = md5($user->email . uniqid() . randomString(5));
                $update_password['password'] = Hash::make($request->password);

                $updated = User::where(['id' => $user->id, 'reset_code' => $user->reset_code])->update($update_password);

                if ($updated) {
                    return [
                        'success' => true,
                        'role' => $user->role,
                        'message' => __('Password changed successfully')
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => __('Password not changed try again')
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => __('Password not changed try again')
                ];
            }
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
        $companyName = isset(allSetting()['app_title']) && !empty(allSetting()['app_title']) ? allSetting()['app_title'] : __('Company Name');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    public function mailVarification($id,$code)
    {
        try {
            $uvc = UserVerificationCode::where(['user_id' => $id,'code' => $code, 'status' => STATUS_PENDING, 'type' => 1])
                ->where('expired_at', '>=', date('Y-m-d'))->first();
            if ($uvc) {
                UserVerificationCode::where(['id' => $uvc->id])->update(['status' => STATUS_SUCCESS]);
                User::where(['id' => $uvc->user_id])->update(['email_verified' => STATUS_SUCCESS]);

                return [
                    'success' => true,
                    'message' => __('Email verification successful.')
                ];
            } else {
                return [
                    'success' => false,
                    'message' => __('Verification code expired or not found!')
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
        }
    }

    public function resetForgotPassword($request)
    {
        $vf_code = UserVerificationCode::where(['type' => 1, 'code' => $request->access_code,'status' => STATUS_PENDING])->first();

        if (isset($vf_code)) {
            User::where(['id' => $vf_code->user_id])->update(['password' => bcrypt($request->password)]);
            UserVerificationCode::where(['id' => $vf_code->id])->update(['status' => STATUS_SUCCESS]);
            $data['success'] = true;
            $data['message'] = __('Password reset successfully');
        } else {
            $data['success'] = false;
            $data['message'] = __('Reset code not valid.');
        }

        return $data;
    }

    // user registration
    public function userRegistration($request, $mailTemplet)
    {
        $randno = randomNumber(6);
        try {
            DB::transaction(function () use ($request, $mailTemplet, $randno) {
                $user = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => isset($request->role) ? $request->role : USER_ROLE_USER,
                    'active_status' => STATUS_SUCCESS,
                    'email_verified' => STATUS_PENDING,
                    'reset_code' => md5($request->get('email') . uniqid() . randomString(5)),
                    'language' => 'en'
                ]);
                if ($user) {
                    UserVerificationCode::create(
                        ['user_id' => $user->id,
                            'type' => 1,
                            'code' => $randno,
                            'expired_at' => date('Y-m-d', strtotime('+10 days')),
                            'status' => STATUS_PENDING]
                    );

                    $this->sendVerificationMail($user, $mailTemplet, $randno);
                }
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

}