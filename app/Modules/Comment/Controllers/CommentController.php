<?php
namespace App\Modules\Comment\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Comment\Models\Comment;
//use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {

    public function __construct() {
        # parent::__construct();
    }
    public function addComment(Request $request) {
        return Comment::addComment($request);
    }
}
