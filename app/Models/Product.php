<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'compare_price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'is_featured',
        'sku',
        'barcode',
        'track_qty',
        'qty',
        'status',
        'tag',
    ];

    public function product_images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductImage::class);

    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
    public function productDetail(){
        return $this->hasMany(ProductDetail::class,'product_id','id');
    }

}
