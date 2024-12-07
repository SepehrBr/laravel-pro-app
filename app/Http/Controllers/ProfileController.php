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
            "phone"=> "required_unless:type,off|min:11",
        ]);

        if ($data["type"] == "sms") {
            if ($request->user()->phone_number != $data['phone']) {
            // generate code
                $code = ActiveCode::generateCode(auth()->user());

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
    public function getPhoneVerify()
    {
        return view('profile.phone_verify');
    }
    public function postPhoneVerify(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string','min:6'],
        ]);
        return $data['token'];
    }

}
