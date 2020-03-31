<?php
namespace App\Repository;
use App\Model\Category;
use App\Model\Service;
use App\Model\Team;
use App\Model\Testimonial;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestimonialRepository
{
// testimonial save process
    public function testimonialSaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'name' => $request->name,
                'profession' => $request->profession,
                'messages' => $request->messages,
                'status' => $request->status,
            ];
            if (isset($request->edit_id)) {
                $item = Testimonial::where('id', $request->edit_id)->first();
            }
            if (!empty($request->image)) {
                $old_img = '';
                if (!empty($item->image)) {
                    $old_img = $item->image;
                }
                $data['image'] = fileUpload($request->image, path_image(), $old_img);
            }

            if(!empty($request->edit_id)) {
                    $update = Testimonial::where(['id' => $request->edit_id])->update($data);
                    if ($update) {
                        $response = [
                            'success' => true,
                            'message' => __('Testimonial updated successfully')
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => __('Failed to update')
                        ];
                    }
            } else {
                $saveData= Testimonial::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('New testimonial created successfully.')
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

    // delete testimonial
    public function deleteTestimonial($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Testimonial::where('id',$id)->first();
            if (isset($item)) {
                if (!empty($item->image)) {
                    $img = get_image_name($item->image);
                    removeImage(path_image(),$img);
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Testimonial deleted successfully.')
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

    // testimonial list

    public function testimonialList()
    {
        $response = ['success'=> false, 'testimonial_list'=> [], 'message' => __('invalid request')];
        $items = Testimonial::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();

        if (isset($items[0])) {
            $response['success'] = true;
            $response['testimonial_list'] = $items;
            $response['message'] = __('Data get successfully');
        } else {
            $response['success'] = false;
            $response['testimonial_list'] = [];
            $response['message'] = __('Data not found');
        }

        return $response;
    }

}
