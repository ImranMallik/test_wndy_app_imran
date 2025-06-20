$(document).ready(function(){
	show_list();
});
function clear_input(){
	_("#menu_code").value="";
	_("#menu_name").value="";
	_("#menu_icon").value="";
	_("#sub_menu_status").value="Yes";
	_("#order_num").value="";
	_("#active").value="Yes";
	chng_sub_menu_status();
	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode=="Update") {
		_(".entry_modal_title").innerHTML = 'Update Menu Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else{
		_(".entry_modal_title").innerHTML = 'Enter Menu Details :';
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
				'url':'templates/menu_master/list.php'
			},
			'drawCallback': function (data) { 
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'menu_name' },
				{ data: 'sub_menu_status' },
				{ data: 'file_name' },
				{ data: 'folder_name' },
				{ data: 'order_num' },
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

function chng_sub_menu_status(){
	if(_("#sub_menu_status").value=="Yes"){
		_("#file_name").value = "";
		_("#file_name").disabled = true;
		_("#folder_name").value = "";
		_("#folder_name").disabled = true;
	}
	else{
		_("#file_name").disabled = false;
		_("#folder_name").disabled = false;
	}
}

function save_details(){
	let save_no =1;
	clearInputAleart();

	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if(!_("#menu_name").checkValidity()){
		toastr['warning']("Menu Name : "+_("#menu_name").validationMessage, "WARNING");
		showInputAlert('menu_name','warning',_("#menu_name").validationMessage);
		_("#menu_name").focus();
		save_no = 0;
		return false;
	}
	if(!_("#menu_icon").checkValidity()){
		toastr['warning']("Menu Icon : "+_("#menu_icon").validationMessage, "WARNING");
		showInputAlert('menu_icon','warning',_("#menu_icon").validationMessage);
		_("#menu_icon").focus();
		save_no = 0;
		return false;
	}
	if(!_("#file_name").checkValidity() && _("#sub_menu_status").value=="No"){
		toastr['warning']("File Name : "+_("#file_name").validationMessage, "WARNING");
		showInputAlert('file_name','warning',_("#file_name").validationMessage);
		_("#file_name").focus();
		save_no = 0;
		return false;
	}
	if(!_("#folder_name").checkValidity() && _("#sub_menu_status").value=="No"){
		toastr['warning']("Folder Name : "+_("#folder_name").validationMessage, "WARNING");
		showInputAlert('folder_name','warning',_("#folder_name").validationMessage);
		_("#folder_name").focus();
		save_no = 0;
		return false;
	}

	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";
		let data = new FormData();
		const sendData = {
			menu_code: _("#menu_code").value, 
			menu_name: _("#menu_name").value,
			menu_icon: _("#menu_icon").value,
			sub_menu_status: _("#sub_menu_status").value,
			file_name: _("#file_name").value,
			folder_name: _("#folder_name").value,
			order_num: _("#order_num").value,
			active: _("#active").value,
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
		save_data.open('POST','templates/menu_master/save_details.php',true);	
		save_data.send(data);
	}
}

function update_data(rw_num){
	if(edit_per=="Yes"){
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			menu_code: _(".menu_code_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			const response = JSON.parse(xhr.responseText);
			
			_("#menu_code").value = response[0]['menu_code'];
			_("#menu_name").value = response[0]['menu_name'];
			_("#menu_icon").value = response[0]['menu_icon'];
			_("#sub_menu_status").value = response[0]['sub_menu_status'];
			_("#file_name").value = response[0]['file_name'];
			_("#folder_name").value = response[0]['folder_name'];
			_("#order_num").value = response[0]['order_num'];
			_("#active").value = response[0]['active'];
			chng_sub_menu_status();
			chngMode('Update');
			$("#entryModal").modal();
			_(".background_overlay").style.display = "none";
		}}
		xhr.open('POST','templates/menu_master/update_data_input.php',true);	
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
			menu_code: _(".menu_code_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			reload_table();
			_(".background_overlay").style.display = "none";
			toastr['info']("Data Deleted Successfully.", "SUCCESS!!");
			return false;
		}}
		xhr.open('POST','templates/menu_master/delete_data.php',true);	
		xhr.send(data);
		
	}
	else{
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}