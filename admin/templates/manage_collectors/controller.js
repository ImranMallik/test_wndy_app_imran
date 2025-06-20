$(document).ready(function () {
	show_list();
	make_select2_ajx('under_buyer_id');
});

function clear_input() {
	_("#name").value = "";
	_("#ph_num").value = "";
	$("#under_buyer_id").val('').trigger('change');

	_(".user_img").setAttribute("data-blank-image", '../upload_content/upload_img/user_img/default.png');
	$("#user_img").val('').trigger('change');

	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Your Collector Details :';
		_(".save_btn").innerHTML = 'Update Data';
	} else if (mode == "Insert"){
		_(".entry_modal_title").innerHTML = 'Enter Your Collector Details :';
		_(".save_btn").innerHTML = 'Save Data';
	} else if (mode === "View") {
		document.querySelector(".entry_modal_title").innerHTML = "Assigned Address Details:";
	}
}

function make_select2_ajx(id) {
	let fileName, sendData;
	switch (id) {
		case 'under_buyer_id':
			fileName = 'select_buyer_list';
			break;
	}

	$("#" + id).select2({
		dropdownParent: $('#entryModal'),
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_collectors/" + fileName + ".php",
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
				'url': 'templates/manage_collectors/list.php'
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'entry_timestamp' },
				{ data: 'user_img' },
				{ data: 'user_type' },
				{ data: 'name' },
				{ data: 'ph_num' },
				{ data: 'buyer_details' },
				{ data: "referral_id" },
				{ data: 'under_referral_by' },
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

	var numberRegex = /^\d+$/;

	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#name").checkValidity()) {
		toastr['warning']("Collector Name : " + _("#name").validationMessage, "WARNING");
		showInputAlert('name', 'warning', _("#name").validationMessage);
		_("#name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#country_code").checkValidity()) {
		toastr["warning"]("Country Code : " + _("#country_code").validationMessage, "WARNING");
		showInputAlert("country_code", "warning", _("#country_code").validationMessage);
		_("#country_code").focus();
		save_no = 0;
		return false;
	}
	if (!_("#ph_num").checkValidity()) {
		toastr["warning"]("Phone Number : " + _("#ph_num").validationMessage, "WARNING");
		showInputAlert("ph_num", "warning", _("#ph_num").validationMessage);
		_("#ph_num").focus();
		save_no = 0;
		return false;
	}
	if (!numberRegex.test(_("#ph_num").value)) {
		toastr["warning"]("Phone Number : Only Number Accepted", "WARNING");
		showInputAlert("ph_num", "warning", "Only Number Accepted");
		_("#ph_num").focus();
		save_no = 0;
		return false;
	}
	if (_("#ph_num").value.length < 10) {
		toastr["warning"]("Phone Number : 10 Digits Number Accepted", "WARNING");
		showInputAlert("ph_num", "warning", "10 Digits Number Accepted");
		_("#ph_num").focus();
		save_no = 0;
		return false;
	}
	if (!_("#under_buyer_id").checkValidity()) {
		toastr['warning']("Buyer Name : " + _("#under_buyer_id").validationMessage, "WARNING");
		showInputAlert('under_buyer_id', 'warning', _("#under_buyer_id").validationMessage);
		_("#under_buyer_id").focus();
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
	
		//============================= FOR Buyer IMAGE  =====================================
		let d = new Date();
		let user_img_file_name = "user_img_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
		let user_img_fl = _("#user_img").files[0];
	
		var original_file_name = _("#user_img").value;
		var ext = original_file_name.split(".").pop();
		let user_img = "";
		if (_("#user_img").value != "") {
		  user_img = user_img_file_name + "." + ext;
		}
	
		let data = new FormData();
		const sendData = {
		  user_id: _("#user_id").value,
		  name: _("#name").value,
		  country_code: _("#country_code").value,
		  ph_num: _("#ph_num").value,
		  user_img: user_img,
		  under_buyer_id: _("#under_buyer_id").value,
		  active: _("#active").value,
		};
		data.append("sendData", JSON.stringify(sendData));
		data.append("user_img_fl", user_img_fl);
	
		save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
		  if (save_data.readyState == 4) {
			_(".background_overlay").style.display = "none";
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
			} else if (status == "user_img error") {
			  toastr["error"](status_text, "ERROR!!");
			  showInputAlert("user_img", "error", status_text);
			  return false;
			} else if (status == "ph_num error") {
			  toastr["error"](status_text, "ERROR!!");
			  showInputAlert("ph_num", "error", status_text);
			  _("#ph_num").focus();
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
		save_data.open("POST", "templates/manage_collectors/save_details.php", true);
		save_data.send(data);
	  }
}


function update_data(user_id) {
	// console.log(user_id);
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
				// console.log(xhr.responseText);
				const response = JSON.parse(xhr.responseText);

				_("#user_id").value = response['user_id'];
				_("#name").value = response['name'];
				_("#ph_num").value = response['ph_num'];
				_("#under_buyer_id").innerHTML = `<option value="` + response['under_buyer_id'] + `" selected>` + response['buyer_name'] + `</option>`;

				_("#active").value = response['active'];

				let imgElement = _(".image-input-wrapper img.user_img");
				let sellerImgPath = "../upload_content/upload_img/user_img/" + response["user_img"];
				imgElement.src = sellerImgPath;
				imgElement.setAttribute("data-blank-image", sellerImgPath);

				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_collectors/update_data_input.php', true);
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
			user_id: user_id,
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
		xhr.open('POST', 'templates/manage_collectors/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}


// function view_addresses(user_id) {
// 	if (view_per === "Yes") {
// 	  // Show the background overlay
// 	  document.querySelector(".background_overlay").style.display = "block";
	  
// 	  // Create FormData object
// 	  const data = new FormData();
// 	  const sendData = {
// 		user_id: user_id,
// 		baseUrl: baseUrl,
// 	  };
// 	  data.append("sendData", JSON.stringify({ sendData }));
  
// 	  // Create and send XMLHttpRequest
// 	  const xhr = new XMLHttpRequest();
// 	  xhr.onreadystatechange = function () {
// 		if (xhr.readyState === 4) {
// 		  if (xhr.status === 200) {
// 			// Update modal content and show it
// 			const response = xhr.responseText;
// 			document.querySelector("#exampleModal .modal-body").innerHTML = response;
  
// 			chngMode("View");
// 			$("#exampleModal").modal('show');
// 		  } else {
// 			// console.error("Error fetching data: " + xhr.statusText);
// 		  }
// 		  document.querySelector(".background_overlay").style.display = "none";
// 		}
// 	  };
// 	  xhr.open("POST", "templates/manage_collectors/fetch_collector_addresses.php", true);
// 	  xhr.send(data);
// 	} else {
// 	  toastr.error("You don't have permission to update any data!", "ERROR!");
// 	}
//   }

  function view_addresses(user_id) {
	if (view_per === "Yes") {
	  // Show the background overlay
	  document.querySelector(".background_overlay").style.display = "block";
	  
	  // Create FormData object
	  const data = new FormData();
	  const sendData = {
		user_id: user_id,
		baseUrl: baseUrl,
	  };
	  data.append("sendData", JSON.stringify(sendData));
  
	  // Create and send XMLHttpRequest
	  const xhr = new XMLHttpRequest();
	  xhr.onreadystatechange = function () {
		if (xhr.readyState === 4) {
		  if (xhr.status === 200) {
			// Update modal content and show it
			const response = xhr.responseText;
			document.querySelector("#exampleModal .modal-body").innerHTML = response;
  
			chngMode("View");
			$("#exampleModal").modal('show');
		  } else {
			// console.error("Error fetching data: " + xhr.statusText);
		  }
		  document.querySelector(".background_overlay").style.display = "none";
		}
	  };
	  xhr.open("POST", "templates/manage_collectors/fetch_collector_addresses.php", true);
	  xhr.send(data);
	} else {
	  toastr.error("You don't have permission to update any data!", "ERROR!");
	}
  }