<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PortfolioCategoryRequest;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Model\Portfolio;
use App\Model\PortfolioCategory;
use App\Repository\PortfolioRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    /*
    *
    * portfolio list
    * Show the list of specified resource.
    * @return \Illuminate\Http\Response
    *
    */
    public function portfolioList(Request $request)
    {
        $data['pageTitle'] = __('Portfolio List');
        $data['menu'] = 'portfolio';
        if ($request->ajax()) {
            $items = Portfolio::select('*');
            return datatables($items)
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->addColumn('category_id', function ($item) {
                    return $item->category->name;
                })
                ->addColumn('image', function ($item) {
                    if($item->image) {
                        return '<img class="lists-img" src="' . $item->image[0] . '">';
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
                    $html .= edit_html('portfolioEdit', $item->id);
                    $html .= delete_html('portfolioDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }

        return view('admin.portfolio.list', $data);
    }


    /*
     *
     * portfolioCategoryList
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function portfolioCategoryList(Request $request)
    {
        $data['pageTitle'] = __('Portfolio Category List');
        $data['menu'] = 'portfolio';
        if ($request->ajax()) {
            $items = PortfolioCategory::select('*');
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
                    $html .= edit_html('portfolioCategoryEdit', $item->id);
                    $html .= delete_html('portfolioCategoryDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        return view('admin.portfolio.category.list', $data);
    }

    /*
     * portfolioCategoryCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function portfolioCategoryCreate()
    {
        $data['pageTitle'] = __('Add Portfolio Category');
        $data['menu'] = 'portfolio';

        return view('admin.portfolio.category.add', $data);
    }

    /**
     * portfolioCategoryEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function portfolioCategoryEdit($id)
    {
        $data['pageTitle'] = __('Update Portfolio Category');
        $data['menu'] = 'portfolio';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Category not found.')]);
        }
        $data['item'] = PortfolioCategory::where('id',$id)->first();

        return view('admin.portfolio.category.add', $data);
    }

    /**
     * portfolioCategorySave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function portfolioCategorySave(PortfolioCategoryRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(PortfolioRepository::class)->portfolioCategorySaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('portfolioCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * portfolioCategoryDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function portfolioCategoryDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(PortfolioRepository::class)->deletePortfolioCategory($id);
            if ($response['success'] == true) {
                return redirect()->route('portfolioCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }


    /*
     * portfolioCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function portfolioCreate()
    {
        $data['pageTitle'] = __('Add New Portfolio');
        $data['menu'] = 'portfolio';
        $data['categories'] = PortfolioCategory::where('status', STATUS_ACTIVE)->get();

        return view('admin.portfolio.add', $data);
    }

    /**
     * portfolioEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function portfolioEdit($id)
    {
        $data['pageTitle'] = __('Update Portfolio');
        $data['menu'] = 'portfolio';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['categories'] = PortfolioCategory::where('status', STATUS_ACTIVE)->get();
        $data['item'] = Portfolio::where('id',$id)->first();

        return view('admin.portfolio.add', $data);
    }

    /**
     * portfolioSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function portfolioSave(PortfolioRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(PortfolioRepository::class)->portfolioSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('portfolioList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back()->with('dismiss',__('Something went wrong.'));
    }

    /**
     * portfolioDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function portfolioDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(PortfolioRepository::class)->deletePortfolio($id);
            if ($response['success'] == true) {
                return redirect()->route('portfolioList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }


    // delete portfolio single image

    public function deleteUploadedImage(Request $request) {
        $item = Portfolio::where('id', $request->id)->first();
        $images = $item->getOriginal('image');

        $data['updateData'] =str_replace('|'.$request->src.'|','|',$images);
        $item->update(['image' => $data['updateData']]);
        removeImage(path_image(),$request->src);

        return response()->json(['data' => $data]);
    }
}
