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
            $destination_dir = public_path().'/users/'.$request->user()->email.'/';
            $public_address = '/users/'.$request->user()->email.'/';
            if (
                Upload::toStorage($request, $destination_dir, $filename)
            &&  Upload::toDB($request, $public_address, $filename)
            ){
                echo ('Upload Successfully');
            }
        }
    }

    public static function isValid(Request $request) {
        if (isset($request['submit_image'])) {
            $validMimeType = ['image/jpeg', 'image/png', 'image/gif'];
            if (!empty($request['title']) && !empty($request['image_upload'])) {
                if ( !empty($request->file()['image_upload']) ) {
                    if ( in_array($request->file()['image_upload']->getMimeType(), $validMimeType) ) {
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
    }

    public static function toStorage(Request $request, string $dir, string $filename) {
        if (!is_dir($dir)) {
            if (!mkdir($dir)) {
                echo('mkdir() failed');
                return false;
            }
        }
        try {
            $request->file()['image_upload']->move($dir, $filename);
        } catch (Exception $e) {
            echo ('Exception: '.$e->getMessage());
            return false;
        } finally {
            return true;
        }
    }

    public static function toDB(Request $request,string $address, string $filename) {
        return DB::table('posts')->insert([
            'author' => $request->user()->id,
            'link_to_image' => $address.$filename,
            'title' => $request['title'],
            'post_time' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getConfigData() {
        return Config::getConfigData();
    }
}