<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    public function showLoginForm()
    {
        $userpc = \App\User::where('pc_name',$_SERVER['REMOTE_ADDR'])->get();
        if (!isset($userpc)){//если поле с айпи клиента не задано (сброшено, например)
            return view('auth.login');
        }elseif(count($userpc)>1){ //если айпи клиента содержится более чем у двух юзеров
            return view('auth.login');
        }elseif(count($userpc)==1){
            $user=$userpc->first();
            $user_role_type = \App\roles::find($user->role_id);
            if (isset($user_role_type))
                if ($user_role_type == 'Администратор'||
                    $user_role_type == 'Руководители') return view('auth.login');
                else $this->attemptLoginWithPcName($user);
        }
        return redirect('home');##001
    }

    private function attemptLoginWithPcName($user){
        if(Auth::loginUsingId($user->id, true)){
            return redirect('home');
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
