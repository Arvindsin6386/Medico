<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'image_path',
        'is_master',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}