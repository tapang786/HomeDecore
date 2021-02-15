<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StyleVariant extends Model
{
    use HasFactory,SoftDeletes;
    public function getStyleName()
    {
       return $this->belongsTo(ProductStyleCustomization::class,'product_style_customization_id');
    }
    public function getAppliedStyleGalImage()
    {
       return $this->belongsTo(ProductGallaryImage::class,'product_gallary_image_id');
    }
}
