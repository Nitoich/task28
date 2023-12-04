<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'car_brand_id'
    ];

    public function car_brand(): HasOne
    {
        return $this->hasOne(CarBrand::class);
    }
}
