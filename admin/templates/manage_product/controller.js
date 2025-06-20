$(document).ready(function () {
	show_list();
	make_select2_ajx('category_id');
	make_select2_ajx('user_id');
	make_select2_ajx('address_id');
	make_select2_ajx('seller_num');

	// Dynamic show/hide for Closure Remark based on Product Status
	const statusField = document.getElementById("product_status");
	const closureRemarkContainer = document.getElementById("closure_remark_container");
	const closureRemarkInput = document.getElementById("closure_remark");

	statusField.addEventListener("change", function () {
		const selectedValue = this.value;
const showRemarkStatuses = [
	"Active",
	"Post Viewed",
	"Under Negotiation",
	"Offer Accepted",
	"Pickup Scheduled",
	"Completed",
	"Third-Party Transaction"
];


		if (showRemarkStatuses.includes(selectedValue)) {
			closureRemarkContainer.classList.remove("d-none");
		} else {
			closureRemarkContainer.classList.add("d-none");
			closureRemarkInput.value = "";
		}
	});
});


function clear_location() {
	$("#address_id").val('').trigger('change');
	make_select2_ajx('address_id');
}

function clear_input() {
	$("#category_id").val('').trigger('change');
	$("#user_id").val('').trigger('change');
	$("#address_id").val('').trigger('change');
	$("#seller_num").val('').trigger('change');
	_("#product_id").value = "";
	_("#whithdrawl_reson").value = "";
	_("#product_name").value = "";
	_("#quantity_kg").value = "";
	_("#closure_remark").value = "";

	_("#description").value = "";
	_("#brand").value = "";
// 	_("#quantity").value = "";
	_("#sale_price").value = "";
	_("#product_status").value = "";
	_("#active").value = "Yes";
	// _("#file_type").value = "Photo";

	_(".product_image_1").setAttribute("data-blank-image", '../upload_content/upload_img/product_img/no_image.png');
	$("#product_image_1").val('').trigger('change');


	chngMode('Insert');
	clearInputAleart();
}



function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Your Product Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Your Product Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}


function make_select2_ajx(id) {
	let fileName, sendData;
	switch (id) {
		case 'category_id':
			fileName = 'select_category_list';
			break;
		case 'user_id':
			fileName = 'select_seller_list';
			break;
		case 'seller_num':
			fileName = 'get_seller_num';
			break;
		case 'address_id':
			fileName = 'select_address_list';
			sendData = {
				user_id: _("#user_id").value,
			};
			// console.log(sendData);

			break;
	}


	$("#" + id).select2({
		dropdownParent: $('#entryModal'),
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_product/" + fileName + ".php",
			dataType: 'json',
			type: "post",
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					sendData: JSON.stringify(sendData),
				};
			},
			processResults: function (response) {
				return {
					results: response
				};
			},
			cache: true
		},
	});
}

function onStartDateChange() {
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');
    const toLabel = document.getElementById('to_label');

    if (startInput.value) {
        toLabel.style.display = 'inline';
        endInput.style.display = 'inline';
        endInput.min = startInput.value; 
    } else {
        toLabel.style.display = 'none';
        endInput.style.display = 'none';
        endInput.value = '';
        document.getElementById('custom_date_range').value = '';
    }
}

function onEndDateChange() {
    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    const hiddenField = document.getElementById('custom_date_range');

    if (!start || !end) return;

    if (start > end) {
        toastr.warning("End date cannot be before start date", "Date Range Error");
        hiddenField.value = '';
        return;
    }

    hiddenField.value = `${start} to ${end}`;
    reload_table();
}


function show_list() {
	if (view_per == "Yes") {
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url': 'templates/manage_product/list.php',
				'data': function (d) {
					  const range = $('#custom_date_range').val();
                    if (range.includes(' to ')) {
                        const [from, to] = range.split(' to ');
                        d.from_date = from.trim();
                        d.to_date = to.trim();
                    }
				},
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'entry_timestamp' },
				{ data: 'category_name' },
				{ data: 'name' },
				{ data: 'address_line_1' },
				{ data: 'product_name' },
				{data:'product_image'},
				{data:'pincode'},
				{ data: 'description' },
				{ data: 'brand' },
				{ data: 'quantity_kg' },
				{ data: 'quantity_pcs' },
				{ data: 'sale_price' },
				{ data: 'product_status' },
				{data:'closure_remark'},
				{data:'withdrawal_date'},
				{data:'purchased_price'},
				{data:'no_of_post'},
				{data:'duration_days'},
				{data:'reason'},
				{ data: 'active' },
				{ data: 'action' }
			],
			dom: 'lBfrtip',
			lengthMenu: [
				[50, 100, 250, 500,1000, -1],
				[50, 100, 250, 500,1000, 'All']
			],
			buttons: [
				{ extend: 'print', className: 'btn dark btn-outline' },
				{ extend: 'copy', className: 'btn red btn-outline' },
				{ extend: 'pdf', className: 'btn green btn-outline' },
				{ extend: 'excel', className: 'btn yellow btn-outline ' },
				{ extend: 'csv', className: 'btn purple btn-outline ' },
				{ extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns' },
				{ extend: 'pageLength', className: 'btn dark btn-outline', text: 'Show Entries' }
			],
			'order': [[0, "desc"]],
			'aoColumnDefs': [{
				'bSortable': false,
				'aTargets': ['nosort']
			}]
		});
	}
}



