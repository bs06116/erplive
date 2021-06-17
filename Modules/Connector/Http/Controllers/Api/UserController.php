<?php

namespace Modules\Connector\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Connector\Transformers\CommonResource;
use App\Utils\Util;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group User management
 * @authenticated
 *
 * APIs for managing users
 */
class UserController extends ApiController
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * List users
     *
     * @response {
            "data": [
                {
                    "id": 1,
                    "user_type": "user",
                    "surname": "Mr",
                    "first_name": "Admin",
                    "last_name": null,
                    "username": "admin",
                    "email": "admin@example.com",
                    "language": "en",
                    "contact_no": null,
                    "address": null,
                    "business_id": 1,
                    "max_sales_discount_percent": null,
                    "allow_login": 1,
                    "essentials_department_id": null,
                    "essentials_designation_id": null,
                    "status": "active",
                    "crm_contact_id": null,
                    "is_cmmsn_agnt": 0,
                    "cmmsn_percent": "0.00",
                    "selected_contacts": 0,
                    "dob": null,
                    "gender": null,
                    "marital_status": null,
                    "blood_group": null,
                    "contact_number": null,
                    "fb_link": null,
                    "twitter_link": null,
                    "social_media_1": null,
                    "social_media_2": null,
                    "permanent_address": null,
                    "current_address": null,
                    "guardian_name": null,
                    "custom_field_1": null,
                    "custom_field_2": null,
                    "custom_field_3": null,
                    "custom_field_4": null,
                    "bank_details": null,
                    "id_proof_name": null,
                    "id_proof_number": null,
                    "deleted_at": null,
                    "created_at": "2018-01-04 02:15:19",
                    "updated_at": "2018-01-04 02:15:19"
                }
            ]
        }
     */
    public function index()
    {
        $user = Auth::user();

        $business_id = $user->business_id;
        
        if (!empty(request()->service_staff) && request()->service_staff == true) {
            $users = $this->commonUtil->getServiceStaff($business_id);
        } else {
            $users = User::where('business_id', $business_id)
                        ->get();
        }

        return CommonResource::collection($users);
    }

    /**
     * Get the specified user
     * 
     * @response {
            "data": [
                {
                    "id": 1,
                    "user_type": "user",
                    "surname": "Mr",
                    "first_name": "Admin",
                    "last_name": null,
                    "username": "admin",
                    "email": "admin@example.com",
                    "language": "en",
                    "contact_no": null,
                    "address": null,
                    "business_id": 1,
                    "max_sales_discount_percent": null,
                    "allow_login": 1,
                    "essentials_department_id": null,
                    "essentials_designation_id": null,
                    "status": "active",
                    "crm_contact_id": null,
                    "is_cmmsn_agnt": 0,
                    "cmmsn_percent": "0.00",
                    "selected_contacts": 0,
                    "dob": null,
                    "gender": null,
                    "marital_status": null,
                    "blood_group": null,
                    "contact_number": null,
                    "fb_link": null,
                    "twitter_link": null,
                    "social_media_1": null,
                    "social_media_2": null,
                    "permanent_address": null,
                    "current_address": null,
                    "guardian_name": null,
                    "custom_field_1": null,
                    "custom_field_2": null,
                    "custom_field_3": null,
                    "custom_field_4": null,
                    "bank_details": null,
                    "id_proof_name": null,
                    "id_proof_number": null,
                    "deleted_at": null,
                    "created_at": "2018-01-04 02:15:19",
                    "updated_at": "2018-01-04 02:15:19"
                }
            ]
        }
     * @urlParam user required comma separated ids of the required users Example: 1
     */
    public function show($user_ids)
    {
        $user = Auth::user();

        $business_id = $user->business_id;
        $user_ids = explode(',', $user_ids);

        $users = User::where('business_id', $business_id)
                    ->whereIn('id', $user_ids)
                    ->get();

        return CommonResource::collection($users);
    }

    /**
     * Get the loggedin user details.
     * 
     * @response {
            "data":{
                "id": 1,
                "user_type": "user",
                "surname": "Mr",
                "first_name": "Admin",
                "last_name": null,
                "username": "admin",
                "email": "admin@example.com",
                "language": "en",
                "contact_no": null,
                "address": null,
                "business_id": 1,
                "max_sales_discount_percent": null,
                "allow_login": 1,
                "essentials_department_id": null,
                "essentials_designation_id": null,
                "status": "active",
                "crm_contact_id": null,
                "is_cmmsn_agnt": 0,
                "cmmsn_percent": "0.00",
                "selected_contacts": 0,
                "dob": null,
                "gender": null,
                "marital_status": null,
                "blood_group": null,
                "contact_number": null,
                "fb_link": null,
                "twitter_link": null,
                "social_media_1": null,
                "social_media_2": null,
                "permanent_address": null,
                "current_address": null,
                "guardian_name": null,
                "custom_field_1": null,
                "custom_field_2": null,
                "custom_field_3": null,
                "custom_field_4": null,
                "bank_details": null,
                "id_proof_name": null,
                "id_proof_number": null,
                "deleted_at": null,
                "created_at": "2018-01-04 02:15:19",
                "updated_at": "2018-01-04 02:15:19"
            }
        }
     */
    public function loggedin()
    {
        $user = Auth::user();
        return new CommonResource($user);
    }

    /**
     * Update user password.
     * @bodyParam current_password string required Current password of the user
     * @bodyParam new_password string required New password of the user
     * 
     * @response {
            "success":1,
            "msg":"Password updated successfully"
        }
     */
    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!empty($request->input('current_password')) && !empty($request->input('new_password'))) {
                if (Hash::check($request->input('current_password'), $user->password)) {
                    $user->password = Hash::make($request->input('new_password'));
                    $user->save();
                    $output = ['success' => 1,
                                'msg' => __('lang_v1.password_updated_successfully')
                            ];
                } else {
                    $output = ['success' => 0,
                                'msg' => __('lang_v1.u_have_entered_wrong_password')
                            ];
                }
            } else {
                $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
            }

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
        }

        if ($output['success']) {
            return $this->respond($output);
        } else {
            return $this->otherExceptions($output['msg']);
        }
    }
}
