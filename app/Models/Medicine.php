<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use SoftDeletes;
    protected $fillable = [

        'category_id',
        'subcategory_id',

        'name',
        'brand_name',
        'medicine_type',
        'unit',

        'purchase_price',
        'selling_price',

        'stock',

        'batch_number',

        'manufacture_date',
        'expiry_date',

        'status',

        'image',

        'description',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }


    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<=', $threshold);
    }


    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }


    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereBetween('expiry_date', [now(), now()->addDays($days)]);
    }

    public function scopeAlreadyExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    public function images()
    {
        return $this->hasMany(MedicineImages::class);
    }
    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }
}
