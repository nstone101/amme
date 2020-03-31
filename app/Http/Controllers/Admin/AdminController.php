<?php

namespace App\Http\Controllers\Admin;

use App\Model\Blog;
use App\Model\Contact;
use App\Model\Portfolio;
use App\Model\PricingPlan;
use App\Model\Service;
use App\Model\Subscriber;
use App\Model\Team;
use App\Services\CommonService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /*
     * adminDashboardView
     *
     * Basic view of admin dashboard
     *
     *
     *
     *
     */
    public function adminDashboard()
    {
        $data['pageTitle'] = __('Admin|Dashboard');
        $data['menu'] = 'dashboard';
        $data['totalUser'] = User::where(['active_status'=> STATUS_ACTIVE, 'role' => USER_ROLE_USER])->count();
        $data['totalProject'] = Portfolio::where(['status'=> STATUS_ACTIVE])->count();
        $data['teams'] = Team::where(['status'=> STATUS_ACTIVE])->count();
        $data['posts'] = Blog::where(['status'=> STATUS_ACTIVE])->count();
        $data['services'] = Service::where(['status'=> STATUS_ACTIVE])->count();
        $data['plans'] = PricingPlan::where(['status'=> STATUS_ACTIVE])->count();

        $monthlyPosts = Blog::select(DB::raw('Count(id) as totalCount'), DB::raw('MONTH(created_at) as months'))
            ->where('status', STATUS_ACTIVE)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('months')
            ->get();
        $all_month = all_months();
        if (isset($monthlyPosts[0])) {
            foreach ($monthlyPosts as $mPosts) {
                $data['post'][$mPosts->months] = $mPosts->totalCount;
            }
        }
        $allPosts= [];
        foreach ($all_month as $month) {
            $allPosts[] =  isset($data['post'][$month]) ? $data['post'][$month] : 0;
        }
        $data['all_posts'] = $allPosts;

        $data['blogs'] = Blog::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->limit(4)->get();
        $data['view_posts'] = Blog::join('user_blogs', 'user_blogs.blog_id', '=', 'blogs.id')
            ->where(['blogs.status'=> STATUS_ACTIVE])
            ->select('blogs.*', DB::raw("count(user_blogs.blog_id) as count"))
            ->groupBy('user_blogs.blog_id')
            ->limit(4)->get();
        $data['portfolios'] = Portfolio::where(['status'=> STATUS_ACTIVE])->limit(4)->get();

        return view('admin.dashboard.dashboard', $data);
    }

    /*
   *
   * contact list
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function contactList(Request $request)
    {
        $data['pageTitle'] = __('Contact List');
        $data['menu'] = 'contact';
        if ($request->ajax()) {
            $items = Contact::select('*');
            return datatables($items)
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('subject', function ($item) {
                    return str_limit($item->subject,15);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= view_html('contactDetails', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.contact.list', $data);
    }
    /*
   *
   * subscriberList list
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function subscriberList(Request $request)
    {
        $data['pageTitle'] = __('Subscriber List');
        $data['menu'] = 'subscriber';
        if ($request->ajax()) {
            $items = Subscriber::select('*');
            return datatables($items)
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->make(true);
        }

        return view('admin.contact.subscriber_list', $data);
    }

    /**
     * contactDetails
     *
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function contactDetails($id)
    {
        $data['pageTitle'] = __('Contact Details');
        $data['menu'] = 'contact';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['item'] = Contact::where('id',$id)->first();

        return view('admin.contact.details', $data);
    }

    /*
   *
   * testimonial list
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function testimonialList(Request $request)
    {
        $data['pageTitle'] = __('Testimonial List');
        $data['menu'] = 'testimonial';
        if ($request->ajax()) {
            $items = Contact::select('*');
            return datatables($items)
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= view_html('contactDetails', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->addColumn('user_id', function ($item) {
                    return $item->user->name;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.contact.list', $data);
    }

    /**
     * testimonialDetails
     *
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function testimonialDetails($id)
    {
        $data['pageTitle'] = __('Contact Details');
        $data['menu'] = 'testimonial';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['item'] = Contact::where('id',$id)->first();

        return view('admin.contact.details', $data);
    }
}
