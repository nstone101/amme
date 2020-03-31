<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\GalleryCategoryRequest;
use App\Http\Requests\Admin\GalleryRequest;
use App\Model\Gallery;
use App\Model\GalleryCategory;
use App\Repository\GalleryRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    /*
    *
    * gallery List
    * Show the list of specified resource.
    * @return \Illuminate\Http\Response
    *
    */
    public function galleryList(Request $request)
    {
        $data['pageTitle'] = __('Gallery Image List');
        $data['menu'] = 'gallery';
        if ($request->ajax()) {
            $items = Gallery::select('*');
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
                    $html .= edit_html('galleryEdit', $item->id);
                    $html .= delete_html('galleryDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }

        return view('admin.gallery.list', $data);
    }


    /*
     *
     * galleryCategoryList
     *
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function galleryCategoryList(Request $request)
    {
        $data['pageTitle'] = __('Image Category List');
        $data['menu'] = 'gallery';
        if ($request->ajax()) {
            $items = GalleryCategory::select('*');
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
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= edit_html('galleryCategoryEdit', $item->id);
                    $html .= delete_html('galleryCategoryDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.gallery.category.list', $data);
    }

    /*
     * galleryCategoryCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function galleryCategoryCreate()
    {
        $data['pageTitle'] = __('Add Image Category');
        $data['menu'] = 'gallery';

        return view('admin.gallery.category.add', $data);
    }

    /**
     * galleryCategoryEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function galleryCategoryEdit($id)
    {
        $data['pageTitle'] = __('Update Image Category');
        $data['menu'] = 'gallery';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Category not found.')]);
        }
        $data['item'] = GalleryCategory::where('id',$id)->first();

        return view('admin.gallery.category.add', $data);
    }

    /**
     * galleryCategorySave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function galleryCategorySave(GalleryCategoryRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(GalleryRepository::class)->galleryCategorySaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('galleryCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * gallery Category Delete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function galleryCategoryDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(GalleryRepository::class)->deleteGalleryCategory($id);
            if ($response['success'] == true) {
                return redirect()->route('galleryCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }


    /*
     * galleryCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function galleryCreate()
    {
        $data['pageTitle'] = __('Add New Image');
        $data['menu'] = 'gallery';
        $data['categories'] = GalleryCategory::where('status', STATUS_ACTIVE)->get();

        return view('admin.gallery.add', $data);
    }

    /**
     * galleryEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function galleryEdit($id)
    {
        $data['pageTitle'] = __('Update Image');
        $data['menu'] = 'gallery';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['categories'] = GalleryCategory::where('status', STATUS_ACTIVE)->get();
        $data['item'] = Gallery::where('id',$id)->first();

        return view('admin.gallery.add', $data);
    }

    /**
     * gallerySave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function gallerySave(GalleryRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(GalleryRepository::class)->gallerySaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('galleryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * galleryDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function galleryDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(GalleryRepository::class)->deleteGalleryImage($id);
            if ($response['success'] == true) {
                return redirect()->route('galleryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }
}
