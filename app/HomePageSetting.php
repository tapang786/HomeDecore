<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class HomePageSetting extends Model
{
    use HasFactory,SoftDeletes;
    use HasSlug;
    protected $fillable=['id',"page_module","pricing_type","show_as","min_pricing","max_pricing",
                      'product_category',"content_title","contents",
                      'attributes',"content_position","content_priority",
                      'total_product_to_show',"total_product_in_row","meta_title",
                      "meta_description"
                    ];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('content_title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
            //->usingSeparator('');
    }
}
