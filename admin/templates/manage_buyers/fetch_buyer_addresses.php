<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);

$user_id = trim(mysqli_real_escape_string($con, $sendData['user_id']));
$baseUrl = trim(mysqli_real_escape_string($con, $sendData['baseUrl']));

$query = "SELECT address_name, address_line_1, landmark, city, pincode, state, country FROM tbl_address_master WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

$address_count = mysqli_num_rows($result);

if ($address_count > 0) {
  $addresses = '';
  $i = 1;
  while ($row = mysqli_fetch_assoc($result)) {
    $addresses .= '
                      <h3>Address ' . $i . '</h3>
                      <div style="margin-bottom: 10px;">
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

    $i++;
  }
  echo $addresses;
  if ($address_count >= 1) {
    echo '<a href="' . $baseUrl . '/manage_buyers_addresses/MC_646623cae9d771684415434/' . $user_id . '" target="_blank">
                <button type="button" class="btn btn-light-primary font-weight-bold desktop_view" style="margin-top: 20px; color: primary;" id="manageAddressButton">Manage Address</button>
              </a>';
  }
} else {
  echo 'No Address Found.';
}
