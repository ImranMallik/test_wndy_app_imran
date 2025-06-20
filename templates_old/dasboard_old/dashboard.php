<?php
include("module_function/date_time_format.php");

$user_dataget = mysqli_query($con, "SELECT 
    tbl_user_master.name
    FROM tbl_user_master WHERE user_id = '" . $session_user_code . "'");
$user_data = mysqli_fetch_assoc($user_dataget);
?>

<script>
    const session_user_type = "<?php echo $session_user_type; ?>";
</script>

<!-- Body Container -->
<div id="page-content" class="pb-5">
    <!--Page Header-->
  
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 mb-4 mb-lg-0">
                <?php
                include("templates/common_part/user_menu.php");
                ?>
            </div>
            <?php
            if ($session_user_type == "Seller") {
            ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                    <!-- Account Info -->
                    <div class="tab-pane fade h-100 show active" id="info">
                        <div class="account-info h-100">
                            <div class="welcome-msg mb-4">
                                <h2>Welcome to Dashboard!</h2>
                                <h2>Hi, <span class="text-primary"><?php echo $user_data['name'] ?></h2>
                                <p>View snapshots of your activity and information from your dashboard </p>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/address-book"; ?>" style="background-color: #dc357c">
                                        <div class="visual">
                                            <i class="fa fa-map-signs"></i>
                                        </div>
                                        <div class="details">
                                            <?php
                                            $seller_total_address = mysqli_query($con, "SELECT COUNT(*) AS total_addresses FROM tbl_address_master WHERE tbl_address_master.user_id = '" . $session_user_code . "' ");
                                            $seller_total_address_rw = mysqli_fetch_assoc($seller_total_address);
                                            ?>
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $seller_total_address_rw['total_addresses'] ?>">
                                                    <?php echo $seller_total_address_rw['total_addresses'] ?>
                                                </span>
                                            </div>
                                            <div class="desc"> Addresses </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/product_list"; ?>" style="background-color: #b18527">
                                        <div class="visual">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="details">
                                            <?php
                                            $total_product = mysqli_query($con, "SELECT COUNT(*) AS total_products FROM tbl_product_master WHERE tbl_product_master.user_id = '" . $session_user_code . "' ");
                                            $total_product_rw = mysqli_fetch_assoc($total_product);
                                            ?>
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $total_product_rw['total_products'] ?>">
                                                    <?php echo $total_product_rw['total_products'] ?>
                                                </span>
                                            </div>
                                            <div class="desc"> Total Items </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/product_list/open"; ?>" style="background-color: #b12727">
                                        <div class="visual">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="details">
                                            <?php
                                            $total_open_product = mysqli_query($con, "SELECT COUNT(*) AS total_open_products FROM tbl_product_master WHERE tbl_product_master.user_id = '" . $session_user_code . "' AND tbl_product_master.product_status = 'Active' ");
                                            $total_open_product_rw = mysqli_fetch_assoc($total_open_product);
                                            ?>
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $total_open_product_rw['total_open_products'] ?>">
                                                    <?php echo $total_open_product_rw['total_open_products'] ?>
                                                </span>
                                            </div>
                                            <div class="desc"> Open Items </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/product_list/under_negotiation"; ?>" style="background-color: #2786b1">
                                        <div class="visual">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="details">
                                            <?php
                                            $dataget = mysqli_query($con, "SELECT COUNT(*) AS total_under_negotiation_products FROM tbl_product_master WHERE tbl_product_master.user_id = '" . $session_user_code . "' AND tbl_product_master.product_status = 'Under Negotiation' ");
                                            $data = mysqli_fetch_assoc($dataget);
                                            ?>
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $data['total_under_negotiation_products'] ?>">
                                                    <?php echo $data['total_under_negotiation_products'] ?>
                                                </span>
                                            </div>
                                            <div class="desc"> Under Negotiation Items </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/product_list/completed"; ?>" style="background-color: #478f17">
                                        <div class="visual">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="details">
                                            <?php
                                            $total_closed_product = mysqli_query($con, "SELECT COUNT(*) AS total_closed_products FROM tbl_product_master WHERE tbl_product_master.user_id = '" . $session_user_code . "' AND tbl_product_master.product_status = 'Completed' ");
                                            $total_closed_product_rw = mysqli_fetch_assoc($total_closed_product);
                                            ?>
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $total_closed_product_rw['total_closed_products'] ?>">
                                                    <?php echo $total_closed_product_rw['total_closed_products'] ?>
                                                </span>
                                            </div>
                                            <div class="desc"> Closed Items </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="main-sellerItemListingChart">
                                        <?php
                                        // seller total open items
                                        $dataget = mysqli_query($con, "select count(*) from tbl_product_master where user_id='" . $session_user_code . "' and product_status='Active' ");
                                        $data = mysqli_fetch_row($dataget);
                                        $totalOpenItems = $data[0] == "" ? 0 : $data[0];

                                        // seller total deal Under Negotiation items
                                        $dataget = mysqli_query($con, "select 
                                            count(*) 
                                            from tbl_user_product_view 
                                            where tbl_user_product_view.seller_id='" . $session_user_code . "' and
                                            tbl_user_product_view.deal_status='Under Negotiation' ");
                                        $data = mysqli_fetch_row($dataget);
                                        $totalDealCompletedItems = $data[0] == "" ? 0 : $data[0];;

                                        // seller total closed item
                                        $dataget = mysqli_query($con, "select count(*) from tbl_product_master where user_id='" . $session_user_code . "' and product_status='Completed' ");
                                        $data = mysqli_fetch_row($dataget);
                                        $totalClosedItems = $data[0] == "" ? 0 : $data[0];


                                        $chartShow = "Yes";
                                        if ($totalOpenItems == 0 && $totalDealCompletedItems == 0 && $totalClosedItems == 0) {
                                            $chartShow = "No";
                                        }
                                        ?>
                                        <script>
                                            const sellerItemListingValue = [<?php echo $totalOpenItems; ?>, <?php echo $totalDealCompletedItems; ?>, <?php echo $totalClosedItems; ?>];
                                            const sellerItemListingLable = ['Active', 'Under Negotiation', 'Closed Item'];
                                            const sellerItemListingColor = ['#145F82', '#E87331', '#186C24'];
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
                                        $dataget = mysqli_query($con, "select sum(sale_price) from tbl_product_master where user_id='" . $session_user_code . "' and product_status='Active' ");
                                        $data = mysqli_fetch_row($dataget);
                                        $totalOpenItems = $data[0] == "" ? 0 : $data[0];

                                        // seller total deal Under Negotiation items
                                        $dataget = mysqli_query($con, "select 
                                            sum(tbl_user_product_view.purchased_price) 
                                            from tbl_user_product_view 
                                            where tbl_user_product_view.seller_id='" . $session_user_code . "' and
                                            tbl_user_product_view.deal_status='Under Negotiation' ");
                                        $data = mysqli_fetch_row($dataget);
                                        $totalDealCompletedItems = $data[0] == "" ? 0 : $data[0];

                                        // seller total closed item
                                        $dataget = mysqli_query($con, "select sum(sale_price) from tbl_product_master where user_id='" . $session_user_code . "' and product_status='Completed' ");
                                        $data = mysqli_fetch_row($dataget);
                                        $totalClosedItems = $data[0] == "" ? 0 : $data[0];

                                        $chartShow = "Yes";
                                        if ($totalOpenItems == 0 && $totalDealCompletedItems == 0 && $totalClosedItems == 0) {
                                            $chartShow = "No";
                                        }
                                        ?>
                                        <script>
                                            const sellerScrapValuationValue = [<?php echo $totalOpenItems; ?>, <?php echo $totalDealCompletedItems; ?>, <?php echo $totalClosedItems; ?>];
                                            const sellerScrapValuationLabel = [
                                                ['Active'],
                                                ['Under', 'Negotiation'],
                                                ['Closed', 'Item']
                                            ];
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
                    </div>
                    <!-- End Account Info -->
                </div>
            <?php
            }
            ?>
            <!-- buyer Dashboard start -->
            <?php
            if ($session_user_type == "Buyer") {
            ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                    <h2>Welcome to Dashboard!</h2>
                    <h2>Hi, <span class="text-primary"><?php echo $user_data['name'] ?></h2>
                    <p>View snapshots of your activity and information from your dashboard </p>

                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                            <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/upcoming-pickups"; ?>" style="background-color: #dc357c">
                                <div class="visual">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="details">
                                    <?php
                                    $dataget = mysqli_query($con, "select 
                                        tbl_product_master.product_name,    
                                        tbl_user_product_view.product_id,    
                                        tbl_user_product_view.pickup_date,    
                                        tbl_user_product_view.pickup_time 
                                        from tbl_user_product_view 
                                        LEFT JOIN tbl_product_master ON tbl_product_master.product_id = tbl_user_product_view.product_id
                                        where tbl_user_product_view.buyer_id='" . $session_user_code . "' and 
                                        tbl_user_product_view.pickup_date >= '" . $date . "' and tbl_user_product_view.deal_status='Pickup Scheduled' ");
                                    $data = mysqli_num_rows($dataget);
                                    ?>
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $data; ?>">
                                            <?php echo $data == "" ? 0 : $data; ?>
                                        </span>
                                    </div>
                                    <div class="desc">Under Negotiation</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                            <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/address-book"; ?>" style="background-color: #3598dc">
                                <div class="visual">
                                    <i class="fa fa-map-signs"></i>
                                </div>
                                <div class="details">
                                    <?php
                                    $buyer_total_address = mysqli_query($con, "SELECT COUNT(*) AS total_addresses FROM tbl_address_master WHERE tbl_address_master.user_id = '" . $session_user_code . "' ");
                                    $buyer_total_address_rw = mysqli_fetch_assoc($buyer_total_address);
                                    ?>
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $buyer_total_address_rw['total_addresses'] ?>">
                                            <?php echo $buyer_total_address_rw['total_addresses'] ?>
                                        </span>
                                    </div>
                                    <div class="desc"> Addresses </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                            <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/credit_addon"; ?>" style="background-color: #4d35dc">
                                <div class="visual">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <div class="details">
                                    <?php
                                    $buyer_total_in_credit = mysqli_query($con, "SELECT SUM(in_credit) AS total_in_credit FROM tbl_credit_trans WHERE tbl_credit_trans.user_id = '" . $session_user_code . "' ");
                                    $buyer_total_in_credit_rw = mysqli_fetch_assoc($buyer_total_in_credit);

                                    $buyer_total_out_credit = mysqli_query($con, "SELECT SUM(out_credit) AS total_out_credit FROM tbl_credit_trans WHERE tbl_credit_trans.user_id = '" . $session_user_code . "' ");
                                    $buyer_total_out_credit_rw = mysqli_fetch_assoc($buyer_total_out_credit);

                                    $buyer_total_credit = $buyer_total_in_credit_rw['total_in_credit'] - $buyer_total_out_credit_rw['total_out_credit'];
                                    ?>
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $buyer_total_credit; ?>">
                                            <?php echo $buyer_total_credit ?>
                                        </span>
                                    </div>
                                    <div class="desc"> Credits </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                            <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/deal-items"; ?>" style="background-color: #b18527">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <?php
                                    $dataget = mysqli_query($con, "SELECT COUNT(*) FROM tbl_user_product_view WHERE tbl_user_product_view.buyer_id = '" . $session_user_code . "' ");
                                    $data = mysqli_fetch_row($dataget);
                                    ?>
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $data[0]; ?>">
                                            <?php echo $data[0]; ?>
                                        </span>
                                    </div>
                                    <div class="desc"> Product Viewed </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                            <a class="dashboard-stat dashboard-stat-v2" href="<?php echo $baseUrl . "/collector"; ?>" style="background-color: #7eb127">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <?php
                                    $buyer_total_collector = mysqli_query($con, "SELECT COUNT(*) AS total_collector FROM tbl_user_master WHERE tbl_user_master.under_buyer_id = '" . $session_user_code . "' ");
                                    $buyer_total_collector_rw = mysqli_fetch_assoc($buyer_total_collector);
                                    ?>
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $buyer_total_collector_rw['total_collector']; ?>">
                                            <?php echo $buyer_total_collector_rw['total_collector']; ?>
                                        </span>
                                    </div>
                                    <div class="desc"> Collectors </div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="main-itemListingChart">
                                <?php
                                // buyer total view item
                                $dataget = mysqli_query($con, "select count(*) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Credit Used' ");
                                $data = mysqli_fetch_row($dataget);
                                $totalViewItem = $data[0];

                                // buyer total purchased item
                                $dataget = mysqli_query($con, "select count(*) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Completed' ");
                                $data = mysqli_fetch_row($dataget);
                                $totalPurchasedItem = $data[0];

                                // buyer total negotiation item
                                $dataget = mysqli_query($con, "select count(*) from tbl_user_product_view where buyer_id='" . $session_user_code . "' and deal_status='Under Negotiation' ");
                                $data = mysqli_fetch_row($dataget);
                                $totalNegotiationItem = $data[0];

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
                                $totalItemsInZone = $data[0];

                                $chartShow = "Yes";
                                if ($totalViewItem == 0 && $totalPurchasedItem == 0 && $totalNegotiationItem == 0 && $totalClosedItem == 0 && $totalItemsInZone == 0) {
                                    $chartShow = "No";
                                }
                                ?>
                                <script>
                                    const itemListingValue = [<?php echo $totalViewItem; ?>, <?php echo $totalPurchasedItem; ?>, <?php echo $totalNegotiationItem; ?>, <?php echo $totalClosedItem; ?>, <?php echo $totalItemsInZone; ?>];
                                    const itemListingLable = ['Post Viewed', 'Completed', 'Under Negotiation', 'Offer Rejected', 'Items In My Area'];
                                    const itemListingColor = ['#145F82', '#E87331', '#186C24', '#0F9ED5', '#A02B93'];
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
                                    const scrapValuationColor = ['#145F82', '#E87331', '#186C24', '#0F9ED5', '#A02B93'];
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
                                // get buyer's collector name and total purchased value
                                $collector_dataget = mysqli_query($con, "select 
                                    tbl_user_master.name,
                                    (select sum(tbl_user_product_view.purchased_price) from tbl_user_product_view where tbl_user_product_view.assigned_collecter = tbl_user_master.user_id) AS collector_total_purchased
                                    from tbl_user_master 
                                    where tbl_user_master.under_buyer_id='" . $session_user_code . "' and tbl_user_master.active='Yes' 
                                    order by tbl_user_master.name ASC ");
                                $amountArray = null;
                                $collectorArray = null;
                                $i = 1;
                                $minimumAmount = 0;
                                $maximumAmount = 0;
                                while ($rw = mysqli_fetch_array($collector_dataget)) {
                                    if ($i == 1) {

                                        // inistial first row value will be maximum and minimum
                                        $minimumAmount = ($rw['collector_total_purchased'] == "" ? 0 : $rw['collector_total_purchased']);
                                        $maximumAmount = ($rw['collector_total_purchased'] == "" ? 0 : $rw['collector_total_purchased']);

                                        $amountArray .= ($rw['collector_total_purchased'] == "" ? 0 : $rw['collector_total_purchased']);
                                        $collectorArray .= "'" . $rw['name'] . "'";
                                    } else {
                                        $amountArray .= "," . ($rw['collector_total_purchased'] == "" ? 0 : $rw['collector_total_purchased']);
                                        $collectorArray .= ", '" . $rw['name'] . "'";

                                        // update minimum amount
                                        if ($minimumAmount > $rw['collector_total_purchased']) {
                                            $minimumAmount = $rw['collector_total_purchased'];
                                        }
                                        // update maximum amount
                                        if ($maximumAmount < $rw['collector_total_purchased']) {
                                            $maximumAmount = $rw['collector_total_purchased'];
                                        }
                                    }
                                    $i++;
                                }
                                ?>
                                <script>
                                    const collectorPurchasedValue = [<?php echo $amountArray; ?>];
                                    const collectorPurchasedLable = [<?php echo $collectorArray; ?>];
                                    const collectorMinAmountValue = <?php echo $minimumAmount; ?>;
                                    const collectorMaxAmountValue = <?php echo $maximumAmount; ?>;
                                </script>
                                <h3 class="chart-heading">Collector Wise Item Purchased</h3>
                                <?php
                                if ($i == 1) {
                                ?>
                                    <p style="color: red;text-align: center;">No Data Found</p>
                                <?php
                                }
                                ?>
                                <div id="collectorPurchasedChart" class="<?php echo $i == 1 ? "d-none" : null; ?>">

                                </div>
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
            <?php
            } ?>
            <!-- buyer Dashboard start -->
            <!-- ollector Dashboard start -->
            <?php
            if ($session_user_type == "Collector") {
            ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                    <h2>Welcome to Dashboard!</h2>
                    <h2>Hi, <span class="text-primary"><?php echo $user_data['name'] ?></h2>
                    <p>View snapshots of your activity and information from your dashboard </p>
                    <div class="row g-3 row-cols-lg-3 row-cols-md-3 row-cols-sm-3 row-cols-1 mb-4">
                        <?php
                        $collector_assigned_address_get = mysqli_query($con, "SELECT
                        tbl_address_master.landmark,
                        tbl_address_master.city,
                        tbl_address_master.state,
                        tbl_address_master.country,
                        tbl_address_master.pincode
                    FROM tbl_user_master
                    LEFT JOIN tbl_address_master ON tbl_address_master.address_id = tbl_user_master.address_id
                    WHERE tbl_user_master.user_id = '" . $session_user_code . "' ");
                        $collector_assigned_address = mysqli_fetch_assoc($collector_assigned_address_get);
                        ?>
                        <div class="counter-box">
                            <div class="bg-block d-flex-center flex-wrap">
                                <img class="blur-up lazyload d-img" data-src="frontend_assets/img-icon/ad.png"
                                    src="frontend_assets/img-icon/ad.png" alt="icon" width="55" height="55" />
                                <div class="content">
                                    <h6 class="mb-1 text-primary address-font" style="padding-left: 120px;"><?php echo isset($collector_assigned_address['landmark']) ? $collector_assigned_address['landmark'] : ''; ?>,</h6>
                                    <h6 class="mb-1 text-primary address-font" style="padding-left: 120px;"><?php echo isset($collector_assigned_address['city']) ? $collector_assigned_address['city'] : ''; ?>,</h6>
                                    <h6 class="mb-1 text-primary address-font" style="padding-left: 120px;"><?php echo isset($collector_assigned_address['state']) ? $collector_assigned_address['state'] : ''; ?>,</h6>
                                    <h6 class="mb-1 text-primary address-font" style="padding-left: 120px;"><?php echo isset($collector_assigned_address['country']) ? $collector_assigned_address['country'] : ''; ?>,</h6>
                                    <h6 class="mb-1 text-primary address-font" style="padding-left: 120px;"><?php echo isset($collector_assigned_address['pincode']) ? $collector_assigned_address['pincode'] : ''; ?></h6>
                                    <p class="address">Assigned Address</p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $collector_assigned_items = mysqli_query($con, "SELECT COUNT(*) AS total_assigned_items FROM tbl_user_product_view WHERE tbl_user_product_view.assigned_collecter = '" . $session_user_code . "'  AND deal_status<>'Completed' ");
                        $collector_assigned_item_rw = mysqli_fetch_assoc($collector_assigned_items);
                        ?>
                        <div class="counter-box">
                            <div class="bg-block d-flex-center flex-wrap">
                                <img class="blur-up lazyload d-img" data-src="frontend_assets/img-icon/assign.png"
                                    src="frontend_assets/img-icon/assign.png" alt="icon" width="55" height="55" />
                                <div class="content">
                                    <h3 class="fs-5 mb-1 text-primary address"><?php echo $collector_assigned_item_rw['total_assigned_items'] ?></h3>
                                    <p class="address">Total Assigned Items</p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $total_items_accepted_getdata = mysqli_query($con, "SELECT COUNT(*) AS total_items_accepted FROM tbl_user_product_view WHERE tbl_user_product_view.assigned_collecter = '" . $session_user_code . "' AND tbl_user_product_view.deal_status = 'Offer Accepted' ");
                        $total_items_accepted_data = mysqli_fetch_assoc($total_items_accepted_getdata);
                        ?>
                        <div class="counter-box">
                            <div class="bg-block d-flex-center flex-nowrap">
                                <img class="blur-up lazyload d-img" data-src="frontend_assets/img-icon/agreement.png"
                                    src="frontend_assets/img-icon/agreement.png" alt="icon" width="55" height="55" />
                                <div class="content">
                                    <h3 class="fs-5 mb-1 text-primary order"><?php echo $total_items_accepted_data['total_items_accepted'] ?></h3>
                                    <p class="order">Total Accpted Items By You</p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $total_items_canceled_getdata = mysqli_query($con, "SELECT COUNT(*) AS total_items_canceled FROM tbl_user_product_view WHERE tbl_user_product_view.assigned_collecter = '" . $session_user_code . "' AND tbl_user_product_view.deal_status = 'Offer Rejected' ");
                        $total_items_canceled_data = mysqli_fetch_assoc($total_items_canceled_getdata);
                        ?>
                        <div class="counter-box">
                            <div class="bg-block d-flex-center flex-nowrap">
                                <img class="blur-up lazyload d-img" data-src="frontend_assets/img-icon/cancelled.png"
                                    src="frontend_assets/img-icon/agreement.png" alt="icon" width="55" height="55" />
                                <div class="content">
                                    <h3 class="fs-5 mb-1 text-primary order"><?php echo $total_items_canceled_data['total_items_canceled'] ?></h3>
                                    <p class="order">Total Canceled Items By You</p>
                                </div>
                            </div>
                        </div>
                    <?php
                } ?>
                    <!-- collector Dashboard end -->

                    </div>
                </div>
                <!--End Main Content-->

        </div>
        <!-- End Body Container -->