<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PlanRequest;
use App\Model\PricingFeature;
use App\Model\PricingPlan;
use App\Repository\PlanRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /*
    *
    * plan list
    * Show the list of specified resource.
    * @return \Illuminate\Http\Response
    *
    */
    public function planList(Request $request)
    {
        $data['pageTitle'] = __('Pricing List');
        $data['menu'] = 'plan';
        if ($request->ajax()) {
            $items = PricingPlan::select('*');
            return datatables($items)
                ->addColumn('duration', function ($item) {
                    return plan_duration($item->duration);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= edit_html('planEdit', $item->id);
                    $html .= delete_html('planDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->addColumn('price', function ($item) {
                    $html = $item->price;
                    $html .= ' $';
                    return $html;
                })
                ->rawColumns(['actions', 'price'])
                ->make(true);
        }

        return view('admin.plan.list', $data);
    }

    /*
     * planCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function planCreate()
    {
        $data['pageTitle'] = __('Add New Pricing Plan');
        $data['menu'] = 'plan';

        return view('admin.plan.add', $data);
    }

    /**
     * planEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function planEdit($id)
    {
        $data['pageTitle'] = __('Update Pricing Plan');
        $data['menu'] = 'plan';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['item'] = PricingPlan::where('id',$id)->first();
        $data['plan_features'] = PricingFeature::where('plan_id',$id)->get();

        return view('admin.plan.add', $data);
    }

    /**
     * planSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function planSave(PlanRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(PlanRepository::class)->planSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('planList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * planDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function planDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(PlanRepository::class)->deletePricingPlan($id);
            if ($response['success'] == true) {
                return redirect()->route('planList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }
}
