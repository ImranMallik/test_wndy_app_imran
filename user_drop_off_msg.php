<?php
include 'templates/db/db.php';
include 'templates/db/router.php';

// Function to send WhatsApp message and update `end_time`
function sendWhatsappMessageUserDropOff($sendPhoneNumber, $fetchUserName, $campaignName)
{
    global $con;
    // Headers for the request
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY3NTE0YTFlZDVlZTI1MGMwYWI4MzE1ZiIsIm5hbWUiOiJaQUcgVGVjaCBTb2x1dGlvbnMgUHZ0IEx0ZCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NzUxNGExZGQ1ZWUyNTBjMGFiODMxMjYiLCJhY3RpdmVQbGFuIjoiUFJPX01PTlRITFkiLCJpYXQiOjE3MzUzNjY0ODl9.JKw6kMM7V37qOqHiPWwoORmiPA6sbWPc7HovocvyeX4',
        'User-Agent: MyApp/1.0',
        'Accept: application/json',
    ];

    // Payload data
    $data = [
        "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY3NTE0YTFlZDVlZTI1MGMwYWI4MzE1ZiIsIm5hbWUiOiJaQUcgVGVjaCBTb2x1dGlvbnMgUHZ0IEx0ZCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NzUxNGExZGQ1ZWUyNTBjMGFiODMxMjYiLCJhY3RpdmVQbGFuIjoiUFJPX01PTlRITFkiLCJpYXQiOjE3MzUzNjY0ODl9.JKw6kMM7V37qOqHiPWwoORmiPA6sbWPc7HovocvyeX4",
        "campaignName" => $campaignName,
        "destination" => $sendPhoneNumber,
        "userName" => $fetchUserName,
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

    // Execute cURL and get the response
    $response = curl_exec($curl);
    $curlError = curl_error($curl);
    curl_close($curl);

    // Handle errors
    if ($curlError) {
        echo "cURL Error: " . $curlError;
        exit;
    }
    echo $response;
}
// Get the latest 10 records where `end_time` is NULL and wait 5 seconds before sending
$sql = "SELECT DISTINCT `phone_number`  FROM `tbl_whatsapp_drop_off_noti` 
        WHERE `end_time` IS NULL 
        ORDER BY `entry_time` DESC 
        LIMIT 10";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sendPhoneNumberDF = $row['phone_number'];
        $fetchUserNameDF = "Nadim";
        $campaignNameDF = "Final_drop_off_msg";

        // Check if this number exists in tbl_user_master
        $queryPhn = "SELECT ph_num FROM tbl_user_master WHERE ph_num = '$sendPhoneNumberDF'";
        $resultPhn = mysqli_query($con, $queryPhn);
        // Debugging output
        if (!$resultPhn) {
            echo "Error in Query: " . mysqli_error($con);
        }
        $numRows = mysqli_num_rows($resultPhn);

        if ($numRows == 0) {
            sendWhatsappMessageUserDropOff($sendPhoneNumberDF, $fetchUserNameDF, $campaignNameDF);
        }
        // Update `end_time` after sending message
        $end_time = date('Y-m-d H:i:s');
        $updateTbl = "UPDATE tbl_whatsapp_drop_off_noti 
              SET end_time = '$end_time'
              WHERE phone_number = '$sendPhoneNumberDF' 
              AND end_time IS NULL";

        mysqli_query($con, $updateTbl);

        echo "✅ Message sent to: $sendPhoneNumberDF, Updated end_time: $end_time \n";
    }
}

// Close database connection
mysqli_close($con);
