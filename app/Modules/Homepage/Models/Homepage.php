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
        $return = Config::getConfigData();
        DB::setFetchMode(PDO::FETCH_ASSOC);
        /* $return['posts'] = DB::table('posts')
        						->where('category','=',$request->path())
        						->orderBy('id','desc')
        						->paginate($return['posts_per_page']);*/
        return $return;
    }
}