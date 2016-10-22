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
                case 'category';
                    $data['category'] = $config['config_values'];
                    break;
            }
        }
        return $data;
    }
    public static function modifyConfigData(Request $data) {
        if (isset($data['submit'])) {
            if (!empty($data['new_max_size']) && !empty($data['new_ppp'])) {
                if (is_numeric($data['new_max_size']) && is_numeric($data['new_ppp'])) {
                    DB::table('configs')
                        ->where('config_names', 'max_size')
                        ->update(['config_values' => $data['new_max_size']]);
                    DB::table('configs')
                        ->where('config_names', 'posts_per_page')
                        ->update(['config_values' => $data['new_ppp']]);
                }
            }
        }
        return 0;
    }
}