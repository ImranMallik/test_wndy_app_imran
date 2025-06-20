$(document).ready(function () {
	show_list();
	make_select2_ajx('buyer_id');
	make_select2_ajx('product_id');
});
function clear_input() {
	_("#wishlist_id").value = "";
	$("#buyer_id").val('').trigger('change');
	$("#product_id").val('').trigger('change');
	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Wishlist Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Wishlist Details :';
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
	}

	$("#" + id).select2({
		dropdownParent: $('#entryModal'),
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_wishList/" + fileName + ".php",
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
				'url': 'templates/manage_wishList/list.php'
			},
			'drawCallback': function (data) {
				// Here the response			
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'action' },
				{ data: 'buyer_details' },
				{ data: 'product_name' }
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

function reload_table(){
	$('#data_table').DataTable().ajax.reload();
}

function save_details(){
	let save_no =1;
	clearInputAleart();

	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if(!_("#buyer_id").checkValidity()){
		toastr['warning']("Buyer ID: "+_("#buyer_id").validationMessage, "WARNING");
		showInputAlert('buyer_id','warning',_("#buyer_id").validationMessage);
		_("#buyer_id").focus();
		save_no = 0;
		return false;
	}
	if(!_("#product_id").checkValidity()){
		toastr['warning']("Product ID: "+_("#product_id").validationMessage, "WARNING");
		showInputAlert('product_id','warning',_("#product_id").validationMessage);
		_("#product_id").focus();
		save_no = 0;
		return false;
	}

	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";
		//============================= FOR PROFILE IMAGE =====================================
	
		let data = new FormData();
		const sendData = {
			wishlist_id: _("#wishlist_id").value, 
			buyer_id: _("#buyer_id").value,
			product_id: _("#product_id").value,
		};
		data.append("sendData",JSON.stringify(sendData));

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
			else if(status=="Exist"){
				toastr['error'](status_text, "ERROR!!");
				showInputAlert('buyer_id','error',status_text);
				_("#buyer_id").focus();
				return false;
			}
			else{
				// When Data Save successfully
				reload_table();
				clear_input();
				toastr['success'](status_text, "SUCCESS!!");
				return false;
			}

		}}
		save_data.open('POST','templates/manage_wishList/save_details.php',true);	
		save_data.send(data);
	}
}



function update_data(rw_num){
	if(edit_per=="Yes"){
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			wishlist_id: _(".wishlist_id_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			const response = JSON.parse(xhr.responseText);
			const buyer_id = response[0]['buyer_name'];
			const product_id = response[0]['product_name'];
			_("#wishlist_id").value = response[0]['wishlist_id'];
			_("#buyer_id").innerHTML = `<option value="`+response[0]['buyer_id']+`" selected>`+buyer_id+`</option>`;
			_("#product_id").innerHTML = `<option value="`+response[0]['product_id']+`" selected>`+product_id+`</option>`;

			chngMode('Update');
			$("#entryModal").modal();
			_(".background_overlay").style.display = "none";
		}}
		xhr.open('POST','templates/manage_wishList/update_data_input.php',true);	
		xhr.send(data);
	}
	else{
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(rw_num) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			wishlist_id: _(".wishlist_id_" + rw_num).value
		};
		// console.log(sendData);
		data.append("sendData", JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				// console.log(xhr.responseText);
				reload_table();
				_(".background_overlay").style.display = "none";
				toastr['info']("Data Deleted Successfully.", "SUCCESS!!");
				return false;
			}
		}
		xhr.open('POST', 'templates/manage_wishList/delete_data.php', true);
		xhr.send(data);
	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}