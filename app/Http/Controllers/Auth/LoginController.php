<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        $this->middleware('auth')->only('logout');
    }

    // check twofactor after login
    protected function authenticated(Request $request, $user)
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
            // sendin code after loggin in with sms
            if ($user->twofactor_type == 'sms') {
                // generate code
                $code = ActiveCode::generateCode($user);

                // TODO send sms

                // add session using flash
                $request->session()->flash('auth.using_sms', true);

                return redirect(route('twofactor.token'));
            }
        }

        // if twofactor auth is not activated we dont need to authenticate using twofactor
        return false;
    }
}
