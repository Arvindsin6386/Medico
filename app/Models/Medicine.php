<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'company',
        'stock',
        'price',
        'description',
        'expiry_date',
        'category_id',
        'subcategory_id'
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
}
