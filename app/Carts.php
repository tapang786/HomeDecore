<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $fillable=['user_id','sku_id','quantity','product_type','product_id'];
    public $timestamps=true;
    use HasFactory;
    public function product()
    {
       return $this->belongsTo(Product::class,'product_id');
    }
    public function colorName()
    {
        return $this->belongsTo(Color::class,'color_id');
    }
    public function sleeveName()
    {
        return $this->belongsTo(ProductStyleCustomization::class,'sleeve_id');
    }
    public function neckName()
    {
        return $this->belongsTo(ProductStyleCustomization::class,'neck_id');
    }
    public function bottomName()
    {
        return $this->belongsTo(ProductStyleCustomization::class,'bottom_id');
    }
    
}
