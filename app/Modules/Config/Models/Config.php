<?php

namespace App\Modules\Config\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
//use Illuminate\Support\Facades\Auth;

class Config extends Model
{
    public static function getConfigData() {
        $data = array();
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $configs = DB::table('configs')->get()->toArray();
        foreach ($configs as $config) {
            switch ($config['config_names']) {
                case 'max_size':
                    $data['max_size'] = $config['config_values'];
                    break;
                case 'posts_per_page':
                    $data['posts_per_page'] = $config['config_values'];
                    break;
                case 'min_trending_like':
                    $data['min_trending_like'] = $config['config_values'];
                    break;
                case 'min_hot_like':
                    $data['min_hot_like'] = $config['config_values'];
                    break;
            }
        }
        $data['tags'] = Config::getTags();
        return $data;
    }
    public static function getTags() {
        DB::setFetchMode(PDO::FETCH_NUM);
        $tags = DB::table('tags')->get()->toArray();
        $return = array();
        foreach ($tags as $tag) {
            array_push($return, $tag[0]);
        }
        return $return;
    }
    public static function submit(Request $data) {
        if (isset($data['config_submit'])) {
            Config::modifyConfigData($data);
        }
        if (isset($data['submit_new_tag']) && !empty($data['new_tag'])) {
            Config::addNewTag($data['new_tag']);
        }
        if (isset($data['submit_delete_tag']) && !empty($data['delete_tag'])) {
            Config::deleteTag($data['delete_tag']);
        }
    }
    public static function modifyConfigData(Request $data) {
        if (isset($data['new_max_size'], $data['new_ppp'], $data['new_min_trending_like'], $data['new_min_hot_like'])) {
            $nms = $data['new_max_size'];
            $nppp = $data['new_ppp'];
            $nmtl = $data['new_min_trending_like'];
            $nmhl = $data['new_min_hot_like'];
            if (is_numeric($nms) && is_numeric($nppp) && is_numeric($nmtl) && is_numeric($nmhl)) {
                if ($nmtl <= $nmhl) {
                    DB::table('configs')
                        ->where('config_names', 'max_size')
                        ->update(['config_values' => $nms]);
                    DB::table('configs')
                        ->where('config_names', 'posts_per_page')
                        ->update(['config_values' => $nppp]);
                    DB::table('configs')
                        ->where('config_names', 'min_trending_like')
                        ->update(['config_values' => $nmtl]);
                    DB::table('configs')
                        ->where('config_names', 'min_hot_like')
                        ->update(['config_values' => $nmhl]);
                }
            }
        }
    }
    public static function addNewTag($new_tag) {
        DB::setFetchMode(PDO::FETCH_NUM);
        if (empty(DB::table('tags')->where('tag_name', $new_tag)->get()->toArray())) {
            DB::table('tags')->insert(['tag_name' => $new_tag]);
        }
    }
    public static function deleteTag($del_tag) {
        DB::table('tags')->where('tag_name', $del_tag)->delete();
    }
}