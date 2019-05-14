<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'theme', 'text', 'user_id'
    ];

    public static function getComments($inPage = 5)
    {
		return Comment::select('comments.*', 'users.name', 'users.image')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->orderBy('comments.id', 'desc')
            ->paginate($inPage);
    }
}
