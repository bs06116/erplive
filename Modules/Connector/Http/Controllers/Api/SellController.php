<?php

namespace Modules\Connector\Http\Controllers\Api;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Utils\BusinessUtil;
use App\Utils\CashRegisterUtil;
use App\Utils\ContactUtil;
use App\Utils\NotificationUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Variation;
use Modules\Connector\Transformers\SellTransactionResource;
use App\BusinessLocation;
use App\Product;
use App\TaxRate;
use App\Unit;
use App\Contact;
use App\Business;
use App\Transaction;
use App\TransactionSellLine;
use App\TransactionPayment;
use DB;
use Modules\Connector\Transformers\SellResource;

/**
 * @group Sales management
 * @authenticated
 *
 * APIs for managing sales
 */
class SellController extends ApiController
{
    /**
     * All Utils instance.
     *
     */
    protected $contactUtil;
    protected $productUtil;
    protected $businessUtil;
    protected $transactionUtil;
    protected $cashRegisterUtil;
    protected $moduleUtil;
    protected $notificationUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(
        ContactUtil $contactUtil,
        ProductUtil $productUtil,
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        CashRegisterUtil $cashRegisterUtil,
        NotificationUtil $notificationUtil
    ) {
        $this->contactUtil = $contactUtil;
        $this->productUtil = $productUtil;
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->notificationUtil = $notificationUtil;

        $this->dummyPaymentLine = ['method' => 'cash', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
        'is_return' => 0, 'transaction_no' => ''];
        parent::__construct();
    }

    /**
     * List sells
     * @queryParam location_id id of the location
     * @queryParam contact_id id of the customer
     * @queryParam payment_status payment status Example: paid
     * @queryParam start_date format:Y-m-d Example: 2018-06-25
     * @queryParam end_date format:Y-m-d Example: 2018-06-25
     * @queryParam user_id id of the user who created the sale
     * @queryParam service_staff_id id of the service staff assigned with the sale
     * @queryParam shipping_status Shipping Status of the sale ('ordered', 'packed', 'shipped', 'delivered', 'cancelled') Example: ordered
     * @queryParam only_subscriptions Filter only subcription invoices (1, 0)
     * @queryParam per_page Total records per page. default: 10, Set -1 for no pagination Example:10
     *
     * @response {
        "data": [
            {
                "id": 6,
                "business_id": 1,
                "location_id": 1,
                "res_table_id": null,
                "res_waiter_id": null,
                "res_order_status": null,
                "type": "sell",
                "sub_type": null,
                "status": "final",
                "is_quotation": 0,
                "payment_status": "paid",
                "adjustment_type": null,
                "contact_id": 4,
                "customer_group_id": null,
                "invoice_no": "AS0001",
                "ref_no": "",
                "subscription_no": null,
                "subscription_repeat_on": null,
                "transaction_date": "2018-04-10 13:23:21",
                "total_before_tax": "770.0000",
                "tax_id": null,
                "tax_amount": "0.0000",
                "discount_type": "percentage",
                "discount_amount": "0.0000",
                "rp_redeemed": 0,
                "rp_redeemed_amount": "0.0000",
                "shipping_details": null,
                "shipping_address": null,
                "shipping_status": null,
                "delivered_to": null,
                "shipping_charges": "0.0000",
                "additional_notes": null,
                "staff_note": null,
                "round_off_amount": "0.0000",
                "final_total": "770.0000",
                "expense_category_id": null,
                "expense_for": null,
                "commission_agent": null,
                "document": null,
                "is_direct_sale": 0,
                "is_suspend": 0,
                "exchange_rate": "1.000",
                "total_amount_recovered": null,
                "transfer_parent_id": null,
                "return_parent_id": null,
                "opening_stock_product_id": null,
                "created_by": 1,
                "import_batch": null,
                "import_time": null,
                "types_of_service_id": null,
                "packing_charge": null,
                "packing_charge_type": null,
                "service_custom_field_1": null,
                "service_custom_field_2": null,
                "service_custom_field_3": null,
                "service_custom_field_4": null,
                "mfg_parent_production_purchase_id": null,
                "mfg_wasted_units": null,
                "mfg_production_cost": "0.0000",
                "mfg_is_final": 0,
                "is_created_from_api": 0,
                "essentials_duration": "0.00",
                "essentials_duration_unit": null,
                "essentials_amount_per_unit_duration": "0.0000",
                "essentials_allowances": null,
                "essentials_deductions": null,
                "rp_earned": 0,
                "repair_completed_on": null,
                "repair_warranty_id": null,
                "repair_brand_id": null,
                "repair_status_id": null,
                "repair_model_id": null,
                "repair_defects": null,
                "repair_serial_no": null,
                "repair_updates_email": 0,
                "repair_updates_sms": 0,
                "repair_checklist": null,
                "repair_security_pwd": null,
                "repair_security_pattern": null,
                "repair_due_date": null,
                "repair_device_id": null,
                "order_addresses": null,
                "is_recurring": 0,
                "recur_interval": null,
                "recur_interval_type": null,
                "recur_repetitions": null,
                "recur_stopped_on": null,
                "recur_parent_id": null,
                "invoice_token": null,
                "pay_term_number": null,
                "pay_term_type": null,
                "pjt_project_id": null,
                "pjt_title": null,
                "woocommerce_order_id": null,
                "selling_price_group_id": null,
                "created_at": "2018-01-06 07:06:11",
                "updated_at": "2018-01-06 07:06:11",
                "sell_lines": [
                    {
                        "id": 1,
                        "transaction_id": 6,
                        "product_id": 2,
                        "variation_id": 3,
                        "quantity": 10,
                        "mfg_waste_percent": "0.0000",
                        "quantity_returned": "0.0000",
                        "unit_price_before_discount": "70.0000",
                        "unit_price": "70.0000",
                        "line_discount_type": null,
                        "line_discount_amount": "0.0000",
                        "unit_price_inc_tax": "77.0000",
                        "item_tax": "7.0000",
                        "tax_id": 1,
                        "discount_id": null,
                        "lot_no_line_id": null,
                        "sell_line_note": null,
                        "res_service_staff_id": null,
                        "res_line_order_status": null,
                        "woocommerce_line_items_id": null,
                        "parent_sell_line_id": null,
                        "children_type": "",
                        "sub_unit_id": null,
                        "created_at": "2018-01-06 07:06:11",
                        "updated_at": "2018-01-06 07:06:11"
                    }
                ],
                "payment_lines": [
                    {
                        "id": 1,
                        "transaction_id": 6,
                        "business_id": null,
                        "is_return": 0,
                        "amount": "770.0000",
                        "method": "cash",
                        "transaction_no": null,
                        "card_transaction_number": null,
                        "card_number": null,
                        "card_type": "visa",
                        "card_holder_name": null,
                        "card_month": null,
                        "card_year": null,
                        "card_security": null,
                        "cheque_number": null,
                        "bank_account_number": null,
                        "paid_on": "2018-01-09 17:30:35",
                        "created_by": 1,
                        "payment_for": null,
                        "parent_id": null,
                        "note": null,
                        "document": null,
                        "payment_ref_no": null,
                        "account_id": null,
                        "created_at": "2018-01-06 01:36:11",
                        "updated_at": "2018-01-06 01:36:11"
                    }
                ]
            }
        ],
        "links": {
            "first": "http://local.pos.com/connector/api/sell?page=1",
            "last": "http://local.pos.com/connector/api/sell?page=6",
            "prev": null,
            "next": "http://local.pos.com/connector/api/sell?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "path": "http://local.pos.com/connector/api/sell",
            "per_page": 10,
            "to": 10
        }
    }
     *
     */
    public function index()
    {
        //TODO::order by
        $user = Auth::user();
        $business_id = $user->business_id;

        $filters = request()->only(['location_id', 'contact_id', 'payment_status', 'start_date', 'end_date', 'user_id', 'service_staff_id', 'only_subscriptions', 'synced_from_woocommerce', 'per_page', 'shipping_status']);
        $query = Transaction::where('business_id', $business_id)
                            ->where('type', 'sell')
                            ->with(['sell_lines', 'payment_lines']);

        $permitted_locations = $user->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('transactions.location_id', $permitted_locations);
        }

