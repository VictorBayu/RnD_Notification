<?php
$conn = mysqli_connect("localhost", "root", "", "rnd_notif");
$curl = curl_init();

function kirimTele()
{
    if (isset($_POST['submit'])) {
        global $curl;

        $url = "https://api.telegram.org/bot1389960601:AAGAAqmhYZQmbtfsVbRToncEb9ERr8l1IG4/sendMessage?chat_id=" . $_POST['chatid'] . "&parse_mode=HTML&text=" . $_POST['pesan'];
        $curlHandle = $curl;
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
}

function checkDB() {
    global $curl, $conn;

    $url = "https://api.telegram.org/bot1389960601:AAGAAqmhYZQmbtfsVbRToncEb9ERr8l1IG4/getUpdates";
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"),
    ));

    $res = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $data = json_decode($res, true);
    $data = $data['result'];
    $tmp = array();
    for ($i=0; $i < sizeof($data); $i++) { 
        $id = $data[$i]['message']['chat']['id'];
        $txt = $data[$i]['message']['text'];
        if (is_numeric($txt)) {
            // echo "[$i]= id[$id] No($txt) adalah Phone <br>";
            array_push($tmp, [$id, $txt]);
        }
    }
    for ($i=0; $i < sizeof($tmp); $i++) { 
        $sql = "UPDATE contact SET tele_userID =".$tmp[$i][0]." WHERE telegram=".$tmp[$i][1];
        if (mysqli_query($conn, $sql)) {
            echo "Saved to [".$tmp[$i][1]."] value chatID =".$tmp[$i][0];
            echo "<br>";
        } else {
            echo "Save Failed [".$tmp[$i][1]."] value chatID =".$tmp[$i][0];
            echo "<br>";
        }
    }
}

?>