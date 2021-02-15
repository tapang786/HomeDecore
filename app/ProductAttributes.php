<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;
    //use HasSlug;

    public $table = 'product_attributes';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'product_id',
        'attribute_id',
        'term_id',
    ];

    /*public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
            //->usingSeparator('');
    }*/
}
