<?php

namespace App\Models;
use App\Models\Medicine;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'medicine_id', 'quantity_sold', 'unit_price',
        'total_amount', 'customer_name', 'customer_phone', 'sale_date'
    ];
        protected $casts = ['sale_date' => 'date'];


        public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

}
