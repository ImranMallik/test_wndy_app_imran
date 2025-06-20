<?php
include("../db/db.php");

if ($view_permission == "Yes") {

	## Read value
	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length']; // Rows display per page
	$columnIndex = $_POST['order'][0]['column']; // Column index
	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

	## Search 
	$searchQuery = " ";
	if ($searchValue != '') {
		$searchQuery = " and ( tbl_category_master.category_name like '%" . $searchValue . "%' or
		tbl_category_master.order_number like '%" . $searchValue . "%' or
		tbl_category_master.active like '%" . $searchValue . "%') ";
	}

	$query = "SELECT 
				category_id,
				entry_timestamp,
				category_name,
				category_img,
				order_number,
				active 
			FROM 
				tbl_category_master
			WHERE active='Yes' ";

	## Total number of records without filtering
	$sel = mysqli_query($con, $query);
	$records = mysqli_num_rows($sel);
	$totalRecords = $records;

	## Total number of records with filtering
	$sel = mysqli_query($con, $query . $searchQuery);
	$records = mysqli_num_rows($sel);
	$totalRecordwithFilter = $records;

	## Fetch records
	$empQuery = $query . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	while ($row = mysqli_fetch_assoc($empRecords)) {

		$category_img = $row['category_img'] == "" ? "no_image.png" : $row['category_img'];
		$category_img_Str = '
							<div class="image-input image-input-outline">
								<div style="width: auto; height:auto;" class="image-input-wrapper">
									<img style="max-width: 80px;" src="../upload_content/upload_img/category_img/' . $category_img . '">
								</div>
							</div>
							';

		$productDataget = mysqli_query($con, "select count(*), sum(sale_price) from tbl_product_master where category_id='" . $row['category_id'] . "' ");
		$productData = mysqli_fetch_row($productDataget);

		$total_rec = $productData[0];
		$total_amount = $productData[1];

		$avgPrice = round($total_amount / $total_rec);

		$data[] = array(
			"category_img" => $category_img_Str,
			"category_name" => $row['category_name'],
			"avg_price" => $avgPrice." /-",
		);
		$i++;
	}

	## Response
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data
	);
	echo json_encode($response);
}
