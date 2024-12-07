<?php

namespace App\Http\Controllers;

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
        $data = $request->validate([
            "type"=> ["required", 'in:sms,off'],
            "phone"=> "required_unless:type,off|min:11",
        ]);

        if ($data["type"] == "sms") {
            if ($request->user()->phone_number != $data['phone']) {
                return redirect(route('twofactor.phone'));
            } else {
                $request->user()->update([
                    'twofactor_type' => 'sms',
                    'phone_number'=> $data['phone']
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
    public function getPhoneVerify()
    {
        return view('profile.phone_verify');
    }
    public function postPhoneVerify(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string','min:6'],
        ]);
        return $request->token;
    }

}
