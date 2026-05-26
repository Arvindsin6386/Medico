<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use SoftDeletes;
        use HasFactory;

    protected $fillable = ['name','description','status', 'image'];
    
    protected $dates = [
        'deleted_at',

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

    protected static function booted()
{
    static::deleting(function ($category) {

        // delete subcategories
        $category->subcategories()->delete();

        // delete medicines
        $category->medicines()->delete();
    });
}
   
}
