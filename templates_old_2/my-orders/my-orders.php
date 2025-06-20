     <!-- Body Container -->
     <div id="page-content">
         <!--Page Header-->
         <div class="page-header text-center">
             <div class="container">
                 <div class="row">
                     <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                         <div class="page-title">
                             <h1>My Orders</h1>
                         </div>
                         <!--Breadcrumbs-->
                         <div class="breadcrumbs"><a href="index.html" title="Back to the home page">Home</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>My Orders</span>
                         </div>
                         <!--End Breadcrumbs-->
                     </div>
                 </div>
             </div>
         </div>
         <!--End Page Header-->

         <!--Main Content-->
         <div class="container">
             <div class="row">
                 <div class="col-12 col-sm-12 col-md-12 col-lg-3 mb-4 mb-lg-0">
                     <?php
                        include("templates/common_part/user_menu.php");
                        ?>
                 </div>
                 <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                     <div class="dashboard-content tab-content h-100" id="top-tabContent">

                         <!-- My Orders -->
                         <div class="tab-pane fade h-100 show active" id="orders">
                             <div class="orders-card mt-0 h-100">


                                 <div class="table-bottom-brd table-responsive">
                                     <table class="table align-middle text-center order-table">
                                         <thead>
                                             <tr class="table-head text-nowrap">
                                                 <th scope="col">image</th>
                                                 <th scope="col">Product Name</th>
                                                 <th scope="col">Order Id</th>
                                                 <th scope="col">Price</th>
                                                 <th scope="col">Date</th>
                                                 <th scope="col">Note</th>
                                                 <th scope="col">Status</th>
                                             </tr>
                                         </thead>
                                         <tbody>

                                             <!-- my orederlist -->
                                             <?php
                                                $order_booking_details_fetch_query = mysqli_query($con, "SELECT 
                                                    order_booking_details.order_code,
                                                    order_booking_details.customer_code,
                                                    order_booking_details.order_num, 
                                                    order_booking_details.sale_price,
                                                    order_booking_details.transaction_date,
                                                    order_booking_details.status,
                                                    order_booking_details.note,
                                                    product_master.product_code,
                                                    product_master.product_name,
                                                    product_master.sale_price,
                                                    product_master.product_image_1,
                                                    product_master.active
                                                    FROM order_booking_details
                                                    LEFT JOIN product_master ON order_booking_details.product_code = product_master.product_code
                                                    WHERE order_booking_details.customer_code = '" .  $session_user_code . "'");

                                                while ($rw = mysqli_fetch_array($order_booking_details_fetch_query)) {
                                                ?>
                                                 <tr>
                                                     <td style="width: 150px;">
                                                        <img class="blur-up lazyload" data-src="upload_content/upload_img/product_img/<?php echo $rw['product_image_1']; ?>" src="upload_content/upload_img/product_img/<?php echo $rw['product_image_1']; ?>" style="max-width:100%;height:100%;" alt="product" title="product" />
                                                
                                                        <a href="<?php echo $baseUrl ?>/templates/download_pdf/index.php?productcode=<?php echo $rw['product_code'];?>" class="btn btn-secondary btn-lg">Download</a>
                                                    </td>
                                                     <td><a href="<?php echo $baseUrl . "/product-details/" . $rw['product_code']; ?>"><span class="name"><?php echo $rw['product_name']; ?></span></a></td>
                                                     <td><span class="id"><?php echo $rw['order_num']; ?></span></td>

                                                     <td><span class="price fw-500"><?php echo $rw['sale_price']; ?></span></td>
                                                     <td><span class="price fw-500"><?php echo $rw['transaction_date']; ?></span></td>
                                                     <td><span class="name"><?php echo $rw['note']; ?></span></td>
                                                     <td><span class="badge rounded-pill bg-success custom-badge"><?php echo $rw['status']=="Accepted"?"Success":$rw['status']; ?></span>
                                                     </td>
                                                 </tr>
                                             <?php } ?>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                         <!-- End My Orders -->



                     </div>
                 </div>
             </div>
         </div>



         <!--End Main Content-->
     </div>
     <!-- End Body Container -->