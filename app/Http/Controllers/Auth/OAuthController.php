<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{

    public function redirectToProvider(Request $request, $service)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $ref_url = $_SERVER['HTTP_REFERER'];
            session('ref_url', $ref_url);
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
        dd($user);
    }
}