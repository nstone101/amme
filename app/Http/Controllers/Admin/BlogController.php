<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Http\Requests\Admin\BlogRequest;
use App\Model\Blog;
use App\Model\BlogCategory;
use App\Model\BlogComment;
use App\Repository\BlogRepository;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /*
    *
    * blog list
    * Show the list of specified resource.
    * @return \Illuminate\Http\Response
    *
    */
    public function blogList(Request $request)
    {
        $data['pageTitle'] = __('Blog List');
        $data['menu'] = 'blog';
        if ($request->ajax()) {
            $items = Blog::select('*');
            return datatables($items)
                ->addColumn('title', function ($item) {
                    return str_limit($item->title,12);
                })
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->addColumn('user_id', function ($item) {
                    return $item->user->name;
                })
                ->addColumn('comments',function($item){
                    return  '<a href="'.route('commentList',encrypt($item->id)).'">'.Blog::get_comment_count($item->id).'</a>';
                })
                ->addColumn('category_id', function ($item) {
                    return $item->category->title;
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
                    $html .= edit_html('blogEdit', $item->id);
                    $html .= delete_html('blogDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'image', 'comments'])
                ->make(true);
        }

        return view('admin.blog.list', $data);
    }


    /*
     *
     * blogCategoryList
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function blogCategoryList(Request $request)
    {
        $data['pageTitle'] = __('Blog Category List');
        $data['menu'] = 'blog';
        if ($request->ajax()) {
            $items = BlogCategory::select('*');
            return datatables($items)
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->addColumn('posts',function($item){
                    return BlogCategory::get_post_count($item->id);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= edit_html('blogCategoryEdit', $item->id);
                    $html .= delete_html('blogCategoryDelete', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.blog.category.list', $data);
    }

    /*
     *
     * commentList
     * Show the list of specified resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function commentList(Request $request, $id)
    {
        $data['pageTitle'] = __('Comment List');
        $data['menu'] = 'blog';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Comment not found.')]);
        }
        $data['id'] = $id;
        if ($request->ajax()) {
            $items = BlogComment::where('blog_id',$id);
            return datatables($items)
                ->addColumn('status', function ($item) {
                    return comment_status($item->status);
                })
                ->addColumn('post', function ($item) {
                    return str_limit($item->blog->title,15);
                })
                ->addColumn('comment', function ($item) {
                    return str_limit($item->comment,15);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('actions', function ($item) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= view_html('commentDetails', $item->id);
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        }
        return view('admin.blog.comment.list', $data);
    }

    /*
     * blogCategoryCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function blogCategoryCreate()
    {
        $data['pageTitle'] = __('Add Blog Category');
        $data['menu'] = 'blog';

        return view('admin.blog.category.add', $data);
    }

    /**
     * blogCategoryEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function blogCategoryEdit($id)
    {
        $data['pageTitle'] = __('Update Blog Category');
        $data['menu'] = 'blog';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Category not found.')]);
        }
        $data['item'] = BlogCategory::where('id',$id)->first();

        return view('admin.blog.category.add', $data);
    }
    /**
     * commentDetails
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function commentDetails($id)
    {
        $data['pageTitle'] = __('Comment Details');
        $data['menu'] = 'blog';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Comment not found.')]);
        }
        $data['item'] = BlogComment::where('id',$id)->first();

        return view('admin.blog.comment.details', $data);
    }

    /**
     * blogCategorySave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function blogCategorySave(BlogCategoryRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(BlogRepository::class)->blogCategorySaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('blogCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * blogCategoryDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function blogCategoryDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(BlogRepository::class)->deleteBlogCategory($id);
            if ($response['success'] == true) {
                return redirect()->route('blogCategoryList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }


    /*
     * blogCreate
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function blogCreate()
    {
        $data['pageTitle'] = __('Add New Post');
        $data['menu'] = 'blog';
        $data['categories'] = BlogCategory::where('status', STATUS_ACTIVE)->get();

        return view('admin.blog.add', $data);
    }

    /**
     * blogEdit
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function blogEdit($id)
    {
        $data['pageTitle'] = __('Update Post');
        $data['menu'] = 'blog';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['categories'] = BlogCategory::where('status', STATUS_ACTIVE)->get();
        $data['item'] = Blog::where('id',$id)->first();

        return view('admin.blog.add', $data);
    }

    /**
     * blogSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function blogSave(BlogRequest $request)
    {
        if ($request->isMethod('post')) {
            $response = app(BlogRepository::class)->blogSaveProcess($request);
            if ($response['success'] == true) {
                return redirect()->route('blogList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * blogDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function blogDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            $response = app(BlogRepository::class)->deleteBlog($id);
            if ($response['success'] == true) {
                return redirect()->route('blogList')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    // approve comment

    public function commentApprove(Request $request)
    {
        if (!empty($request->active_id) && is_numeric($request->active_id)) {
            $item = BlogComment::findOrFail($request->active_id);
            if ($item->status == 1) {
                $item->status = 0;
            } elseif ($item->status == 0) {
                $item->status = 1;
            }
            $item->save();
        }
        if ($request->ajax()) {
            return response()->json(['message'=>__('Status changed successfully')]);
        } else {
            if ($item->status == STATUS_ACTIVE) {
                return redirect()->back()->with('success',__('Comment approved successfully'));
            } else {
                return redirect()->back()->with('success',__('Comment rejected successfully'));
            }
        }
    }
}
