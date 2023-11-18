<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'date_start',
        'date_end',
        'date_return',
        'total_price',
        'status',
    ];

    /**
     * Get the user that owns the rent.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car that owns the rent.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
}
