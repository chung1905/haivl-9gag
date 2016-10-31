<?php

namespace App\Modules\Homepage\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Config\Models\Config;
use Illuminate\Support\Facades\DB;
use PDO;

class Homepage extends Model
{
    public static function homepage(Request $request) {
        # $request->path() = tag/{something}
        $path = ($request->path() == '/') ? 'hot':substr($request->path(), 4); # Path in URL = "hot" by default
        $return = Config::getConfigData(); # Return ConfigData by adding it to $return
        $primary_category = ['hot', 'trending', 'fresh'];
        DB::setFetchMode(PDO::FETCH_ASSOC);
        if (in_array($path, $primary_category)) { # Get posts by like or tag
            $return['posts'] = Homepage::loadByLike($return, $path); # Attach posts (by like) to $return
        } else {
            $return['posts'] = Homepage::loadByTag($return, $path); # Attach posts (by tag) to $return
        }
        return $return;
    }
    public static function loadByLike($return, $path) {
        $min_like = ($path == 'fresh') ? 0:$return['min_'.$path.'_like'];
        return DB::table('posts')
                    ->where('like', '>=', $min_like)
                    ->orderBy('id', 'desc')
                    ->paginate($return['posts_per_page']);
    }
    public static function loadByTag($return, $path) {
        return DB::table('posts')
                    ->where('tag', $path)
                    ->orderBy('id', 'desc')
                    ->paginate($return['posts_per_page']);
    }
    public static function like($data = []) {
        $user = isset($data['user']) ? $data['user']:null;
        $isLike = isset($data['isLike']) ? $data['isLike']:null;
        $post = isset($data['post']) ? $data['post']:null;
        if (isset($user, $isLike, $post)) {
            $likeColumn = DB::table('posts')->where('id', $post);
            ($isLike) ? $likeColumn->increment('like'):$likeColumn->decrement('like');
            //DB::table('reaction')
            //        ->insert(['post' => $post, 'who' => $user, 'is_like' => $isLike]);            
            DB::setFetchMode(PDO::FETCH_NUM);
            $like = DB::table('posts')
                    ->select('like')
                    ->where('id', $post)
                    ->get()->toArray()[0][0];
            return $like;
        }
        return "False";
    }
    public static function getConfigData() {
        return Config::getConfigData();
    }
}