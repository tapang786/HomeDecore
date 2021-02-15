<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory,SoftDeletes;
    protected $date=['deleted_at'];
    protected $fillable=['id','name','icon'];
}
