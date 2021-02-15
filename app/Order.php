<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =['orderid',
                        "total_discount",
                        "total_price",
                        "order_date",
                        'user_id',
                        "total_order",
                        'shipping_charge',
                        "tax"];
    public $timestamps=true;
    public function orderItem()
    {
    return $this->hasMany(OrderedProducts::class,'order_id');
    }
    public function shippingAddress()
    {
    return $this->belongsTo(ShippingAddress::class,'shipping_address_id');
    }
    public function user()
    {
       return $this->belongsTo(User::class,'user_id');
    }
    public function payment()
    {
      return $this->hasOne(Payment::class,'order_id');
    }

}
