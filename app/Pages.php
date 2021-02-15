<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Pages extends Model
{
    use HasFactory,SoftDeletes;
    use HasSlug;

    protected $fillable=[
    	'id',
    	'slug',
    	'page_title',
    	'page_sub_title',
    	'page_subtitle_content',
    	'meta_title',
    	'meta_keyword'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('page_title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
            ->usingSeparator('-');
    }
}
