<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

class GoogleAuthController extends Controller
{
    use TwoFactorAuth;
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback(Request $request)
    {

        try {
            // get google user
            $googleUser = Socialite::driver('google')->user();

            // check user in sql
            $user = User::whereEmail($googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'=> $googleUser->name,
                    'email'=> $googleUser->email,
                    'password' => bcrypt(\Str::random(15)),
                    'twofactor_type' => 'off'
                ]);
            }

            auth()->loginUsingId($user->id);

            return $this->loginWithTwoFactorAuth($request, $user);
        } catch (\Throwable $th) {
            alert()->error('خطا', 'مشکلی رخ داده هست دوباره تلاش کنید');

            return redirect(route('login'));
        }
    }
}
