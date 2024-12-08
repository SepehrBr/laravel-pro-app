<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        // first check that request must has session
        if (! $request->session()->has('auth')) {
            return redirect('/');
        }

        // if request has session then ...
        return view('auth.twofactor_auth');
    }
    public function postToken()
    {

    }
}
