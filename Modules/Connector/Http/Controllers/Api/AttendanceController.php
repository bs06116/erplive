<?php

namespace Modules\Connector\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Connector\Transformers\CommonResource;
use App\Business;
use App\Utils\ModuleUtil;

/**
 * @group Attendance management
 * @authenticated
 *
 * APIs for managing attendance
 */
class AttendanceController extends ApiController
{
	/**
     * All Utils instance.
     *
     */
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Get Attendance
     *
     * @urlParam user_id required id of the user Example: 1
     * @response {
		    "data": {
		        "id": 4,
		        "user_id": 1,
		        "business_id": 1,
		        "clock_in_time": "2020-09-12 13:13:00",
		        "clock_out_time": "2020-09-12 13:15:00",
		        "essentials_shift_id": 3,
		        "ip_address": null,
		        "clock_in_note": "test clock in from api",
		        "clock_out_note": "test clock out from api",
		        "created_at": "2020-09-12 13:14:39",
		        "updated_at": "2020-09-12 13:15:39"
		    }
		}
     */
	public function getAttendance($user_id)
	{
		if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
			abort(403, 'Unauthorized action.');
		}

		$user = Auth::user();
        $business_id = $user->business_id;

		$attendance = \Modules\Essentials\Entities\EssentialsAttendance::where('business_id', $business_id)
                                    ->where('user_id', $user_id)
                                    ->orderBy('clock_in_time', 'desc')
                                    ->first();

        return new CommonResource($attendance);
	}

	/**
	 * Clock In
     * @bodyParam user_id integer required id of the user Example: 1
     * @bodyParam clock_in_time string Clock in time.If not given current date time will be used Fromat: Y-m-d H:i:s Example:2000-06-13 13:13:00
     * @bodyParam clock_in_note string Clock in note.
     * @bodyParam ip_address string IP address.
     *
     * @response {
     	"success":true,
     	"msg":"Clocked In successfully",
     	"type":"clock_in"
     }
     */
	public function clockin(Request $request)
    {
    	if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
			abort(403, 'Unauthorized action.');
		}

        try {
        	$user = Auth::user();
        	$business_id = $user->business_id;
        	$business = Business::findOrFail($business_id);
        	$settings = $business->essentials_settings;
        	$settings = !empty($settings) ? json_decode($settings, true) : [];

        	$data = [
                    'business_id' => $business_id,
                    'user_id' => $request->input('user_id'),
                    'clock_in_time' => empty($request->input('clock_in_time')) ?\Carbon::now() : $request->input('clock_in_time'),
                    'clock_in_note' => $request->input('clock_in_note'),
                    'ip_address' => $request->input('ip_address'),
                ];

            $essentialsUtil = new \Modules\Essentials\Utils\EssentialsUtil;

            $output = $essentialsUtil->clockin($data, $settings);

            if ($output['success']) {
            	return $this->respond($output);
            } else {
            	return $this->otherExceptions($output['msg']);
            }
        	
        } catch (\Exception $e) {
            return $this->otherExceptions(__("messages.something_went_wrong"));
        }
    }

    /**
	 * Clock Out
     * @bodyParam user_id integer required id of the user Example: 1
     * @bodyParam clock_out_time string Clock out time.If not given current date time will be used Fromat: Y-m-d H:i:s Example:2000-06-13 13:13:00
     * @bodyParam clock_out_note string Clock out note.
     *
     * @response {
     	"success":true,
     	"msg":"Clocked Out successfully",
     	"type":"clock_out"
     }
     */
    public function clockout(Request $request)
    {
    	if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
			abort(403, 'Unauthorized action.');
		}

        try {
        	$user = Auth::user();
        	$business_id = $user->business_id;
        	$business = Business::findOrFail($business_id);
        	$settings = $business->essentials_settings;
        	$settings = !empty($settings) ? json_decode($settings, true) : [];

        	$data = [
                'business_id' => $business_id,
                'user_id' => $request->input('user_id'),
                'clock_out_time' => empty($request->input('clock_out_time')) ?\Carbon::now() : $request->input('clock_out_time'),
                'clock_out_note' => $request->input('clock_out_note')
            ];

            $essentialsUtil = new \Modules\Essentials\Utils\EssentialsUtil;
            $output = $essentialsUtil->clockout($data, $settings);

            if ($output['success']) {
            	return $this->respond($output);
            } else {
            	return $this->otherExceptions($output['msg']);
            }
        	
        } catch (\Exception $e) {
        	return $this->otherExceptions(__("messages.something_went_wrong"));
        }
    }

    /**
     * List Holidays
     * @queryParam location_id id of the location 
     * @queryParam start_date format:Y-m-d Example: 2020-06-25
     * @queryParam end_date format:Y-m-d Example: 2020-06-25
     *
     * @response {
            "data": [
                {
                    "id": 2,
                    "name": "Independence Day",
                    "start_date": "2020-08-15",
                    "end_date": "2020-09-15",
                    "business_id": 1,
                    "location_id": null,
                    "note": "test holiday",
                    "created_at": "2020-09-15 11:25:56",
                    "updated_at": "2020-09-15 11:25:56"
                }
            ]
        }
     */
    public function getHolidays()
    {
        if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();
        $business_id = $user->business_id;

        $query = \Modules\Essentials\Entities\EssentialsHoliday::where('business_id', $business_id);

        $permitted_locations = $user->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->where(function ($q) use ($permitted_locations) {
                $q->whereIn('location_id', $permitted_locations)
                    ->orWhereNull('location_id');
            });
        }

        if (!empty(request()->input('location_id'))) {
                $query->where('location_id', request()->input('location_id'));
            }

        if (!empty(request()->start_date) && !empty(request()->end_date)) {
            $start = request()->start_date;
            $end =  request()->end_date;
            $query->whereDate('start_date', '>=', $start)
                        ->whereDate('start_date', '<=', $end);
        }
        $holidays = $query->get();

        return new CommonResource($holidays);
    }
}