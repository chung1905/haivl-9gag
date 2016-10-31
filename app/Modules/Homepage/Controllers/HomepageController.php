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
}