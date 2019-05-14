<?php

namespace App\Http\Controllers;

use Request;
use App\User;

use Illuminate\Support\Facades\DB;
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
    	return view("profile_edit", ["user" => User::getUserInfo(), "coutnrys" => DB::table('country')->get()]);
    }

    public function show($id = 0)
    {
        return view("showProfile", ["user"=>User::getUserInfo($id)]);
    }

    public function update() 
    {
    	$input = Request::all();
        
        $messages = [];

        request()->validate([
            'email' => 'nullable|email|unique:users|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' =>  'nullable|string|min:1 max:255',
            'last_name' => 'nullable|string|min:1 max:255',
        ]);

        if (isset($input['first_name'])) {
            User::where('id', Auth::id())
                ->update(['first_name' => $input['first_name']]);

            $messages[] = "Firs name changed";
        }

        if (isset($input['last_name'])) {
            User::where('id', Auth::id())
                ->update(['last_name' => $input['last_name']]);

            $messages[] = "Last name changed";
        }

        if (isset($input['email'])) {
            User::where('id', Auth::id())
                ->update(['email' => $input['email'], 'email_verified_at' => null]);
        
            $messages[] = "Email changed";
        }

        if (isset(request()->image)) {
            $imageName = Auth::id().'-'.time().'.'.request()->image->getClientOriginalExtension();

            request()->image->move(public_path('images'), $imageName);

            User::where('id', Auth::id())
                ->update(['image' => $imageName]);

            $messages[] = "Image changed";
        }

        if (isset($input['city_id']) and $input['city_id'] != 0) {
            User::where('id', Auth::id())
                ->update(['country_id' => $input['country_id'], 'region_id' => $input['region_id'], 'city_id' => $input['city_id']]);
            $messages[] = "Residence changed";
        }

        $user = User::getUserInfo();

        if (isset($input['old_pass'])) {
            if (Hash::check($input['old_pass'], $user -> password)) {
                request()->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed']
                ]);

                User::where('id', Auth::id())
                    ->update(['password' => Hash::make($input['password'])]);

                $messages[] = "Password chenged";
            }
            else {
                $messages[] = "Wrong password";
            }
        }    

        if ($user -> email_verified_at !== null) {
            return view("profile_edit", ["user"=>$user, "messages"=>$messages, "coutnrys" => DB::table('country')->get()]);
        }
        else {
            return redirect()->route('verification.resend');
        }
    }
}
