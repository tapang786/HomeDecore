<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    protected $table="shipping_address";
    protected $fillable =['name',"phone","alternate_phone","address","address_type","city","country",'state','zip_code','landmark','user_id'];
    public $timestamps=true;
}
