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
		return Comment::orderBy('comments.id', 'desc')
            ->paginate($inPage);
    }

    public function user()
    {
        return $this -> belongsTo('App\User');
    }
}
