<?php
include("../../templates/db/db.php");
$postData = json_decode($_POST['sendData'], true);

$cart_dataget = mysqli_query($con, "SELECT 
	product_master.product_code, 
	product_master.product_image_1, 
	product_master.product_name, 
	product_master.sale_price, 
	customer_cart.quantity 
	FROM customer_cart 
	LEFT JOIN product_master ON product_master.product_code = customer_cart.product_code
	WHERE customer_cart.customer_code='".$session_user_code."' ");
$i = 0;
$subtotal = 0;
while($rw = mysqli_fetch_array($cart_dataget)){
	$subtotal = $subtotal + ($rw['sale_price']  * $rw['quantity']);
?>

<div class="products add_products_from_js">
	<div class="product product-cart">
		<div class="product-detail">
			<a href="./product-details/<?php echo $rw['product_code'] ?>" class="product-name"><?php echo $rw['product_name'] ?></a>
			<div class="price-box">
				<span class="product-quantity"><?php echo $rw['quantity'] ?></span>
				<span class="product-price"><?php echo $rw['sale_price'] ?></span>
			</div>
		</div>
		<figure class="product-media">
			<a href="./product-details/<?php echo $rw['product_code'] ?>">
				<img src="upload_content/upload_img/product_img/<?php echo $rw['product_image_1'] == "" ? "no_image.png" :  $rw['product_image_1']; ?>" alt="<?php echo $rw['product_name'] ?>" height="84" width="94" />
			</a>
		</figure>
		<button onclick="removeCartProduct('<?php echo $rw['product_code'] ?>')" class="btn btn-link btn-close" aria-label="button">
			<i class="fas fa-times"></i>
		</button>
	</div>

</div>

<?php
$i++;
}
?>

<input type="hidden" value="<?php echo $i; ?>" id="totalCartRw" />

<div class="cart-total">
	<label>Subtotal:</label>
	<span class="price"><?php echo $subtotal;?></span>
</div>