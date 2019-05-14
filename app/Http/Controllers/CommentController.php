<?php

namespace App\Http\Controllers;

use Request;
use App\Comment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() 
    {
    	$comments = Comment::getComments();
    	
        $messages = [];

    	return view("comments", ["comments"=>$comments, "messages"=>$messages]);
    }

    public function create() 
    {
        request()->validate([

            'theme' => 'required|max:255',
            'text' => 'required|max:255',
            
        ]);

    	$input = Request::all();
        
        $messages = [];
    
        if (session('comment') !== $input['text']) {
            $result = Comment::create([
                'theme' => $input['theme'],
                'text' => $input['text'],
                'user_id' => Auth::id()
            ]);

            if (isset($result -> id)) {
                session(['comment' => $input['text']]);
                $messages[] = "The comment has been sent";
            }
        }
        
    	$comments = Comment::getComments();
    	
        return view("comments", ["comments" => $comments, "messages" => $messages]);
    }
}
