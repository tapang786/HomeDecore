<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table="settings";
    protected $fillable = [
        'id',
        'title',
        'desc',
        'business_name',
        'state',
        'city',
        'country',
        'address',
        'zip',
        'helpline',
        'email',
        'pan',
        'cin',
        'gstin',
        'site_url',
        'logo',
        'mailtype'
    ];
    public $timestamps=true;
    public function countryName()
    {
    	return $this->belongsTo(Country::class,'country');
    }
}
