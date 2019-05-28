<?php

namespace App;

// use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city_name'
    ];

    public function region()
    {
        return $this -> belongsTo('App\Region', 'region_id', 'region_id');
    }

    public function country()
    {
        return $this -> belongsTo('App\Country', 'country_id', 'country_id');
    }

}
