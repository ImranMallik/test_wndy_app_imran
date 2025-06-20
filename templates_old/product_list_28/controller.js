$(document).ready(function () {
	$(".filter-btn[data-filter='all']").trigger("click");
	getProductList();

});
function clear_filter() {
	_("#pincode").value = "All";
	_("#landmark").value = "All";
	_("#product_status").value = "";
	closeCategory();
}



let category_id = "";

function getLandmark() {
	_(".background_overlay").style.display = "block";
	let data = new FormData();
	const sendData = {
		pincode: _("#pincode").value,
	};
	data.append("sendData", JSON.stringify(sendData));

	landmarkXhr = new XMLHttpRequest();
	landmarkXhr.onreadystatechange = function () {
		if (landmarkXhr.readyState == 4) {
			// console.log(landmarkXhr.responseText);
			_("#landmark").innerHTML = landmarkXhr.responseText;
			getProductList();
			_(".background_overlay").style.display = "none";
		}
	}
	landmarkXhr.open('POST', 'templates/product_list/get_landmark_select_list.php', true);
	landmarkXhr.send(data);
}

function selectCategory(cate_rw) {
	_(".main-cate-btn").innerHTML = _(".cate_btn_" + cate_rw).innerHTML;
	_(".main-cate-btn").classList.remove("animate__bounceOut");
	_(".main-cate-btn").classList.add("animate__bounceIn");
	_(".catgory-show-div").style.display = "flex";
	category_id = _(".cate_btn_" + cate_rw).getAttribute("data-category_id");
	getProductList();
}

function closeCategory(params) {
	_(".main-cate-btn").innerHTML = '';
	_(".main-cate-btn").classList.remove("animate__bounceIn");
	_(".main-cate-btn").classList.add("animate__bounceOut");
	setTimeout(function () {
		_(".catgory-show-div").style.display = "none";
	}, 500);
	category_id = '';
	getProductList();
}

function getProductList() {
	_("#product_list").innerHTML = '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';
	let data = new FormData();
	const sendData = {
		pincode: _("#pincode").value,
		landmark: _("#landmark").value,
// 		product_status: _("#product_status").value,
		category_id: category_id,
	};
	data.append("sendData", JSON.stringify(sendData));

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4) {
			// console.log(xhr.responseText);
			_("#product_list").innerHTML = xhr.responseText;
			_(".background_overlay").style.display = "none";
		}
	}
	xhr.open('POST', 'templates/product_list/get_product_list.php', true);
	xhr.send(data);
}

function toggleRecentPosts() {
	// Get the elements by ID
	var productList = document.getElementById("product_list");
	var recentPostList = document.getElementById("recent_post_list");
	var recentPostContainer = document.getElementById("recent_post_container");

	if (recentPostContainer.style.display === "none") {
		recentPostContainer.style.display = "block";
		productList.style.display = "none";
	} else {
		recentPostContainer.style.display = "none";
		productList.style.display = "block";
	}

}


// Statsus Wise Product Filter
$(".filter-btn").on("click", function () {
	let status = $(this).attr("data-filter");
	// alert(status);


	$(".filter-btn").removeClass("active btn-primary").addClass("btn-light text-primary");
	$(this).addClass("active btn-primary").removeClass("btn-light text-primary");

	$.ajax({
		url: "templates/product_list/filter_status_wise_product.php",
		type: "POST",
		data: { product_status: status },
		beforeSend: function () {

			document.getElementById("product_list").innerHTML = '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';
		},
		success: function (response) {
			$("#product_list").html(response);
		},
		error: function () {
			$("#product_list").html("<p>Error loading products.</p>");
		}
	});
});