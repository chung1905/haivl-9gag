<?php

namespace App\Modules\Comment\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
//use App\Modules\Config\Models\Config;

class Comment extends Model
{
    public static function addComment(Request $request) {
        $author = (!empty($request->user())) ? $request->user()->id:null; # If "auth"
        $content = ($request->cmt != "") ? $request->cmt:null;  # If cmt is not empty
        $post_id = (!empty($request->post)) ? (int)$request->post:null;
        if (!isset($author, $content, $post_id)) { return "False"; }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $time = date("Y-m-d H:i:s");
        DB::table("comments")->insert([
                'author' => $author,
                'content' => $content,
                'post_id' => $post_id,
                'time' => $time
            ]);
        return "True";
    }
    public static function loadComment($post_id) {
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $comments = DB::table("comments")->where('post_id', $post_id)->orderBy('id','desc')->get()->toArray();
        return $comments;
    }
}