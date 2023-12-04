<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'user_id',
        'car_model_id',
        'release_date',
        'mileage',
    ];

    public function car_model(): HasOne
    {
        return $this->hasOne(CarModel::class);
    }

    public function getBrandAttribute(): CarBrand
    {
        return $this->car_model->car_brand;
    }
}