        if (!empty($filters['location_id'])) {
            if (!empty($filters['location_id'])) {
                $query->where('transactions.location_id', $filters['location_id']);
            }
        }

        if (!empty($filters['contact_id'])) {
            if (!empty($filters['contact_id'])) {
                $query->where('transactions.contact_id', $filters['contact_id']);
            }
        }

        if (!empty($filters['payment_status'])) {
            if (!empty($filters['payment_status'])) {
                $query->where('transactions.payment_status', $filters['payment_status']);
            }
        }

        if (!empty($filters['start_date'])) {
            if (!empty($filters['start_date'])) {
                $query->whereDate('transactions.transaction_date', '>=', $filters['start_date']);
            }
        }

        if (!empty($filters['end_date'])) {
            if (!empty($filters['end_date'])) {
                $query->whereDate('transactions.transaction_date', '<=', $filters['end_date']);
            }
        }

        if (!empty($filters['user_id'])) {
            if (!empty($filters['user_id'])) {
                $query->where('transactions.created_by', $filters['user_id']);
            }
        }

        if (!empty($filters['service_staff_id'])) {
            if (!empty($filters['service_staff_id'])) {
                $query->where('transactions.res_waiter_id', $filters['service_staff_id']);
            }
        }

        if (!empty($filters['shipping_status'])) {
            if (!empty($filters['shipping_status'])) {
                $query->where('transactions.shipping_status', $filters['shipping_status']);
            }
        }

        if (!empty($filters['only_subscriptions']) && $filters['only_subscriptions'] == 1) {
            $query->where(function ($q) {
                $q->whereNotNull('transactions.recur_parent_id')
                    ->orWhere('transactions.is_recurring', 1);
            });
        }

        if (!empty($filters['synced_from_woocommerce']) && $filters['synced_from_woocommerce'] == 1) {
            $query->whereNotNull('transactions.woocommerce_order_id');
        }

        $perPage = !empty($filters['per_page']) ? $filters['per_page'] : $this->perPage;
        if ($perPage == -1) {
            $sells = $query->get();
        } else {
            $sells = $query->simplePaginate($perPage)->appends($filters);
        }

