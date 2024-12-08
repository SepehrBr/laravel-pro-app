<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view("profile.index");
    }
    public function manageTwofactor()
    {
        return view("profile.twofactor");
    }
    public function postTwofactor(Request $request)
    {
        // validate
        $data = $request->validate([
            "type"=> ["required", 'in:sms,off'],
            "phone"=> "required_unless:type,off|min:11|unique:users,phone_number",
        ]);

        if ($data["type"] == "sms") {
            if ($request->user()->phone_number != $data['phone']) {
            // generate code
            $code = ActiveCode::generateCode(auth()->user());

            // save phone number to session using flash
            $request->session()->flash('phone', $data['phone']);

            // TODO send to user

                return redirect(route('twofactor.phone'));
            } else {
                $request->user()->update([
                    'twofactor_type' => 'sms',
                ]);
            };
        }
        if ($data["type"] == "off") {
            $request->user()->update([
                'twofactor_type' => 'off',
                'phone_number' => null
            ]);

            return back();
        }
    }
    public function getPhoneVerify(Request $request)
    {
        // redirect to twofactor route if phone number isnt saved in session
        if (! $request->session()->has('phone')) {
            return redirect(route('twofactor'));
        }

        // reflash session for another route
        $request->session()->reflash();

        return view('profile.phone_verify');
    }
    public function postPhoneVerify(Request $request)
    {
        // validate
        $data = $request->validate([
            'token' => ['required', 'string','min:6'],
        ]);

        // verify code
        $status = ActiveCode::verifyCode(auth()->user(), $data['token']);

        // delete code after verification
        if ($status && $request->session()->has('phone')) {
            auth()->user()->activecode()->delete();
            auth()->user()->update([
                'twofactor_type' => 'sms',
                'phone_number' => $request->session()->get('phone')
            ]);

            alert()->success('تایید شد', 'عملیات موفقیت آمیز بود!');
        } else {
            alert()->error('تایید نشد', 'مشکلی رخ داده است!');
        }

        return redirect(route('twofactor'));
    }
}
