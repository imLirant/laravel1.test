<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\City;
use \Twitter;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'city_id', 'region_id', 'country_id', 'image', 'twitter'
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
        $cityInfo = City::where('city_id', $city_id)
            ->first();
        
        $country = $cityInfo -> country -> country_name;

        $region = $cityInfo -> region -> region_name; 

        $result = $country.', '.$region.', '.$cityInfo -> city_name;

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

    public function getShortInfo()
    {
        $user = User::select('id', 'name', 'image')
                        ->where('id', $input['user_id'])
                        -> first();
        $user -> image = $user -> getImagePath();

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

    public function getTimeline($count)
    {
        if (isset($this -> twitter))
        {
            return Twitter::getUserTimeline(['screen_name' => $this -> twitter, 'count' => $count, 'format' => 'json']);  
        }
        else
        {
            return [];
        }
    }
}
