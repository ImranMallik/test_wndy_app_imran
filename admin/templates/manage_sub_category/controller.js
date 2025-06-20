$(document).ready(function () {
	show_list();
});
function clear_input() {
	_("#sub_category_id").value = "";
	_("#sub_category_name").value = "";
	_("#active").value = "Yes";
	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Product Sub Category Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Product Sub Category Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function show_list() {
	if (view_per == "Yes") {
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url': 'templates/manage_sub_category/list.php'
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'sub_category_name' },
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
	clearInputAleart();

	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#sub_category_name").checkValidity()) {
		toastr['warning']("Sub Category : " + _("#sub_category_name").validationMessage, "WARNING");
		showInputAlert('sub_category_name', 'warning', _("#sub_category_name").validationMessage);
		_("#sub_category_name").focus();
		save_no = 0;
		return false;
	}

	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";
		let data = new FormData();
		const sendData = {
			sub_category_id: _("#sub_category_id").value,
			sub_category_name: _("#sub_category_name").value,
			active: _("#active").value
		};
		data.append("sendData", JSON.stringify(sendData));

		save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
			if (save_data.readyState == 4) {
				const response = JSON.parse(save_data.responseText);
				const status = response[0]['status'];
				const status_text = response[0]['status_text'];
				_(".background_overlay").style.display = "none";
				if (status == "SessionDestroy") {
					session_destroy();
					setTimeout(function () {
						window.location.reload();
					}, 5000);
					return false;
				}
				else if (status == "NoPermission") {
					toastr['error'](status_text, "ERROR!!");
					return false;
				}
				else if (status == "Exist") {
					toastr['warning'](status_text, "WARNING!!");
					showInputAlert('sub_category', 'warning', status_text);
					_("#sub_category").focus();
					return false;
				}
				else {
					// When Data Save successfully
					reload_table();
					clear_input();
					toastr['success'](status_text, "SUCCESS!!");
					return false;
				}

			}
		}
		save_data.open('POST', 'templates/manage_sub_category/save_details.php', true);
		save_data.send(data);
	}
}

function update_data(sub_category_id) {
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			sub_category_id: sub_category_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);

				_("#sub_category_id").value = response['sub_category_id'];
				_("#sub_category_name").value = response['sub_category_name'];
				_("#active").value = response['active'];
				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_sub_category/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(sub_category_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			sub_category_id: sub_category_id
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
		xhr.open('POST', 'templates/manage_sub_category/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}