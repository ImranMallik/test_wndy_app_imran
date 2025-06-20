$(document).ready(function(){
	show_list();
});
function clear_input(){
	_("#user_mode_code").value="";
	_("#user_mode").value="";
	_("#active").value="Yes";
	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode=="Update") {
		_(".entry_modal_title").innerHTML = 'Update User Role Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else{
		_(".entry_modal_title").innerHTML = 'Enter User Role Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function show_list(){
	if(view_per=="Yes"){
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url':'templates/create_user_mode/list.php'
			},
			'drawCallback': function (data) { 
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'user_mode' },
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
				{ extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'},
				{ extend: 'pageLength', className: 'btn dark btn-outline', text: 'Show Entries' }
			],
			'order': [[0, "asc"]],
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
	
	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if(!_("#user_mode").checkValidity()){
		toastr['warning']("User Role Title : "+_("#user_mode").validationMessage, "WARNING");
		showInputAlert('user_mode','warning',_("#user_mode").validationMessage);
		_("#user_mode").focus();
		save_no = 0;
		return false;
	}

	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";
		let data = new FormData();
		const sendData = {
			user_mode_code: _("#user_mode_code").value, 
			user_mode: _("#user_mode").value,
			active: _("#active").value
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
				toastr['warning'](status_text, "WARNING!!");
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
		save_data.open('POST','templates/create_user_mode/save_details.php',true);	
		save_data.send(data);
	}
}

function update_data(rw_num){
	if(edit_per=="Yes"){
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			user_mode_code: _(".user_mode_code_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			const response = JSON.parse(xhr.responseText);

			_("#user_mode_code").value = response[0]['user_mode_code'];
			_("#user_mode").value = response[0]['user_mode'];
			_("#active").value = response[0]['active'];
			chngMode('Update');
			$("#entryModal").modal();
			_(".background_overlay").style.display = "none";
		}}
		xhr.open('POST','templates/create_user_mode/update_data_input.php',true);	
		xhr.send(data);
	}
	else{
		toastr['error']("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(rw_num){
	if(del_per=="Yes"){
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			user_mode_code: _(".user_mode_code_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			reload_table();
			_(".background_overlay").style.display = "none";
			toastr['info']("Data Deleted Successfully.", "SUCCESS!!");
			return false;
		}}
		xhr.open('POST','templates/create_user_mode/delete_data.php',true);	
		xhr.send(data);
		
	}
	else{
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}