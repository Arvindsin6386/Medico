<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineImages extends Model
{
protected $fillable = ['medicine_id', 'image_path']; 

    public function medicine(){
        return $this->belongsTo(Medicine::class);
    }
}
