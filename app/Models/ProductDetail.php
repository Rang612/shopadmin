<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';
    protected $primaryKey = 'id';
    protected $fillable = ['product_id', 'color', 'size', 'qty'];
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
