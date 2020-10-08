<?php

class PaypalProvider
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $state;

    public function __construct($clientId, $clientSecret, $state)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->state = $state;
    }

    public function callback()
    {
        ['code' => $code, 'state' => $rstate] = $_GET;
        if ($this->state === $rstate) {

            // GET TOKEN
            $link = "https://api.sandbox.paypal.com/v1/oauth2/token";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ":" . $this->clientSecret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=$code");

            $result = curl_exec($ch);
            curl_close($ch);

            ['access_token' => $access_token, 'token_type' => $token_type,
                'expires_in' => $expires_in, 'refresh_token' => $refresh_token] = json_decode($result, true);

            $link = "https://api.sandbox.paypal.com/v1/identity/oauth2/userinfo?schema=paypalv1.1";
            $rs = curl_init($link);
            curl_setopt_array($rs, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => 0,
                CURLOPT_HTTPHEADER => [
                    "Authorization: {$token_type} {$access_token}"
                ]
            ]);
            echo curl_exec($rs);
            curl_close($rs);
        }
    }
}