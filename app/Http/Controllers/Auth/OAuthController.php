<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
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
            'name'          => $user->nickname,
            'login_ip'      => $request->getClientIp(),
            'avatar'        => $user->avatar,
            'email'         => $user->email,
        ];
        $oldUser = $this->user->getUserByTypeAndId($type[$service], $uid);
        if ($oldUser) {
            $data['login_times'] = $oldUser->login_times + 1;
            $this->user->update($oldUser->id, $data);
            $session['user']['id'] = $oldUser->id;
            $session['user']['is_admin'] = $oldUser->is_admin;
        } else {
            $data['type']        = $type[$service];
            $data['openid']      = $uid;
            $data['login_times'] = 1;
            $res = $this->user->store($data);
            $session['user']['id'] = $res->id;
            $session['user']['is_admin'] = 0;
        }
        $session['user']['name'] = $user->nickname;
        $session['user']['avatar'] = $user->avatar;
        session($session);
        return redirect(session('ref_url', url('/')));
    }

    /**
     * 退出登录
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->forget('user');
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
        if (!session('user')) {
            return 0;
        }
        return 1;
    }
}