function reload_table() {
	$('#data_table').DataTable().ajax.reload();
}


function save_details() {
	let save_no = 1;
	clearInputAleart();

	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#category_id").checkValidity()) {
		toastr['warning']("Category ID: " + _("#category_id").validationMessage, "WARNING");
		showInputAlert('category_id', 'warning', _("#category_id").validationMessage);
		_("#category_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#user_id").checkValidity()) {
		toastr['warning']("Seller ID : " + _("#user_id").validationMessage, "WARNING");
		showInputAlert('user_id', 'warning', _("#user_id").validationMessage);
		_("#user_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#seller_num").checkValidity()) {
		toastr['warning']("Seller Number : " + _("#seller_num").validationMessage, "WARNING");
		showInputAlert('seller_num', 'warning', _("#seller_num").validationMessage);
		_("#seller_num").focus();
		save_no = 0;
		return false;
	}
	if (!_("#address_id").checkValidity()) {
		toastr['warning']("Address ID: " + _("#address_id").validationMessage, "WARNING");
		showInputAlert('address_id', 'warning', _("#address_id").validationMessage);
		_("#address_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#product_name").checkValidity()) {
		toastr['warning']("Product Name : " + _("#product_name").validationMessage, "WARNING");
		showInputAlert('product_name', 'warning', _("#product_name").validationMessage);
		_("#product_name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#description").checkValidity()) {
		toastr['warning']("Description : " + _("#description").validationMessage, "WARNING");
		showInputAlert('description', 'warning', _("#description").validationMessage);
		_("#description").focus();
		save_no = 0;
		return false;
	}
	if (!_("#brand").checkValidity()) {
		toastr['warning']("Brand : " + _("#brand").validationMessage, "WARNING");
		showInputAlert('brand', 'warning', _("#brand").validationMessage);
		_("#brand").focus();
		save_no = 0;
		return false;
	}
	if (!_("#quantity_kg").checkValidity()) {
		toastr['warning']("Quantity : " + _("#quantity").validationMessage, "WARNING");
		showInputAlert('quantity', 'warning', _("#quantity").validationMessage);
		_("#quantity_kg").focus();
		save_no = 0;
		return false;
	}
	if (!_("#product_status").checkValidity()) {
		toastr['warning']("Product Status : " + _("#product_status").validationMessage, "WARNING");
		showInputAlert('product_status', 'warning', _("#product_status").validationMessage);
		_("#product_status").focus();
		save_no = 0;
		return false;
	}
	if (!_("#active").checkValidity()) {
		toastr['warning']("Active : " + _("#active").validationMessage, "WARNING");
		showInputAlert('active', 'warning', _("#active").validationMessage);
		_("#active").focus();
		save_no = 0;
		return false;
	}



	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";


		//============================= FOR PRODUCT IMAGE 1 =====================================

		let d = new Date();
		let product_image_1_file_name = "product_image_1_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
		let product_image_1_fl = _("#product_image_1").files[0];

		var original_file_name = _("#product_image_1").value;
		var ext = original_file_name.split('.').pop();
		let product_image_1 = "";
		if (_("#product_image_1").value != "") {
			product_image_1 = product_image_1_file_name + "." + ext;
		}



		let data = new FormData();
		const sendData = {
			category_id: _("#category_id").value,
			user_id: _("#user_id").value,
			ph_num: _("#seller_num").value,
			address_id: _("#address_id").value,
			product_id: _("#product_id").value,
			product_name: _("#product_name").value,
			description: _("#description").value,
			brand: _("#brand").value,
			quantity_pcs: _("#quantity_pcs").value,
            quantity_kg: _("#quantity_kg").value,
			sale_price: _("#sale_price").value,
			product_status: _("#product_status").value,
			whithdrawl_reson: _("#whithdrawl_reson").value,
			active: _("#active").value,

			product_image_1: product_image_1,
			closure_remark: _("#closure_remark").value.trim(),
		};

		console.log(sendData);
		data.append("sendData", JSON.stringify(sendData));
		data.append("product_image_1_fl", product_image_1_fl);

		save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
			if (save_data.readyState == 4) {
				// console.log(save_data.responseText);
				const response = JSON.parse(save_data.responseText);
				const status = response[0]["status"];
				const status_text = response[0]["status_text"];
				_(".background_overlay").style.display = "none";
				if (status == "SessionDestroy") {
					session_destroy();
					setTimeout(function () {
						window.location.reload();
					}, 5000);
					return false;
				} else if (status == "NoPermission") {
					toastr["error"](status_text, "ERROR!!");
					return false;
				} else if (status == "product_image_1 error") {
					toastr["error"](status_text, "ERROR!!");
					showInputAlert("product_image_1", "error", status_text);
					return false;
				} else {
					// When Data Save successfully
					reload_table();
					clear_input();
					toastr["success"](status_text, "SUCCESS!!");
					return false;
				}
			}
		};
		save_data.open('POST', 'templates/manage_product/save_details.php', true);
		save_data.send(data);
	}
}



