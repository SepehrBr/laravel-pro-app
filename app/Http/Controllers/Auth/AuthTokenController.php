<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\User;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        // first check that request must has session
        if (! $request->session()->has('auth')) {
            return redirect('/');
        }

        // reflash session for another route
        $request->session()->reflash();

        // if request has session then ...
        return view('auth.twofactor_auth');
    }
    public function postToken(Request $request)
    {
        // first check that request must has session
        if (! $request->session()->has('auth')) {
            return redirect('/');
        }

        // validate token
        $validate_data = $request->validate([
            'token' => ['required', 'string','min:6'],
        ]);

        // find user if not => 404
        $user = User::findOrFail($request->session()->get('auth.user_id'));

        // verify code
        $status = ActiveCode::verifyCode($user, $validate_data['token']);

        // redirect to login if code didnt validate
        if (!$status) {
            alert()->error('خطا', 'کد نامتعبر میباشد');

            $request->session()->reflash();

            return redirect(route('twofactor.token'));
        }

        // if code was verified
        if ($status) {
            // first login with id and remember user
            auth()->loginUsingId($user->id, $request->session()->get('auth.remember'));

            // delete verified code from db
            $user->activeCode()->delete();

            return redirect(route('home'));
        }
    }
}
