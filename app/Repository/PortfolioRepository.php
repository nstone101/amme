<?php
namespace App\Repository;
use App\Model\Category;
use App\Model\Portfolio;
use App\Model\PortfolioCategory;
use App\Model\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PortfolioRepository
{
// port  category save process
    public function portfolioCategorySaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ];
            if (isset($request->edit_id)) {
                $item = PortfolioCategory::where('id', $request->edit_id)->first();
            }
            if (!empty($request->image)) {
                $old_img = '';
                if (!empty($item->image)) {
                    $old_img = $item->image;
                }
                $data['image'] = fileUpload($request->image, path_image(), $old_img);
            }

            if(!empty($request->edit_id)) {
                    $update = PortfolioCategory::where(['id' => $request->edit_id])->update($data);
                    if ($update) {
                        $response = [
                            'success' => true,
                            'message' => __('Portfolio category updated successfully')
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => __('Failed to update')
                        ];
                    }
            } else {
                $saveData= PortfolioCategory::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('Portfolio category created successfully.')
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

    // delete port category
    public function deletePortfolioCategory($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = PortfolioCategory::where('id',$id)->first();
            if (isset($item)) {
                $portfolio = Portfolio::where('category_id', $id)->get();
                if(isset($team[0])) {
                    $response = [
                        'success' => false,
                        'message' => __('This item has used at portfolio, You can not delete this.')
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
                        'message' => __('Portfolio category deleted successfully.')
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


// portfolio  save process
    public function portfolioSaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        try {
            $data = [
                'title' => $request->title,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'experience' => $request->experience,
                'client' => $request->client,
                'date' => $request->date,
                'demo' => $request->demo,
                'status' => $request->status,
            ];
            if (!empty($request->file('image'))) {
                $data['image'] = '|'.implode('|',multipleuploadimage($request->file('image'), path_image(), '', '', '')).'|';
            }

            if(!empty($request->edit_id)) {
                $portfolio = Portfolio::where('id', $request->edit_id)->first();
                if (isset($portfolio)) {
                    if (!empty($request->file('image'))) {
                        $old_image =!empty($portfolio->getOriginal('image')) ? $portfolio->getOriginal('image'):'|';
                        $item['image'] = $old_image.implode('|',multipleuploadimage($request->image, path_image(), '', '')).'|';
                    }
                    $update = Portfolio::where(['id' => $request->edit_id])->update($data);
                    if ($update) {
                        $response = [
                            'success' => true,
                            'message' => __('Portfolio updated successfully')
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => __('Failed to update')
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Portfolio not found.')
                    ];
                }
            } else {
                $saveData= Portfolio::create($data);
                if ($saveData) {
                    $response = [
                        'success' => true,
                        'message' => __('New portfolio created successfully.')
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
// delete portfolio
    public function deletePortfolio($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = Portfolio::where('id',$id)->first();
            if (isset($item)) {
                if (!empty($item->image)) {
                    foreach ($item->image as $item_image) {
                        $img = get_image_name($item_image);
                        removeImage(path_image(),$img);
                    }
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Portfolio deleted successfully.')
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
                    'message' => __('Portfolio not found.')
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

    // portfolio list

    public function portfolioList($type)
    {
        $response = ['success'=> false, 'message' => __('Something went wrong')];
        if ($type == TYPE_HOME) {
            $items = Portfolio::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->limit(3)->get();
        } else {
            $items = Portfolio::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();
        }

        $lists = [];
        if (isset($items[0])) {
            foreach ($items as $item) {
                $lists[] = [
                    'id' => $item->id,
                    'encrypt_id' => encrypt($item->id),
                    'category_id' => $item->category_id,
                    'category_name' => isset($item->category->name) ? $item->category->name : '',
                    'title' => $item->title,
                    'description' => $item->description,
                    'image' => $item->image,
                    'experience' => $item->experience,
                    'client' => $item->client,
                    'date' => $item->date,
                    'demo' => $item->demo,
                    'created_at' => date('d M y', strtotime($item->created_at))
                ];
            }
            $response['success'] = true;
            $response['message'] = __('Data get successfully');
        } else {
            $response['success'] = false;
            $response['message'] = __('Data not found');
        }
        $response['portfolio_list'] = $lists;

        return $response;
    }
}
