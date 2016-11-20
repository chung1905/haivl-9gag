<?php
namespace App\Modules\User\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
//use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function __construct() {
        # parent::__construct();
    }

    public static function socialLogin(Request $request) {
        return User::socialLogin($request);
    }
}
