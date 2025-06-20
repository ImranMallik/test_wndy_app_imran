$(document).ready(function () {
	show_list();
	make_select2_ajx('category_id');
});

function clear_input() {
	_("#category_rate_list_id").value = "";
	$("#category_id").val('').trigger('change');
	_("#product_name").value = "";
	_("#lowest_price").value = "";
	_("#highest_price").value = "";
	_("#active").value = "Yes";

	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Category Rate List Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Category Rate List Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2_ajx(id) {
	let fileName;
	let sendData = '';
	switch (id) {
		case 'category_id':
			fileName = 'select_category_list';
			break;
	}

	$("#" + id).select2({
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_category_ratelist/" + fileName + ".php",
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
				'url': 'templates/manage_category_ratelist/list.php',
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'action_timestamp' },
				{ data: 'category_name' },
				{ data: 'product_name' },
				{ data: 'lowest_price' },
				{ data: 'highest_price' },
				{ data: 'active' },
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
	clearInputAleart();
	
	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#category_id").checkValidity() && _("#category_rate_list_id").value == "") {
		toastr['warning']("Category : " + _("#category_id").validationMessage, "WARNING");
		showInputAlert('category_id', 'warning', _("#category_id").validationMessage);
		_("#category_id").focus();
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
	if (!_("#lowest_price").checkValidity()) {
		toastr['warning']("Lowest Price : " + _("#lowest_price").validationMessage, "WARNING");
		showInputAlert('lowest_price', 'warning', _("#lowest_price").validationMessage);
		_("#lowest_price").focus();
		save_no = 0;
		return false;
	}
	if (!_("#highest_price").checkValidity()) {
		toastr['warning']("Highest Price : " + _("#highest_price").validationMessage, "WARNING");
		showInputAlert('highest_price', 'warning', _("#highest_price").validationMessage);
		_("#highest_price").focus();
		save_no = 0;
		return false;
	}

	
	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";

	let data = new FormData();
	const sendData = {
		category_rate_list_id: _("#category_rate_list_id").value,
		category_id: _("#category_id").value,
		product_name: _("#product_name").value,
		lowest_price: _("#lowest_price").value,
		highest_price: _("#highest_price").value,
		active: _("#active").value,
	};
	// console.log(sendData);
	data.append("sendData", JSON.stringify(sendData));

	save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function() {if(save_data.readyState == 4) {
			// console.log(save_data.responseText);
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
		save_data.open('POST','templates/manage_category_ratelist/save_details.php',true);	
		save_data.send(data);
	}
}

function update_data(category_rate_list_id) {
	console.log(category_rate_list_id);
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			category_rate_list_id: category_rate_list_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);
				console.log(response);
				
				_("#category_rate_list_id").value = response['category_rate_list_id'];
				_("#category_id").innerHTML = `<option value="` + response['category_id'] + `" selected>` + response['category_name'] + `</option>`;
				_("#product_name").value = response['product_name'];
				_("#lowest_price").value = response['lowest_price'];
				_("#highest_price").value = response['highest_price'];
				_("#active").value = response['active'];
				
				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_category_ratelist/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(category_rate_list_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			category_rate_list_id: category_rate_list_id
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
		xhr.open('POST', 'templates/manage_category_ratelist/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}
