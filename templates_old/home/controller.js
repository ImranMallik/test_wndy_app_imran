$(document).ready(function () {
	
});

function clear_input() {
	_("#product_code").value = "";
	_("#product_name").value = "";
	$("#category_code").val('').trigger('change');
	$("#sub_category_code").val('').trigger('change');
	$("#unit_code").val('').trigger('change');
	_("#sale_price").value = "";
	_("#purchase_price").value = "";
	_("#pv").value = "";
	_("#ev").value = "";
	CKEDITOR.instances['description'].setData( '' );
	_("#active").value = "Yes";

	_(".product_image_1").setAttribute("data-blank-image", '../upload_content/upload_img/product_img/no_image.png');
	$("#product_image_1").val('').trigger('change');
	_(".product_image_2").setAttribute("data-blank-image", '../upload_content/upload_img/product_img/no_image.png');
	$("#product_image_2").val('').trigger('change');
	_(".product_image_3").setAttribute("data-blank-image", '../upload_content/upload_img/product_img/no_image.png');
	$("#product_image_3").val('').trigger('change');

	chngMode('Insert');
	clearInputAleart();
}

function make_editor(id) {
	CKEDITOR.replace(id, {
		editorplaceholder: 'Enter Product Description',
		height: 120
	});

}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Product Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Product Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2_ajx(id) {
	let fileName;
	let sendData = {
		auth_token: auth_token,
	};
	switch (id) {
		case 'category_code':
			fileName = 'select_category_list';
			break;
		case 'sub_category_code':
			fileName = 'select_sub_category_list';
			break;
		case 'unit_code':
			fileName = 'select_unit_list';
			break;
	}

	$("#" + id).select2({
		dropdownParent: $('#entryModal'),
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: apiUrl + "manage_product/" + fileName + ".php",
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

function show_list() {
	if (view_per == "Yes") {
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url': apiUrl + 'manage_product/datatable_fetch_data.php',
				'data': function (d) {
					d.auth_token = auth_token;
				},
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'product_image_1' },
				{ data: 'product_name' },
				{ data: 'category' },
				{ data: 'sub_category' },
				{ data: 'unit' },
				{ data: 'sale_price' },
				{ data: 'purchase_price' },
				{ data: 'pv' },
				{ data: 'ev' },
				{ data: 'active' },
				{ data: 'action' }
			],
			dom: 'lBfrtip',
			buttons: [
				{ extend: 'print', className: 'btn dark btn-outline' },
				{ extend: 'copy', className: 'btn red btn-outline' },
				{ extend: 'pdf', className: 'btn green btn-outline' },
				{ extend: 'excel', className: 'btn yellow btn-outline ' },
				{ extend: 'csv', className: 'btn purple btn-outline ' },
				{ extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns' },
				{ extend: 'pageLength', className: 'btn dark btn-outline', text: 'Show Entries' }
			],
			'order': [[1, "asc"]],
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
	const description = CKEDITOR.instances['description'].getData();

	if (insert_per == "No" && _("#product_code").value == "") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (edit_per == "No" && _("#product_code").value != "") {
		toastr['error']("You Don't Have Permission To Edit Any Data !!", "ERROR");
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
	if (!_("#category_code").checkValidity()) {
		toastr['warning']("Category : " + _("#category_code").validationMessage, "WARNING");
		showInputAlert('category_code', 'warning', _("#category_code").validationMessage);
		_("#category_code").focus();
		save_no = 0;
		return false;
	}
	if (!_("#sub_category_code").checkValidity()) {
		toastr['warning']("Sub Category : " + _("#sub_category_code").validationMessage, "WARNING");
		showInputAlert('sub_category_code', 'warning', _("#sub_category_code").validationMessage);
		_("#sub_category_code").focus();
		save_no = 0;
		return false;
	}
	if (!_("#unit_code").checkValidity()) {
		toastr['warning']("Unit : " + _("#unit_code").validationMessage, "WARNING");
		showInputAlert('unit_code', 'warning', _("#unit_code").validationMessage);
		_("#unit_code").focus();
		save_no = 0;
		return false;
	}
	if (!_("#sale_price").checkValidity()) {
		toastr['warning']("Sale Price : " + _("#sale_price").validationMessage, "WARNING");
		showInputAlert('sale_price', 'warning', _("#sale_price").validationMessage);
		_("#sale_price").focus();
		save_no = 0;
		return false;
	}
	if (!_("#purchase_price").checkValidity()) {
		toastr['warning']("Purchase Price : " + _("#purchase_price").validationMessage, "WARNING");
		showInputAlert('purchase_price', 'warning', _("#purchase_price").validationMessage);
		_("#purchase_price").focus();
		save_no = 0;
		return false;
	}
	if (!_("#pv").checkValidity()) {
		toastr['warning']("Product PV : " + _("#pv").validationMessage, "WARNING");
		showInputAlert('pv', 'warning', _("#pv").validationMessage);
		_("#pv").focus();
		save_no = 0;
		return false;
	}
	if (!_("#ev").checkValidity()) {
		toastr['warning']("Product EV : " + _("#ev").validationMessage, "WARNING");
		showInputAlert('ev', 'warning', _("#ev").validationMessage);
		_("#ev").focus();
		save_no = 0;
		return false;
	}
	if(description==""){
		toastr['warning']("Product Description Empty !!", "WARNING");
		showInputAlert('description', 'warning', "Product Description Empty !!");
		CKEDITOR.instances['description'].focus();
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

		//============================= FOR PRODUCT IMAGE 2 =====================================
		let product_image_2_file_name = "product_image_2_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
		let product_image_2_fl = _("#product_image_2").files[0];

		var original_file_name = _("#product_image_2").value;
		var ext = original_file_name.split('.').pop();
		let product_image_2 = "";
		if (_("#product_image_2").value != "") {
			product_image_2 = product_image_2_file_name + "." + ext;
		}

		//============================= FOR PRODUCT IMAGE 3 =====================================
		let product_image_3_file_name = "product_image_3_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
		let product_image_3_fl = _("#product_image_3").files[0];

		var original_file_name = _("#product_image_3").value;
		var ext = original_file_name.split('.').pop();
		let product_image_3 = "";
		if (_("#product_image_3").value != "") {
			product_image_3 = product_image_3_file_name + "." + ext;
		}

		let data = new FormData();
		const sendData = {
			auth_token: auth_token,
			product_code: _("#product_code").value,
			product_name: _("#product_name").value,
			category_code: _("#category_code").value,
			sub_category_code: _("#sub_category_code").value,
			unit_code: _("#unit_code").value,
			sale_price: _("#sale_price").value,
			purchase_price: _("#purchase_price").value,
			pv: _("#pv").value,
			ev: _("#ev").value,
			description: description,
			active: _("#active").value,
			product_image_1: product_image_1,
			product_image_2: product_image_2,
			product_image_3: product_image_3,
		};
		data.append("sendData", JSON.stringify(sendData));

		let save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
			if (save_data.readyState == 4) {

				const response = JSON.parse(save_data.responseText);
				const status = response['status'];
				const message = response['message'];
				_(".background_overlay").style.display = "none";

				if (status == "No Permission") {
					toastr['error'](message, "ERROR!!");
					return false;
				}
				if (status == "product_name Exist") {
					toastr['error'](message, "ERROR!!");
					showInputAlert('product_name', 'error', message);
					return false;
				}
				if (status == "Success") {
					// When Data Save successfully
					if (product_image_1 != "") {
						uploadImageFile(product_image_1_fl, product_image_1_file_name, 'Product Iamge 1');
					}
					if (product_image_2 != "") {
						uploadImageFile(product_image_2_fl, product_image_2_file_name, 'Product Iamge 2');
					}
					if (product_image_3 != "") {
						uploadImageFile(product_image_3_fl, product_image_3_file_name, 'Product Iamge 3');
					}
					reload_table();
					clear_input();
					toastr['success'](message, "SUCCESS!!");
					return false;
				}

			}
		}
		save_data.open('POST', apiUrl + 'manage_product/save_details.php', true);
		save_data.send(data);
	}
}

function uploadImageFile(file, file_name, type) {
	_(".background_overlay_preloader").style.display = "block";

	let data = new FormData();
	const sendData = {
		file_name: file_name,
		type: type,
	};
	data.append("sendData", JSON.stringify(sendData));
	data.append("uploaded_file", file);

	let fileUploadXHR = new XMLHttpRequest();

	//================== RUN PRELOADER ================//
	fileUploadXHR.upload.addEventListener("progress", function (evt) {
		if (evt.lengthComputable) {
			var percentComplete = parseInt(((evt.loaded / evt.total) * 100));

			if (parseFloat(percentComplete) > parseFloat(_(".preloader_inner_number").innerHTML)) {
				_(".preloader_inner_number").innerHTML = percentComplete;
			}
		}
	}, false);

	fileUploadXHR.onreadystatechange = function () {
		if (fileUploadXHR.readyState == 4) {
			// console.log(fileUploadXHR.responseText);
			const response = JSON.parse(fileUploadXHR.responseText);
			const status = response['status'];
			const message = response['message'];
			const image_name = response['image_name'];

			_(".background_overlay_preloader").style.display = "none";
			_(".preloader_inner_number").innerHTML = 0;

			if (status == "File Type Error") {
				toastr['error'](message, "ERROR!!");
				return false;
			}
			if (status == "Success") {
				toastr['info'](message, "SUCCESS!!");
				return false;
			}
		}
	};
	fileUploadXHR.open('POST', apiUrl + 'manage_product/upload_image_file.php', true);
	fileUploadXHR.send(data);
}

function update_data(rw_num) {
	if (view_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			auth_token: auth_token,
			product_code: _(".product_code_" + rw_num).value
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {

				const response = JSON.parse(xhr.responseText);
				const status = response['status'];
				const message = response['message'];
				const data = response['data'];

				_(".background_overlay").style.display = "none";

				if (status == "No Permission") {
					toastr['error'](message, "ERROR!!");
					return false;
				}
				if (status == "Not Found") {
					toastr['error'](message, "ERROR!!");
					return false;
				}
				if (status == "Success") {

					_("#product_code").value = data['product_code'];
					_("#product_name").value = data['product_name'];
					_("#category_code").innerHTML = `<option value="` + data['category_code'] + `" selected>` + data['category'] + `</option>`;
					_("#sub_category_code").innerHTML = `<option value="` + data['sub_category_code'] + `" selected>` + data['sub_category'] + `</option>`;
					_("#unit_code").innerHTML = `<option value="` + data['unit_code'] + `" selected>` + data['unit'] + `</option>`;
					_("#sale_price").value = data['sale_price'];
					_("#purchase_price").value = data['purchase_price'];
					_("#pv").value = data['pv'];
					_("#ev").value = data['ev'];
					CKEDITOR.instances['description'].setData( response[0]['description'] );
					_("#active").value = data['active'];

					_(".product_image_1").src = '../upload_content/upload_img/product_image/' + data['product_image_1'];
					_(".product_image_1").setAttribute("data-blank-image", '../upload_content/upload_img/product_image/' + data['product_image_1']);
					_(".product_image_2").src = '../upload_content/upload_img/product_image/' + data['product_image_2'];
					_(".product_image_2").setAttribute("data-blank-image", '../upload_content/upload_img/product_image/' + data['product_image_2']);
					_(".product_image_3").src = '../upload_content/upload_img/product_image/' + data['product_image_3'];
					_(".product_image_3").setAttribute("data-blank-image", '../upload_content/upload_img/product_image/' + data['product_image_3']);

					chngMode('Update');
					$("#entryModal").modal();
					return false;
				}

			}
		}
		xhr.open('POST', apiUrl + 'manage_product/fetch_update_data.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To View Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(rw_num) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			auth_token: auth_token,
			product_code: _(".product_code_" + rw_num).value
		};
		data.append("sendData", JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {

				const response = JSON.parse(xhr.responseText);
				const status = response['status'];
				const message = response['message'];

				_(".background_overlay").style.display = "none";

				if (status == "No Permission") {
					toastr['error'](message, "ERROR!!");
					return false;
				}
				if (status == "Success") {
					reload_table();
					toastr['info'](message, "SUCCESS!!");
					return false;
				}

			}
		}
		xhr.open('POST', apiUrl + 'manage_product/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}