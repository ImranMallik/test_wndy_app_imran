
$(document).ready(function () {
	getProductList();
});

function getProductList() {
	_("#product_list").innerHTML = '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';

	let data = new FormData();
	const sendData = {
		
	};
	data.append("sendData", JSON.stringify(sendData));

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4) {
			// console.log(xhr.responseText);
			_("#product_list").innerHTML = xhr.responseText;
		}
	}
	xhr.open('POST', 'templates/deal-items/get_product_list.php', true);
	xhr.send(data);
}