        return SellResource::collection($sells);

    }

    /**
     * Get the specified sell
     * @urlParam sell required comma separated ids of the sells Example: 55
     *
     * @response {
        "data": [
            {
                "id": 55,
                "business_id": 1,
                "location_id": 1,
                "res_table_id": 5,
                "res_waiter_id": null,
                "res_order_status": null,
                "type": "sell",
                "sub_type": null,
                "status": "final",
                "is_quotation": 0,
                "payment_status": "paid",
                "adjustment_type": null,
                "contact_id": 1,
                "customer_group_id": null,
                "invoice_no": "AS0007",
                "ref_no": "",
                "subscription_no": null,
                "subscription_repeat_on": null,
                "transaction_date": "2020-06-04 23:29:36",
                "total_before_tax": "437.5000",
                "tax_id": 1,
                "tax_amount": "39.3750",
                "discount_type": "percentage",
                "discount_amount": "10.0000",
                "rp_redeemed": 0,
                "rp_redeemed_amount": "0.0000",
                "shipping_details": "Express Delivery",
                "shipping_address": null,
                "shipping_status": "ordered",
                "delivered_to": "Mr Robin",
                "shipping_charges": "10.0000",
                "additional_notes": null,
                "staff_note": null,
                "round_off_amount": "0.0000",
                "final_total": "453.1300",
                "expense_category_id": null,
                "expense_for": null,
                "commission_agent": null,
                "document": null,
                "is_direct_sale": 0,
                "is_suspend": 0,
                "exchange_rate": "1.000",
                "total_amount_recovered": null,
                "transfer_parent_id": null,
                "return_parent_id": null,
                "opening_stock_product_id": null,
                "created_by": 9,
                "import_batch": null,
                "import_time": null,
                "types_of_service_id": 1,
                "packing_charge": "10.0000",
                "packing_charge_type": "fixed",
                "service_custom_field_1": null,
                "service_custom_field_2": null,
                "service_custom_field_3": null,
                "service_custom_field_4": null,
                "mfg_parent_production_purchase_id": null,
                "mfg_wasted_units": null,
                "mfg_production_cost": "0.0000",
                "mfg_is_final": 0,
                "is_created_from_api": 0,
                "essentials_duration": "0.00",
                "essentials_duration_unit": null,
                "essentials_amount_per_unit_duration": "0.0000",
                "essentials_allowances": null,
                "essentials_deductions": null,
                "rp_earned": 0,
                "repair_completed_on": null,
                "repair_warranty_id": null,
                "repair_brand_id": null,
                "repair_status_id": null,
                "repair_model_id": null,
                "repair_defects": null,
                "repair_serial_no": null,
                "repair_updates_email": 0,
                "repair_updates_sms": 0,
                "repair_checklist": null,
                "repair_security_pwd": null,
                "repair_security_pattern": null,
                "repair_due_date": null,
                "repair_device_id": null,
                "order_addresses": null,
                "is_recurring": 0,
                "recur_interval": null,
                "recur_interval_type": "days",
                "recur_repetitions": 0,
                "recur_stopped_on": null,
                "recur_parent_id": null,
                "invoice_token": null,
                "pay_term_number": null,
                "pay_term_type": null,
                "pjt_project_id": null,
                "pjt_title": null,
                "woocommerce_order_id": null,
                "selling_price_group_id": 0,
                "created_at": "2020-06-04 23:29:36",
                "updated_at": "2020-06-04 23:29:36",
                "sell_lines": [
                    {
                        "id": 38,
                        "transaction_id": 55,
                        "product_id": 17,
                        "variation_id": 58,
                        "quantity": 1,
                        "mfg_waste_percent": "0.0000",
                        "quantity_returned": "0.0000",
                        "unit_price_before_discount": "437.5000",
                        "unit_price": "437.5000",
                        "line_discount_type": "fixed",
                        "line_discount_amount": "0.0000",
                        "unit_price_inc_tax": "437.5000",
                        "item_tax": "0.0000",
                        "tax_id": null,
                        "discount_id": null,
                        "lot_no_line_id": null,
                        "sell_line_note": "",
                        "res_service_staff_id": null,
                        "res_line_order_status": null,
                        "woocommerce_line_items_id": null,
                        "parent_sell_line_id": null,
                        "children_type": "",
                        "sub_unit_id": null,
                        "created_at": "2020-06-04 23:29:36",
                        "updated_at": "2020-06-04 23:29:36"
                    }
                ],
                "payment_lines": [
                    {
                        "id": 37,
                        "transaction_id": 55,
                        "business_id": 1,
                        "is_return": 0,
                        "amount": "453.1300",
                        "method": "cash",
                        "transaction_no": null,
                        "card_transaction_number": null,
                        "card_number": null,
                        "card_type": "credit",
                        "card_holder_name": null,
                        "card_month": null,
                        "card_year": null,
                        "card_security": null,
                        "cheque_number": null,
                        "bank_account_number": null,
                        "paid_on": "2020-06-04 23:29:36",
                        "created_by": 9,
                        "payment_for": 1,
                        "parent_id": null,
                        "note": null,
                        "document": null,
                        "payment_ref_no": "SP2020/0002",
                        "account_id": null,
                        "created_at": "2020-06-04 23:29:36",
                        "updated_at": "2020-06-04 23:29:36"
                    }
                ]
            }
        ]
    }
     */
    public function show($sell_ids)
    {
        $user = Auth::user();

        $business_id = $user->business_id;
        $sell_ids = explode(',', $sell_ids);

        $sells = Transaction::where('business_id', $business_id)
                        ->whereIn('id', $sell_ids)
                        ->with(['sell_lines', 'payment_lines'])
                        ->get();

        return SellResource::collection($sells);
    }

    /**
    * Create sell
    *
    * @bodyParam sells.*.location_id int required id of the business location
    * @bodyParam sells.*.contact_id int required id of the customer
    * @bodyParam sells.*.transaction_date string transaction date format:Y-m-d H:i:s, Example: 2020-07-22 15:48:29
    * @bodyParam sells.*.invoice_no string Invoice number
    * @bodyParam sells.*.status string sale status (final, draft) Example: final
    * @bodyParam sells.*.tax_rate_id int id of the tax rate applicable to the sale
    * @bodyParam sells.*.discount_amount float discount amount applicable to the sale Example:10.00
    * @bodyParam sells.*.discount_type string  type of the discount amount (fixed, percentage) Example: fixed
    * @bodyParam sells.*.sale_note string
    * @bodyParam sells.*.staff_note string
    * @bodyParam sells.*.commission_agent int commission agent id
    * @bodyParam sells.*.shipping_details string shipping details Example: Express Delivery
    * @bodyParam sells.*.shipping_address string shipping address
    * @bodyParam sells.*.shipping_status string ('ordered', 'packed', 'shipped', 'delivered', 'cancelled') Example: ordered
    * @bodyParam sells.*.delivered_to string Name of the person recieved the consignment Example:'Mr robin'
    * @bodyParam sells.*.shipping_charges float shipping amount Example:10.0000
    * @bodyParam sells.*.packing_charge float packing charge Example:10
    * @bodyParam sells.*.exchange_rate float exchange rate for the currency used Example: 1
    * @bodyParam sells.*.selling_price_group_id int id of the selling price group
    * @bodyParam sells.*.pay_term_number int pay term value Example:3
    * @bodyParam sells.*.pay_term_type string type of the pay term value ('days', 'months') Example: months
    * @bodyParam sells.*.is_recurring int whether the invoice is recurring (0, 1) Example: 0
    * @bodyParam sells.*.recur_interval int value of the interval invoice will be regenerated
    * @bodyParam sells.*.recur_interval_type string type of the recur interval ('days', 'months', 'years') Example: months
    * @bodyParam sells.*.subscription_repeat_on int day of the month on which invoice will be generated if recur interval type is months (1-30) Example: 15
    * @bodyParam sells.*.subscription_no string subscription number
    * @bodyParam sells.*.recur_repetitions int total number of invoices to be generated
    * @bodyParam sells.*.rp_redeemed int reward points redeemed
    * @bodyParam sells.*.rp_redeemed_amount float reward point redeemed amount after conversion Example: 13.5000
    * @bodyParam sells.*.types_of_service_id int types of service id
    * @bodyParam sells.*.service_custom_field_1 string types of service custom field 1
    * @bodyParam sells.*.service_custom_field_2 string types of service custom field 2
    * @bodyParam sells.*.service_custom_field_3 string types of service custom field 3
    * @bodyParam sells.*.service_custom_field_4 string types of service custom field 4
    * @bodyParam sells.*.round_off_amount float round off amount on total payable
    * @bodyParam sells.*.table_id int id of the table
    * @bodyParam sells.*.service_staff_id int id of the service staff assigned to the sale
    * @bodyParam sells.*.change_return float Excess paid amount Example:0.0000
    * @bodyParam sells.*.products array required array of the products for the sale
    * @bodyParam sells.*.payments array payment lines for the sale
    *
    *
    * @bodyParam sells.*.products.*.product_id int required product id Example:17
    * @bodyParam sells.*.products.*.variation_id int required variation id Example:58
    * @bodyParam sells.*.products.*.quantity float required quantity Example: 1
    * @bodyParam sells.*.products.*.unit_price float unit selling price Example:437.5000
    * @bodyParam sells.*.products.*.tax_rate_id int tax rate id applicable on the product Example:null
    * @bodyParam sells.*.products.*.discount_amount float discount amount applicable on the product Example:0.0000
    * @bodyParam sells.*.products.*.discount_type string type of discount amount ('fixed', 'percentage') Example: percentage
    * @bodyParam sells.*.products.*.sub_unit_id int sub unit id
    * @bodyParam sells.*.products.*.note string note for the product
    *
    *
    * @bodyParam sells.*.payments.*.amount float required amount of the payment Example: 453.1300
    * @bodyParam sells.*.payments.*.method string payment methods ('cash', 'card', 'cheque', 'bank_transfer', 'other', 'custom_pay_1', 'custom_pay_2', 'custom_pay_3') Example: cash
    * @bodyParam sells.*.payments.*.account_id int account id
    * @bodyParam sells.*.payments.*.card_number string
    * @bodyParam sells.*.payments.*.card_holder_name string
    * @bodyParam sells.*.payments.*.card_transaction_number string
    * @bodyParam sells.*.payments.*.card_type string
    * @bodyParam sells.*.payments.*.card_month string
    * @bodyParam sells.*.payments.*.card_year string
    * @bodyParam sells.*.payments.*.card_security string
    * @bodyParam sells.*.payments.*.transaction_no_1 string
    * @bodyParam sells.*.payments.*.transaction_no_2 string
    * @bodyParam sells.*.payments.*.transaction_no_3 string
    * @bodyParam sells.*.payments.*.bank_account_number string
    * @bodyParam sells.*.payments.*.note string payment note
    * @bodyParam sells.*.payments.*.cheque_number string
    *
    * @response {
        "data": [
            {
                "id": 6,
                "business_id": 1,
                "location_id": 1,
                "res_table_id": null,
                "res_waiter_id": null,
                "res_order_status": null,
                "type": "sell",
                "sub_type": null,
                "status": "final",
                "is_quotation": 0,
                "payment_status": "paid",
                "adjustment_type": null,
                "contact_id": 4,
                "customer_group_id": null,
                "invoice_no": "AS0001",
                "ref_no": "",
                "subscription_no": null,
                "subscription_repeat_on": null,
                "transaction_date": "2018-04-10 13:23:21",
                "total_before_tax": "770.0000",
                "tax_id": null,
                "tax_amount": "0.0000",
                "discount_type": "percentage",
                "discount_amount": "0.0000",
                "rp_redeemed": 0,
                "rp_redeemed_amount": "0.0000",
                "shipping_details": null,
                "shipping_address": null,
                "shipping_status": null,
                "delivered_to": null,
                "shipping_charges": "0.0000",
                "additional_notes": null,
                "staff_note": null,
                "round_off_amount": "0.0000",
                "final_total": "770.0000",
                "expense_category_id": null,
                "expense_for": null,
                "commission_agent": null,
                "document": null,
                "is_direct_sale": 0,
                "is_suspend": 0,
                "exchange_rate": "1.000",
                "total_amount_recovered": null,
                "transfer_parent_id": null,
                "return_parent_id": null,
                "opening_stock_product_id": null,
                "created_by": 1,
                "import_batch": null,
                "import_time": null,
                "types_of_service_id": null,
                "packing_charge": null,
                "packing_charge_type": null,
                "service_custom_field_1": null,
                "service_custom_field_2": null,
                "service_custom_field_3": null,
                "service_custom_field_4": null,
                "mfg_parent_production_purchase_id": null,
                "mfg_wasted_units": null,
                "mfg_production_cost": "0.0000",
                "mfg_is_final": 0,
                "is_created_from_api": 0,
                "essentials_duration": "0.00",
                "essentials_duration_unit": null,
                "essentials_amount_per_unit_duration": "0.0000",
                "essentials_allowances": null,
                "essentials_deductions": null,
                "rp_earned": 0,
                "repair_completed_on": null,
                "repair_warranty_id": null,
                "repair_brand_id": null,
                "repair_status_id": null,
                "repair_model_id": null,
                "repair_defects": null,
                "repair_serial_no": null,
                "repair_updates_email": 0,
                "repair_updates_sms": 0,
                "repair_checklist": null,
                "repair_security_pwd": null,
                "repair_security_pattern": null,
                "repair_due_date": null,
                "repair_device_id": null,
                "order_addresses": null,
                "is_recurring": 0,
                "recur_interval": null,
                "recur_interval_type": null,
                "recur_repetitions": null,
                "recur_stopped_on": null,
                "recur_parent_id": null,
                "invoice_token": null,
                "pay_term_number": null,
                "pay_term_type": null,
                "pjt_project_id": null,
                "pjt_title": null,
                "woocommerce_order_id": null,
                "selling_price_group_id": null,
                "created_at": "2018-01-06 07:06:11",
                "updated_at": "2018-01-06 07:06:11",
                "sell_lines": [
                    {
                        "id": 1,
                        "transaction_id": 6,
                        "product_id": 2,
                        "variation_id": 3,
                        "quantity": 10,
                        "mfg_waste_percent": "0.0000",
                        "quantity_returned": "0.0000",
                        "unit_price_before_discount": "70.0000",
                        "unit_price": "70.0000",
                        "line_discount_type": null,
                        "line_discount_amount": "0.0000",
                        "unit_price_inc_tax": "77.0000",
                        "item_tax": "7.0000",
                        "tax_id": 1,
                        "discount_id": null,
                        "lot_no_line_id": null,
                        "sell_line_note": null,
                        "res_service_staff_id": null,
                        "res_line_order_status": null,
                        "woocommerce_line_items_id": null,
                        "parent_sell_line_id": null,
                        "children_type": "",
                        "sub_unit_id": null,
                        "created_at": "2018-01-06 07:06:11",
                        "updated_at": "2018-01-06 07:06:11"
                    }
                ],
                "payment_lines": [
                    {
                        "id": 1,
                        "transaction_id": 6,
                        "business_id": null,
                        "is_return": 0,
                        "amount": "770.0000",
                        "method": "cash",
                        "transaction_no": null,
                        "card_transaction_number": null,
                        "card_number": null,
                        "card_type": "visa",
                        "card_holder_name": null,
                        "card_month": null,
                        "card_year": null,
                        "card_security": null,
                        "cheque_number": null,
                        "bank_account_number": null,
                        "paid_on": "2018-01-09 17:30:35",
                        "created_by": 1,
                        "payment_for": null,
                        "parent_id": null,
                        "note": null,
                        "document": null,
                        "payment_ref_no": null,
                        "account_id": null,
                        "created_at": "2018-01-06 01:36:11",
                        "updated_at": "2018-01-06 01:36:11"
                    }
                ]
            }
        ]
    }
    */
    public function store(Request $request)
    {
        //TODO::Check customer credit limit
        try {
            $sells = $request->input('sells');
            $user = Auth::user();

            $business_id = $user->business_id;
            $business = Business::find($business_id);
            $commsn_agnt_setting = $business->sales_cmsn_agnt;
            $output = [];

            if (empty($sells) || !is_array($sells)) {
                throw new \Exception("Invalid form data");
            }

            foreach ($sells as $sell_data) {
                try {
                    DB::beginTransaction();
                    $sell_data['business_id'] = $user->business_id;
                    $input = $this->__formatSellData($sell_data);

                    //Check if location allowed
                    if (!$user->can_access_this_location($input['location_id'])) {
                        throw new \Exception("User not allowed to access location with id " . $input['location_id']);
                    }

                    $discount = ['discount_type' => $input['discount_type'],
                            'discount_amount' => $input['discount_amount']
                        ];
                    $invoice_total = $this->productUtil->calculateInvoiceTotal($input['products'], $input['tax_rate_id'], $discount);

                    if ($commsn_agnt_setting == 'logged_in_user') {
                        $input['commission_agent'] = $user->id;
                    }

                    $transaction = $this->transactionUtil->createSellTransaction($user->business_id, $input, $invoice_total, $user->id, false);

                    $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id'], false, null, [], false);
                    //Add change return
                    $change_return = $this->dummyPaymentLine;
                    $change_return['amount'] = $input['change_return'];
                    $change_return['is_return'] = 1;
                    $input['payment'][] = $change_return;

                    if (!empty($input['payment'])) {
                        $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment'], $business_id, $user->id, false);
                    }

                    if ($input['status'] == 'final') {
                        //Check for final and do some processing.
                        //update product stock
                        foreach ($input['products'] as $product) {
                            $decrease_qty = $product['quantity'];
                            if (!empty($product['base_unit_multiplier'])) {
                                $decrease_qty = $decrease_qty * $product['base_unit_multiplier'];
                            }

                            if ($product['enable_stock']) {
                                $this->productUtil->decreaseProductQuantity(
                                    $product['product_id'],
                                    $product['variation_id'],
                                    $input['location_id'],
                                    $decrease_qty
                                );
                            }

                            if ($product['product_type'] == 'combo') {
                                //Decrease quantity of combo as well.
                                $this->productUtil
                                    ->decreaseProductQuantityCombo(
                                        $product['combo'],
                                        $input['location_id']
                                    );
                            }
                        }

                        //Update payment status
                        $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);

                        if ($business->enable_rp == 1) {
                            $redeemed = !empty($input['rp_redeemed']) ? $input['rp_redeemed'] : 0;
                            $this->transactionUtil->updateCustomerRewardPoints($transaction->contact_id, $transaction->rp_earned, 0, $redeemed);
                        }

                        //Allocate the quantity from purchase and add mapping of
                        //purchase & sell lines in
                        //transaction_sell_lines_purchase_lines table
                        $business_details = $this->businessUtil->getDetails($business_id);
                        $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);

                        $business_info = ['id' => $business_id,
                                        'accounting_method' => $business->accounting_method,
                                        'location_id' => $input['location_id'],
                                        'pos_settings' => $pos_settings
                                    ];
                        $this->transactionUtil->mapPurchaseSell($business_info, $transaction->sell_lines, 'purchase');

                        //Auto send notification
                        $this->notificationUtil->autoSendNotification($business_id, 'new_sale', $transaction, $transaction->contact);
                    }

                    DB::commit();
                    $output[] = $transaction;

                }
                catch(ModelNotFoundException $e){
                    DB::rollback();
                    $output[] = $this->modelNotFoundExceptionResult($e);
                }
                catch (\Exception $e) {
                    DB::rollback();
                    $output[] = $this->otherExceptions($e);
                }
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $output;
    }

    /**
    * Update sell
    *
    * @urlParam sell required id of sell to update Example: 6
    * @bodyParam contact_id int id of the customer
    * @bodyParam transaction_date string transaction date format:Y-m-d H:i:s, Example: 2020-5-7 15:20:22
    * @bodyParam status string sale status (final, draft) Example:final
    * @bodyParam tax_rate_id int id of the tax rate applicable to the sale
    * @bodyParam discount_amount float discount amount applicable to the sale Example: 10.0000
    * @bodyParam discount_type string type of the discount amount (fixed, percentage) Example: fixed
    * @bodyParam sale_note string
    * @bodyParam staff_note string
    * @bodyParam commission_agent int commission agent id
    * @bodyParam shipping_details string shipping details Example: Express Delivery
    * @bodyParam shipping_address string shipping address
    * @bodyParam shipping_status string ('ordered', 'packed', 'shipped', 'delivered', 'cancelled') Example:ordered
    * @bodyParam delivered_to string Name of the person recieved the consignment Example: Mr Robin
    * @bodyParam shipping_charges float shipping amount Example: 10.0000
    * @bodyParam packing_charge float packing charge Example: 10.0000
    * @bodyParam exchange_rate float exchange rate for the currency used Example:1
    * @bodyParam selling_price_group_id int id of the selling price group
    * @bodyParam pay_term_number int pay term value
    * @bodyParam pay_term_type string type of the pay term value ('days', 'months') Example: months
    * @bodyParam is_recurring int whether the invoice is recurring (0, 1) Example:0
    * @bodyParam recur_interval int value of the interval invoice will be regenerated
    * @bodyParam recur_interval_type string type of the recur interval ('days', 'months', 'years') Example:days
    * @bodyParam subscription_repeat_on int day of the month on which invoice will be generated if recur interval type is months (1-30) Example:7
    * @bodyParam subscription_no string subscription number
    * @bodyParam recur_repetitions int total number of invoices to be generated
    * @bodyParam rp_redeemed int reward points redeemed
    * @bodyParam rp_redeemed_amount float reward point redeemed amount after conversion Example: 13.5000
    * @bodyParam types_of_service_id int types of service id
    * @bodyParam service_custom_field_1 string types of service custom field 1
    * @bodyParam service_custom_field_2 string types of service custom field 2
    * @bodyParam service_custom_field_3 string types of service custom field 3
    * @bodyParam service_custom_field_4 string types of service custom field 4
    * @bodyParam round_off_amount float round off amount on total payable
    * @bodyParam table_id int id of the table
    * @bodyParam service_staff_id int id of the service staff assigned to the sale
    * @bodyParam change_return float Excess paid amount Example:0.0000
    * @bodyParam change_return_id int id of the change return payment if exists
    * @bodyParam products array required array of the products for the sale
    * @bodyParam payments array payment lines for the sale
    *
    *
    * @bodyParam sell_line_id int sell line id for existing item only
    * @bodyParam products.*.product_id int product id Example: 17
    * @bodyParam products.*.variation_id int variation id Example: 58
    * @bodyParam products.*.quantity float quantity Example: 1
    * @bodyParam products.*.unit_price float unit selling price Example: 437.5000
    * @bodyParam products.*.tax_rate_id int tax rate id applicable on the product
    * @bodyParam products.*.discount_amount float discount amount applicable on the product  Example:0.0000
    * @bodyParam products.*.discount_type string type of discount amount ('fixed', 'percentage') Example: percentage
    * @bodyParam products.*.sub_unit_id int sub unit id
    * @bodyParam products.*.note string note for the product
    *
    *
    * @bodyParam payments.*.payment_id int payment id for existing payment line
    * @bodyParam payments.*.amount float amount of the payment Example:453.1300
    * @bodyParam payments.*.method string payment methods ('cash', 'card', 'cheque', 'bank_transfer', 'other', 'custom_pay_1', 'custom_pay_2', 'custom_pay_3') Example:cash
    * @bodyParam payments.*.account_id int account id
    * @bodyParam payments.*.card_number string
    * @bodyParam payments.*.card_holder_name string
    * @bodyParam payments.*.card_transaction_number string
    * @bodyParam payments.*.card_type string
    * @bodyParam payments.*.card_month string
    * @bodyParam payments.*.card_year string
    * @bodyParam payments.*.card_security string
    * @bodyParam payments.*.transaction_no_1 string
    * @bodyParam payments.*.transaction_no_2 string
    * @bodyParam payments.*.transaction_no_3 string
    * @bodyParam payments.*.note string payment note
    * @bodyParam payments.*.cheque_number string
    * @bodyParam payments.*.bank_account_number string
    *
    * @response {
        "id": 91,
        "business_id": 1,
        "location_id": 1,
        "res_table_id": null,
        "res_waiter_id": null,
        "res_order_status": null,
        "type": "sell",
        "sub_type": null,
        "status": "final",
        "is_quotation": 0,
        "payment_status": "paid",
        "adjustment_type": null,
        "contact_id": 1,
        "customer_group_id": 1,
        "invoice_no": "AS0020",
        "ref_no": "",
        "subscription_no": null,
        "subscription_repeat_on": null,
        "transaction_date": "25-09-2020 15:22",
        "total_before_tax": 962.5,
        "tax_id": null,
        "tax_amount": 0,
        "discount_type": "fixed",
        "discount_amount": "19.5000",
        "rp_redeemed": 0,
        "rp_redeemed_amount": "0.0000",
        "shipping_details": null,
        "shipping_address": null,
        "shipping_status": null,
        "delivered_to": null,
        "shipping_charges": "0.0000",
        "additional_notes": null,
        "staff_note": null,
        "round_off_amount": "0.0000",
        "final_total": 943,
        "expense_category_id": null,
        "expense_for": null,
        "commission_agent": null,
        "document": null,
        "is_direct_sale": 0,
        "is_suspend": 0,
        "exchange_rate": "1.000",
        "total_amount_recovered": null,
        "transfer_parent_id": null,
        "return_parent_id": null,
        "opening_stock_product_id": null,
        "created_by": 9,
        "import_batch": null,
        "import_time": null,
        "types_of_service_id": null,
        "packing_charge": "0.0000",
        "packing_charge_type": null,
        "service_custom_field_1": null,
        "service_custom_field_2": null,
        "service_custom_field_3": null,
        "service_custom_field_4": null,
        "mfg_parent_production_purchase_id": null,
        "mfg_wasted_units": null,
        "mfg_production_cost": "0.0000",
        "mfg_production_cost_type": "percentage",
        "mfg_is_final": 0,
        "is_created_from_api": 0,
        "essentials_duration": "0.00",
        "essentials_duration_unit": null,
        "essentials_amount_per_unit_duration": "0.0000",
        "essentials_allowances": null,
        "essentials_deductions": null,
        "rp_earned": 0,
        "repair_completed_on": null,
        "repair_warranty_id": null,
        "repair_brand_id": null,
        "repair_status_id": null,
        "repair_model_id": null,
        "repair_job_sheet_id": null,
        "repair_defects": null,
        "repair_serial_no": null,
        "repair_checklist": null,
        "repair_security_pwd": null,
        "repair_security_pattern": null,
        "repair_due_date": null,
        "repair_device_id": null,
        "repair_updates_notif": 0,
        "order_addresses": null,
        "is_recurring": 0,
        "recur_interval": 1,
        "recur_interval_type": "days",
        "recur_repetitions": 0,
        "recur_stopped_on": null,
        "recur_parent_id": null,
        "invoice_token": null,
        "pay_term_number": null,
        "pay_term_type": null,
        "pjt_project_id": null,
        "pjt_title": null,
        "woocommerce_order_id": null,
        "selling_price_group_id": 0,
        "created_at": "2020-09-23 20:16:19",
        "updated_at": "2020-09-25 17:57:08",
        "payment_lines": [
            {
                "id": 55,
                "transaction_id": 91,
                "business_id": 1,
                "is_return": 0,
                "amount": "461.7500",
                "method": "cash",
                "transaction_no": null,
                "card_transaction_number": null,
                "card_number": null,
                "card_type": "credit",
                "card_holder_name": null,
                "card_month": null,
                "card_year": null,
                "card_security": null,
                "cheque_number": null,
                "bank_account_number": null,
                "paid_on": "2020-09-23 20:16:19",
                "created_by": 9,
                "is_advance": 0,
                "payment_for": 1,
                "parent_id": null,
                "note": null,
                "document": null,
                "payment_ref_no": "SP2020/0018",
                "account_id": null,
                "created_at": "2020-09-23 20:16:19",
                "updated_at": "2020-09-23 20:16:19"
            }
        ]
    }
    */
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();

            $business_id = $user->business_id;
            $business = Business::find($business_id);

            $sell_data = $request->input();
            $sell_data['business_id'] = $user->business_id;

            $transaction_before = Transaction::where('business_id', $user->business_id)->with(['payment_lines'])
                                    ->findOrFail($id);

            //Check if location allowed
            if (!$user->can_access_this_location($transaction_before->location_id)) {
                throw new \Exception("User not allowed to access location with id " . $input['location_id']);
            }

            $status_before =  $transaction_before->status;
            $rp_earned_before = $transaction_before->rp_earned;
            $rp_redeemed_before = $transaction_before->rp_redeemed;

            $sell_data['location_id'] = $transaction_before->location_id;
            $input = $this->__formatSellData($sell_data, $transaction_before);
            $discount = ['discount_type' => $input['discount_type'],
                                'discount_amount' => $input['discount_amount']
                            ];
            $invoice_total = $this->productUtil->calculateInvoiceTotal($input['products'], $input['tax_rate_id'], $discount);

            //Begin transaction
            DB::beginTransaction();

            $transaction = $this->transactionUtil->updateSellTransaction($transaction_before, $business_id, $input, $invoice_total, $user->id, false);

            //Update Sell lines
            $deleted_lines = $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id'], true, $status_before, [], false);
            if (!empty($input['payment'])) {

                $change_return = $this->dummyPaymentLine;
                $change_return['amount'] = $input['change_return'];
                $change_return['is_return'] = 1;
                if (!empty($input['change_return_id'])) {
                    $change_return['id'] = $input['change_return_id'];
                }
                $input['payment'][] = $change_return;

               $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment'], $business_id, $user->id, false);
            }

            if ($business->enable_rp == 1) {
                $this->transactionUtil->updateCustomerRewardPoints($transaction->contact_id, $transaction->rp_earned, $rp_earned_before, $transaction->rp_redeemed, $rp_redeemed_before);
            }

            //Update payment status
            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);

            //Update product stock
            $this->productUtil->adjustProductStockForInvoice($status_before, $transaction, $input, false);

            //Allocate the quantity from purchase and add mapping of
            //purchase & sell lines in
            //transaction_sell_lines_purchase_lines table
            $business_details = $this->businessUtil->getDetails($business_id);
            $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);

            $business = ['id' => $business_id,
                            'accounting_method' => $business->accounting_method,
                            'location_id' => $input['location_id'],
                            'pos_settings' => $pos_settings
                        ];
            $this->transactionUtil->adjustMappingPurchaseSell($status_before, $transaction, $business, $deleted_lines);
            DB::commit();

            $updated_transaction = Transaction::where('business_id', $user->business_id)->with(['payment_lines'])
                                    ->findOrFail($id);
            $output = $updated_transaction;
        } catch(ModelNotFoundException $e){
            DB::rollback();
            $output = $this->modelNotFoundExceptionResult($e);
        }
        catch (\Exception $e) {
            DB::rollback();
            $output = $this->otherExceptions($e);
        }

        return $output;
    }

    private function __getValue($key, $data, $obj, $default = null, $db_key = null)
    {
        $value = $default;

        if (isset($data[$key])) {
            $value = $data[$key];
        } else if (!empty($obj)) {
            $key = !empty($db_key) ? $db_key : $key;
            $value = $obj->$key;
        }

        return $value;
    }

    /**
     * Formats input form data to sell data
     * @param  array $data
     * @return array
     */
    private function __formatSellData($data, $transaction = null)
    {

        $business_id = $data['business_id'];
        $location = BusinessLocation::where('business_id', $business_id)
                                    ->findOrFail($data['location_id']);

        $customer_id = $this->__getValue('contact_id', $data, $transaction, null);
        $contact = Contact::where('business_id', $data['business_id'])
                            ->whereIn('type', ['customer', 'both'])
                            ->findOrFail($customer_id);

        $cg = $this->contactUtil->getCustomerGroup($business_id, $contact->id);
        $customer_group_id = (empty($cg) || empty($cg->id)) ? null : $cg->id;
        $formated_data = [
            'business_id' => $business_id,
            'location_id' => $location->id,
            'contact_id' => $contact->id,
            'customer_group_id' => $customer_group_id,
            'transaction_date' => $this->__getValue('transaction_date', $data,
                                $transaction,  \Carbon::now()->toDateTimeString()),
            'invoice_no' => $this->__getValue('invoice_no', $data, $transaction, null, 'invoice_no'),
            'status' => $this->__getValue('status', $data, $transaction, 'final'),
            'sale_note' => $this->__getValue('sale_note', $data, $transaction),
            'staff_note' => $this->__getValue('staff_note', $data, $transaction),
            'commission_agent' => $this->__getValue('commission_agent',
                                    $data, $transaction),
            'shipping_details' => $this->__getValue('shipping_details',
                                    $data, $transaction),
            'shipping_address' => $this->__getValue('shipping_address',
                                $data, $transaction),
            'shipping_status' => $this->__getValue('shipping_status', $data, $transaction),
            'delivered_to' => $this->__getValue('delivered_to', $data, $transaction),
            'shipping_charges' => $this->__getValue('shipping_charges', $data,
                $transaction, 0),
            'exchange_rate' => $this->__getValue('exchange_rate', $data, $transaction, 1),
            'selling_price_group_id' => $this->__getValue('selling_price_group_id', $data, $transaction),
            'pay_term_number' => $this->__getValue('pay_term_number', $data, $transaction),
            'pay_term_type' => $this->__getValue('pay_term_type', $data, $transaction),
            'is_recurring' => $this->__getValue('is_recurring', $data, $transaction, 0),
            'recur_interval' => $this->__getValue('recur_interval', $data, $transaction),
            'recur_interval_type' => $this->__getValue('recur_interval_type', $data, $transaction),
            'subscription_repeat_on' => $this->__getValue('subscription_repeat_on', $data, $transaction),
            'subscription_no' => $this->__getValue('subscription_no', $data, $transaction),
            'recur_repetitions' => $this->__getValue('recur_repetitions', $data, $transaction, 0),
            'order_addresses' => $this->__getValue('order_addresses', $data, $transaction),
            'rp_redeemed' => $this->__getValue('rp_redeemed', $data, $transaction, 0),
            'rp_redeemed_amount' => $this->__getValue('rp_redeemed_amount', $data, $transaction, 0),
            'is_created_from_api' => 1,
            'types_of_service_id' => $this->__getValue('types_of_service_id', $data, $transaction),
            'packing_charge' => $this->__getValue('packing_charge', $data, $transaction, 0),
            'packing_charge_type' => $this->__getValue('packing_charge_type', $data, $transaction),
            'service_custom_field_1' => $this->__getValue('service_custom_field_1', $data, $transaction),
            'service_custom_field_2' => $this->__getValue('service_custom_field_2', $data, $transaction),
            'service_custom_field_3' => $this->__getValue('service_custom_field_3', $data, $transaction),
            'service_custom_field_4' => $this->__getValue('service_custom_field_4', $data, $transaction),
            'round_off_amount' => $this->__getValue('round_off_amount', $data, $transaction),
            'res_table_id' => $this->__getValue('table_id', $data, $transaction, null, 'res_table_id'),
            'res_waiter_id' => $this->__getValue('service_staff_id', $data, $transaction, null, 'res_waiter_id'),
            'change_return' => $this->__getValue('change_return', $data, $transaction, 0),
            'change_return_id' => $this->__getValue('change_return_id', $data, $transaction, null),
        ];

        //Generate reference number
        if (!empty($formated_data['is_recurring'])) {
            //Update reference count
            $ref_count = $this->transactionUtil->setAndGetReferenceCount('subscription');
            $formated_data['subscription_no'] = $this->transactionUtil->generateReferenceNumber('subscription', $ref_count);
        }

        $sell_lines = [];
        $subtotal = 0;

        if (!empty($data['products'])) {
            foreach ($data['products'] as $product_data) {

                $sell_line = null;
                if (!empty($product_data['sell_line_id'])) {
                    $sell_line = TransactionSellLine::findOrFail($product_data['sell_line_id']);
                }

                $product_id = $this->__getValue('product_id', $product_data, $sell_line);
                $variation_id = $this->__getValue('variation_id', $product_data, $sell_line);
                $product = Product::where('business_id', $business_id)
                                ->with(['variations'])
                                ->findOrFail($product_id);

                $variation = $product->variations->where('id', $variation_id)->first();

                //Calculate line discount
                $unit_price =  $this->__getValue('unit_price', $product_data, $sell_line, $variation->sell_price_inc_tax, 'unit_price_before_discount');

                $discount_amount = $this->__getValue('discount_amount', $product_data, $sell_line, 0, 'line_discount_amount');

                $line_discount = $discount_amount;
                $line_discount_type = $this->__getValue('discount_type', $product_data, $sell_line, 'fixed', 'line_discount_type');

                if ($line_discount_type == 'percentage') {
                    $line_discount = $this->transactionUtil->calc_percentage($unit_price, $discount_amount);
                }
                $discounted_price = $unit_price - $line_discount;

                //calculate line tax
                $item_tax = 0;
                $unit_price_inc_tax = $discounted_price;
                $tax_id = $this->__getValue('tax_rate_id', $product_data, $sell_line, null, 'tax_id');
                if (!empty($tax_id)) {
                    $tax = TaxRate::where('business_id', $business_id)
                                ->findOrFail($tax_id);

                    $item_tax = $this->transactionUtil->calc_percentage($discounted_price, $tax->amount);
                    $unit_price_inc_tax += $item_tax;
                }

                $formated_sell_line = [
                    'product_id' => $product->id,
                    'variation_id' => $variation->id,
                    'product_type' => $product->type,
                    'unit_price' => $unit_price,
                    'line_discount_type' => $line_discount_type,
                    'line_discount_amount' => $discount_amount,
                    'tax_id' => $tax_id,
                    'item_tax' => $item_tax,
                    'sell_line_note' => $this->__getValue('note', $product_data, $sell_line, null, 'sell_line_note'),
                    'enable_stock' => $product->enable_stock,
                    'quantity' => $this->__getValue('quantity', $product_data,
                                        $sell_line, 0),
                    'product_unit_id' => $product->unit_id,
                    'sub_unit_id' => $this->__getValue('sub_unit_id', $product_data,
                                        $sell_line),
                    'unit_price_inc_tax' => $unit_price_inc_tax
                ];
                if (!empty($sell_line)) {
                    $formated_sell_line['transaction_sell_lines_id'] = $sell_line->id;
                }

                if (($formated_sell_line['product_unit_id'] != $formated_sell_line['sub_unit_id']) && !empty($formated_sell_line['sub_unit_id']) ) {
                    $sub_unit = Unit::where('business_id', $business_id)
                                    ->findOrFail($formated_sell_line['sub_unit_id']);
                    $formated_sell_line['base_unit_multiplier'] = $sub_unit->base_unit_multiplier;
                } else {
                    $formated_sell_line['base_unit_multiplier'] = 1;
                }

                //Combo product
                if ($product->type == 'combo') {
                    $combo_variations = $this->productUtil->calculateComboDetails($location->id, $variation->combo_variations);
                    foreach ($combo_variations as $key => $value) {
                        $combo_variations[$key]['quantity'] = $combo_variations[$key]['qty_required'] * $formated_sell_line['quantity'] * $formated_sell_line['base_unit_multiplier'];
                    }

                    $formated_sell_line['combo'] = $combo_variations;
                }

                $line_total = $unit_price_inc_tax * $formated_sell_line['quantity'];

                $sell_lines[] = $formated_sell_line;

                $subtotal += $line_total;
            }
        }

        $formated_data['products'] = $sell_lines;

        //calculate sell discount and tax
        $order_discount_amount = $this->__getValue('discount_amount', $data, $transaction, 0);
        $order_discount_type = $this->__getValue('discount_type', $data, $transaction, 'fixed');
        $order_discount = $order_discount_amount;
        if ($order_discount_type == 'percentage') {
            $order_discount = $this->transactionUtil->calc_percentage($subtotal, $order_discount_amount);
        }
        $discounted_total = $subtotal - $order_discount;

        //calculate line tax
        $order_tax = 0;
        $final_total = $discounted_total;
        $order_tax_id = $this->__getValue('tax_rate_id', $data, $transaction);
        if (!empty($order_tax_id)) {
            $tax = TaxRate::where('business_id', $business_id)
                        ->findOrFail($order_tax_id);

            $order_tax = $this->transactionUtil->calc_percentage($discounted_total, $tax->amount);
            $final_total += $order_tax;
        }

        $formated_data['discount_amount'] = $order_discount_amount;
        $formated_data['discount_type'] = $order_discount_type;
        $formated_data['tax_rate_id'] = $order_tax_id;
        $formated_data['tax_calculation_amount'] = $order_tax;

        $final_total += $formated_data['shipping_charges'];

        if (!empty($formated_data['packing_charge']) && !empty($formated_data['types_of_service_id'])) {
            $final_total += $formated_data['packing_charge'];
        }

        $formated_data['final_total'] = $final_total;

        $payments = [];
        if (!empty($data['payments'])) {
            foreach ($data['payments'] as $payment_data) {
                $transaction_payment =  null;
                if (!empty($payment_data['payment_id'])) {
                    $transaction_payment = TransactionPayment::findOrFail($payment_data['payment_id']);
                }
                $payment = [
                    'amount' => $this->__getValue('amount', $payment_data, $transaction_payment),
                    'method' => $this->__getValue('method', $payment_data, $transaction_payment),
                    'account_id' => $this->__getValue('account_id', $payment_data, $transaction_payment),
                    'card_number' => $this->__getValue('card_number', $payment_data, $transaction_payment),
                    'card_holder_name' => $this->__getValue('card_holder_name', $payment_data, $transaction_payment),
                    'card_transaction_number' => $this->__getValue('card_transaction_number', $payment_data, $transaction_payment),
                    'card_type' => $this->__getValue('card_type', $payment_data, $transaction_payment),
                    'card_month' => $this->__getValue('card_month', $payment_data, $transaction_payment),
                    'card_year' => $this->__getValue('card_year', $payment_data, $transaction_payment),
                    'card_security' => $this->__getValue('card_security', $payment_data, $transaction_payment),
                    'cheque_number' => $this->__getValue('cheque_number', $payment_data, $transaction_payment),
                    'bank_account_number' => $this->__getValue('bank_account_number', $payment_data, $transaction_payment),
                    'transaction_no_1' => $this->__getValue('transaction_no_1', $payment_data, $transaction_payment),
                    'transaction_no_2' => $this->__getValue('transaction_no_2', $payment_data, $transaction_payment),
                    'transaction_no_3' => $this->__getValue('transaction_no_3', $payment_data, $transaction_payment),
                    'note' => $this->__getValue('note', $payment_data, $transaction_payment),
                ];
                if (!empty($transaction_payment)) {
                    $payment['payment_id'] = $transaction_payment->id;
                }

                $payments[] = $payment;
            }

            $formated_data['payment'] = $payments;
        }
        return $formated_data;
    }

    /**
     * Delete Sell
     *
     * @urlParam sell required id of the sell to be deleted
     *
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $business_id = $user->business_id;
            //Begin transaction
            DB::beginTransaction();

            $output = $this->transactionUtil->deleteSale($business_id, $id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output['success'] = false;
            $output['msg'] = trans("messages.something_went_wrong");
        }

        return $output;
    }

    /**
    * Update shipping status
    *
    * @bodyParam id int required id of the sale
    * @bodyParam shipping_status string ('ordered', 'packed', 'shipped', 'delivered', 'cancelled') Example:ordered
    * @bodyParam delivered_to string Name of the consignee
    */
    public function updateSellShippingStatus(Request $request)
    {
        try {
            $user = Auth::user();
            $business_id = $user->business_id;

            $sell_id = $request->input('id');
            $shipping_status = $request->input('shipping_status');
            $delivered_to = $request->input('delivered_to');
            $shipping_statuses = $this->transactionUtil->shipping_statuses();
            if (array_key_exists($shipping_status, $shipping_statuses)) {
                Transaction::where('business_id', $business_id)
                    ->where('id', $sell_id)
                    ->where('type', 'sell')
                    ->update(['shipping_status' => $shipping_status, 'delivered_to' => $delivered_to]);
            } else {
                return $this->otherExceptions('Invalid shipping status');
            }

            return $this->respond(['success' => 1,
                    'msg' => trans("lang_v1.updated_success")
                ]);

        } catch (\Exception $e) {
            return $this->otherExceptions($e);
        }
    }
}
