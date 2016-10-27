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
        $data = [];
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
                case 'min_hot_like':
                    $data['min_hot_like'] = $config['config_values'];
            }
        }
        return $data;
    }
    public static function submit(Request $data) {
        if (isset($data['config_submit'])) {
            Config::modifyConfigData($data);
        }
    }
    public static function modifyConfigData(Request $data) {
        $nms = $data['new_max_size'];
        $nppp = $data['new_ppp'];
        $nmtl = $data['new_min_trending_like'];
        $nmhl = $data['new_min_hot_like'];
        if (!empty($nms) && !empty($nppp) && isset($nmtl) && isset($nmhl)) {
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
}