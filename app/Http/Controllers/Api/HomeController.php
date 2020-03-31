<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CommentRequest;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Requests\Api\SubscriptionRequest;
use App\Model\Portfolio;
use App\Repository\BlogRepository;
use App\Repository\GalleryRepository;
use App\Repository\PortfolioRepository;
use App\Repository\ServiceRepository;
use App\Repository\TeamRepository;
use App\Services\CommonService;
use App\Services\HomeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //home page
    public function home()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(HomeService::class)->apiDashboardData();
        if ($response) {
            $data = $response;
        }
        return response()->json($data);
    }

    //header data
    public function header()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(HomeService::class)->apiHeaderData();
        if ($response) {
            $data = $response;
        }
        return response()->json($data);
    }
    //home page
    public function aboutUs()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(HomeService::class)->apiAboutData();
        if ($response) {
            $data = $response;
        }
        return response()->json($data);
    }

    // contact process
    public function contactProcess(ContactRequest $request)
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(HomeService::class)->contactProcess($request);
        if ($response) {
            $data = $response;
        }
        return response()->json($data);
    }

    // service page data
    public function service()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(ServiceRepository::class)->serviceList(TYPE_ALL);
        if ($response) {
            $data = $response;
        }
        $adm_setting = allSetting();
        $data['service_banner_title'] = isset($adm_setting['service_banner_title']) ? $adm_setting['service_banner_title'] : '';
        $data['service_banner_des'] = isset($adm_setting['service_banner_des']) ? $adm_setting['service_banner_des'] : '';
        $data['service_banner_image'] = isset($adm_setting['service_banner_image']) && (!empty($adm_setting['service_banner_image'])) ? asset(path_image().$adm_setting['service_banner_image']) : '';

        return response()->json($data);
    }

    // team page data
    public function teams()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(TeamRepository::class)->teamList();
        if ($response) {
            $data = $response;
        }
        $adm_setting = allSetting();
        $data['team_banner_title'] = isset($adm_setting['team_banner_title']) ? $adm_setting['team_banner_title'] : '';
        $data['team_banner_des'] = isset($adm_setting['team_banner_des']) ? $adm_setting['team_banner_des'] : '';
        $data['team_banner_image'] = isset($adm_setting['team_banner_image']) && (!empty($adm_setting['team_banner_image'])) ? asset(path_image().$adm_setting['team_banner_image']) : '';

        return response()->json($data);
    }

    // portfolio page data
    public function portfolio()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(PortfolioRepository::class)->portfolioList(TYPE_ALL);
        if ($response) {
            $data = $response;
        }
        $adm_setting = allSetting();
        $data['portfolio_banner_title'] = isset($adm_setting['portfolio_banner_title']) ? $adm_setting['portfolio_banner_title'] : '';
        $data['portfolio_banner_des'] = isset($adm_setting['portfolio_banner_des']) ? $adm_setting['portfolio_banner_des'] : '';
        $data['portfolio_banner_image'] = isset($adm_setting['portfolio_banner_image']) && (!empty($adm_setting['portfolio_banner_image'])) ? asset(path_image().$adm_setting['team_banner_image']) : '';
        $data['work_image'] = isset($adm_setting['work_image']) && (!empty($adm_setting['work_image'])) ? asset(path_image().$adm_setting['work_image']) : '';
        $data['work_header_title'] = isset($adm_setting['work_header_title']) ? $adm_setting['work_header_title'] : '';
        $data['work_title'] = isset($adm_setting['work_title']) ? $adm_setting['work_title'] : '';
        $data['work_sub_title'] = isset($adm_setting['work_sub_title']) ? $adm_setting['work_sub_title'] : '';
        $data['work_des'] = isset($adm_setting['work_des']) ? $adm_setting['work_des'] : '';

        return response()->json($data);
    }

    // single portfolio data
    public function portfolioSingle($id)
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            $data = ['success' => false,  'message' => __('Item not found')];
            response()->json($data);
        }
        $data['portfolio'] = (object)[];
        $portfolio = Portfolio::where(['id'=> $id, 'status' => STATUS_ACTIVE])->first();
        if (isset($portfolio)) {
            $data = [
                'success'=> true,
                'message' => __('Data get successfully'),
                'portfolio' => $portfolio
            ];
            $data['portfolio']->category_name = $portfolio->category->name;
        }

        return response()->json($data);
    }
    // gallery page data
    public function gallery()
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(GalleryRepository::class)->galleryList();
        if ($response) {
            $data = $response;
        }

        return response()->json($data);
    }

    // blog page data
    public function blogs(Request $request)
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(BlogRepository::class)->blogList($request);
        if ($response) {
            $data = $response;
        }

        return response()->json($data);
    }

    // single blog

    public function singleBlog(Request $request, $id)
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(BlogRepository::class)->blogDetails($request,$id);
        if ($response) {
            $data = $response;
        }

        return response()->json($data);
    }

    // subscriber process
    public function subscriptionProcess(SubscriptionRequest $request)
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(HomeService::class)->subscriberProcess($request);
        if ($response) {
            $data = $response;
        }
        return response()->json($data);
    }
    // save blog commengt process
    public function saveBlogComment(CommentRequest $request)
    {
        $data = ['success' => false,  'message' => __('Invalid request')];
        $response = app(BlogRepository::class)->commentSaveProcess($request);
        if ($response) {
            $data = $response;
        }
        return response()->json($data);
    }
}
