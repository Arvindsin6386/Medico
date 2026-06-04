<?php

namespace App\Http\Controllers\Admin;

use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Sale;
use App\Models\Medicine;
use App\Models\Customer;

class BillingController extends Controller
{
    public function index()
    {
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name')->get();
        return view('admin.billing.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $total_amount = 0;

        /*
    |--------------------------------------------------------------------------
    | Find Customer By Phone
    |--------------------------------------------------------------------------
    */
        $customer = Customer::where(
            'phone',
            $request->customer_phone
        )->first();

        /*
    |--------------------------------------------------------------------------
    | Create Customer If Not Exists
    |--------------------------------------------------------------------------
    */
        if (!$customer) {

            $customerCode = IdGenerator::generate([
                'table'  => 'customers',
                'field'  => 'customer_id',
                'length' => 8,
                'prefix' => 'CUS'
            ]);

            $customer = Customer::create([
                'customer_id' => $customerCode,
                'name'        => $request->customer_name,
                'phone'       => $request->customer_phone,
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Generate Bill Number
    |--------------------------------------------------------------------------
    */
        $billNumber = IdGenerator::generate([
            'table'  => 'bills',
            'field'  => 'bill_number',
            'length' => 10,
            'prefix' => 'BILL'
        ]);

        /*
    |--------------------------------------------------------------------------
    | Create Bill
    |--------------------------------------------------------------------------
    */
        $bill = Bill::create([
            'bill_number'     => $billNumber,

            // Customer Relation
            'customer_id'     => $customer->id,
            'customer_name'   => $customer->name,
            'customer_phone'  => $customer->phone,
            'subtotal'        => 0,
            'tax'             => 0,
            'tax_percentage'  => 0,
            'total_amount'    => 0,
        ]);

        /*
    |--------------------------------------------------------------------------
    | Save Medicines
    |--------------------------------------------------------------------------
    */
        foreach ($request->medicine_id as $key => $medicineId) {

            $medicine = Medicine::findOrFail($medicineId);

            $qty = $request->quantity[$key];

            $price = $medicine->selling_price;

            $subtotal = $price * $qty;

            $total_amount += $subtotal;

            BillItem::create([
                'bill_id'        => $bill->id,
                'medicine_id'    => $medicine->id,
                'medicine_name'  => $medicine->name,
                'quantity'       => $qty,
                'unit_price'     => $price,
                'subtotal'       => $subtotal,
            ]);

            // Reduce Stock
            $medicine->decrement('stock', $qty);
        }

        /*
    |--------------------------------------------------------------------------
    | Tax Calculation
    |--------------------------------------------------------------------------
    */
        $taxPercentage = 5;

        $tax = ($total_amount * $taxPercentage) / 100;

        $finalTotal = $total_amount + $tax;

        /*
    |--------------------------------------------------------------------------
    | Update Bill Totals
    |--------------------------------------------------------------------------
    */
        $bill->update([
            'subtotal'       => $total_amount,
            'tax'            => $tax,
            'tax_percentage' => $taxPercentage,
            'total_amount'   => $finalTotal,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Bill Created Successfully');
    }


    public function customerSearch(Request $request)
    {
        $search = $request->search;
        $customers = Customer::where('phone', 'LIKE', '%' . $search . '%')->get();

        return response()->json($customers);
    }
    public function medicineSearch(Request $request)
    {
        $medicines = Medicine::with(['category', 'subcategory'])
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->limit(10)
            ->get();

        return response()->json($medicines);
    }
}
