<?php
namespace App\Repository;
use App\Model\Category;
use App\Model\Gallery;
use App\Model\GalleryCategory;
use App\Model\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GalleryRepository
{
// gallery category save process
    public function galleryCategorySaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ];

            if(!empty($request->edit_id)) {
                    $update = GalleryCategory::where(['id' => $request->edit_id])->update($data);
                    if ($update) {
                        $response = [
                            'success' => true,
                            'message' => __('Category updated successfully')
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => __('Failed to update')
                        ];
                    }
            } else {
                $saveData= GalleryCategory::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('Category created successfully.')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to save')
                    ];
                }
            }

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
//                'message' => __('Something Went wrong !')
            ];
            return $response;
        }

        return $response;
    }

    // delete gallery category
    public function deleteGalleryCategory($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = GalleryCategory::where('id',$id)->first();
            if (isset($item)) {
                $team = Gallery::where('category_id', $id)->get();
                if(isset($team[0])) {
                    $response = [
                        'success' => false,
                        'message' => __('This item has used at gallery, You can not delete this.')
                    ];
                    return $response;
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Category deleted successfully.')
                    ];
                } else {
                    DB::rollBack();
                    $response = [
                        'success' => false,
                        'message' => __('Operation failed.')
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Item not found.')
                ];
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }


// gallery  save process
    public function gallerySaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'status' => $request->status,
            ];
            if (isset($request->edit_id)) {
                $item = Gallery::where('id', $request->edit_id)->first();
            }
            if (!empty($request->image)) {
                $old_img = '';
                if (!empty($item->image)) {
                    $old_img = $item->image;
                }
                $data['image'] = fileUpload($request->image, path_image(), $old_img);
            }

            if(!empty($request->edit_id)) {
                $update = Gallery::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    $response = [
                        'success' => true,
                        'message' => __('Image updated successfully')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to update')
                    ];
                }
            } else {
                $saveData= Gallery::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('New image uploaded successfully.')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to create')
                    ];
                }
            }

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
//                'message' => __('Something Went wrong !')
            ];
            return $response;
        }

        return $response;
    }
// delete gallery image
    public function deleteGalleryImage($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Gallery::where('id',$id)->first();
            if (isset($item)) {
                if (!empty($item->image)) {
                    $img = get_image_name($item->image);
                    removeImage(path_image(),$img);
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Image deleted successfully.')
                    ];
                } else {
                    DB::rollBack();
                    $response = [
                        'success' => false,
                        'message' => __('Operation failed.')
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Data not found.')
                ];
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // gallery list

    public function galleryList()
    {
        $response = ['success'=> false, 'message' => __('Something went wrong')];
        $adm_setting = allSetting();
        $categories = Category::where(['status'=> STATUS_ACTIVE])->get();
        $items = Gallery::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();

        $lists = [];
        if (isset($items[0])) {
            foreach ($items as $item) {
                $lists[] = [
                    'id' => $item->id,
                    'encrypt_id' => encrypt($item->id),
                    'category_id' => $item->category_id,
                    'category_name' => isset($item->category->name) ? $item->category->name : '',
                    'name' => $item->name,
                    'description' => $item->description,
                    'image' => $item->image,
                    'created_at' => date('d M y', strtotime($item->created_at))
                ];
            }
            $response['success'] = true;
            $response['message'] = __('Data get successfully');
        } else {
            $response['success'] = false;
            $response['message'] = __('Data not found');
        }

        $response['gallery_banner_title'] = isset($adm_setting['gallery_banner_title']) ? $adm_setting['gallery_banner_title'] : '';
        $response['gallery_banner_des'] = isset($adm_setting['gallery_banner_des']) ? $adm_setting['gallery_banner_des'] : '';
        $response['gallery_banner_image'] = isset($adm_setting['gallery_banner_image']) && (!empty($adm_setting['gallery_banner_image'])) ? asset(path_image().$adm_setting['gallery_banner_image']) : '';
        $response['cat_list'] = $categories;
        $response['image_list'] = $lists;
        $response['work_image'] = isset($adm_setting['work_image']) && (!empty($adm_setting['work_image'])) ? asset(path_image().$adm_setting['work_image']) : '';
        $response['work_header_title'] = isset($adm_setting['work_header_title']) ? $adm_setting['work_header_title'] : '';
        $response['work_title'] = isset($adm_setting['work_title']) ? $adm_setting['work_title'] : '';
        $response['work_sub_title'] = isset($adm_setting['work_sub_title']) ? $adm_setting['work_sub_title'] : '';
        $response['work_des'] = isset($adm_setting['work_des']) ? $adm_setting['work_des'] : '';

        return $response;
    }

}
