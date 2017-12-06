<?php
/**
 * Created by PhpStorm.
 * User: dd
 * Date: 2017/10/7
 * Time: 16:31
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/dd/index';
    public function login()
    {
        if (Auth::check()) return redirect('/dd/index');
        return view('admin/login');
    }
    
    public function toLogin(UserRequest $request)
    {
        if (Auth::check()) return redirect('/dd/index');
        $user = $request->except('_token');
        if ($this->guard()->attempt($user, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }
        $msg = '账号或密码错误！';
        return back()->withInput()->with(compact('msg'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/dd/login');
    }

    public function check()
    {
        if (Auth::check()) {
            return 1;
        }
        return 0;
    }
}