<?php
include "App/PaypalProvider.php";
include "App/LinkedinProvider.php";

$providers = [
    "Paypal" => [
        "clientId" => "ARCpWqXNTslsyZL2bK2ptF6TMsA-vpf_-wtAcZe_WeqtfF8Z769Gb-qksURbjwm4VneEQheMzgSSooJn",
        "clientSecret" => "ECoNHboKG7l1rNl_UaWYlEn_EMa8ae43E3HIJimg8of144ppgp8wqZmfKHDjCcZJEtMiObrufuAx1XIX",
        "scope"=>"openid%20email%20profile",
        "state"=>'1234567890',
        "redirect_uri"=>"http%3A%2F%2Fmonsite.fr%3A7071%2Fcallback"
    ],

    "Linkedin" => [
        "clientId" => "779v0r8jryu6dw",
        "clientSecret" => "7xHm4iWPqfX3iUsh",
        "scope"=>"r_liteprofile%20r_emailaddress%20w_member_social",
        "state"=>'123456',
        "redirect_uri"=>"http://localhost:7071/callbackLinkedin",
        "uri_auth"=>"https://www.linkedin.com/oauth/v2/accessToken",
        "access_link"=>"https://www.linkedin.com/oauth/v2/authorization"
    ]
];

foreach ($providers as $k => $v) {
    $link = links($k, $v);
    echo "<a href='" . $link . "'> $k </a><br>";
}

function links($name, $value) {
    $link = "";
    if ($name === "Paypal") {
        $link = "https://www.sandbox.paypal.com/connect/?flowEntry=static&client_id=".$value['clientId']."&response_type=code&scope=".$value['scope']."&redirect_uri=".$value['redirect_uri']."&state=".$value['state'];
    }

    if ($name === "Linkedin") {
    $link = $value['access_link']. "?response_type=code&client_id=" . $value['clientId'] . "&redirect_uri=" . $value['redirect_uri'] . "&state=" . $value['state'] ."&scope=" . $value['scope'];
    }


    return $link;



}

// Router
$route = strtok($_SERVER['REQUEST_URI'], '?');
switch ($route) {
    case '/callback':
        (new PaypalProvider($providers['paypal']['clientId'], $providers['paypal']['clientSecret'], $providers['paypal']["state"]))->callback();
        break;

    case '/callbackLinkedin':
        (new LinkedinProvider($providers['Linkedin']['clientId'], $providers['Linkedin']['clientSecret'], $providers['Linkedin']["state"], $providers['Linkedin']['scope'], $providers['Linkedin']['redirect_uri'], $providers['Linkedin']['uri_auth'], $providers['Linkedin']['access_link']))->callbackLinkedin();
        break;
}
