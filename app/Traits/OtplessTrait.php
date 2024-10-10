<?php


namespace App\Traits;

require '../vendor/autoload.php';

use Illuminate\Support\Facades\Http;


trait OtplessTrait {
    public function Otpless($token)
    {
        $clientId = "21U7I51VX2UT0XH3902JYDXGRTEPUT5Q";
        $clientSecret = "b7cnfyrtzlud5eqon1u5jn4uxc9sy7c1";
        $response = Http::asForm()->post('https://auth.otpless.app/auth/userInfo', [
            'token'         => $token,
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
        ]);
        return  $response->status();
    }
}
