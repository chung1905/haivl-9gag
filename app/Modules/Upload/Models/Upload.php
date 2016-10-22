<?php

namespace App\Modules\Upload\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Modules\Config\Models\Config;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
//use PDO;
//use Illuminate\Support\Facades\Auth;

class Upload extends Model
{
    public static function submit(Request $request) {
        if (Upload::isValid($request)) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $filename = date('ymdHis').'.'.$request->file()['image_upload']->guessExtension();
            $destination_dir = __DIR__.'/../users/'.$request->user()->email.'/';
            Upload::toStorage($request, $destination_dir, $filename);
            Upload::toDB($request, $destination_dir, $filename);
        }
    }

    public static function isValid(Request $request) {
        if (isset($request['submit_image'])) {
            $validMimeType = ['image/jpeg', 'image/png', 'image/gif'];
            if (!empty($request['title']) && !empty($request['image_upload'])) {
                if (isset($request->file()['image_upload']) && in_array($request->file()['image_upload']->getMimeType(), $validMimeType)) {
                    if ($request->file()['image_upload']->getClientSize() <= Config::getConfigData()['max_size']*1000) {
                        return true;
                    }
                    else {
                        echo('Image is too large.');
                        return false;
                    }
                }
                else {
                    echo('Invalid image or no title.');
                    return false;
                }
            }
        }
    }

    public static function toStorage(Request $request, string $dir, string $filename) {
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $request->file()['image_upload']->move($dir, $filename);
    }

    public static function toDB(Request $request,string $dir, string $filename) {
        DB::table('posts')->insert([
            'author' => $request->user()->id,
            'title' => $request['title'],
            'link_to_image' => $dir.$filename,
            'post_time' => date('Y-m-d H:i:s'),
        ]);
        //DB::table('posts')
            //->where('config_names', 'max_size')
            //->update(['config_values' => $data['new_max_size']]);
        //DB::table('posts')
            //->where('config_names', 'posts_per_page')
            //->update(['config_values' => $data['new_ppp']]);
    }
}