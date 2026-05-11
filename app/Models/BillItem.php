<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
        protected $fillable = [
        'bill_id','medicine_id','medicine_name',
        'quantity','unit_price','subtotal'
    ];

    public function bill() {
        return $this->belongsTo(Bill::class);
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

}
