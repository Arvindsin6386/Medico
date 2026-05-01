<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [ 'name',
        'company',
        'stock',
        'expiry_date',
        'category_id',
        'subcategory_id'];


         public function category()
    {
        return $this->belongsTo(Category::class);
    }

     public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
