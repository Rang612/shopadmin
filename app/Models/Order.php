<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable=[
        'user_id',
        'subtotal',
        'shipping',
        'coupon_code',
        'discount',
        'grand_total',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'country_id',
        'city',
        'district',
        'ward',
        'street',
        'house_number',
        'zip',
        'notes'
    ];
}
