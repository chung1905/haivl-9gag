<?php
namespace App\Modules\Post\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Post\Models\Post;
//use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

    public function __construct() {
        # parent::__construct();
    }
    public function index($id, Request $request) {
        return view('Post::index', Post::Post($request, (int)$id));
    }
}
