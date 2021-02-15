<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetProductVariant extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['id','color_id','product_id','color_vary_price'];
    public function getProduct()
    {
       return $this->belongsTo(Product::class,"product_id");
    }

    public function colorName()
    {
    	return $this->belongsTo(Color::class,'color_id');
    }
    public function getGallaryImage()
    {
      return $this->hasMany(ProductGallaryImage::class,'set_product_variant_id');
    }
    public function getStleVariant()
    {
      return $this->hasMany(StyleVariant::class,'set_product_variant_id');
    }
  
    
}
