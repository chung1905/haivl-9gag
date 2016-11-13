<?php

namespace App\Modules\Homepage\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Config\Models\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use PDO;

class Homepage extends Model
{
    public static function homepage(Request $request) {
               # $request->path() = tag/{**this**}
        $path = ($request->path() == '/') ? 'hot':substr($request->path(), 4); # Path in URL = "hot" by default
        $return = Config::getConfigData(); # Return ConfigData by adding it to $return
        $posts = Homepage::loadPosts($return, $path); # $return === getConfigData()
        $return["posts"] = Homepage::parsePosts($posts);
        # upcase the first letter in tag name if the tag name is in $primary_category
        $return["path"] = ($path=="hot") ? "Hot":(($path=="trending") ? "Trending":(($path=="fresh") ? "Fresh":$path));
        $return["total"] = $posts->total();
        //$return["links"] = $posts->links();
        return $return;
    }
    public static function loadPage(Request $request) {
        $data = Config::getConfigData();
        $tag = ($request->tag=="Hot") ? "hot":(($request->tag=="Trending") ? "trending":(($request->tag=="Fresh") ? "fresh":$request->tag));
        $page = $request->page;
        $posts = Homepage::parsePosts(Homepage::loadPosts($data, $tag, $page));
        return $posts;
    }
    public static function loadPosts($data, $path, $page = 1) {
        $primary_category = ['hot', 'trending', 'fresh']; # 3 categories are sorted by like
        DB::setFetchMode(PDO::FETCH_ASSOC);
        Paginator::currentPageResolver(function() use ($page) { # Set current page
            return $page;
        });
        if (in_array($path, $primary_category)) { # Get posts by like or tag
            return Homepage::loadByLike($data, $path); # Get posts (by like)
        } else {
            return Homepage::loadByTag($data, $path); # Get posts (by tag)
        }
    }
    public static function parsePosts($posts){
        $return = [];
        foreach ($posts as $key => $p) {
            $return[$key] = $posts[$key]; # Attach posts to $return
            DB::setFetchMode(PDO::FETCH_NUM); # Set fetch mode to FETCH_NUM to get author easier
            # Add author name to $post
            $return[$key]["author"] = DB::table('users')->where('id', $p['author'])->select('name')->get()->toArray()[0][0];
            DB::setFetchMode(PDO::FETCH_BOTH); # Reset fetch mode to FETCH_BOTH (default) * if not, app can't load user()->name *
            # Check if current user has liked it or not
            $return[$key]['is_like'] = "0"; # Default: not like
            if (Auth::check()) {
                if (!empty(DB::table('reaction')->where([['who', Auth::id()], ['post', $p['id']]])->get()->toArray())) {
                    $return[$key]['is_like'] = "1"; # User has liked it, $post['is_like'] = 1 ($post in view)
                }
            }
        }
        return $return;
    }
    protected static function loadByLike($data, $path) {
        $min_like = ($path == 'fresh') ? 0:$data['min_'.$path.'_like'];
        return DB::table('posts')
                    ->where('like', '>=', $min_like)
                    ->orderBy('id', 'desc')
                    ->paginate($data['posts_per_page']);
    }
    protected static function loadByTag($data, $path) {
        return DB::table('posts')
                    ->where('tag', $path)
                    ->orderBy('id', 'desc')
                    ->paginate($data['posts_per_page']);
    }
}