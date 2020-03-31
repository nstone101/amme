<?php
namespace App\Repository;
use App\Model\Category;
use App\Model\PricingFeature;
use App\Model\PricingPlan;
use App\Model\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlanRepository
{
// plan save process
    public function planSaveProcess($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $data = [
                'title' => $request->title,
                'price' => $request->price,
                'duration' => $request->duration,
                'description' => $request->description,
                'status' => $request->status,
            ];

            if(!empty($request->edit_id)) {
                $plan  = PricingPlan::where(['id' => $request->edit_id])->first();
                if (isset($plan)) {
                    $update = $plan->update($data);
                    if ($update) {
                        $this->addPricingFeature($request, $plan->id);
                        $response = [
                            'success' => true,
                            'message' => __('Plan updated successfully')
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
                        'message' => __('Plan not found')
                    ];
                }
            } else {
                $saveData= PricingPlan::create($data);
                if ($saveData) {
                    $this->addPricingFeature($request, $saveData->id);
                    $response = [
                        'success' => true,
                        'message' => __('New plan created successfully.')
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('Failed to create')
                    ];
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => $e->getMessage()
//                'message' => __('Something Went wrong !')
            ];
            return $response;
        }

        DB::commit();
        return $response;
    }

    // save plan feature

    public function addPricingFeature($request, $planId)
    {
        if (isset($request->features[0])) {
            $addedoptions = PricingFeature::where(['plan_id' => $planId])->get();
            if (isset($addedoptions[0])) {
                PricingFeature::where(['plan_id' => $planId])->delete();
            }
            $size = sizeof($request->features);
            for ($i = 0; $size > $i; $i++) {
                PricingFeature::create([
                    'plan_id' => $planId,
                    'title' => $request->features[$i]
                ]);
            }
        }

        return true;
    }

// delete Pricing Plan
    public function deletePricingPlan($id)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            $item = PricingPlan::where('id',$id)->first();
            if (isset($item)) {
                $features = PricingFeature::where(['plan_id' => $id])->get();
                if (isset($features[0])) {
                    PricingFeature::where(['plan_id' => $id])->delete();
                }
                $delete = $item->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'message' => __('Plan deleted successfully.')
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
                    'message' => __('Plan not found.')
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

    // plan list

    public function planList($type)
    {
        $response = ['success'=> false, 'message' => __('Something went wrong')];
        if ($type == TYPE_HOME) {
            $items = PricingPlan::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();
        } else {
            $items = PricingPlan::where(['status'=> STATUS_ACTIVE])->orderBy('id', 'desc')->get();
        }

        $lists = [];
        if (isset($items[0])) {
            foreach ($items as $item) {
                $lists[] = [
                    'id' => $item->id,
                    'encrypt_id' => encrypt($item->id),
                    'title' => $item->title,
                    'description' => $item->description,
                    'price' => $item->price,
                    'duration_type' => $item->duration,
                    'duration' => plan_duration($item->duration),
                    'features' => $this->planFeature($item->id)['features'],
                    'created_at' => date('d M y', strtotime($item->created_at))
                ];
            }
            $response['success'] = true;
            $response['message'] = __('Data get successfully');
        } else {
            $response['success'] = false;
            $response['message'] = __('Data not found');
        }
        $response['plan_list'] = $lists;

        return $response;
    }

    // plan feature

    public function planFeature($planId)
    {
        $feature = [];
        $features = PricingFeature::where(['plan_id'=> $planId])->get();
        if (isset($features[0])) {
            foreach ($features as $item) {
                $feature[] = $item->title;
            }
        }
        $data['features'] = $feature;

        return $data;
    }
}
