<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand',
        'model',
        'type',
        'license_plate',
        'color',
        'year',
        'machine_number',
        'chasis_number',
        'image',
        'seat',
        'price',
        'status',
    ];

    /**
     * Get the rents for the car.
     */
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
}
