<?php
namespace App\Repository;
use App\Model\Category;
use App\Model\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeamRepository
{
// team category save process
    public function teamCategorySaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ];
            if (isset($request->edit_id)) {
                $item = Category::where('id', $request->edit_id)->first();
            }
            if (!empty($request->image)) {
                $old_img = '';
                if (!empty($item->image)) {
                    $old_img = $item->image;
                }
                $data['image'] = fileUpload($request->image, path_image(), $old_img);
            }

            if(!empty($request->edit_id)) {
                    $update = Category::where(['id' => $request->edit_id])->update($data);
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
                $saveData= Category::create($data);
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

    // delete team category
    public function deleteTeamCategory($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Category::where('id',$id)->first();
            if (isset($item)) {
                $team = Team::where('category_id', $id)->get();
                if(isset($team[0])) {
                    $response = [
                        'success' => false,
                        'message' => __('This item has used at team, You can not delete this.')
                    ];
                    return $response;
                }
                if (!empty($item->image)) {
                    $img = get_image_name($item->image);
                    removeImage(path_image(),$img);
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


// team  save process
    public function teamSaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'designation' => $request->designation,
                'bio' => $request->bio,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'google' => $request->google,
                'twitter' => $request->twitter,
                'skype' => $request->skype,
                'linkedin' => $request->linkedin,
                'status' => $request->status,
            ];
            if (isset($request->edit_id)) {
                $item = Team::where('id', $request->edit_id)->first();
            }
            if (!empty($request->image)) {
                $old_img = '';
                if (!empty($item->image)) {
                    $old_img = $item->image;
                }
                $data['image'] = fileUpload($request->image, path_image(), $old_img);
            }

            if(!empty($request->edit_id)) {
                $update = Team::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    $response = [
                        'success' => true,
                        'message' => __('Member updated successfully')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to update')
                    ];
                }
            } else {
                $saveData= Team::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('New member created successfully.')
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
// delete team member
    public function deleteTeam($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Team::where('id',$id)->first();
            if (isset($item)) {
                if (!empty($item->image)) {
                    $img = get_image_name($item->image);
                    removeImage(path_image(),$img);
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Member deleted successfully.')
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
                    'message' => __('Member not found.')
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

    // team list

    public function teamList()
    {
        $response = ['success'=> false, 'message' => __('Something went wrong')];

        $items = Team::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();

        $lists = [];
        if (isset($items[0])) {
            foreach ($items as $item) {
                $lists[] = [
                    'id' => $item->id,
                    'encrypt_id' => encrypt($item->id),
                    'name' => $item->name,
                    'designation' => $item->designation,
                    'bio' => $item->bio,
                    'image' => $item->image,
                    'email' => $item->email,
                    'facebook' => $item->facebook,
                    'google' => $item->google,
                    'twitter' => $item->twitter,
                    'skype' => $item->skype,
                    'linkedin' => $item->linkedin,
                    'created_at' => date('d M y', strtotime($item->created_at))
                ];
            }
            $response['success'] = true;
            $response['message'] = __('Data get successfully');
        } else {
            $response['success'] = false;
            $response['message'] = __('Data not found');
        }
        $response['team_list'] = $lists;

        return $response;
    }
}
