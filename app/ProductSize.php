<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['id','varient_category','varient_name'];

    public function getvalue()
    {
        return $this->hasMany(ProductSizeValue::class);
    }
}
