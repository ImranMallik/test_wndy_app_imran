<?php
function sendSms()
{
    global $sendMssg;
    global $sendPhNum;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://msgn.mtalkz.com/api?apikey=4uPT3yi4Irl3UVQg&senderid=ZAGTCH&number=' . urlencode($sendPhNum) . '&message=' . urlencode($sendMssg) . '&format=json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);

    curl_close($curl);

    if ($response['status'] == "OK") {
        return 'success';
    } else {
        return 'error';
    }
}
