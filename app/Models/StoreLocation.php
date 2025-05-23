<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'opening_hours',
        'latitude',
        'longitude',
        'is_featured',
    ];
}
