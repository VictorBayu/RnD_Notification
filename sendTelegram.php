<?php
    
    if(isset($_POST['submit'])){

        $url="https://api.telegram.org/bot1389960601:AAGAAqmhYZQmbtfsVbRToncEb9ERr8l1IG4/sendMessage?chat_id=".$_POST['chatid']."&parse_mode=HTML&text=".$_POST['pesan'];
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);
    
        echo "Pesan Telah Terkirim";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action='' method='POST'>
            Chat ID    : <textarea id='chatid' name='chatid'></textarea><br>
            Pesan      : <textarea id='pesan' name='pesan'></textarea><br>
            <input type='submit' id='submit' name='submit' value='Kirim Pesan'>
    </form>
</body>
</html>
