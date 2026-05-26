<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Sale;
use App\Models\Medicine;

class BillingController extends Controller
{
    public function index()
    {
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name')->get();
        return view('admin.billing.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $total_amount = 0;

        $bill = Bill::create([
            'bill_number' => 'BILL-' . time(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'subtotal' => 0,
            'tax' => 0,
            'total_amount' => 0,
        ]);

        foreach ($request->medicine_id as $key => $medicineId) {
            // find medicine
            $medicine = Medicine::findOrFail($medicineId);

            // quantity
            $qty = $request->quantity[$key];

            // correct price field
            $price = $medicine->selling_price;

            // subtotal
            $subtotal = $price * $qty;

            // add into final total
            $total_amount += $subtotal;

            // save bill item
            BillItem::create([
                'bill_id' => $bill->id,
                'medicine_id' => $medicine->id,
                'medicine_name' => $medicine->name,
                'quantity' => $qty,
                'unit_price' => $price,
                'subtotal' => $subtotal,
            ]);
        }

        // calculate tax percentage
        $taxPercentage = 5;
        

        // calculate tax
        $tax = $total_amount * ($taxPercentage / 100);

        // final total
        $finalTotal = $total_amount + $tax;

        // update bill
        $bill->update([
            'subtotal' => $total_amount,
            'tax' => $tax,
            'tax_percentage' => $taxPercentage,
            'total_amount' => $finalTotal,
        ]);


        return back()->with('success', 'Bill Created Successfully');
    }
}