function update_data(product_id) {
	console.log(product_id);
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = { product_id: product_id };
		data.append("sendData", JSON.stringify(sendData));
		let xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					const response = JSON.parse(xhr.responseText);

					if (response.error) {
						toastr["error"](response.error, "ERROR!!");
						_(".background_overlay").style.display = "none";
						return;
					}

					_("#product_id").value = response["product_id"];
					_("#product_name").value = response["product_name"];

					_("#category_id").innerHTML = `<option value="` + response['category_id'] + `" selected>` + response['category_name'] + `</option>`;

					_("#user_id").innerHTML = `<option value="` + response['user_id'] + `" selected>` + response['name'] + `</option>`;

					_("#seller_num").innerHTML = `<option value="` + response['user_id'] + `" selected>` + response['ph_num'] + `</option>`;

					_("#sale_price").value = response["sale_price"];
					_("#description").value = response["description"];
					_("#brand").value = response["brand"];
					_("#quantity_kg").value = response["quantity_kg"];
                    _("#quantity_pcs").value = response["quantity_pcs"];

					_("#product_status").value = response['product_status'];
					_("#whithdrawl_reson").value = response['close_reason'];

					_("#address_id").innerHTML = `<option value="` + response['address_id'] + `" selected>` + response['address_line_1'] + `</option>`;

					_("#active").value = response["active"];

					let imgElement = _(".image-input-wrapper img.product_image_1");
					let productImgPath = "../upload_content/upload_img/product_img/" + response["file_name"];
					
					imgElement.src = productImgPath;
					imgElement.setAttribute("data-blank-image", productImgPath);
					
						const showRemarkStatuses = [
	"Active",
	"Post Viewed",
	"Under Negotiation",
	"Offer Accepted",
	"Pickup Scheduled",
	"Completed",
	"Third-Party Transaction"
];

					const closureRemarkContainer = _("#closure_remark_container");
					const closureRemarkInput = _("#closure_remark");

					if (showRemarkStatuses.includes(response["product_status"]) && response["closure_remark"]) {
						closureRemarkContainer.classList.remove("d-none");
						closureRemarkInput.value = response["closure_remark"];
					} else {
						closureRemarkContainer.classList.add("d-none");
						closureRemarkInput.value = "";
					}

					chngMode("Update");
					$("#entryModal").modal();
					_(".background_overlay").style.display = "none";
				} else {
					toastr["error"]("Failed to retrieve data!", "ERROR!!");
					_(".background_overlay").style.display = "none";
				}
			}
		};
		xhr.open("POST", "templates/manage_product/update_data_input.php", true);
		xhr.send(data);
	} else {
		toastr["error"]("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(product_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			product_id: product_id,
			baseUrl: baseUrl,
		};
		data.append("sendData", JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				reload_table();
				_(".background_overlay").style.display = "none";
				toastr['info']("Data Deleted Successfully.", "SUCCESS!!");
				return false;
			}
		}
		xhr.open('POST', 'templates/manage_product/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}

function fetch_buyers(product_id) {

	window.open(baseUrl + "/manage_post_transactions/MC_64662383d90fb1684415363/" + product_id, '_blank');

	// if (view_per === "Yes") {
	// 	_(".background_overlay").style.display = "block";
	// 	const data = new FormData();
	// 	const sendData = {
	// 		product_id: product_id,
	// 		baseUrl: baseUrl,
	// 	};
	// 	data.append("sendData", JSON.stringify(sendData));
	// 	const xhr = new XMLHttpRequest();
	// 	xhr.onreadystatechange = function () {
	// 		if (xhr.readyState === 4) {
	// 			if (xhr.status === 200) {
	// 				const response = xhr.responseText;
	// 				_("#exampleModal .modal-body").innerHTML = response;

	// 				$("#exampleModal").modal('show');
	// 			} else {
	// 				// console.error("Error fetching data: " + xhr.statusText);
	// 			}
	// 			_(".background_overlay").style.display = "none";
	// 		}
	// 	};
	// 	xhr.open("POST", "templates/manage_product/fetch_viewed_buyers.php", true);
	// 	xhr.send(data);
	// } else {
	// 	toastr.error("You don't have permission to update any data!", "ERROR!");
	// }
}


