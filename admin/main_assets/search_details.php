<?php
include("../templates/db/db.php");
$search = mysqli_real_escape_string($con,$_POST['searchTerm']);

$data = array();

$order_booking_voucher_dataget = mysqli_query($con,"select voucher_code, voucher_number from order_booking_master where voucher_number like '%".$search."%' limit 50 ");
while($rw = mysqli_fetch_assoc($order_booking_voucher_dataget)){
	$data[] = array("id"=>'order_booking/MC_6319bbedcd86c1662630893/'.$rw['voucher_code'], "text"=>'Order Booking : '.$rw['voucher_number']);
}

$gold_receive_voucher_dataget = mysqli_query($con,"select voucher_code, voucher_number from gold_receive_master where voucher_number like '%".$search."%' limit 50 ");
while($rw = mysqli_fetch_assoc($gold_receive_voucher_dataget)){
	$data[] = array("id"=>'gold_receive/MC_6319bbedcd86c1662630893/'.$rw['voucher_code'], "text"=>'Gold Receive : '.$rw['voucher_number']);
}

$gold_sale_voucher_dataget = mysqli_query($con,"select voucher_code, voucher_number from gold_sale_details where voucher_number like '%".$search."%' limit 50 ");
while($rw = mysqli_fetch_assoc($gold_sale_voucher_dataget)){
	$data[] = array("id"=>'gold_sale/MC_6319bbedcd86c1662630893/'.$rw['voucher_code'], "text"=>'Gold Sale : '.$rw['voucher_number']);
}

$payment_voucher_dataget = mysqli_query($con,"select voucher_code, voucher_number from payment_voucher_master where voucher_number like '%".$search."%' limit 50 ");
while($rw = mysqli_fetch_assoc($payment_voucher_dataget)){
	$data[] = array("id"=>'payment_voucher/MC_6319bbedcd86c1662630893/'.$rw['voucher_code'], "text"=>'Payment : '.$rw['voucher_number']);
}

echo json_encode($data);
?>