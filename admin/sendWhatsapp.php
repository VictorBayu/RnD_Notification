<?php
$curl = curl_init();
$token = "4hgvjjxIPLHI5n1LYG2U0s2wdw4vhADZmZzIkgnxDCR1kg07EwwP3ovGiA9u98Ps";
$domain = "https://cepogo.wablas.com";


function sendMessage($phone, $message)
{
    global $token, $curl, $domain;
    $data = [
        'phone' => $phone,
        'message' => $message,
    ];
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Authorization: $token",
        )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "$domain/api/send-message");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    // curl_close($curl);
}

function getDeviceInfo()
{
    global $domain, $token;
    // $qr =  "$domain/generate/index.php?token=$token&url=aHR0cHM6Ly9jb25zb2xlLndhYmxhcy5jb20";
    $info = "$domain/api/device/info?token=$token";
    return $info;
}

function changeSender($phone)
{
    global $token, $curl, $domain;
    $data = [
        'phone' => $phone,
    ];
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Authorization: $token",
        )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "$domain/api/device/change-sender");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    echo "<pre>";
    print_r($result);
}
