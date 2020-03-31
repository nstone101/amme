<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TestimonialRequest;
use App\Model\Testimonial;
use App\Repository\TestimonialRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    /*
   *
   * testimonialList
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */

    public function testimonialList(Request $request)
    {
        $data['pageTitle'] = __('Testimonial List');
        $data['menu'] = 'testimonial';
        if ($request->ajax()) {
            $items = Testimonial::select('*');
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
                    $html .= edit_html('testimonialEdit', $item->id);
                    $html .= delete_html('testimonialDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        return view('admin.testimonial.list', $data);
    }

    /*
     * testimonialCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function testimonialCreate()
    {
        $data['pageTitle'] = __('Add New Testimonial');
        $data['menu'] = 'testimonial';

        return view('admin.testimonial.add', $data);
    }

    /**
     * testimonialEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function testimonialEdit($id)
    {
        $data['pageTitle'] = __('Update Testimonial');
        $data['menu'] = 'testimonial';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Item not found.')]);
        }
        $data['item'] = Testimonial::where('id',$id)->first();

        return view('admin.testimonial.add', $data);
    }

    /**
     * testimonialSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function testimonialSave(TestimonialRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(TestimonialRepository::class)->testimonialSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('testimonialList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * testimonialDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function testimonialDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(TestimonialRepository::class)->deleteTestimonial($id);
            if ($response['success'] == true) {
                return redirect()->route('testimonialList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }
}
