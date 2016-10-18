<?php
namespace App\Modules\Upload\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Upload\Models\Upload;

class UploadController extends Controller {

    public function __construct() {
        # parent::__construct();
    }
    public function index(Request $request) {
        return view('Upload::index', Upload::hello());
    }
}
