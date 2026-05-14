<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','description','image','status'];
    
    protected $dates = [
        'deleted_at',

    ];
    protected $casts = [
    'images' => 'array',
];

    // one catergory has many subcategory
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    // one category has many medicine 
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
   
}
