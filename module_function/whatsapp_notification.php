<?php
include("../templates/db/db.php");
include("../templates/db/router.php");

function sendWhatsappMessage()
{
    global $con, $sendPhoneNumber, $fetchUserName, $campaignName, $params, $media;

    // Headers for the request
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer YOUR_ACCESS_TOKEN',
        'User-Agent: MyApp/1.0',
        'Accept: application/json',
    ];

    // Payload data
    $data = [
        "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY3NTE0YTFlZDVlZTI1MGMwYWI4MzE1ZiIsIm5hbWUiOiJaQUcgVGVjaCBTb2x1dGlvbnMgUHZ0IEx0ZCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NzUxNGExZGQ1ZWUyNTBjMGFiODMxMjYiLCJhY3RpdmVQbGFuIjoiUFJPX01PTlRITFkiLCJpYXQiOjE3MzUzNjY0ODl9.JKw6kMM7V37qOqHiPWwoORmiPA6sbWPc7HovocvyeX4",
        "campaignName" => $campaignName,
        "destination" => +91 . $sendPhoneNumber,
        "userName" => $fetchUserName,
        "templateParams" => $params,
        "media" => $media,
    ];

    // Initialize cURL
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://backend.api-wa.co/campaign/myoperator/api/v2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    $status = ($httpCode == 200) ? 'Success' : 'Failure';
    $requestData = json_encode($data);

    $sql = "INSERT INTO whatsapp_logs (campaign_name, phone_number, user_name, message_status, response_data, request_data) 
        VALUES ('$campaignName', '$sendPhoneNumber', '$fetchUserName', '$status', '$response', '$requestData')";
    mysqli_query($con, $sql);
    if ($curlError) {
        $status = 'Curl Error: ' . $curlError;
    }
}
