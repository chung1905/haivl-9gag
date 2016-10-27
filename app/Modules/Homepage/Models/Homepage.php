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
    	$path = ($request->path() == '/') ? 'hot':$request->path();
        $return = Config::getConfigData();
        DB::setFetchMode(PDO::FETCH_ASSOC);
    	$primary_category = ['hot', 'trending', 'fresh'];
    	
    	if (in_array($path, $primary_category)) {
    		$return['posts'] = Homepage::loadByLike($return, $path);
    	} else {
    		echo ('else');
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
}