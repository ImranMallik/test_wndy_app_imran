$(document).ready(function () {
	show_list();
	make_select2_ajx('buyer_id');
	make_select2_ajx('product_id');
	make_select2_ajx('seller_id');
	make_editor('note');
});

function make_editor(id) {
	CKEDITOR.replace(id, {
		editorplaceholder: 'e.g: It is a brand new premium product...',
		height: 120
	});
}

function clear_input() {
	$("#buyer_id").val('').trigger('change');
	$("#product_id").val('').trigger('change');
	$("#seller_id").val('').trigger('change');
	CKEDITOR.instances['note'].setData('');
	_("#seen_status").value = "Yes";

	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Order Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Order Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2_ajx(id) {
	let fileName, sendData;
	switch (id) {
		case 'buyer_id':
			fileName = 'select_buyer_list';
			break;
		case 'product_id':
			fileName = 'select_product_list';
			break;
		case 'seller_id':
			fileName = 'select_seller_list';
			break;
	}

	$("#" + id).select2({
		dropdownParent: $('#entryModal'),
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_order/" + fileName + ".php",
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
				'url': 'templates/manage_order/list.php'
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'action' },
				{ data: 'buyer_name' },
				{ data: 'product_name' },
				{ data: 'seller_name' },
				{ data: 'note' },
				{ data: 'seen_status' }
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
			'order': [[1, "desc"]],
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
	// console.log("hfhf");
	clearInputAleart();
	const note = CKEDITOR.instances['note'].getData();

	var numberRegex = /^\d+$/;  
	// console.log("abc");
	
	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#request_id").checkValidity()) {
		toastr['warning']("Request ID : " + _("#request_id").validationMessage, "WARNING");
		showInputAlert('request_id', 'warning', _("#request_id").validationMessage);
		_("#request_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#buyer_id").checkValidity()) {
		toastr['warning']("Buyer ID : " + _("#buyer_id").validationMessage, "WARNING");
		showInputAlert('buyer_id', 'warning', _("#buyer_id").validationMessage);
		_("#buyer_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#product_id").checkValidity()) {
		toastr['warning']("Product ID : " + _("#product_id").validationMessage, "WARNING");
		showInputAlert('product_id', 'warning', _("#product_id").validationMessage);
		_("#product_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#seller_id").checkValidity()) {
		toastr['warning']("Seller ID : " + _("#seller_id").validationMessage, "WARNING");
		showInputAlert('seller_id', 'warning', _("#seller_id").validationMessage);
		_("#seller_id").focus();
		save_no = 0;
		return false;
	}
	// if (note == "") {
	// 	toastr['warning']("Product Note Empty !!", "WARNING");
	// 	showInputAlert('note', 'warning', "Product Note Empty !!");
	// 	CKEDITOR.instances['note'].focus();
	// 	save_no = 0;
	// 	return false;
	// }
	if (!_("#seen_status").checkValidity()) {
		toastr['warning']("Seen Status : " + _("#seen_status").validationMessage, "WARNING");
		showInputAlert('seen_status', 'warning', _("#seen_status").validationMessage);
		_("#seen_status").focus();
		save_no = 0;
		return false;
	}

	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";

	let data = new FormData();
	const sendData = {
		request_id: _("#request_id").value,
		buyer_id: _("#buyer_id").value,
		product_id: _("#product_id").value,
		seller_id: _("#seller_id").value,
		note: note,
		seen_status : _("#seen_status").value,
	};
	// console.log(sendData);
	data.append("sendData", JSON.stringify(sendData));

	save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function() {if(save_data.readyState == 4) {
			const response = JSON.parse(save_data.responseText);
			const status = response[0]['status'];
			const status_text = response[0]['status_text'];
			_(".background_overlay").style.display = "none";
			if(status=="SessionDestroy"){
				session_destroy();
				setTimeout(function(){ 
					window.location.reload();
				}, 5000);
				return false;
			}
			else if(status=="NoPermission"){
				toastr['error'](status_text, "ERROR!!");
				return false;
			}
			else{
				reload_table();
				clear_input();
				toastr['success'](status_text, "SUCCESS!!");
				return false;
			}
		
		}}
		save_data.open('POST','templates/manage_order/save_details.php',true);	
		save_data.send(data);
	}
}


function update_data(request_id) {
	// console.log(seller_address_id);
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			request_id: request_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);
				// console.log(response);
				const buyer_id = response[0]['buyer_name'];
				const product_id = response[0]['product_name'];
				const seller_id = response[0]['seller_name'];
				
				_("#request_id").value = response[0]['request_id'];
				_("#buyer_id").innerHTML = `<option value="` + response[0]['buyer_id'] + `" selected>` + buyer_id + `</option>`;
				_("#product_id").innerHTML = `<option value="` + response[0]['product_id'] + `" selected>` + product_id + `</option>`;
				_("#seller_id").innerHTML = `<option value="` + response[0]['seller_id'] + `" selected>` + seller_id + `</option>`;

				_("#seen_status").value = response[0]['seen_status'];

				CKEDITOR.instances['note'].setData(response[0]['note']);
				
				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_order/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(request_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			request_id: request_id
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
		xhr.open('POST', 'templates/manage_order/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}
