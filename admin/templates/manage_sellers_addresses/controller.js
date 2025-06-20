$(document).ready(function () {
	show_list();
	make_select2_ajx('user_id');
	make_select2_ajx('user_id_search');
	make_select2_ajx('seller_type');
});

function clear_input() {
	_("#address_id").value = "";
	$("#user_id").val('').trigger('change');
	$("#seller_type").val('').trigger('change');
	_("#contact_name").value = "";
	_("#contact_ph_num").value = "";
	_("#address_name").value = "";
	_("#country").value = "";
	_("#state").value = "";
	_("#city").value = "";
	_("#landmark").value = "";
	_("#pincode").value = "";
	_("#address_line_1").value = "";
	_("#default_address").value = "No";

	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Seller Address Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Seller Address Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2_ajx(id) {
	let fileName;
	let sendData = '';
	switch (id) {
		case 'user_id':
			fileName = 'select_sellers_list';
			break;
		case 'user_id_search':
			fileName = 'select_sellers_list';
			break;
		case 'seller_type':
			fileName = 'get_seller_type_list';
			break;
	}

	$("#" + id).select2({
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_sellers_addresses/" + fileName + ".php",
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
				'url': 'templates/manage_sellers_addresses/list.php',
				'data': function (d) {
					d.user_id = $('#user_id_search').val();
				},
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'entry_timestamp' },
				{ data: 'name' },
				{ data: 'default' },
				{ data: 'contact_name' },
				{ data: 'seller_type' },
				{ data: 'contact_ph_num' },
				{ data: 'address_name' },
				{ data: 'country' },
				{ data: 'state' },
				{ data: 'city' },
				{ data: 'landmark' },
				{ data: 'pincode' },
				{ data: 'address_line_1' },
				{ data: 'action' }
			],
			dom: 'lBfrtip',
			lengthMenu: [50, 100, 250, 500, 1000, { label: 'All', value: -1 }],
			buttons: [
				{ extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'copy', className: 'btn red btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'excel', className: 'btn yellow btn-outline ', exportOptions: { columns: ':visible' } },
				{ extend: 'csv', className: 'btn purple btn-outline ', exportOptions: { columns: ':visible' } },
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
	// console.log("hfhf");
	clearInputAleart();

	var numberRegex = /^\d+$/;  
	// console.log("abc");
	
	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#user_id").checkValidity() && _("#address_id").value == "") {
		toastr['warning']("Buyer : " + _("#user_id").validationMessage, "WARNING");
		showInputAlert('user_id', 'warning', _("#user_id").validationMessage);
		_("#user_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#contact_name").checkValidity()) {
		toastr['warning']("Contact Name : " + _("#contact_name").validationMessage, "WARNING");
		showInputAlert('contact_name', 'warning', _("#contact_name").validationMessage);
		_("#contact_name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#contact_ph_num").checkValidity()) {
		toastr['warning']("Contact Phone Number : " + _("#contact_ph_num").validationMessage, "WARNING");
		showInputAlert('contact_ph_num', 'warning', _("#contact_ph_num").validationMessage);
		_("#contact_ph_num").focus();
		save_no = 0;
		return false;
	}
	if (!_("#address_name").checkValidity()) {
		toastr['warning']("Address Name : " + _("#address_name").validationMessage, "WARNING");
		showInputAlert('address_name', 'warning', _("#address_name").validationMessage);
		_("#address_name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#country").checkValidity()) {
		toastr['warning']("Country : " + _("#country").validationMessage, "WARNING");
		showInputAlert('country', 'warning', _("#country").validationMessage);
		_("#country").focus();
		save_no = 0;
		return false;
	}
	if (!_("#state").checkValidity()) {
		toastr['warning']("State : " + _("#state").validationMessage, "WARNING");
		showInputAlert('state', 'warning', _("#state").validationMessage);
		_("#state").focus();
		save_no = 0;
		return false;
	}
	if (!_("#city").checkValidity()) {
		toastr['warning']("City : " + _("#city").validationMessage, "WARNING");
		showInputAlert('city', 'warning', _("#city").validationMessage);
		_("#city").focus();
		save_no = 0;
		return false;
	}
	if (!_("#landmark").checkValidity()) {
		toastr['warning']("Landmark : " + _("#landmark").validationMessage, "WARNING");
		showInputAlert('landmark', 'warning', _("#landmark").validationMessage);
		_("#landmark").focus();
		save_no = 0;
		return false;
	}
	if (!_("#address_line_1").checkValidity()) {
		toastr['warning']("Address : " + _("#address_line_1").validationMessage, "WARNING");
		showInputAlert('address_line_1', 'warning', _("#address_line_1").validationMessage);
		_("#address_line_1").focus();
		save_no = 0;
		return false;
	}

	
	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";

	let data = new FormData();
	const sendData = {
		address_id: _("#address_id").value,
		user_id: _("#user_id").value,
		contact_name: _("#contact_name").value,
		contact_ph_num: _("#contact_ph_num").value,
		address_name: _("#address_name").value,
		country: _("#country").value,
		state: _("#state").value,
		city: _("#city").value,
		seller_type: _("#seller_type").value,
		landmark: _("#landmark").value,
		pincode: _("#pincode").value,
		address_line_1: _("#address_line_1").value,
		default_address: _("#default_address").value,
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
		save_data.open('POST','templates/manage_sellers_addresses/save_details.php',true);	
		save_data.send(data);
	}
}

function update_data(address_id) {
	// console.log(address_id);
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			address_id: address_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);
				// console.log(response);
				
				_("#address_id").value = response['address_id'];
				_("#user_id").innerHTML = `<option value="` + response['user_id'] + `" selected>` + response['name'] + ' [' + response['ph_num'] + ']' + `</option>`;
				_("#seller_type").innerHTML = `<option value="` + response['seller_type'] + `" selected>` + response['seller_type'] + `</option>`;

				_("#contact_name").value = response['contact_name'];
				_("#contact_ph_num").value = response['contact_ph_num'];
				_("#address_name").value = response['address_name'];
				_("#country").value = response['country'];
				_("#state").value = response['state'];
				_("#city").value = response['city'];
				_("#landmark").value = response['landmark'];
				_("#pincode").value = response['pincode'];
				_("#address_line_1").value = response['address_line_1'];
				_("#default_address").value = response['default_address'];
				
				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_sellers_addresses/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(address_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			address_id: address_id
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
		xhr.open('POST', 'templates/manage_sellers_addresses/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}
