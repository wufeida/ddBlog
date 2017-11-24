<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{

    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    public function redirectToProvider(Request $request, $service)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $data = [
                'ref_url' => $_SERVER['HTTP_REFERER'],
            ];
            session($data);
        }
        return Socialite::driver($service)->redirect();
    }

    public function handleProviderCallback(Request $request, $service)
    {
        $user = Socialite::driver($service)->user();
        $type = [
            'qq' => 1,
            'weibo' => 2,
            'github' => 3
        ];
        $uid = $user->id;
        $data = [
            'nickname'      => $user->nickname,
            'login_ip'      => $request->getClientIp(),
            'avatar'        => $user->avatar,
            'email'         => $user->email,
            'last_time'     => Carbon::now(),
        ];
        $oldUser = $this->user->getUserByTypeAndId($type[$service], $uid);
        if ($oldUser) {
            $data['login_times'] = $oldUser->login_times + 1;
            $this->user->update($oldUser->id, $data);
            Auth::loginUsingId($oldUser->id);
        } else {
            $data['type']        = $type[$service];
            $data['openid']      = $uid;
            $data['login_times'] = 1;
            $name = $this->suiji(10);
            $data['name']        = $name;
            $res = $this->user->store($data);
            Auth::loginUsingId($res->id);
        }
        return redirect(session('ref_url', url('/')));
    }

    /**
     * 生成随机字符
     * @param $len
     * @return string
     */
    function suiji($len)
    {
        $key = '';
        $pattern = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
        $chang = strlen($pattern);
        for($i=0;$i<$len;$i++)
        {
            $key .= $pattern{mt_rand(0,$chang)};    //生成php随机数
        }
        $da = DB::table('users')->where('name',$key)->first();
        if ($da)
        {
            $this->suiji($len);
        }
        return $key;
    }
    /**
     * 退出登录
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        session()->forget('ref_url');
        return redirect()->back();
    }

    /**
     * 检测登录
     *
     * @return int
     */
    public function checkLog()
    {
        if (Auth::check()) {
            return 1;
        }
        return 0;
    }
}