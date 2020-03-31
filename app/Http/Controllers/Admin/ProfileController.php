<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /*
     * userProfile
     *
     * User profile
     *
     *
     *
     *
     */

    public function userProfile()
    {
        $data['pageTitle'] = __('Profile');
        $data['menu'] = 'profile';
        $data['user'] = User::where('id', Auth::user()->id)->first();

        return view('admin.profile.profile', $data);
    }

    /*
     * passwordChange
     *
     * password change page
     *
     *
     *
     *
     */

    public function passwordChange()
    {
        $data['pageTitle'] = __('Change Password');
        $data['menu'] = 'profile';
        $data['user'] = User::where('id', Auth::user()->id)->first();

        return view('admin.profile.change-password', $data);
    }

    /*
     * updateProfile
     *
     * Profile Update process
     *
     *
     *
     *
     */

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $userRepository = app(UserRepository::class);
        $response = $userRepository->profileUpdate($request->all(),Auth::user()->id);
        if ($response['status'] == false) {
            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('success', $response['message']);
        }
    }

    /*
     * changePassword
     *
     * Password change process
     *
     *
     *
     *
     */

    public function changePassword(ChangePasswordRequest $request)
    {
        $userRepository = app(UserRepository::class);
        $response = $userRepository->passwordChange($request->all(), Auth::user()->id);

        if ($response['status'] == false) {
            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('success', $response['message']);
        }
    }
}
