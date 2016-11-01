<?php

namespace App\Modules\Like\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Config\Models\Config;
use Illuminate\Support\Facades\DB;
use PDO;

class Like extends Model
{
    public static function like($data = []) {
        # Check if isset($user, $isLike, $post)
        $user = isset($data['user']) ? $data['user']:null;
        $isLike = isset($data['isLike']) ? $data['isLike']:null;
        $post = isset($data['post']) ? $data['post']:null;
        if (isset($user, $isLike, $post)) {
            $likeColumn = DB::table('posts')->where('id', $post);
            $reaction = DB::table('reaction')->where([['who', $user], ['post', $post]]);
            ($isLike) ? $likeColumn->increment('like'):$likeColumn->decrement('like'); # +1 or -1 like
            if (empty($reaction->get()->toArray())) {
                DB::table('reaction')->insert(['post' => $post, 'who' => $user, 'is_like' => $isLike]);
            } else {
                $reaction->delete();
            }
            DB::setFetchMode(PDO::FETCH_NUM);
            return DB::table('posts') # Return total numbers of like
                    ->select('like')
                    ->where('id', $post)
                    ->get()->toArray()[0][0];
        }
        return "False";
    }
}