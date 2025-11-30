<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
        'model_year',
        'color',
        'price',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
