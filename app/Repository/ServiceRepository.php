<?php
namespace App\Repository;
use App\Model\Category;
use App\Model\Service;
use App\Model\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceRepository
{
// service save process
    public function serviceSaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ];
            if (isset($request->edit_id)) {
                $item = Service::where('id', $request->edit_id)->first();
            }
            if (!empty($request->image)) {
                $old_img = '';
                if (!empty($item->image)) {
                    $old_img = $item->image;
                }
                $data['image'] = fileUpload($request->image, path_image(), $old_img);
            }

            if(!empty($request->edit_id)) {
                    $update = Service::where(['id' => $request->edit_id])->update($data);
                    if ($update) {
                        $response = [
                            'success' => true,
                            'message' => __('Service updated successfully')
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => __('Failed to update')
                        ];
                    }
            } else {
                $saveData= Service::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('New service created successfully.')
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

    // delete service
    public function deleteService($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Service::where('id',$id)->first();
            if (isset($item)) {
                if (!empty($item->image)) {
                    $img = get_image_name($item->image);
                    removeImage(path_image(),$img);
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Service deleted successfully.')
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

    // service list

    public function serviceList($type)
    {
        $response = ['success'=> false, 'message' => __('Something went wrong')];
        if ($type == TYPE_HOME) {
            $items = Service::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->limit(3)->get();
        } else {
            $items = Service::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();
        }

        $lists = [];
        if (isset($items[0])) {
            foreach ($items as $item) {
                $lists[] = [
                    'id' => $item->id,
                    'encrypt_id' => encrypt($item->id),
                    'title' => $item->title,
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
        $response['service_list'] = $lists;

        return $response;
    }

}
