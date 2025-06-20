<?php
include("../db/db.php");

$sendData = json_decode($_POST['sendData'], true);
$category_id = trim(mysqli_real_escape_string($con, $sendData['category_id']));

$categoryDataGet = mysqli_query($con, "SELECT category_id,
                                            category_name
                                        FROM tbl_category_master
                                        WHERE category_id='" . $category_id . "'");
$categoryData = mysqli_fetch_assoc($categoryDataGet);

$dataget = mysqli_query($con, "SELECT
                                    product_name, 
                                    lowest_price, 
                                    highest_price 
                            FROM tbl_category_rate_list
                            WHERE category_id='" . $categoryData['category_id'] . "'");

## Check if data exists
echo '<div class="container cont" style="background-color: #e2ebdd; border-radius:8px;">
        <h2 style="font-size:20px;" class="text-center pt-3">' . htmlspecialchars($categoryData['category_name']) . ' Rate List (Rs ₹)</h2>';

if (mysqli_num_rows($dataget) > 0) {
    echo '<p class="rate-list-description">Scrap is valued by weight. Final rates depend on the weight of collected products</p> 
            <div class="custom-scrollbar-container">
                <table class="table table-bordered table-hover" style="margin: 0;">
                    <thead style="position: sticky; top: 0; z-index: 9999; background-color: #d8e6ca; text-align: center">
                        <tr>
                            <th>Product</th>
                            <th>Range</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">';
    while ($data = mysqli_fetch_assoc($dataget)) {
        echo '<tr>
                <td>' . htmlspecialchars($data['product_name']) . '</td>
                <td>' . htmlspecialchars($data['lowest_price']) . ' - ' . htmlspecialchars($data['highest_price']) . '</td>
              </tr>';
    }
    echo '      </tbody>
                </table>
            </div>
        </div>';
} else {
    echo '<div class="custom-scrollbar-container">
                <table class="table table-bordered table-hover" style="margin: 0;">
                    <thead style="position: sticky; top: 0; z-index: 9999; background-color: #d8e6ca; text-align: center">
                        <tr>
                            <th>Product Name</th>
                            <th>Lowest Price</th>
                            <th>Highest Price</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr>
                            <td colspan="3" style="text-align: center; color: #555; font-size: 16px; padding: 10px;">No Data Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>';
}
?>