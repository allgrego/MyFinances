<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index(){
        if(session()->get('activeSession')){
            return redirect(route('dashboard'));
        }
        
        return view('login/index');
    }

    public function login(Request $request){        
        if(session()->get('activeSession')){
            return redirect(route('dashboard'));
        }
        
        $username = $request->username;
        $password = $request->password;

        $user = DB::select('select * from user where username=?', [$username]);

        if(empty($user)) return redirect(route('loginIndex').'?error=invaliduser'); 
        
        $user = $user[0];

        if($user->password != $password){
            return redirect(route('loginIndex').'?error=invaliduser');
        }
        
        session()->put('activeSession',true);
        session()->put('activeUsername',$username);

        date_default_timezone_set("America/Caracas");
        $nowTimestamp = date("Y-m-d H:i:s");

        DB::update('update user set last_activity = ? where id = ?', [$nowTimestamp,$user->id]);

        return redirect(route('dashboard'));
        
    }
    
}
