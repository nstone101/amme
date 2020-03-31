<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserSaveRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Repository\UserRepository;
use App\Services\CommonService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /*
     *
     * user list
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function userList(Request $request)
    {
        $data['pageTitle'] = __('User List');
        $data['menu'] = 'userlist';
        if ($request->ajax()) {
            $user = User::where('id','<>', Auth::user()->id);
            return datatables($user)
                ->addColumn('active_status', function ($item) {
                    return statusAction($item->active_status);
                })
                ->addColumn('role', function ($item) {
                    return userRole($item->role);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= edit_html('editUser', $item->id);
                    $html .= view_html('userDetails', $item->id);
                    if ($item->active_status != STATUS_DELETED){
                        $html .= delete_html('userDelete', $item->id);
                    }
                    if ($item->active_status != STATUS_ACTIVE){
                        $html .= activate_html('userActivate', $item->id);
                    }
                    if ($item->email_verified != STATUS_ACTIVE){
                        $html .= email_verify_html('userEmailVerify', $item->id);
                    }
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.user.list', $data);
    }

    /*
     * userAdd
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function addUser()
    {
        $data['pageTitle'] = __('Add User');
        $data['menu'] = 'userlist';

        return view('admin.user.add-edit', $data);
    }

    /**
     * userEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editUser($id)
    {
        $data['pageTitle'] = __('Update User');
        $data['menu'] = 'userlist';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('User not found.')]);
        }
        $data['user'] = User::where('id',$id)->first();

        return view('admin.user.add-edit', $data);
    }

    /**
     * userAddProcess
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function userAddProcess(UserSaveRequest $request)
    {
        if ($request->isMethod('post')) {
            $mail_key = $this->generate_email_verification_key();
            $mailTemplet = 'email.verify';

            $response = app(CommonService::class)->userRegistration($request, $mailTemplet, $mail_key);
            if (isset($response['success']) && $response['success']) {
                return redirect()->route('userList')->with('success', __('New user created successfully'));
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * userActivate
     *
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function userActivate($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('User not found.')]);
            }
            $user = User::where(['id' => $id])->update(['active_status' => STATUS_ACTIVE]);
            if (isset($user)) {
                return redirect()->back()->with(['success' => __('User has been activated successfully!')]);
            } else {
                return redirect()->back()->with(['dismiss' => __('Something went wrong. Please try again later!')]);
            }
        }
        return redirect()->back();
    }

    /**
     * userDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function userDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('User not found.')]);
            }
            $user = User::where(['id' => $id])->update(['active_status' => STATUS_DELETED]);
            if (isset($user)) {
                return redirect()->back()->with(['success' => __('User has been deleted successfully!')]);
            } else {
                return redirect()->back()->with(['dismiss' => __('Something went wrong. Please try again later!')]);
            }
        }
        return redirect()->back();
    }

    /**
     * userEmailVerify
     *
     * verify email the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function userEmailVerify($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('User not found.')]);
            }
            $user = User::where(['id' => $id])->update(['email_verified' => STATUS_ACTIVE]);
            if (isset($user)) {
                return redirect()->back()->with(['success' => __('Email verified successfully!')]);
            } else {
                return redirect()->back()->with(['dismiss' => __('Something went wrong. Please try again later!')]);
            }
        }
        return redirect()->back();
    }

    public function userUpdateProcess(UserUpdateRequest $request)
    {
        if($request->edit_id) {
            $id = $request->edit_id;
            $userRepository = app(UserRepository::class);
            $response = $userRepository->profileUpdate($request->all(),$id);
            if ($response['status'] == false) {
                return redirect()->back()->withInput()->with('dismiss', $response['message']);
            } else {
                return redirect()->route('userList')->with('success', __('User updated successfully'));
            }
        } else {
            return redirect()->back()->with(['dismiss' => __('User not found')]);
        }
    }

    public function userDetails($id)
    {
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('User not found.')]);
        }
        $data['pageTitle'] = __('User details');
        $data['menu'] = 'userlist';
        $data['user'] = User::where('id', $id)->first();

        return view('admin.user.user-profile', $data);
    }

    /*
     * generate_email_verification_key
     *
     * Generate email verification key
     *
     *
     *
     */

    private function generate_email_verification_key()
    {
        do {
            $key = Str::random(60);
        } While (User::where('email_verified', $key)->count() > 0);

        return $key;
    }

}
