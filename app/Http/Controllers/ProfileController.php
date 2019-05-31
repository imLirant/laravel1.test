<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() 
    {
    	return view("profile-edit", ["user" => User::getUserInfo(), "countries" => Country::get()]);
    }

    public function show($id = 0)
    {
        return view("show-profile", ["user"=>User::getUserInfo($id)]);
    }

    public function update(Request $request) 
    {
        $input = $request -> all();
        
        $user = User::getUserInfo();

        $messages = [];

        $update = [];

        request()->validate([
            'email' => 'nullable|email|unique:users|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' =>  'nullable|string|min:1 max:255',
            'last_name' => 'nullable|string|min:1 max:255',
        ]);

        if (isset($input['first_name'])) {
            $update['first_name'] = $input['first_name'];
            $messages[] = "Firs name changed";
        }

        if (isset($input['last_name'])) {
            $update['last_name'] = $input['last_name'];

            $messages[] = "Last name changed";
        }

        if (isset($input['email'])) {
            $update['email'] = $input['email'];
            $update['email_verified_at'] = null;
            $user -> email_verified_at = null; 
            $messages[] = "Email changed";
        }

        if (isset($input['twitter'])) {
            $update['twitter'] = $input['twitter'];
            $messages[] = "Twitter changed";   
        }

        if (isset($input['marscn'])) {
            $update['marscn'] = $input['marscn'];
            $messages[] = "Mars cn changed";
        }

        if (request()->hasFile('image')) {
            $imageName = Auth::id().'-'.time().'.'.request() -> image -> getClientOriginalExtension();
            request() -> image -> move(public_path('images'), $imageName);
            $update['image'] = $imageName;
            $messages[] = "Image changed";
        }

        if (isset($input['city_id']) and $input['city_id'] != 0) {
            $update['country_id'] = $input['country_id'];
            $update['region_id'] = $input['region_id'];
            $update['city_id'] = $input['city_id'];
            
            $messages[] = "Residence changed";
        }

        if (isset($input['old_pass'])) {
            if (Hash::check($input['old_pass'], $user -> password)) {
                request()->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed']
                ]);

                $update['password'] = Hash::make($input['password']);
                $messages[] = "Password changed";
            }
            else {
                $messages[] = "Wrong password";
            }
        }    

        if (!empty($update)) {
            User::where('id', Auth::id())
                ->update($update);
        }

        $result = [];
        $result['messages'] = $messages;
        $result['user'] = User::getUserInfo();
        $result['email_changed'] = $user -> email_verified_at === null;

        return $result;
    }
}
 