<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ForgotPasswordResetRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Services\AuthService;
use App\Model\UserVerificationCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login view
    public function login()
    {
        if (Auth::user()) {
            return redirect()->route('adminDashboard');
        } else {
            return view('auth.signin');
        }

    }

    // Login post
    public function postLogin(UserLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (auth::user()->active_status == STATUS_SUCCESS) {
                if (auth::user()->email_verified == STATUS_PENDING) {
                    $mailTemplet = 'email.verify';
                    $mail_key = randomNumber(6);
                    UserVerificationCode::where(['user_id' => Auth::user()->id])->update(['status' => STATUS_SUCCESS]);
                    UserVerificationCode::create(['user_id' => Auth::user()->id, 'type' => 1, 'code' => $mail_key, 'expired_at' => date('Y-m-d', strtotime('+10 days'))]);
                    $response = app(AuthService::class)->sendVerificationMail(Auth::user(), $mailTemplet, $mail_key);
                    Auth::logout();
                    return redirect()->route('login')->with(['dismiss' => __('Your email is not verified Yet. A verification link has been send to your email. Click on the verification link to verify your email.')]);
                }
                if (auth::user()->role == USER_ROLE_USER) {
                    Auth::logout();
                    return redirect()->route('login')->with('dismiss', __('You are not authorized.'));
                }

                return redirect()->route('adminDashboard');

            } elseif (auth::user()->active_status == STATUS_SUSPENDED) {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' => __('Your account has been suspended. please contact support team to active again.')]);
            } elseif (auth::user()->active_status == STATUS_DELETED) {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' => __('Your account has been deleted. please contact support team to active again.')]);
            } elseif (auth::user()->active_status == STATUS_PENDING) {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' => __('Your account has been Pending for admin approval. please contact support team to active again.')]);
            } else {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' => __('Your account has some problem. please contact support team.')]);
            }
        } else {
            return redirect()->route('login')->with(['dismiss' => __('Email or password not matched')]);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }

    /*
     * forgetPassword
     *
     * Forget Password page
     *
     *
     *
     */

    public function forgetPassword()
    {
        $data['pageTitle'] = __('Forget Password');
        return view('auth.forget-pass', $data);
    }

    /*
     * forgetPasswordProcess
     *
     * Forget Password Process
     *
     *
     *
     */

    public function forgetPasswordProcess(ForgetPasswordRequest $request)
    {
        $response = app(AuthService::class)->sendForgotPasswordMail($request);
        if (isset($response)) {
            if (isset($response['success']) && ($response['success'] == true)) {
                if ($response['role'] == USER_ROLE_USER) {
                    $route = 'login';
                } else {
                    $route = 'login';
                }
                return redirect()->route($route)->with('success', $response['message']);
            } else {
                return redirect()->back()->with('dismiss', $response['message']);
            }
        } else {
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }

    }

    /*
     * forgetPasswordReset
     *
     * Password reset page
     *
     *
     *
     */

    public function forgetPasswordReset()
    {
        $data['pageTitle'] = __('Reset Password');
        return view('auth.forgetpassreset', $data);
    }

    /*
     * forgetPasswordChange
     *
     * Change the forgotten password
     *
     *
     *
     */

    public function forgetPasswordChange($reset_code)
    {
        $data['pageTitle'] = __('Reset Password');
        $data['reset_code'] = $reset_code;
        $user = User::where(['reset_code' => $reset_code])->first();
        if ($user) {
            if ($user->role == USER_ROLE_USER) {
                return view('auth.reset-pass', $data);
            } else {
                return view('auth.reset-pass', $data);
            }
        } else {
            return redirect()->route('login')->with(['dismiss' => __('Invalid request!')]);
        }
    }

    /*
     * forgetPasswordResetProcess
     *
     * Reset process of forgotten password
     *
     *
     *
     */

    public function forgetPasswordResetProcess(ForgotPasswordResetRequest $request, $reset_code)
    {
        if ($reset_code) {
            $response = app(AuthService::class)->forgetPasswordChangeProcess($request, $reset_code);
            if (isset($response['success']) && ($response['success'] == true)) {
                if ($response['role'] == USER_ROLE_USER) {
                    return redirect()->route('login')->with('success', $response['message']);
                } else {
                    return redirect()->route('login')->with('success', $response['message']);
                }
            } else {
                return redirect()->back()->with('dismiss', $response['message']);
            }
        } else {
            return redirect()->back()->with(['dismiss' => __('Code not found')]);
        }
    }

    /*
     * verifyEmail
     *
     * Verify email code
     *
     *
     *
     */

    public function verifyEmail($id,$code)
    {
        $user = User::where('id', $id)->first();
        if (isset($code) && isset($user)) {
            if ($user->role == USER_ROLE_USER) {
                $route = 'customerSignin';
            } else {
                $route = 'login';
            }
            $response = app(AuthService::class)->mailVarification($id,$code);

            if (isset($response)) {
                if (isset($response['success']) && ($response['success'] == true)) {
                    return redirect()->route($route)->with('success', $response['message']);
                } else {
                    return redirect()->route($route)->with('dismiss', $response['message']);
                }
            } else {
                return redirect()->route($route)->with('dismiss', __('Something went wrong'));
            }
        } else {
            return redirect()->route('login')->with(['dismiss' => __('Verification code not found!')]);
        }
    }

    // privacy and policy

    public function privacyPolicy()
    {
        $data['pageTitle'] = __('Privacy Policy');
        $data['adm_setting'] = allsetting();

        return view('privacy.privacy', $data);
    }
    // terms and conditions

    public function termsCondition()
    {
        $data['pageTitle'] = __('Terms & Conditions');
        $data['adm_setting'] = allsetting();

        return view('privacy.terms', $data);
    }
}
