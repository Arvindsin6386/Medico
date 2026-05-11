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
    public function index(){
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name')->get();
                return view('admin.billing.create', compact('medicines'));

    }

    public function store(Request $request)
{
    // Validation
    $request->validate([

        'customer_name' => 'nullable|string|max:100',

        'customer_phone' => 'nullable|string|max:15',

        'medicine_id' => 'required|array',

        'quantity' => 'required|array',
    ]);

    // Total amount
    $grandTotal = 0;

    // Create Main Bill
    $bill = Bill::create([

        'bill_number' => 'BILL-' . time(),

        'customer_name' => $request->customer_name,

        'customer_phone' => $request->customer_phone,

        'subtotal' => 0,

        'discount' => 0,

        'tax' => 0,

        'total' => 0,

        'payment_method' => 'cash',
    ]);

    // Loop medicines
    foreach($request->medicine_id as $key => $medicineId)
    {

        // Find medicine
        $medicine = Medicine::findOrFail($medicineId);

        // Get quantity
        $qty = $request->quantity[$key];

        // Check stock
        if($medicine->stock < $qty)
        {
            return back()->with('error',
                $medicine->name . ' stock not available'
            );
        }

        // Calculate subtotal
        $subtotal = $medicine->price * $qty;

        // Add grand total
        $grandTotal += $subtotal;

        // Save Bill Item
        BillItem::create([

            'bill_id' => $bill->id,

            'medicine_id' => $medicine->id,

            'medicine_name' => $medicine->name,

            'quantity' => $qty,

            'unit_price' => $medicine->price,

            'subtotal' => $subtotal,
        ]);

        // Reduce stock
        $medicine->decrement('stock', $qty);
    }

    // Update final total
    $bill->update([

        'subtotal' => $grandTotal,

        'total' => $grandTotal,
    ]);

    return back()->with('success',
        'Multi medicine bill generated successfully'
    );
}

    
}
