<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedOrders extends Model
{
    use HasFactory;
    protected $table="returned_orders";
    protected $fillable=['order_id','return_date'];
    public $timestamps=true;

    public function order()
    {
      return $this->belongsTo(Order::class,'order_id');
    }
}
