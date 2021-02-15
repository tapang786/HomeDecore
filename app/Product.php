<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
      use HasFactory;
      use HasSlug;

      //public $table = 'products';
      protected $fillable=[
            'id',
            'pname',
            'slug',
            'categories',
            'sub_category',
            'sub_sub_category',
            'thumbnails',
            'sku_id',
            'p_price',
            's_price',
            'discount',
            'p_s_description',
            'feature',
            'p_description',
            'meta_title',
            'meta_keyword',
            'stock',
            'stock_alert',
            'status',
            'shipping',
            'shipping_charge',
            'return_policy',
            'tax_type',
            'tax',
            'parent_id',
            'product_type'
      ];

      public function category()
      {
            return $this->belongsTo(Category::class, 'categories');
      }

      public function subCategory()
      {
            return $this->belongsTo(Category::class, 'sub_category');
      }
      public function getProductVariant()
      {
            return $this->hasMany(SetProductVariant::class,'product_id');
      }

      public function getSlugOptions() : SlugOptions
      {
            return SlugOptions::create()
                  ->generateSlugsFrom('pname')
                  ->saveSlugsTo('slug')
                  ->doNotGenerateSlugsOnUpdate()
                  ->usingSeparator('-');
      }
}