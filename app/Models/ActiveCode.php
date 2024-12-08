<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    protected $table = 'active_code';
    protected $fillable = [
        'user_id',
        'code',
        'expired_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopeGenerateCode($query, $user) {
        // check if there was code sent before or not
        if ($this->checkIfCodeExists($user)) {
            $code = $this->checkIfCodeExists($user);

        // set new
            $code = $code->code;
        } else {
        // generate code
            do {
                $code = mt_rand(100000, 999999);
            } while ($this->checkCodeIsUnique($user, $code));

        // store code
            $user->activeCode()->create([
                'code' => $code,
                'expired_at' => now()->addSeconds(90)
            ]);
        }


        return $code;
    }
    public function checkCodeIsUnique($user, $code)
    {
        return !! $user->activeCode()->whereCode($code)->first();
    }
    public function checkIfCodeExists($user)
    {
        return $user->activeCode()->where('expired_at', '>', now())->first();
    }


    // verifycode
    public function scopeVerifyCode($query, $user, $code)
    {
        return !! $user->activeCode()->whereCode($code)->where('expired_at', '>', now())->first();
    }
}
