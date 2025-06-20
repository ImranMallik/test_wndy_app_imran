$(document).ready(function () {
	show_list();
});
function clear_input() {
	_("#category_id").value = "";
	_("#category_name").value = "";
	_("#order_number").value = "";
	_("#active").value = "Yes";
	_(".category_img").setAttribute("data-blank-image", '../upload_content/upload_img/category_img/no_image.png');
	$("#category_img").val('').trigger('change');

	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Category Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Category Details :';
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
				'url': 'templates/manage_category/list.php'
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'entry_timestamp' },
				{ data: 'category_img' },
				{ data: 'category_name' },
				{ data: 'order_number' },
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
			'order': [[ 3, "asc" ]],
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
	if (!_("#category_name").checkValidity()) {
		toastr['warning']("Category Name: " + _("#category_name").validationMessage, "WARNING");
		showInputAlert('category_name', 'warning', _("#category_name").validationMessage);
		_("#category_name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#order_number").checkValidity()) {
		toastr['warning']("Order Number: " + _("#order_number").validationMessage, "WARNING");
		showInputAlert('order_number', 'warning', _("#order_number").validationMessage);
		_("#order_number").focus();
		save_no = 0;
		return false;
	}

	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";

		//============================= FOR CATEGORY IMAGE =====================================
		let d = new Date();
		let category_img_file_name = "category_img_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
		let category_img_fl = _("#category_img").files[0];

		var original_file_name = _("#category_img").value;
		var ext = original_file_name.split('.').pop();
		let category_img = "";
		if (_("#category_img").value != "") {
			category_img = category_img_file_name + "." + ext;
		}

		let data = new FormData();
		const sendData = {
			category_id: _("#category_id").value,
			category_name: _("#category_name").value,
			order_number: _("#order_number").value,
			active: _("#active").value,
			category_img: category_img
		};
		data.append("sendData", JSON.stringify(sendData));
		data.append("category_img_fl", category_img_fl);

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
				else if (status == "category_img error") {
					toastr["error"](status_text, "ERROR!!");
					showInputAlert("category_img", "error", status_text);
					return false;
				}
				else if (status == "category_name Exists") {
					toastr['warning'](status_text, "WARNING!!");
					return false;
				}
				else if (status == "order_number Exists") {
					toastr['warning'](status_text, "WARNING!!");
					return false;
				}
				else {
					// When Data Save successfully
					// if (category_img != "") {
					// 	upload_image_file(category_img_fl, category_img_file_name, 'Category Image');
					// }
					reload_table();
					clear_input();
					toastr['success'](status_text, "SUCCESS!!");
					return false;
				}

			}
		}
		save_data.open('POST', 'templates/manage_category/save_details.php', true);
		save_data.send(data);
	}
}


function upload_image_file(file, file_name, type) {
	_(".background_overlay_preloader").style.display = "block";
	let url = "templates/manage_category/img_save.php?file_name=" + file_name + "&type=" + type;
	let img_save = new XMLHttpRequest();
	let img = new FormData();

	img_save.open("POST", url, true);

	//================== RUN PRELOADER ================//
	img_save.upload.addEventListener("progress", function (evt) {
		if (evt.lengthComputable) {
			var percentComplete = parseInt(((evt.loaded / evt.total) * 100));

			if (parseFloat(percentComplete) > parseFloat(_(".preloader_inner_number").innerHTML)) {
				_(".preloader_inner_number").innerHTML = percentComplete;
			}
		}
	}, false);

	img_save.onreadystatechange = function () {
		if (img_save.readyState == 4 && img_save.status == 200) {
			// alert(img_save.responseText);
			_(".background_overlay_preloader").style.display = "none";
			_(".preloader_inner_number").innerHTML = 0;
			if (img_save.responseText == "session destroy") {
				_(".session_des_box_background_overlay").style.display = "block";
			}
			else if (img_save.responseText == "error") {
				toastr['error']("File Error !!", "ERROR!!");
				return false;
			}
			else {
				toastr['success'](type + " Saved Successfully.", "SUCCESS!!");
			}

		}
	};
	img.append('uploaded_file', file);
	img_save.send(img);
}


function update_data(category_id) {
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			category_id: category_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);

				_("#category_id").value = response['category_id'];
				_("#category_name").value = response['category_name'];
				_("#order_number").value = response['order_number'];
				_("#active").value = response['active'];
				_(".category_img").src = '../upload_content/upload_img/category_img/' + response['category_img'];
				_(".category_img").setAttribute("data-blank-image", '../upload_content/upload_img/category_img/' + response['category_img']);

				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_category/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(category_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			category_id: category_id
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
		xhr.open('POST', 'templates/manage_category/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}