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
    	$path = ($request->path() == '/') ? 'hot':$request->path(); # Path in URL = "hot" by default
        $return = Config::getConfigData(); # Return ConfigData by adding it to $return
    	$primary_category = ['hot', 'trending', 'fresh'];
        DB::setFetchMode(PDO::FETCH_ASSOC);
    	if (in_array($path, $primary_category)) { # We need get posts by like or tag
    		$return['posts'] = Homepage::loadByLike($return, $path); # Attach posts (by like) to $return
    	} else {
    		$return['posts'] = Homepage::loadByTag($return, $path);
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