<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            // get google user
            $googleUser = Socialite::driver('google')->user();

            // check user in sql
            $user = User::whereEmail($googleUser->email)->first();

            // login old user or register new user then login
            if ($user) {
                Auth::loginUsingId($user->id);
            } else {
                $newUser = User::create([
                    'name'=> $googleUser->name,
                    'email'=> $googleUser->email,
                    'password' => bcrypt(\Str::random(15)),
                ]);

                Auth::loginUsingId($newUser->id);
            }

            // in both case redirect to home
            return redirect('/');
        } catch (\Throwable $th) {
            // TODO
            return 'error';
        }
    }
}
