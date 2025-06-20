$(document).ready(function(){
	show_list();
	make_select2();
	
});
function clear_input(){
	_("#sub_menu_code").value="";
	_("#sub_menu_name").value="";
	_("#menu_icon").value="fa fa-circle-notch";
	$("#menu_code").val('').trigger('change');
	_("#file_name").value="";
	_("#folder_name").value="";
	_("#order_num").value="";
	_("#active").value="Yes";
	chngMode('Insert');
	clearInputAleart();
}

function chngMode(mode) {
	if (mode=="Update") {
		_(".entry_modal_title").innerHTML = 'Update Sub Menu Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else{
		_(".entry_modal_title").innerHTML = 'Enter Sub Menu Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2() {
	$('#menu_code').select2({
        dropdownParent: $('#entryModal'),
		width: '100%',
		allowClear: true,
    });
}

function show_list(){
	if(view_per=="Yes"){
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url':'templates/sub_menu_master/list.php'
			},
			'drawCallback': function (data) { 
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'sub_menu_name' },
				{ data: 'menu_name' },
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

function save_details(){
	let save_no =1;
	clearInputAleart();

	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if(!_("#sub_menu_name").checkValidity()){
		toastr['warning']("Sub Menu Name : "+_("#sub_menu_name").validationMessage, "WARNING");
		showInputAlert('sub_menu_name','warning',_("#sub_menu_name").validationMessage);
		_("#sub_menu_name").focus();
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
	if(!_("#menu_code").checkValidity()){
		toastr['warning']("Master Menu : "+_("#menu_code").validationMessage, "WARNING");
		showInputAlert('menu_code','warning',_("#menu_code").validationMessage);
		_("#menu_code").focus();
		save_no = 0;
		return false;
	}
	if(!_("#file_name").checkValidity()){
		toastr['warning']("File Name : "+_("#file_name").validationMessage, "WARNING");
		showInputAlert('file_name','warning',_("#file_name").validationMessage);
		_("#file_name").focus();
		save_no = 0;
		return false;
	}
	if(!_("#folder_name").checkValidity()){
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
			sub_menu_code: _("#sub_menu_code").value, 
			sub_menu_name: _("#sub_menu_name").value,
			menu_icon: _("#menu_icon").value,
			menu_code: _("#menu_code").value,
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
		save_data.open('POST','templates/sub_menu_master/save_details.php',true);	
		save_data.send(data);
	}
}

function update_data(rw_num){
	if(edit_per=="Yes"){
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			sub_menu_code: _(".sub_menu_code_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			const response = JSON.parse(xhr.responseText);

			_("#sub_menu_code").value = response[0]['sub_menu_code'];
			_("#sub_menu_name").value = response[0]['sub_menu_name'];
			_("#menu_icon").value = response[0]['menu_icon'];
			$("#menu_code").val(response[0]['menu_code']).trigger('change');
			_("#file_name").value = response[0]['file_name'];
			_("#folder_name").value = response[0]['folder_name'];
			_("#order_num").value = response[0]['order_num'];
			_("#active").value = response[0]['active'];
			chngMode('Update');
			$("#entryModal").modal();
			_(".background_overlay").style.display = "none";
		}}
		xhr.open('POST','templates/sub_menu_master/update_data_input.php',true);	
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
			sub_menu_code: _(".sub_menu_code_"+rw_num).value
		};
		data.append("sendData",JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			reload_table();
			_(".background_overlay").style.display = "none";
			toastr['info']("Data Deleted Successfully.", "SUCCESS!!");
			return false;
		}}
		xhr.open('POST','templates/sub_menu_master/delete_data.php',true);	
		xhr.send(data);
		
	}
	else{
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}