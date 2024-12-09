<?php namespace App\Http\Controllers\Auth;

use App\Models\ActiveCode;
use App\Notifications\LoginToWebNotification;
use Illuminate\Http\Request;

trait TwoFactorAuth
{
    public function loginWithTwoFactorAuth(Request $request, $user)
    {
        // check if twofactor auth is activated or not
        // if activated then ...
        if ($user->twofactor_type != 'off') {
            // چون که بالاخره ورود میکنیم ولی نه ورود با اس‌ام‌اس، به همین خاطر اول کار تو پشت پرده باید بلافاصله لاگ‌اوت کرده باشیم
            auth()->logout();

            // we must add session to access necessary keys and values in next route
            $request->session()->flash('auth', [
                'user_id' => $user->id,
                'using_sms' => false,
                'remember' => $request->has('remember')
            ]);

        // diffrenet rypes of sending code
            // sending code after loggin in with sms
            if ($user->twofactor_type == 'sms') {
                // generate code
                $code = ActiveCode::generateCode($user);

                // TODO send sms

                // add session using flash
                $request->session()->flash('auth.using_sms', true);

            }

            return redirect(route('twofactor.token'));
        }

        // if twofactor auth is not activated then notify with mail for email activation
        $user->notify(new LoginToWebNotification());

        return false;
    }
}
