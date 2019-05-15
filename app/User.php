<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'city_id', 'region_id', 'country_id', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getResidence($city_id)
    {
        $cityInfo = DB::table('city')
            ->where('city_id', $city_id)
            ->first();
        
        $country = DB::table('country')
            ->where('country_id', $cityInfo -> country_id)
            ->first();

        $region = DB::table('region')
            ->where('region_id', $cityInfo -> region_id)
            ->first();

        $result = $country -> country_name.', '.$region -> region_name.', '.$cityInfo -> city_name;

        return $result;
    }

    public static function getUserInfo($id = 0)
    {
        if ($id == 0) {
            $id = Auth::id();
        }

        $user = User::where('id', $id)
            ->first();

        if (isset($user -> city_id)) {
            $user -> residence =  self::getResidence($user -> city_id);
        }

        return $user; 
    }

    public function getImagePath()
    {
        return "/images/".$this -> image;
    }

    public function getProfileUrl()
    {
        return "/profile/id=".$this -> id;
    }
}
