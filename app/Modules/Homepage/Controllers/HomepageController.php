<?php
namespace App\Modules\Homepage\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Homepage\Models\Homepage;

class HomepageController extends Controller {

    public function __construct() {
        # parent::__construct();
    }
    public function index(Request $request) {
        return view('Homepage::index', Homepage::homepage($request));
    }
    public function like(Request $request) {
    	$data['user'] = (!empty($request->user())) ? $request->user()->id:null;
    	$data['isLike'] = (!empty($request->isLike)) ? ((bool)$request->isLike):null;
    	$data['post'] = (!empty($request->post)) ? ((int)substr($request->post, 3)):null;
    	return Homepage::like($data);
    }
}