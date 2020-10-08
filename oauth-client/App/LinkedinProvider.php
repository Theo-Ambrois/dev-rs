<?php

class LinkedinProvider
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $state;
    protected string $scope;
    protected string $redirect_uri;
    protected string $uri_auth;
    protected string $access_link;


    public function __construct($clientId, $clientSecret, $state, $scope, $redirect_uri, $uri_auth, $access_link)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->state = $state;
        $this->scope = $scope;
        $this->redirect_uri = $redirect_uri;
        $this->uri_auth = $uri_auth;
        $this->access_link = $access_link;
    }

    public function callbackLinkedin()
    {
        ['code' => $code, 'state' => $rstate] = $_GET;
        if($rstate === $this->state){
            $linkAccessToken = $this->uri_auth . "?grant_type=authorization_code&code=".$code."&redirect_uri=". $this->redirect_uri ."&client_id=". $this->clientId ."&client_secret=" . $this->clientSecret;
            $access_token = file_get_contents($linkAccessToken);
            $access_token = explode('"', $access_token)[3];
            //print_r($access_token);

            $link = "https://api.linkedin.com/v2/me";
            $rs = curl_init($link);
            curl_setopt_array($rs, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => 0,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$access_token}"
                ]
            ]);
            echo curl_exec($rs);
            curl_close($rs);

        }

        $access_token;
    }
}