<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
      protected $fillable = [
        'medicine_id', 'supplier_name', 'quantity_purchased',
        'cost_per_unit', 'total_cost', 'purchase_date'
    ];

    protected $casts = ['purchase_date' => 'date'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
