<?php
namespace App\Modules\Like\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Like\Models\Like;

class LikeController extends Controller {

    public function __construct() {
        # parent::__construct();
    }
    public function like(Request $request) {
        $data['user'] = (!empty($request->user())) ? $request->user()->id:null;
        $data['isLike'] = (!empty($request->isLike)) ? (($request->isLike == "1") ? true:false):null;
        $data['post'] = (!empty($request->post)) ? ((int)substr($request->post, 3)):null;
        return Like::like($data);
    }
}