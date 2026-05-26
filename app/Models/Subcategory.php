<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Subcategory extends Model // Subategory // sub_categories
{
        use HasFactory;

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
