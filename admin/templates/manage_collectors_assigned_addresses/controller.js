$(document).ready(function () {
	show_list();
	make_select2_ajx('under_buyer_id');
	make_select2_ajx('user_id_collector');
	make_select2_ajx('user_id_search');
	make_select2_ajx('address_id');
	make_select2_ajx('user_buyer_id_search');
});

function clear_input() {
	$("#user_id_collector").val('').trigger('change');
	_("#collector_ph_num").value = "";
	$("#under_buyer_id").val('').trigger('change');
	$("#address_id").val('').trigger('change');
	_("#country").value = "";
	_("#state").value = "";
	_("#city").value = "";
	_("#landmark").value = "";
	_("#pincode").value = "";
	_("#address_line_1").value = "";

	chngMode('Insert');
	clearInputAleart();
}

function clear_address() {
	$("#address_id").val('').trigger('change');
	make_select2_ajx('address_id');
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Collector Address Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Collector Address Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2_ajx(id) {
	let fileName;
	let sendData = '';
	switch (id) {
		case 'under_buyer_id':
			fileName = 'select_buyers_list';
			break;
		case 'user_buyer_id_search':
			fileName = 'select_buyers_list';
			break;
		case 'user_id_search':
			fileName = 'select_collectors_list';
			break;
		case 'address_id':
			fileName = 'select_addresses_list';
			sendData = {
				under_buyer_id: _("#under_buyer_id").value,
			};
			break;
		case 'user_id_collector':
			fileName = 'select_collectors_list';
			break;
	}

	$("#" + id).select2({
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_collectors_assigned_addresses/" + fileName + ".php",
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
				'url': 'templates/manage_collectors_assigned_addresses/list.php',
				'data': function (d) {
					d.user_id = $('#user_id_search').val();
					// console.log(d.user_id);
					
				},
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'update_timestamp' },
				{ data: 'buyer_name' },
				{ data: 'collector_name' },
				{ data: 'country' },
				{ data: 'state' },
				{ data: 'city' },
				{ data: 'landmark' },
				{ data: 'pincode' },
				{ data: 'address_line_1' },
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
	if (!_("#user_id_collector").checkValidity()) {
		toastr['warning']("Collector : " + _("#user_id_collector").validationMessage, "WARNING");
		showInputAlert('user_id_collector', 'warning', _("#user_id_collector").validationMessage);
		_("#user_id_collector").focus();
		save_no = 0;
		return false;
	}
	if (!_("#collector_ph_num").checkValidity()) {
		toastr['warning']("Phone Number : " + _("#collector_ph_num").validationMessage, "WARNING");
		showInputAlert('collector_ph_num', 'warning', _("#collector_ph_num").validationMessage);
		_("#collector_ph_num").focus();
		save_no = 0;
		return false;
	}
	if (!_("#under_buyer_id").checkValidity()) {
		toastr['warning']("Buyer : " + _("#under_buyer_id").validationMessage, "WARNING");
		showInputAlert('under_buyer_id', 'warning', _("#under_buyer_id").validationMessage);
		_("#under_buyer_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#address_id").checkValidity()) {
		toastr['warning']("Address : " + _("#address_id").validationMessage, "WARNING");
		showInputAlert('address_id', 'warning', _("#address_id").validationMessage);
		_("#address_id").focus();
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
		user_id: _("#user_id").value,
		address_id: _("#address_id").value,
		under_buyer_id: _("#under_buyer_id").value,
		user_id_collector: _("#user_id_collector").value,
		collector_ph_num: _("#collector_ph_num").value,
		country: _("#country").value,
		state: _("#state").value,
		city: _("#city").value,
		landmark: _("#landmark").value,
		pincode: _("#pincode").value,
		address_line_1: _("#address_line_1").value,
	};
	// console.log(sendData);
	data.append("sendData", JSON.stringify(sendData));

	save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function() {
			if(save_data.readyState == 4) {
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
		save_data.open('POST','templates/manage_collectors_assigned_addresses/save_details.php',true);	
		save_data.send(data);
	}
}


function update_data(user_id) {
	console.log(user_id);
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			user_id: user_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);
				// console.log(response);

				_("#user_id").value = response['user_id'];

				_("#user_id_collector").innerHTML = `<option value="` + response['user_id'] + `" selected>` + response['collector_name'] + `</option>`;

				_("#collector_ph_num").value = response['collector_ph_num'];

				_("#under_buyer_id").innerHTML = `<option value="` + response['under_buyer_id'] + `" selected>` + response['buyer_name'] + ' [' + response['buyer_ph_num'] + ']' + `</option>`;

				_("#address_id").innerHTML = `<option value="` + response['address_id'] + `" selected>` + response['address_line_1'] + `</option>`;

				_("#country").value = response['country'];
				_("#state").value = response['state'];
				_("#city").value = response['city'];
				_("#landmark").value = response['landmark'];
				_("#pincode").value = response['pincode'];
				_("#address_line_1").value = response['address_line_1'];

				make_select2_ajx('address_id');
				
				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_collectors_assigned_addresses/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(user_id) {
	// console.log(user_id);
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			user_id: user_id
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
		xhr.open('POST', 'templates/manage_collectors_assigned_addresses/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}

function addressDetails()
{
	let save_no = 1;

	if (save_no === 1 ) {
        _(".background_overlay").style.display = "block";

        let data = new FormData();
        const sendData = {

            address_id: _("#address_id").value,
           
        };
		// console.log(sendData);
        data.append("sendData", JSON.stringify(sendData));

        let save_data = new XMLHttpRequest();
        save_data.onreadystatechange = function() {
            if (save_data.readyState === 4) {
                _(".background_overlay").style.display = "none";
                if (save_data.status === 200) {
                    const response = JSON.parse(save_data.responseText);
					// console.log(response);
                    _("#country").value = response['country'];
					_("#state").value = response['state'];
					_("#city").value = response['city'];
					_("#landmark").value = response['landmark'];
					_("#pincode").value = response['pincode'];
					_("#address_line_1").value = response['address_line_1'];

                } 
            }
        };
        save_data.open('POST', 'templates/manage_collectors_assigned_addresses/fetch_address_details.php', true);
        save_data.send(data);
    }

}

function collectorPhoneNo()
{
	let save_no = 1;

	if (save_no === 1 ) {
        _(".background_overlay").style.display = "block";

        let data = new FormData();
        const sendData = {

            user_id_collector: _("#user_id_collector").value,
           
        };
		// console.log(sendData);
        data.append("sendData", JSON.stringify(sendData));

        let save_data = new XMLHttpRequest();
        save_data.onreadystatechange = function() {
            if (save_data.readyState === 4) {
                _(".background_overlay").style.display = "none";
                if (save_data.status === 200) {
                    const response = JSON.parse(save_data.responseText);
					console.log(response);
                    _("#collector_ph_num").value = response['ph_num'];

                } 
            }
        };
        save_data.open('POST', 'templates/manage_collectors_assigned_addresses/fetch_collector_phone_no.php', true);
        save_data.send(data);
    }

}