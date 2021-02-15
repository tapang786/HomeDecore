<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class AttributeTerms extends Model
{
    use HasFactory;
    use HasSlug;

    public $table = 'attribute_terms';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('value')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
            //->usingSeparator('');
    }
}
