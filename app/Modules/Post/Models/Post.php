<?php

namespace App\Modules\Post\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO;
use App\Modules\Config\Models\Config;
use App\Modules\Comment\Models\Comment;

class Post extends Model
{
    public static function Post(Request $request,int $id) {
        $return['tags'] = Config::getTags(); # Return $tags for navbar in view
        DB::setFetchMode(PDO::FETCH_BOTH);
        $return['post'] = DB::table('posts')->where('id', $id)->get()->toArray();
        $return['post'] = (!empty($return['post'])) ? $return['post'][0]:null; # If post exists
        if (isset($return['post'])) { # Check if the user has liked post
            $return['post']['is_like'] = "0"; # Default: not like
            if (!empty(Auth::check())) {
                if (!empty(DB::table('reaction')->where([['who', Auth::id()], ['post', $return['post']['id']]])->get()->toArray())) {
                    $return['post']['is_like'] = "1"; # User has liked it, $post['is_like'] = 1 ($post in view)
                }
            }
        }
        DB::setFetchMode(PDO::FETCH_NUM);
        $return['author'] = DB::table('users')->where('id', Auth::id())->select('name')->get()->toArray()[0][0];
        $return['comments'] = Comment::loadComment($id);
        return $return;
    }
}