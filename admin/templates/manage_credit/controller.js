$(document).ready(function () {
	show_list();
});

function clear_input() {
	_("#option_id").value = "";
	_("#credit").value = "";
	_("#purchase_amount").value = "";
	_("#active").value = "Yes";
	
	chngMode('Insert');
	clearInputAleart();
}



function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Your Credit Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Your Credit Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}


function make_select2_ajx(id) {
	let fileName, sendData;
	switch (id) {
		case 'credit':
			fileName = 'select_credit_list';
			break;
		case 'purchase_amount':
			fileName = 'manage_purchase_amount';
			sendData = {
				credit: _("#credit").value,
			};
			break;
		}

	
	$("#" + id).select2({
		dropdownParent: $('#entryModal'),
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_credit/" + fileName + ".php",
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
				'url': 'templates/manage_credit/list.php'
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'entry_timestamp' },
				{ data: 'credit' },
				{ data: 'purchase_amount' },
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
	if (!_("#option_id").checkValidity()) {
		toastr['warning']("Option ID : " + _("#option_id").validationMessage, "WARNING");
		showInputAlert('option_id', 'warning', _("#option_id").validationMessage);
		_("#option_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#credit").checkValidity()) {
		toastr['warning']("Credit Amount : " + _("#credit").validationMessage, "WARNING");
		showInputAlert('credit', 'warning', _("#credit").validationMessage);
		_("#credit").focus();
		save_no = 0;
		return false;
	}
	if (!_("#purchase_amount").checkValidity()) {
		toastr['warning']("Purchase Amount : " + _("#purchase_amount").validationMessage, "WARNING");
		showInputAlert('purchase_amount', 'warning', _("#purchase_amount").validationMessage);
		_("#purchase_amount").focus();
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
		let data = new FormData();
		const sendData = {
			option_id: _("#option_id").value,
			credit: _("#credit").value,
			purchase_amount: _("#purchase_amount").value,
			active: _("#active").value,
		};

		console.log(sendData);
		data.append("sendData", JSON.stringify(sendData));

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
				} else if (status == "credit error") {
					toastr["error"](status_text, "ERROR!!");
					showInputAlert("credit", "error", status_text);
					_("#credit").focus();
					return false;
				} else if (status == "purchase_amount error") {
					toastr["error"](status_text, "ERROR!!");
					showInputAlert("purchase_amount", "error", status_text);
					_("#purchase_amount").focus();
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
		save_data.open('POST', 'templates/manage_credit/save_details.php', true);
		save_data.send(data);
	}
}



 function update_data(option_id) {
	console.log(option_id);
    if (edit_per == "Yes") {
        _(".background_overlay").style.display = "block";
        clear_input();
        let data = new FormData();
        const sendData = { option_id: option_id };
        data.append("sendData", JSON.stringify(sendData));
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    // console.log(response);

                    if (response.error) {
                        toastr["error"](response.error, "ERROR!!");
                        _(".background_overlay").style.display = "none";
                        return;
                    }

                    _("#option_id").value = response["option_id"];
                    _("#credit").value = response["credit"];
                    _("#purchase_amount").value = response["purchase_amount"];
                    _("#active").value = response["active"];

                    chngMode("Update");
                    $("#entryModal").modal();
                    _(".background_overlay").style.display = "none";
                } else {
                    toastr["error"]("Failed to retrieve data!", "ERROR!!");
                    _(".background_overlay").style.display = "none";
                }
            }
        };
        xhr.open("POST", "templates/manage_credit/update_data_input.php", true);
        xhr.send(data);
    } else {
        toastr["error"]("You Don't Have Permission To Update Any Data !!", "ERROR!!");
        return false;
    }
}

function delete_data(option_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			option_id: option_id
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
		xhr.open('POST', 'templates/manage_credit/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}



