<?php
namespace App\Modules\Config\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Config\Models\Config;
//use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller {

    public function __construct() {
        # parent::__construct();
    }
    public function index(Request $request) {
        Config::submit($request);
        return view('Config::index', Config::getConfigData());
    }
}
