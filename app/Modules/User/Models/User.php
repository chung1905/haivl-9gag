<?php

namespace App\Modules\User\Models;

use App\User as DefaultUser;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO;

class User extends Model
{
    public static function socialLogin($data) {        
        # login via facebook
        if ($data->social === 'facebook') {
            return User::facebook($data);
        }
        # login via google+
        if ($data->social === 'google') {
            return User::google($data);
        }
        return '';
    }

    protected static function google($data) {
        if (!empty($data->email) && !empty($data->name)) {
            $x = DB::table('users')
                ->where('email', $data->email)
                ->get()->toArray();
            (empty($x)) ?
                # It's the first time this user signin, then signup him/her
                User::socialSignUp(['email' => $data->email, 'name' => $data->name]) :
                # It's not the first time, then signin
                User::socialSignIn($x[0]->id);
        }
    }

    protected static function facebook($data) {
        if (!empty($data->id)) {
            $email = $data->id.'@facebook.com';
            $x = DB::table('users')
                ->where('email', $email)
                ->get()->toArray();
            (empty($x)) ?
                # It's the first time this user signin, then signup him/her
                User::socialSignUp(['email' => $email, 'name' => $data->name]) :
                # It's not the first time, then signin
                User::socialSignIn($x[0]->id);
        }
        return 0;
    }

    protected static function socialSignUp($data) {
        return DefaultUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt(User::generateRandomPassword()),
        ]);
    }

    protected static function socialSignIn($id) {
        return Auth::loginUsingId($id, true);
    }

    protected static function generateRandomPassword() {
        $chars = '1234567890qwertyuiopasdfghjklzxcvbnm!@#$%^&*()QWERTYUIOPASDFGHJKLZXCVBNM';
        $len = mb_strlen($chars);
        $password = '';
        for ($i=0; $i < 8 ; $i++) { 
            $password .= substr($chars, rand(0,$len-1), 1);
        }
        return $password;
    }

}