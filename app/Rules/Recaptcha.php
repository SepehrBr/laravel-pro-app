<?php

namespace App\Rules;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function passes($attribute, $value)
    {
        try {
            // access client using Clinet from Guzzle http
            $client = new Client();

            // as google docs to send validation to google we should use POST and url given in docs. all of form_prams are listed in google docs
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => env('GOOGLE_RECAPTHCA_SECRET_KEY'),
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]
            ]);

            // json_decod is like JSON.stringfy that we get google's response of sending recaptcha request
            $response = json_decode($response->getBody());

            return $response->success;
        } catch (\Exception $e) {
            return false;
        }
    }
}
