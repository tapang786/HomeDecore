<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use HasFactory;
    protected $table="email_setting";
    public $fillable=['host','port','encrypt','name','email','password'];
}
