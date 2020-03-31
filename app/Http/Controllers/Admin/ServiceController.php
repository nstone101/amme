<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ServiceRequest;
use App\Model\Service;
use App\Repository\ServiceRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{

    /*
    *
    * serviceList
    * Show the list of specified resource.
    * @return \Illuminate\Http\Response
    *
    */

    public function serviceList(Request $request)
    {
        $data['pageTitle'] = __('Service List');
        $data['menu'] = 'service';
        if ($request->ajax()) {
            $items = Service::select('*');
            return datatables($items)
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->addColumn('image', function ($item) {
                    if($item->image) {
                        return '<img class="lists-img" src="' . $item->image . '">';
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= edit_html('serviceEdit', $item->id);
                    $html .= delete_html('serviceDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        return view('admin.service.list', $data);
    }

    /*
     * serviceCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function serviceCreate()
    {
        $data['pageTitle'] = __('Add New Service');
        $data['menu'] = 'service';

        return view('admin.service.add', $data);
    }

    /**
     * serviceEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function serviceEdit($id)
    {
        $data['pageTitle'] = __('Update Service');
        $data['menu'] = 'service';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Item not found.')]);
        }
        $data['item'] = Service::where('id',$id)->first();

        return view('admin.service.add', $data);
    }

    /**
     * serviceSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function serviceSave(ServiceRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(ServiceRepository::class)->serviceSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('serviceList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * serviceDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function serviceDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(ServiceRepository::class)->deleteService($id);
            if ($response['success'] == true) {
                return redirect()->route('serviceList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }
}
