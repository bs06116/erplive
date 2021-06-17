<?php

namespace Modules\Crm\Http\Controllers;

use App\Category;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmContact;
use Yajra\DataTables\Facades\DataTables;
use Excel;
use DB;

class LeadImportController extends Controller
{
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Shows import option for contacts
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
//            abort(403, 'Unauthorized action.');
//        }

        $zip_loaded = extension_loaded('zip') ? true : false;

        //Check if zip extension it loaded or not.
        if ($zip_loaded === false) {
            $output = ['success' => 0,
                'msg' => 'Please install/enable PHP Zip archive for import'
            ];
            return back()
                ->with('notification', $output);
        }
        $business_id = auth()->user()->business_id;

        return view('crm::lead.import', [
            'lead_categories' => Category::where('business_id', $business_id)
                ->where('parent_id', 0)
                ->whereIn('category_type', ['source', 'life_stage'])
                ->select(['name', 'short_code', 'id', 'category_type'])
                ->get()
        ]);
    }

    /**
     * Imports contacts
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
//            abort(403, 'Unauthorized action.');
//        }

        try {
            $notAllowed = $this->commonUtil->notAllowedInDemo();
            if (!empty($notAllowed)) {
                return $notAllowed;
            }

            //Set maximum php execution time
            ini_set('max_execution_time', 0);
            if ($request->hasFile('contacts_csv')) {
                $file = $request->file('contacts_csv');
                $parsed_array = Excel::toArray([], $file);
                //Remove header row
                $imported_data = array_splice($parsed_array[0], 1);

                $business_id = $request->session()->get('user.business_id');
                $user_id = $request->session()->get('user.id');

                $formated_data = [];

                $is_valid = true;
                $error_msg = '';

                DB::beginTransaction();
                foreach ($imported_data as $key => $value) {
                    //Check if 24 no. of columns exists
//                    dd(count($value));
                    if (count($value) != 24) {
                        $is_valid = false;
                        $error_msg = "Number of columns mismatch";
                        break;
                    }

                    $row_no = $key + 1;

                    $contact_array['prefix'] = $value[0];
                    //Check contact name
                    if (!empty($value[1])) {
                        $contact_array['first_name'] = $value[1];
                    } else {
                        $is_valid = false;
                        $error_msg = "First name is required in row no. $row_no";
                        break;
                    }
                    $contact_array['middle_name'] = $value[2];
                    $contact_array['last_name'] = $value[3];
                    $contact_array['name'] = implode(' ', [$contact_array['prefix'], $contact_array['first_name'], $contact_array['middle_name'], $contact_array['last_name']]);

                    //Check contact ID
                    if (!empty(trim($value[5]))) {
                        $count = CrmContact::where('business_id', $business_id)
                            ->where('contact_id', $value[5])
                            ->count();

                        if ($count == 0) {
                            $contact_array['contact_id'] = $value[5];
                        } else {
                            $is_valid = false;
                            $error_msg = "Contact ID already exists in row no. $row_no";
                            break;
                        }
                    }

                    //Tax number
                    if (!empty(trim($value[5]))) {
                        $contact_array['tax_number'] = $value[5];
                    }

                    //Check email
                    if (!empty(trim($value[7]))) {
                        if (filter_var(trim($value[7]), FILTER_VALIDATE_EMAIL)) {
                            $contact_array['email'] = $value[7];
                        } else {
                            $is_valid = false;
                            $error_msg = "Invalid email id in row no. $row_no";
                            break;
                        }
                    }

                    //Mobile number
                    if (!empty(trim($value[8]))) {
                        $contact_array['mobile'] = $value[8];
                    } else {
                        $is_valid = false;
                        $error_msg = "Mobile number is required in row no. $row_no";
                        break;
                    }

                    //Alt contact number
                    $contact_array['alternate_number'] = $value[9];

                    //Landline
                    $contact_array['landline'] = $value[10];

                    //City
                    $contact_array['city'] = $value[11];

                    //State
                    $contact_array['state'] = $value[12];

                    //Country
                    $contact_array['country'] = $value[13];

                    //address_line_1
                    $contact_array['address_line_1'] = $value[14];
                    //address_line_2
                    $contact_array['address_line_2'] = $value[15];
                    $contact_array['zip_code'] = $value[16];
                    $contact_array['dob'] = $value[17];

                    //Cust fields
                    $contact_array['custom_field1'] = $value[18];
                    $contact_array['custom_field2'] = $value[19];
                    $contact_array['custom_field3'] = $value[20];
                    $contact_array['custom_field4'] = $value[21];
                    $contact_array['crm_life_stage'] = $value[22];
                    $contact_array['crm_source'] = $value[23];
                    $formated_data[] = $contact_array;
                }
                if (!$is_valid) {
                    throw new \Exception($error_msg);
                }
                if (!empty($formated_data)) {
                    foreach ($formated_data as $contact_data) {
                        $ref_count = $this->commonUtil->setAndGetReferenceCount('contacts');
                        //Set contact id if empty
                        if (empty($contact_data['contact_id'])) {
                            $contact_data['contact_id'] = $this->commonUtil->generateReferenceNumber('contacts', $ref_count);
                        }

                        $contact_data['business_id'] = $business_id;
                        $contact_data['created_by'] = $user_id;
                        $contact_data['type'] = 'lead';
//                        dd($contact_data);
//                        dd($contact_data);

                        CrmContact::create($contact_data);

                    }
                }

                $output = ['success' => 1,
                    'msg' => __('product.file_imported_successfully')
                ];

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = ['success' => 0,
                'msg' => $e->getMessage()
            ];
            return back()->with('status', $output);
        }
        return back()->with('status', $output);
    }

}
