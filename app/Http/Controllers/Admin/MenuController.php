<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MenuRequest;
use App\Model\Menu;
use App\Services\CommonService;
use App\Services\SettingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /*
   *
   * menu list
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function menuList(Request $request)
    {
        $data['pageTitle'] = __('Frontend Menu List');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'menu';
        if ($request->ajax()) {
            $items = Menu::select('*');
            return datatables($items)
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<input type="hidden" value="'.$item->id.'" class="shortable_data">';
                    $html .= '<ul class="d-flex activity-menu">';
                    $html .= edit_html('menuEdit', $item->id);
                    $html .= delete_html('menuDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.setting.menu.list', $data);
    }
    /*
     * menuCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function menuCreate()
    {
        $data['pageTitle'] = __('Add New Frontend Menu');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'menu';

        return view('admin.setting.menu.add', $data);
    }

    /**
     * menuEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function menuEdit($id)
    {
        $data['pageTitle'] = __('Update Menu');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'menu';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['item'] = Menu::where('id',$id)->first();

        return view('admin.setting.menu.add', $data);
    }

    /**
     * menuSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function menuSave(MenuRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(SettingService::class)->menuSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('menuList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * menuDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function menuDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(SettingService::class)->deleteMenu($id);
            if ($response['success'] == true) {
                return redirect()->route('menuList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    // change menu order
    public function customMenuOrder(Request $request)
    {
        $vals = explode(',',$request->vals);
        foreach ($vals as $key => $item){
            Menu::where('id',$item)->update(['data_order'=>$key]);
        }

        return response()->json(['message'=>__('Menu order changed successfully')]);
    }

}
