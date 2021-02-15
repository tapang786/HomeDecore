<?php
namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeValue extends Model
{
    use HasFactory;
    protected $fillable=['id','product_size_id','varient_value'];

    public function getVarient()
    {
    	return $this->belongsTo(ProductSize::class,'product_size_id');
    }
}
