<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
	public function __construct() {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        $comments = Comment::getComments();
        
        $messages = [];

        return view("comments", ["comments"=>$comments, "messages"=>$messages]);
    }
  
    public function store(Request $request) {
        $request->validate([
            'theme' => 'required|max:255',
            'text' => 'required|max:255',
            
        ]);

        $input = $request -> all();
        
        $result = Comment::create([
            'theme' => $input['theme'],
            'text' => $input['text'],
            'user_id' => Auth::id()
        ]);

        $result -> message = "The comment has been sent";

        return $result;
    }

    public function getJson(Request $request) {
        $input = $request -> all();

        $comments = [];

        if (!isset($input['page']) or !isset($input['in_page'])) {
            return $comments;
        }

        $comments = Comment::getRange($input['page'], $input['in_page']);

        foreach ($comments['data'] as $comm) {
            if (isset($comm['user'])) {
                $comm['user'] = $comm -> user;
                $comm['user'] -> image = $comm -> user -> getImagePath();
                $comm['user'] -> profileUrl = $comm -> user -> getProfileUrl();
            }
        }

        $comments['userId'] = Auth::id();

        return $comments;
    }

    public function getCount() {
        $result = [];
        $result['lastId'] = (Comment::orderBy('comments.id', 'desc')
                -> first())['id'];
        $result['count'] = Comment::count();
        return $result;
    }

    public function delete(Request $request) {
        
        $input = $request -> all();

        if (isset($input['comment_id'])) {

            echo($input['comment_id']);

            $comment = Comment::where("id", $input['comment_id'])
                            ->first();
            if ($comment['user_id'] === Auth::id()) {
                Comment::where("id", $input['comment_id'])
                            ->delete();
            }
            else {
                echo("!user");
            }
        }
        else {
            echo("!id");
        }
    }
}
