<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'image', 'status'];

    protected $dates = [
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    // One Subcategory has Many Medicines

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
