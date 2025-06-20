<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$user_id = $sendData['user_id'];
$baseUrl = trim(mysqli_real_escape_string($con, $sendData['baseUrl']));

$address_id_fetch_query = mysqli_query($con, "SELECT address_id FROM tbl_user_master WHERE user_id = '$user_id'");

if ($address_id_fetch_query && mysqli_num_rows($address_id_fetch_query) > 0) {
    $address_id_fetch_row = mysqli_fetch_assoc($address_id_fetch_query);
    $address_id = $address_id_fetch_row['address_id'];

    $query = "SELECT 
                address_name, 
                address_line_1, 
                landmark, 
                city, 
                pincode, 
                state, 
                country 
              FROM tbl_address_master 
              WHERE address_id = '$address_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div style="margin-bottom: 10px;">
                    <span style="font-weight: bold; width: 150px; display: inline-block;">Address Name:</span>
                    <span style="word-wrap: break-word;">' . htmlspecialchars($row['address_name']) . '</span>
                  </div>
                  <div style="margin-bottom: 10px; display: flex; align-items: flex-start;">
                    <span style="font-weight: bold; width: 154px; display: inline-block; flex-shrink: 0; vertical-align: top;">Address:</span>
                    <span style="display: inline-block; max-width: calc(100% - 160px); overflow: hidden; text-overflow: ellipsis; vertical-align: top;">' . htmlspecialchars($row['address_line_1']) . '</span>
                  </div>
                  <div style="margin-bottom: 10px;">
                    <span style="font-weight: bold; width: 150px; display: inline-block;">Landmark:</span>
                    <span>' . htmlspecialchars($row['landmark']) . '</span>
                  </div>
                  <div style="margin-bottom: 10px;">
                    <span style="font-weight: bold; width: 150px; display: inline-block;">City:</span>
                    <span>' . htmlspecialchars($row['city']) . '</span>
                  </div>
                  <div style="margin-bottom: 10px;">
                    <span style="font-weight: bold; width: 150px; display: inline-block;">Pincode:</span>
                    <span>' . htmlspecialchars($row['pincode']) . '</span>
                  </div>
                  <div style="margin-bottom: 10px;">
                    <span style="font-weight: bold; width: 150px; display: inline-block;">State:</span>
                    <span>' . htmlspecialchars($row['state']) . '</span>
                  </div>
                  <div style="margin-bottom: 10px;">
                    <span style="font-weight: bold; width: 150px; display: inline-block;">Country:</span>
                    <span>' . htmlspecialchars($row['country']) . '</span>
                  </div>
                  <hr>';
        }
        if (mysqli_num_rows($result) >= 1) {
          echo '<a href='.$baseUrl.'/manage_collectors_assigned_addresses/MC_66754c3661c6b1718963254/'.$user_id.' target="_blank;"><button type="button" class="btn btn-light-primary font-weight-bold desktop_view" style="margin-top: 20px; color: primary;" id="manageAddressButton">Manage Address</button></a>';
      }
    } else {
        echo 'No Address Found.';
    }
} else {
    echo 'No Assigned Address Found.';
}
?>
