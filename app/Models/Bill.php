<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'bill_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'payment_mode',
        'subtotal',
        'tax_percent',
        'tax_amount',
        'total_amount',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }
}
