<?php

namespace Modules\Essentials\Http\Controllers;

use App\Transaction;
use App\User;
use App\Utils\ModuleUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Essentials\Notifications\PayrollNotification;
use Modules\Essentials\Utils\EssentialsUtil;
use Yajra\DataTables\Facades\DataTables;
use App\Category;

class PayrollController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $moduleUtil;
    protected $essentialsUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil, EssentialsUtil $essentialsUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->essentialsUtil = $essentialsUtil;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $payrolls = Transaction::where('transactions.business_id', $business_id)
                ->where('type', 'payroll')
                ->join('users as u', 'u.id', '=', 'transactions.expense_for')
                ->leftJoin('categories as dept', 'u.essentials_department_id', '=', 'dept.id')
                ->leftJoin('categories as dsgn', 'u.essentials_designation_id', '=', 'dsgn.id')
                ->select([
                    'transactions.id',
                    DB::raw("CONCAT(COALESCE(u.surname, ''), ' ', COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, '')) as user"),
                    'final_total',
                    'transaction_date',
                    'ref_no',
                    'transactions.payment_status',
                    'dept.name as department',
                    'dsgn.name as designation'
                ]);

            

            if ($is_admin) {
                if (!empty(request()->input('user_id'))) {
                    $payrolls->where('transactions.expense_for', request()->input('user_id'));
                }

                if (!empty(request()->input('designation_id'))) {
                    $payrolls->where('dsgn.id', request()->input('designation_id'));
                }

                if (!empty(request()->input('department_id'))) {
                    $payrolls->where('dept.id', request()->input('department_id'));
                }
            }

            if (!$is_admin) {
                $payrolls->where('transactions.expense_for', auth()->user()->id);
            }

            if (!empty(request()->month_year)) {
                $month_year_arr = explode('/', request()->month_year);
                if (count($month_year_arr) == 2) {
                    $month = $month_year_arr[0];
                    $year = $month_year_arr[1];

                    $payrolls->whereDate('transaction_date', $year . '-' .$month . '-01');
                }
            }

            return Datatables::of($payrolls)
                ->addColumn(
                    'action',
                    function ($row) use ($is_admin) {
                        $html = '<div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                                        data-toggle="dropdown" aria-expanded="false">' .
                                        __("messages.actions") .
                                        '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">';

                        $html .= '<li><a href="#" data-href="' . action('\Modules\Essentials\Http\Controllers\PayrollController@show', [$row->id]) . '" data-container=".view_modal" class="btn-modal"><i class="fa fa-eye" aria-hidden="true"></i> ' . __("messages.view") . '</a></li>';

                        if ($is_admin) {
                            $html .= '<li><a href="' . action('\Modules\Essentials\Http\Controllers\PayrollController@edit', [$row->id]) . '"><i class="fa fa-edit" aria-hidden="true"></i> ' . __("messages.edit") . '</a></li>';
                            $html .= '<li><a href="' . action('\Modules\Essentials\Http\Controllers\PayrollController@destroy', [$row->id]) . '" class="delete-payroll"><i class="fa fa-trash" aria-hidden="true"></i> ' . __("messages.delete") . '</a></li>';
                        }

                        $html .= '<li><a href="' . action('TransactionPaymentController@show', [$row->id]) . '" class="view_payment_modal"><i class="fa fa-money"></i> ' . __("purchase.view_payments") . '</a></li>';

                        if ($row->payment_status != "paid" && $is_admin) {
                            $html .= '<li><a href="' . action('TransactionPaymentController@addPayment', [$row->id]) . '" class="add_payment_modal"><i class="fa fa-money"></i> ' . __("purchase.add_payment") . '</a></li>';
                        }


                        $html .= '</ul></div>';
                        return $html;
                    }
                )
                ->addColumn('transaction_date', function ($row) {
                    $transaction_date = \Carbon::parse($row->transaction_date);
                    
                    return $transaction_date->format('F Y');
                })
                ->editColumn('final_total', '<span class="display_currency" data-currency_symbol="true">{{$final_total}}</span>')
                ->filterColumn('user', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(u.surname, ''), ' ', COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, '')) like ?", ["%{$keyword}%"]);
                })
                ->editColumn(
                    'payment_status',
                    '<a href="{{ action("TransactionPaymentController@show", [$id])}}" class="view_payment_modal payment-status-label no-print" data-orig-value="{{$payment_status}}" data-status-name="{{__(\'lang_v1.\' . $payment_status)}}"><span class="label @payment_status($payment_status)">{{__(\'lang_v1.\' . $payment_status)}}
                        </span></a>
                        <span class="print_section">{{__(\'lang_v1.\' . $payment_status)}}</span>
                        '
                )
                ->removeColumn('id')
                ->rawColumns(['action', 'final_total', 'payment_status'])
                ->make(true);
        }

        $employees = [];
        if ($is_admin) {
            $employees = User::forDropdown($business_id, false);
        }
        $departments = Category::forDropdown($business_id, 'hrm_department');
        $designations = Category::forDropdown($business_id, 'hrm_designation');

        return view('essentials::payroll.index')->with(compact('employees', 'is_admin', 'departments', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $employee_id = request()->input('employee_id');
        $month_year_arr = explode('/', request()->input('month_year'));
        $month = $month_year_arr[0];
        $year = $month_year_arr[1];

        $transaction_date = $year . '-' . $month . '-01';

        //check if payroll exists for the month year; If yes redirect to edit
        $payroll = Transaction::where('business_id', $business_id)
                                ->where('expense_for', $employee_id)
                                ->whereDate('transaction_date', $transaction_date)
                                ->first();

        $employee = User::where('business_id', $business_id)
                    ->findOrFail($employee_id);

        if (empty($payroll)) {
            $start_date = $transaction_date;
            $end_date = \Carbon::parse($start_date)->lastOfMonth();
            $month_name = $end_date->format('F');
            $total_work_duration = $this->essentialsUtil->getTotalWorkDuration('hour', $employee_id, $business_id, $start_date, $end_date->format('Y-m-d'));

            $allowances_and_deductions = $this->essentialsUtil->getEmployeeAllowancesAndDeductions($business_id, $employee_id, $start_date, $end_date);
            $allowances = [];
            $deductions = [];
            foreach ($allowances_and_deductions as $ad) {
                if ($ad->type == 'allowance') {
                    $allowances['allowance_names'][] = $ad->description;
                    $allowances['allowance_amounts'][] = $ad->amount_type == 'fixed' ?$ad->amount : 0;
                    $allowances['allowance_types'][] = $ad->amount_type;
                    $allowances['allowance_percents'][] = $ad->amount_type == 'percent' ? $ad->amount : 0;
                } else {
                    $deductions['deduction_names'][] = $ad->description;
                    $deductions['deduction_amounts'][] = $ad->amount_type == 'fixed' ? $ad->amount : 0;
                    $deductions['deduction_types'][] = $ad->amount_type;
                    $deductions['deduction_percents'][] = $ad->amount_type == 'percent' ? $ad->amount : 0;
                }
            }

            return view('essentials::payroll.create')
                    ->with(compact('employee', 'total_work_duration', 'month_name', 'transaction_date', 'year', 'allowances', 'deductions'));
        } else {
            return redirect()->action('\Modules\Essentials\Http\Controllers\PayrollController@edit', $payroll->id);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['expense_for', 'transaction_date', 'essentials_duration', 'essentials_amount_per_unit_duration', 'final_total', 'essentials_duration_unit']);

            $input['essentials_amount_per_unit_duration'] = $this->moduleUtil->num_uf($input['essentials_amount_per_unit_duration']);

            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;
            $input['type'] = 'payroll';
            $input['payment_status'] = 'due';
            $input['status'] = 'final';
            $input['total_before_tax'] = $input['final_total'];

            $allowances_and_deductions = $this->getAllowanceAndDeductionJson($request);
            $input['essentials_allowances'] = $allowances_and_deductions['essentials_allowances'];
            $input['essentials_deductions'] = $allowances_and_deductions['essentials_deductions'];

            DB::beginTransaction();
            //Update reference count
            $ref_count = $this->moduleUtil->setAndGetReferenceCount('payroll');
            //Generate reference number
            if (empty($input['ref_no'])) {
                $settings = request()->session()->get('business.essentials_settings');
                $settings = !empty($settings) ? json_decode($settings, true) : [];
                $prefix = !empty($settings['payroll_ref_no_prefix']) ? $settings['payroll_ref_no_prefix'] : '';
                $input['ref_no'] = $this->moduleUtil->generateReferenceNumber('payroll', $ref_count, null, $prefix);
            }

            $payroll = Transaction::create($input);

            //Send notification
            $payroll->action = 'created';
            $payroll->transaction_for->notify(new PayrollNotification($payroll));

            $output = ['success' => true,
                            'msg' => __("lang_v1.added_success")
                        ];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return redirect()->action('\Modules\Essentials\Http\Controllers\PayrollController@index')->with('status', $output);
    }

    private function getAllowanceAndDeductionJson($request)
    {
        $allowance_names = $request->input('allowance_names');
        $allowance_types = $request->input('allowance_types');
        $allowance_percents = $request->input('allowance_percent');
        $allowance_names_array = [];
        $allowance_percent_array = [];
        $allowance_amounts = [];
        foreach ($request->input('allowance_amounts') as $key => $value) {
            if (!empty($allowance_names[$key])) {
                $allowance_amounts[] = $this->moduleUtil->num_uf($value);
                $allowance_names_array[] = $allowance_names[$key];
                $allowance_percent_array[] = !empty($allowance_percents[$key]) ? $this->moduleUtil->num_uf($allowance_percents[$key]) : 0;
            }
        }

        $deduction_names = $request->input('deduction_names');
        $deduction_types = $request->input('deduction_types');
        $deduction_percents = $request->input('deduction_percent');
        $deduction_names_array = [];
        $deduction_percents_array = [];
        $deduction_amounts = [];
        foreach ($request->input('deduction_amounts') as $key => $value) {
            if (!empty($deduction_names[$key])) {
                $deduction_names_array[] = $deduction_names[$key];
                $deduction_amounts[] = $this->moduleUtil->num_uf($value);
                $deduction_percents_array[] = !empty($deduction_percents[$key]) ? $this->moduleUtil->num_uf($deduction_percents[$key]) : 0;
            }
        }

        $output['essentials_allowances'] = json_encode([
                'allowance_names' => $allowance_names_array,
                'allowance_amounts' => $allowance_amounts,
                'allowance_types' => $allowance_types,
                'allowance_percents' => $allowance_percent_array
            ]);
        $output['essentials_deductions'] = json_encode([
                'deduction_names' => $deduction_names_array,
                'deduction_amounts' => $deduction_amounts,
                'deduction_types' => $deduction_types,
                'deduction_percents' => $deduction_percents_array
            ]);

        return $output;
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $business_id = request()->session()->get('user.business_id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
            abort(403, 'Unauthorized action.');
        }

        $payroll = Transaction::where('business_id', $business_id)
                                ->with(['transaction_for', 'payment_lines'])
                                ->findOrFail($id);
        $transaction_date = \Carbon::parse($payroll->transaction_date);

        $month_name = $transaction_date->format('F');
        $year = $transaction_date->format('Y');
        $allowances = !empty($payroll->essentials_allowances) ? json_decode($payroll->essentials_allowances, true) : [];
        $deductions = !empty($payroll->essentials_deductions) ? json_decode($payroll->essentials_deductions, true) : [];

        $payment_types = $this->moduleUtil->payment_types();

        return view('essentials::payroll.show')->with(compact('payroll', 'month_name', 'allowances', 'deductions', 'year', 'payment_types'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || !$this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $payroll = Transaction::where('business_id', $business_id)
                                ->with(['transaction_for'])
                                ->where('type', 'payroll')
                                ->findOrFail($id);

        $transaction_date = \Carbon::parse($payroll->transaction_date);
        $month_name = $transaction_date->format('F');
        $year = $transaction_date->format('Y');
        $allowances = !empty($payroll->essentials_allowances) ? json_decode($payroll->essentials_allowances, true) : [];
        $deductions = !empty($payroll->essentials_deductions) ? json_decode($payroll->essentials_deductions, true) : [];

        return view('essentials::payroll.edit')->with(compact('payroll', 'month_name', 'allowances', 'deductions', 'year'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['essentials_duration', 'essentials_amount_per_unit_duration', 'final_total', 'essentials_duration_unit']);

            $input['essentials_amount_per_unit_duration'] = $this->moduleUtil->num_uf($input['essentials_amount_per_unit_duration']);
            $input['total_before_tax'] = $input['final_total'];

            $allowances_and_deductions = $this->getAllowanceAndDeductionJson($request);
            $input['essentials_allowances'] = $allowances_and_deductions['essentials_allowances'];
            $input['essentials_deductions'] = $allowances_and_deductions['essentials_deductions'];

            DB::beginTransaction();
            $payroll = Transaction::where('business_id', $business_id)
                                ->where('type', 'payroll')
                                ->findOrFail($id);

            $payroll->update($input);

            $payroll->action = 'updated';
            $payroll->transaction_for->notify(new PayrollNotification($payroll));

            $output = ['success' => true,
                            'msg' => __("lang_v1.updated_success")
                        ];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return redirect()->action('\Modules\Essentials\Http\Controllers\PayrollController@index')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

                if ($is_admin) {
                    $payroll = Transaction::where('business_id', $business_id)
                                ->where('type', 'payroll')
                                ->where('id', $id)
                                ->delete();

                    $output = ['success' => true,
                                'msg' => __("lang_v1.deleted_success")
                            ];
                } else {
                    $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
                }
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }
}
