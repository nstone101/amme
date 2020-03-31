<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TeamCategoryRequest;
use App\Http\Requests\Admin\TeamRequest;
use App\Model\Category;
use App\Model\Team;
use App\Repository\TeamRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /*
     *
     * team list
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function teamList(Request $request)
    {
        $data['pageTitle'] = __('Team Member List');
        $data['menu'] = 'teamList';
        if ($request->ajax()) {
            $items = Team::select('*');
            return datatables($items)
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->addColumn('category_id', function ($item) {
                    return $item->category->name;
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
                    $html .= edit_html('teamEdit', $item->id);
                    $html .= delete_html('teamDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }

        return view('admin.team.list', $data);
    }


    /*
     *
     * teamCategoryList
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function teamCategoryList(Request $request)
    {
        $data['pageTitle'] = __('Team Category List');
        $data['menu'] = 'teamList';
        if ($request->ajax()) {
            $items = Category::select('*');
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
                    $html .= edit_html('teamCategoryEdit', $item->id);
                    $html .= delete_html('teamCategoryDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        return view('admin.team.category.list', $data);
    }

    /*
     * teamCategoryCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function teamCategoryCreate()
    {
        $data['pageTitle'] = __('Add Team Category');
        $data['menu'] = 'teamList';

        return view('admin.team.category.add', $data);
    }

    /**
     * teamCategoryEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function teamCategoryEdit($id)
    {
        $data['pageTitle'] = __('Update Team Category');
        $data['menu'] = 'teamList';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Category not found.')]);
        }
        $data['item'] = Category::where('id',$id)->first();

        return view('admin.team.category.add', $data);
    }

    /**
     * teamCategorySave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function teamCategorySave(TeamCategoryRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(TeamRepository::class)->teamCategorySaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('teamCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * teamCategoryDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function teamCategoryDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(TeamRepository::class)->deleteTeamCategory($id);
            if ($response['success'] == true) {
                return redirect()->route('teamCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }


    /*
     * teamCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function teamCreate()
    {
        $data['pageTitle'] = __('Add Team Member');
        $data['menu'] = 'teamList';
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->get();

        return view('admin.team.add', $data);
    }

    /**
     * teamEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function teamEdit($id)
    {
        $data['pageTitle'] = __('Update Team Member');
        $data['menu'] = 'teamList';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->get();
        $data['item'] = Team::where('id',$id)->first();

        return view('admin.team.add', $data);
    }

    /**
     * teamSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function teamSave(TeamRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(TeamRepository::class)->teamSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('teamList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * teamDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function teamDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(TeamRepository::class)->deleteTeam($id);
            if ($response['success'] == true) {
                return redirect()->route('teamList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }
}
