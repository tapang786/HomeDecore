<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
	protected $fillable =["address","address2","city","country",'state','user_id'];
	 public $timestamps=true;
    use HasFactory;

    public function user()
    {

    	return $this->belongsTo("App\Models\User");
    }
}
