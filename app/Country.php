<?php

namespace App;

// use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'country_name'
    ];

    // public function user()
    // {
    //     return $this -> belongsTo('App\User');
    // }
}
