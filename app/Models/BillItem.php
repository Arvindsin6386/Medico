<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillItem extends Model
{
    use SoftDeletes;
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
