<?php

namespace App\Modules\Homepage\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Config\Models\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO;

class Homepage extends Model
{
    public static function homepage(Request $request) {
               # $request->path() = tag/{**this**}
        $path = ($request->path() == '/') ? 'hot':substr($request->path(), 4); # Path in URL = "hot" by default
        $return = Homepage::getConfigData(); # Return ConfigData by adding it to $return
        $primary_category = ['hot', 'trending', 'fresh']; # 3 categories are sorted by like
        DB::setFetchMode(PDO::FETCH_ASSOC);
        if (in_array($path, $primary_category)) { # Get posts by like or tag
            $posts = Homepage::loadByLike($return, $path); # Get posts (by like)
        } else {
            $posts = Homepage::loadByTag($return, $path); # Get posts (by tag)
        }
        $return["path"] = ($path=="hot") ? "Hot":(($path=="trending") ? "Trending":(($path=="fresh") ? "Fresh":$path));
        $return["total"] = $posts->total();
        $return["links"] = $posts->links();
        foreach ($posts as $key => $p) {
            $return["posts"][$key] = $posts[$key]; # Attach posts to $return
            DB::setFetchMode(PDO::FETCH_NUM); # Set fetch mode to FETCH_NUM to get author easily
            $return["posts"][$key]["author"] = DB::table('users')->where('id', $p['author'])->select('name')->get()->toArray()[0][0];
            DB::setFetchMode(PDO::FETCH_BOTH); # Reset fetch mode to FETCH_BOTH (default) * if not, app can't load user()->name *
            $return["posts"][$key]['is_like'] = "0"; # Default: not like
            if (Auth::check()) {
                if (!empty(DB::table('reaction')->where([['who', Auth::id()], ['post', $p['id']]])->get()->toArray())) {
                    $return['posts'][$key]['is_like'] = "1"; # User has liked it, $post['is_like'] = 1 ($post in view)
                }
            }
        }
        return $return;
    }
    public static function loadByLike($data, $path) {
        $min_like = ($path == 'fresh') ? 0:$data['min_'.$path.'_like'];
        return DB::table('posts')
                    ->where('like', '>=', $min_like)
                    ->orderBy('id', 'desc')
                    ->paginate($data['posts_per_page']);
    }
    public static function loadByTag($data, $path) {
        return DB::table('posts')
                    ->where('tag', $path)
                    ->orderBy('id', 'desc')
                    ->paginate($data['posts_per_page']);
    }
    public static function getConfigData() {
        return Config::getConfigData();
    }
}