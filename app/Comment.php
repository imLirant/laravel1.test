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

    public static function getRange($page, $inPage)
    {
        $comments = [];
            
        $count = Comment::count();

        $pageCount = $inPage === 0? 0: ceil($count/$inPage);
        
        if (empty($page)) {
            
            if ($count > $inPage) {
                $comments = Comment::orderBy('comments.id', 'desc')
                                -> take($inPage)
                                -> get();
            }
            elseif ($count > 0) {
                $comments = Comment::orderBy('comments.id', 'desc')
                                -> take($count)
                                -> get();
            }
        }
        else {
            $index = $inPage * $page;

            if ($index < $count) {
                if (($index + $inPage) > $count) {
                    $comments = Comment::orderBy('comments.id', 'desc')
                                -> skip($index)
                                -> take($count - $index)
                                -> get();
                }
                else {
                    $comments = Comment::orderBy('comments.id', 'desc')
                                -> skip($index)
                                -> take($inPage)
                                -> get();
                }
            }
        }

        $result = [];
        $result['data'] = $comments;
        $result['totalCount'] = $count;
        $result['pageCount'] = $pageCount;

        return $result;
    }

    public function user()
    {
        return $this -> belongsTo('App\User') -> select('id', 'name', 'image');
    }
}
