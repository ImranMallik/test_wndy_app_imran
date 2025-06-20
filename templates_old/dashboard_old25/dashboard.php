<?php
include("module_function/date_time_format.php");

$user_dataget = mysqli_query($con, "SELECT 
    tbl_user_master.name
    FROM tbl_user_master WHERE user_id = '" . $session_user_code . "'");
$user_data = mysqli_fetch_assoc($user_dataget);

// print_r($session_user_code);
?>

<script>
    const session_user_type = "<?php echo $session_user_type; ?>";
</script>

<!-- Body Container -->
<div id="page-content" class="pb-5">



    <!-- Seller Dashboard start -->
    <?php
    if ($session_user_type == "Seller") {
    ?>

        <div class="container">
            <h2 class="welcome pt-3">Welcome <span><?php echo $user_data['name'] ?></span></h2>
            <h2 class="section-title">Your Activity</h2>

            <div class="cards-grid">
                <?php
                // Fetch Address Count
                $seller_total_address = mysqli_query($con, "SELECT COUNT(*) AS total_addresses FROM tbl_address_master WHERE user_id = '" . $session_user_code . "'");
                $seller_total_address_rw = mysqli_fetch_assoc($seller_total_address);
                ?>
                <a href="<?php echo $baseUrl . "/address-book"; ?>" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <div class="card-number"><?php echo $seller_total_address_rw['total_addresses'] ?></div>
                        <div class="card-title">Addresses</div>
                        <img src="assets/images/dashbord/_x36_.png" alt="" class="icon-db">
                    </div>
                </a>

<?php
// Fetch Active (including Post Viewed) Products Count
$open_product = mysqli_query($con, "
    SELECT COUNT(*) AS total_products 
    FROM tbl_product_master 
    WHERE user_id = '" . $session_user_code . "' 
    AND product_status IN ('Active', 'Post Viewed')
");
$open_product_rw = mysqli_fetch_assoc($open_product);
?>

                
<a href="<?php echo $baseUrl . "/product_list"; ?>" 
   class="open-items-link" 
   style="text-decoration: none; color: inherit;">
    <div class="card filter-card" style="cursor: pointer;">
        <div class="card-title">Open Items</div>
        <div class="card-number"><?php echo $open_product_rw['total_products']; ?></div>
        <img src="assets/images/dashbord/Frame 12.png" alt="" class="icon-db-open-item">
    </div>


                <?php
                // Fetch Under Negotiation Items Count
                $dataget = mysqli_query($con, "SELECT COUNT(*) AS total_under_negotiation_products FROM tbl_product_master WHERE user_id = '" . $session_user_code . "' AND product_status = 'Under Negotiation'");
                $data = mysqli_fetch_assoc($dataget);
                ?>
<a href="<?php echo $baseUrl . "/product_list"; ?>" 
   style="text-decoration: none; color: inherit;"
   onclick="setFilterUnderNegotiation(event, 'in-process')">
    <div class="card" style="cursor: pointer;">
        <div class="card-number"><?php echo $data['total_under_negotiation_products']; ?></div>
        <div class="card-title">Under Negotiation</div>
        <img src="assets/images/dashbord/_x31_6.png" alt="" class="icon-db-under-nego">
    </div>
</a>


                <?php
                // Fetch Completed (Closed) Items Count
                $dataget = mysqli_query($con, "SELECT COUNT(*) AS Completed FROM tbl_product_master WHERE user_id = '" . $session_user_code . "' AND product_status = 'Completed'");
                $data = mysqli_fetch_assoc($dataget);
                ?>
                <a href="<?php echo $baseUrl . "/product_list"; ?>" style="text-decoration: none; color: inherit;" onclick="setFilterClosedItem(event, 'Completed')">
                    <div class="card" style="cursor: pointer;">
                        <div class="card-number"><?php echo $data['Completed'] ?></div>
                        <div class="card-title">Closed Items</div>
                        <img src="assets/images/dashbord/_x31_4.png" alt="" class="icon-db-close-item">
                    </div>
                </a>
            </div>

            <?php
            // Fetch Total Items
            $total_products = mysqli_query($con, "SELECT COUNT(*) AS total_user_products FROM tbl_product_master WHERE user_id = '" . $session_user_code . "'");
            $total_products_rw = mysqli_fetch_assoc($total_products);
            ?>

            <div class="total-items">
              <a href="<?php echo $baseUrl . "/product_list"; ?>" style="text-decoration: none; color: inherit;" onclick="sellerTotalItems(event, 'all')">
                <span>Total Items</span>
                <span><?php echo $total_products_rw['total_user_products']; ?></span>
                </a>
            </div>

            <!-- Add Chart Section Here -->
            <div class="row">
                <div class="col-md-6">
                    <div class="main-sellerItemListingChart">
                        <?php
                        // seller total open items
                        $dataget = mysqli_query($con, "select count(*) from tbl_product_master where user_id='" . $session_user_code . "' and product_status='Active' ");

                        $data = mysqli_fetch_row($dataget);
                        
                        $totalOpenItems = $data[0] == "" ? 0 : $data[0];
                        
                        // print_r($totalOpenItems);

                        // seller total deal Under Negotiation items
                        $dataget = mysqli_query($con, "SELECT COUNT(*) AS total_under_negotiation_products FROM tbl_product_master WHERE user_id = '" . $session_user_code . "' AND product_status = 'Under Negotiation'");
                        $data = mysqli_fetch_row($dataget);
                        $totalUnderNegotiationItems = $data[0] == "" ? 0 : $data[0];

                        // seller total closed item
                        $dataget = mysqli_query($con, "select count(*) from tbl_product_master where user_id='" . $session_user_code . "' and product_status='Completed' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalClosedItems = $data[0] == "" ? 0 : $data[0];


                        $chartShow = "Yes";
                        if ($totalOpenItems == 0 && $totalUnderNegotiationItems == 0 && $totalClosedItems == 0) {
                            $chartShow = "No";
                        }
                        ?>
<script>
    const sellerItemListingValue = [
        <?php echo $totalOpenItems; ?>,
        <?php echo $totalUnderNegotiationItems; ?>,
        <?php echo $totalClosedItems; ?>
    ];

    const sellerItemListingLable = ['Open Item', 'Under Negotiation', 'Closed Item'];

    // 👉 Fixed color mapping (based on label order)
    const sellerItemListingColor = ['#845834', '#de9457', '#B17F4A'];
</script>

                        <h3 class="chart-heading">Items Listing</h3>
                        <?php
                        if ($chartShow == "No") {
                        ?>
                            <p style="color: red;text-align: center;">No Data Found</p>
                        <?php
                        }
                        ?>
                        <div id="sellerItemListingChart" class="<?php echo $chartShow == "No" ? 'd-none' : null; ?>">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="main-sellerScrapValuationChart">
                        <?php
                        // seller total open items
                        $dataget = mysqli_query($con, "SELECT SUM(sale_price) FROM tbl_product_master WHERE user_id='" . $session_user_code . "' AND product_status='Active'");
                      $data = mysqli_fetch_row($dataget);
                      $totalOpenItems = $data[0] == "" ? 0 : $data[0];



                        // seller total deal Under Negotiation items
$dataget = mysqli_query($con, "SELECT SUM(tbl_user_product_view.purchased_price) FROM tbl_user_product_view WHERE tbl_user_product_view.seller_id='" . $session_user_code . "' AND tbl_user_product_view.deal_status='Under Negotiation'");
$data = mysqli_fetch_row($dataget);
$totalUnderNegotiationItems = (!empty($data[0]) && $data[0] > 0) ? $data[0] : 1;
// echo "<pre>";
// print_r($data);
// echo "</pre>";

                        // seller total closed item
                        $dataget = mysqli_query($con, "SELECT SUM(sale_price) FROM tbl_product_master WHERE user_id='" . $session_user_code . "' AND product_status='Completed'");
$data = mysqli_fetch_row($dataget);
$totalClosedItems = $data[0] == "" ? 0 : $data[0];

// echo "<pre>";
// print_r($data);
// echo "</pre>";

                        $chartShow = "Yes";
                        if ($totalOpenItems == 0 && $totalUnderNegotiationItems == 0 && $totalClosedItems == 0) {
                            $chartShow = "No";
                        }
                        ?>
                        <script>
                            const sellerScrapValuationValue = [<?php echo $totalOpenItems; ?>, <?php echo $totalUnderNegotiationItems; ?>, <?php echo $totalClosedItems; ?>];
                            const sellerScrapValuationLabel = [
                                ['Open'],
                                ['Under', 'Negotiation'],
                                ['Closed', 'Item']
                            ];
                            
                            function assignColors(values) {
        let sorted = [...values].sort((a, b) => b - a); // Sort from highest to lowest
        return values.map(value => {
            if (value === sorted[0]) return '#845834'; // Highest value (Green)
            if (value === sorted[1]) return '#de9457'; // Middle value (Orange)
            return '#B17F4A'; // Lowest value (Dark Blue)
        });
    }

    const sellerScrapValuationColor = assignColors(sellerScrapValuationValue);
                        </script>
                        <h3 class="chart-heading">Total Scrap Value</h3>
                        <?php
                        if ($chartShow == "No") {
                        ?>
                            <p style="color: red;text-align: center;">No Data Found</p>
                        <?php
                        }
                        ?>
                        <div id="sellerScrapValuationChart" class="<?php echo $chartShow == "No" ? "d-none" : null; ?>">

                        </div>

                    </div>
                </div>
            </div>

        </div>

    <?php } ?>

    <!-- Buyer Dashboadr -->
    <?php
    if ($session_user_type == "Buyer") {
    ?>
        <div class="container">
            <h2 class="welcome pt-3">Welcome <span><?php echo $user_data['name'] ?></h2>

            <h2 class="section-title">Your Activity</h2>

            <div class="cards-grid">
<?php
$seller_total_pickups =  mysqli_query($con, "
    SELECT COUNT(*) AS total_pickups
    FROM tbl_user_product_view 
    LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
    WHERE 
        tbl_user_product_view.buyer_id = '" . $session_user_code . "' AND 
        tbl_user_product_view.pickup_date >= '" . $date . "' AND 
        tbl_user_product_view.deal_status = 'Pickup Scheduled'
");
$seller_total_pickups_rw = mysqli_fetch_assoc($seller_total_pickups);
?>

<a href="<?php echo $baseUrl . "/upcoming-pickups"; ?>" class="card-link">
    <div class="card">
        <div class="card-number"><?php echo $seller_total_pickups_rw['total_pickups']; ?></div>
        <div class="card-title">Upcoming Pickups</div>
        <img src="assets/images/dashbord/_x36_.png" alt="" class="icon-db">
    </div>
</a>

                <?php
                $buyer_total_collector = mysqli_query($con, "SELECT COUNT(*) AS total_collector FROM tbl_user_master WHERE tbl_user_master.under_buyer_id = '" . $session_user_code . "' ");
                $buyer_total_collector_rw = mysqli_fetch_assoc($buyer_total_collector);
                ?>
                <a href="<?php echo $baseUrl . '/collector' ?>" class="card-link">
                    <div class="card">
                        <div class="card-number"> <?php echo $buyer_total_collector_rw['total_collector'] ?></div>
                        <div class="card-title">Collectors</div>
                        <img src="assets/images/dashbord/Frame 12.png" alt="" class="icon-db-open-item">
                    </div>
                </a>
<?php
// Fetch Under Negotiation count with an alias
$dataget = mysqli_query($con, "SELECT COUNT(*) AS total_under_negotiation_products FROM tbl_user_product_view WHERE buyer_id='" . $session_user_code . "' AND deal_status='Under Negotiation'");

// Fetch the data properly
$data = mysqli_fetch_assoc($dataget);

// Debugging: Print data to check result
// echo "<pre>";
// print_r($data);
// echo "</pre>";

// Ensure variable exists to avoid undefined errors
$totalUnderNegotiation = isset($data['total_under_negotiation_products']) ? $data['total_under_negotiation_products'] : 0;
?>
<a href="<?php echo $baseUrl . "/product_list"; ?>" 
   style="text-decoration: none; color: inherit;"
   onclick="setFilterUnderNegotiation(event, 'in-process')">
    <div class="card" style="cursor: pointer;">
        <div class="card-number"><?php echo $totalUnderNegotiation; ?></div>
        <div class="card-title">Under Negotiation</div>
        <img src="assets/images/dashbord/_x31_6.png" alt="" class="icon-db-under-nego">
    </div>
</a>

<?php
// Using alias for count and optional security best practices
$open_product = mysqli_query($con, "SELECT COUNT(*) AS total_open_product FROM tbl_product_master WHERE product_status = 'Active' ");
$open_product_rw = mysqli_fetch_assoc($open_product);
?>
<a href="<?php echo $baseUrl . "/deal-items"; ?>" style="text-decoration: none; color: inherit;">
    <div class="card" style="cursor: pointer;">
        <div class="card-number"><?php echo $open_product_rw['total_open_product']; ?></div>
        <div class="card-title">Open Items</div>
        <img src="assets/images/dashbord/_x31_4.png" alt="" class="icon-db-close-item">
    </div>
</a>

            </div>

            <?php
            $buyer_total_in_credit = mysqli_query($con, "SELECT SUM(in_credit) AS total_in_credit FROM tbl_credit_trans WHERE tbl_credit_trans.user_id = '" . $session_user_code . "' ");
            $buyer_total_in_credit_rw = mysqli_fetch_assoc($buyer_total_in_credit);

            $buyer_total_out_credit = mysqli_query($con, "SELECT SUM(out_credit) AS total_out_credit FROM tbl_credit_trans WHERE tbl_credit_trans.user_id = '" . $session_user_code . "' ");
            $buyer_total_out_credit_rw = mysqli_fetch_assoc($buyer_total_out_credit);

            $buyer_total_credit = $buyer_total_in_credit_rw['total_in_credit'] - $buyer_total_out_credit_rw['total_out_credit'];
            ?>

            <div class="total-items">
                <span>Credits</span>
                <span> <?php echo $buyer_total_credit ?></span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="main-itemListingChart">
                        <?php
                        // buyer total view item
                        $dataget =
                         mysqli_query($con, "SELECT COUNT(*) AS total_open_product FROM tbl_product_master WHERE product_status = 'Active'");
                        $data = mysqli_fetch_row($dataget);
                        $totalViewItem = $data[0];
                    //      echo "<pre>";
                    //  print_r($data);
                    //      echo "</pre>";

                        // buyer total purchased item
                        $dataget = mysqli_query($con, "select count(*) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Completed' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalPurchasedItem = $data[0];

                        // buyer total negotiation item
                        $dataget = mysqli_query($con, "select count(*) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Under Negotiation' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalNegotiationItem = $data[0];
                    //      echo "<pre>";
                    //  print_r($data);
                    //      echo "</pre>";

                        // buyer total closed item
                        $dataget = mysqli_query($con, "select count(*) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Offer Rejected' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalClosedItem = $data[0];

                        // items in buyer zone
                        $dataget = mysqli_query($con, "select 
                                    count(*) 
                                    from tbl_product_master 
                                    LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id 
                                    where tbl_address_master.pincode IN (select pincode from tbl_address_master where user_id='" . $session_user_code . "' ) and tbl_product_master.product_status='Active' ");
                        $data = mysqli_fetch_row($dataget);
                    //      echo "<pre>";
                    //  print_r($data);
                    //      echo "</pre>";
                        $totalItemsInZone = (!empty($data[0]) && $data[0] > 0) ? $data[0] : 0;

                        // Create an array of values
                   $itemValues = [$totalViewItem, $totalPurchasedItem, $totalNegotiationItem, $totalClosedItem, $totalItemsInZone];

                 // Predefined color set
                $availableColors = ['#B17F4A', '#de9457', '#845834', '#f8b883', '#e6c9a8'];

            // Sort values in descending order
              $sortedValues = $itemValues;
               rsort($sortedValues);

               // Assign colors dynamically based on value ranking
                  $itemColors = [];
                  foreach ($itemValues as $index => $val) {
                      $rank = array_search($val, $sortedValues); // Get ranking
                      $itemColors[$index] = $availableColors[$rank] ?? '#B17F4A'; // Assign color based on rank
                  }
                  
                  $chartShow = ($totalViewItem == 0 && $totalPurchasedItem == 0 && $totalNegotiationItem == 0 && $totalClosedItem == 0 && $totalItemsInZone == 0) ? "No" : "Yes";
                        ?>
                        <script>
                             const itemListingValue = [<?php echo implode(", ", $itemValues); ?>];
                      const itemListingLable = [
              'Open Items',
              'Completed',
              'Under Negotiation',
              'Offer Rejected',
              'Items In My Area'
    ];

         const itemListingColor = [
            '#006335',   
           '#de9457',   
           '#845834',   
          '#f8b883',   
            '#e6c9a8'    
             ];
                        </script>
                        <h3 class="chart-heading">Items Listing</h3>
                        <?php
                        if ($chartShow == "No") {
                        ?>
                            <p style="color: red;text-align: center;">No Data Found</p>
                        <?php
                        }
                        ?>
                        <div id="itemListingChart" class="<?php echo $chartShow == "No" ? 'd-none' : null; ?>">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="main-scrapValuationChart">
                        <?php
                        // buyer total view item
                        $dataget = mysqli_query($con, "select 
                                    sum(tbl_product_master.sale_price) 
                                    from tbl_user_product_view 
                                    LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
                                    where tbl_user_product_view.buyer_id='" . $session_user_code . "' and tbl_user_product_view.deal_status='Credit Used' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalViewItem = $data[0] == "" ? 0 : $data[0];

                        // buyer total purchased item
                        $dataget = mysqli_query($con, "select sum(purchased_price) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Completed' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalPurchasedItem = $data[0] == "" ? 0 : $data[0];

                        // buyer total negotiation item
                        $dataget = mysqli_query($con, "select sum(negotiation_amount) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Under Negotiation' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalNegotiationItem = $data[0] == "" ? 0 : $data[0];

                        // buyer total closed item
                        $dataget = mysqli_query($con, "select 
                                    sum(tbl_product_master.sale_price) 
                                    from tbl_user_product_view 
                                    LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
                                    where tbl_user_product_view.buyer_id='" . $session_user_code . "' and tbl_user_product_view.deal_status='Offer Rejected' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalClosedItem = $data[0] == "" ? 0 : $data[0];

                        // items in buyer zone
                        $dataget = mysqli_query($con, "select 
                                    sum(tbl_product_master.sale_price)
                                    from tbl_product_master 
                                    LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_product_master.address_id 
                                    where tbl_address_master.pincode IN (select pincode from tbl_address_master where user_id='" . $session_user_code . "' ) and tbl_product_master.product_status='Active' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalItemsInZone = $data[0] == "" ? 0 : $data[0];

                        $chartShow = "Yes";
                        if ($totalViewItem == 0 && $totalPurchasedItem == 0 && $totalNegotiationItem == 0 && $totalClosedItem == 0 && $totalItemsInZone == 0) {
                            $chartShow = "No";
                        }

                        ?>
                        <script>
                            const scrapValuationValue = [<?php echo $totalViewItem; ?>, <?php echo $totalPurchasedItem; ?>, <?php echo $totalNegotiationItem; ?>, <?php echo $totalClosedItem; ?>, <?php echo $totalItemsInZone; ?>];
                            const scrapValuationLable = ['Post Viewed', 'Completed', 'Under Negotiation', 'Offer Rejected', 'Items In My Area'];
                            const scrapValuationColor = ['#B17F4A', '#de9457', '#845834', '#f8b883', '#e6c9a8'];
                        </script>
                        <h3 class="chart-heading">Scrap Valuation</h3>
                        <?php
                        if ($chartShow == "No") {
                        ?>
                            <p style="color: red;text-align: center;">No Data Found</p>
                        <?php
                        }
                        ?>
                        <div id="scrapValuationChart" class="<?php echo $chartShow == "No" ? 'd-none' : null; ?>">

                        </div>
                    </div>
                </div>
            </div>

<div class="row">
    <div class="col-md-12">
        <div class="main-collectorPurchasedChart">
            <?php
            // Get buyer's collector name and total purchased value
            $collector_dataget = mysqli_query($con, "SELECT 
                tbl_user_master.name,
                (SELECT SUM(tbl_user_product_view.purchased_price) 
                    FROM tbl_user_product_view 
                    WHERE tbl_user_product_view.assigned_collecter = tbl_user_master.user_id
                ) AS collector_total_purchased
                FROM tbl_user_master 
                WHERE tbl_user_master.under_buyer_id = '$session_user_code' 
                AND tbl_user_master.active = 'Yes' 
                ORDER BY tbl_user_master.name ASC");

            $amountArray = [];
            $collectorArray = [];
            $minimumAmount = 0;
            $maximumAmount = 0;
            $hasData = false;

            while ($rw = mysqli_fetch_assoc($collector_dataget)) {
                $amount = (float) ($rw['collector_total_purchased'] ?? 0);
                $name = $rw['name'];

                $amountArray[] = $amount;
                $collectorArray[] = $name;

                if ($amount > 0) {
                    $hasData = true;
                }

                // Set min/max for chart
                if ($minimumAmount === 0 || $amount < $minimumAmount) {
                    $minimumAmount = $amount;
                }
                if ($amount > $maximumAmount) {
                    $maximumAmount = $amount;
                }
            }
            ?>

            <script>
                const collectorPurchasedValue = <?php echo json_encode($amountArray); ?>;
                const collectorPurchasedLable = <?php echo json_encode($collectorArray); ?>;
                const collectorMinAmountValue = <?php echo $minimumAmount; ?>;
                const collectorMaxAmountValue = <?php echo $maximumAmount; ?>;
            </script>

            <h3 class="chart-heading">Collector Wise Item Purchased</h3>

            <?php if (!$hasData) : ?>
                <p style="color: red;text-align: center;">No Data Found</p>
            <?php endif; ?>

            <div id="collectorPurchasedChart" class="<?php echo !$hasData ? 'd-none' : ''; ?>"></div>
        </div>
    </div>
</div>



            <div class="row">
                <div class="col-md-12">
                    <div class="main-buyerEarningSalesChart">
                        <?php
                        // get buyer's purchase, sale & profit details
                        $dataget = mysqli_query($con, "select sum(purchased_price) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Completed' ");
                        $data = mysqli_fetch_row($dataget);
                        $totalPurchasedAmount = $data[0] == "" ? 0 : $data[0];
                        $totalSaleAmount = 0;
                        $totalProfit = 0;

                        $chartShow = "Yes";
                        if ($totalPurchasedAmount == 0 && $totalSaleAmount == 0 && $totalProfit == 0) {
                            $chartShow = "No";
                        }
                        ?>
                        <script>
                            const buyerEarningsData = [{
                                x: 'Purchase Value',
                                y: <?php echo $totalPurchasedAmount; ?>
                            }, {
                                x: 'Sales Value',
                                y: <?php echo $totalSaleAmount; ?>
                            }, {
                                x: 'Profit Value',
                                y: <?php echo $totalProfit; ?>
                            }];
                        </script>
                        <h3 class="chart-heading">Earnings From Sales</h3>
                        <?php
                        if ($chartShow == "No") {
                        ?>
                            <p style="color: red;text-align: center;">No Data Found</p>
                        <?php
                        }
                        ?>
                        <div id="buyerEarningSalesChart" class="<?php echo $chartShow == "No" ? "d-none" : null; ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>


</div>
<?php
    } ?>


</div>