$(document).ready(function () {
	show_list();
	make_editor('msg');
});

function make_editor(id) {
	CKEDITOR.replace(id, {
		editorplaceholder: 'e.g: Choosing the product was the best decision I ever made. It is transformed my daily routine and exceeded all my expectations. Highly recommended!...',
		height: 120
	});
}

function clear_input() {
	_("#testimonial_id").value = "";
	_("#name").value = "";
	_("#designation").value = "";
	// _("#msg").value = "";

	CKEDITOR.instances['msg'].setData('');

	_("#rating").value = "5";
	_(".img").setAttribute("data-blank-image", '../upload_content/upload_img/testimonial_img/no_image.png');
	$("#img").val('').trigger('change');

	chngMode('Insert');
	clearInputAleart();
}


function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Testimonial Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Testimonial Details :';
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
				'url': 'templates/manage_testimonial/list.php'
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'action' },
				{ data: 'entry_timestamp' },
				{ data: 'img' },
				{ data: 'name' },
				{ data: 'designation' },
				{ data: 'msg' },
				{ data: 'rating' }
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

	const msg = CKEDITOR.instances['msg'].getData();
	
	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#name").checkValidity()) {
		toastr['warning']("Name : " + _("#name").validationMessage, "WARNING");
		showInputAlert('name', 'warning', _("#name").validationMessage);
		_("#name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#designation").checkValidity()) {
		toastr['warning']("Designation : " + _("#designation").validationMessage, "WARNING");
		showInputAlert('designation', 'warning', _("#designation").validationMessage);
		_("#designation").focus();
		save_no = 0;
		return false;
	}
	if (!_("#msg").checkValidity()) {
		toastr['warning']("Message : " + _("#msg").validationMessage, "WARNING");
		showInputAlert('msg', 'warning', _("#msg").validationMessage);
		_("#msg").focus();
		save_no = 0;
		return false;
	}
	// if (msg == "") {
	// 	toastr['warning']("Testimonial Message is Empty !!", "WARNING");
	// 	showInputAlert('msg', 'warning', "Testimonial Message is Empty !!");
	// 	CKEDITOR.instances['msg'].focus();
	// 	save_no = 0;
	// 	return false;
	// }

	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";

		//============================= FOR CUSTOMER IMAGE  =====================================
		let d = new Date();
		let img_file_name = "img_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
		let img_fl = _("#img").files[0];

		var original_file_name = _("#img").value;
		var ext = original_file_name.split('.').pop();
		let img = "";
		if (_("#img").value != "") {
			img = img_file_name + "." + ext;
		}

		let data = new FormData();
		const sendData = {
			testimonial_id: _("#testimonial_id").value,
			name: _("#name").value,
			designation: _("#designation").value,
			msg: msg,
			// msg:  _("#msg").value,
			rating: _("#rating").value,
			img: img,
		};
		data.append("sendData", JSON.stringify(sendData));
		data.append("img_fl", img_fl);

		save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
			if (save_data.readyState == 4) {
				// console.log(save_data.responseText);
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
				else if (status == "img error") {
					toastr["error"](status_text, "ERROR!!");
					showInputAlert("img", "error", status_text);
					return false;
				}
				else if (status == "NoPermission") {
					toastr['error'](status_text, "ERROR!!");
					return false;
				}
				else {
					// When Data Save successfully
					// if (img != "") {
					// 	uploadImageFile(img_fl, img_file_name, 'img');
					// }
					// send_whatsapp_msg();
					// send_mail();
					reload_table();
					clear_input();
					toastr['success'](status_text, "SUCCESS!!");
					return false;
				}

			}
		}
		save_data.open('POST', 'templates/manage_testimonial/save_details.php', true);
		save_data.send(data);
	}
}

// function uploadImageFile(file, file_name, type) {
// 	_(".background_overlay_preloader").style.display = "block";

// 	let data = new FormData();
// 	const sendData = {
// 		file_name: file_name,
// 		type: type,
// 	};
// 	data.append("sendData", JSON.stringify(sendData));
// 	data.append("uploaded_file", file);

// 	let fileUploadXHR = new XMLHttpRequest();

// 	//================== RUN PRELOADER ================//
// 	fileUploadXHR.upload.addEventListener("progress", function (evt) {
// 		if (evt.lengthComputable) {
// 			var percentComplete = parseInt(((evt.loaded / evt.total) * 100));

// 			if (parseFloat(percentComplete) > parseFloat(_(".preloader_inner_number").innerHTML)) {
// 				_(".preloader_inner_number").innerHTML = percentComplete;
// 			}
// 		}
// 	}, false);

// 	fileUploadXHR.onreadystatechange = function () {
// 		if (fileUploadXHR.readyState == 4) {
// 			// console.log(fileUploadXHR.responseText);
// 			const response = JSON.parse(fileUploadXHR.responseText);
// 			const status = response['status'];
// 			const message = response['message'];
// 			const image_name = response['img'];

// 			_(".background_overlay_preloader").style.display = "none";
// 			_(".preloader_inner_number").innerHTML = 0;

// 			if (status == "File Type Error") {
// 				toastr['error'](message, "ERROR!!");
// 				return false;
// 			}
// 			if (status == "Success") {
// 				toastr['info'](message, "SUCCESS!!");
// 				return false;
// 			}
// 		}
// 	};
// 	fileUploadXHR.open('POST', 'templates/manage_testimonial/upload_image_file.php', true);
// 	fileUploadXHR.send(data);
// }

function update_data(testimonial_id) {
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			testimonial_id: testimonial_id
		};
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				const response = JSON.parse(xhr.responseText);
				
				_("#testimonial_id ").value = response['testimonial_id'];
				_("#name").value = response['name'];
				_("#designation").value = response['designation'];
				// _("#msg").value = response['msg'];

				CKEDITOR.instances['msg'].setData(response['msg']);

				_("#rating").value = response['rating'];

				_(".img").src = '../upload_content/upload_img/testimonial_img/' + response['img'];
				_(".img").setAttribute("data-blank-image", '../upload_content/upload_img/testimonial_img/' + response['img']);
				
				chngMode('Update');
				$("#entryModal").modal();
				_(".background_overlay").style.display = "none";
			}
		}
		xhr.open('POST', 'templates/manage_testimonial/update_data_input.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(testimonial_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			testimonial_id: testimonial_id
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
		xhr.open('POST', 'templates/manage_testimonial/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}