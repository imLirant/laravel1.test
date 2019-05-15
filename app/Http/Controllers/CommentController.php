<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $comments = Comment::getComments();
        
        $messages = [];

        return view("comments", ["comments"=>$comments, "messages"=>$messages]);
    }
  
    public function store(Request $request) {
        request()->validate([

            'theme' => 'required|max:255',
            'text' => 'required|max:255',
            
        ]);

        $input = $request -> all();
        
        $messages = [];

        $result = Comment::create([
            'theme' => $input['theme'],
            'text' => $input['text'],
            'user_id' => Auth::id()
        ]);

        $comments = Comment::getComments();
        
        return redirect() -> back() -> with('CommentSentResut', 'The comment has been sent');
    }
}
