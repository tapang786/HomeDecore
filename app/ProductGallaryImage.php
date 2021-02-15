<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallaryImage extends Model
{
    use HasFactory,SoftDeletes;
    public function getProductVariant()
    {
        return $this->hasMany(StyleVariant::class,'product_gallary_image_id');
    }
}
