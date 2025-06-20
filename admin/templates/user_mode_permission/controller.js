$(document).ready(function(){
	make_select2();
});

function make_select2() {
	$('#user_mode_code').select2({
		width: '100%',
		allowClear: true,
    });
}

function show_menu_list() {
	let showNo = 1;
	if(!_("#user_mode_code").checkValidity()){
		toastr['warning']("User Mode : "+_("#user_mode_code").validationMessage, "WARNING");
		_(".menu_list_div").innerHTML = '';
		showNo = 0;
		return false;
	}
	if(showNo==1){
		_(".background_overlay").style.display = "block";
		let data = new FormData();
		const sendData = {
			user_mode_code: _("#user_mode_code").value
		};
		data.append("sendData",JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {if(xhr.readyState == 4) {
			_(".background_overlay").style.display = "none";
			_(".menu_list_div").innerHTML = xhr.responseText;
			return false;
		}}
		xhr.open('POST','templates/user_mode_permission/menu_list.php',true);	
		xhr.send(data);
	}
}

function chng_main_checkbox(){
	if(_("#main_checkbox").checked==true){
		
		for(z=1; z<_("#total_rw").value;z++){
			if(_("#menu_checkbox_"+z).checked==false){
				_("#menu_checkbox_"+z).checked=true;
			}
		}

	}
	else{
		
		for(z=1; z<_("#total_rw").value;z++){
			if(_("#menu_checkbox_"+z).checked==true){
				_("#menu_checkbox_"+z).checked=false;
			}
		}
		
	}
}

function checkSelection(rw_num) {
	if(_("#menu_checkbox_"+rw_num).checked==true){
		let allCheck = 'Yes';

		for(z=1; z<_("#total_rw").value;z++){
			if(_("#menu_checkbox_"+z).checked==false){
				allCheck = 'No';
			}
		}
		if (allCheck=='No') {
			_("#main_checkbox").checked = false;
		}
		else{
			_("#main_checkbox").checked = true;
		}
	}
	else{
		_("#main_checkbox").checked = false;
	}
}

function save_details(){
	let save_no =1;
	
	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if(!_("#user_mode_code").checkValidity()){
		toastr['warning']("User Mode : "+_("#user_mode_code").validationMessage, "WARNING");
		_("#user_mode_code").focus();
		save_no = 0;
		return false;
	}
	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";
		
		let all_menu_code = [];
		let total_rw = 1;
		
		for(z=1; z<_("#total_rw").value;z++){
			
			if(_("#menu_checkbox_"+z).checked==true){
				all_menu_code[total_rw]= _("#all_menu_code_"+z).value;
				total_rw++;
			}
			
		}

		let data = new FormData();
		const sendData = {
			user_mode_code: _("#user_mode_code").value, 
			all_menu_code: JSON.stringify(all_menu_code),
			total_rw: total_rw
		};
		// console.log(all_menu_code);
		// return false;
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
				toastr['success'](status_text, "SUCCESS!!");
				return false;
			}
		
		}}
		save_data.open('POST','templates/user_mode_permission/save_details.php',true);	
		save_data.send(data);
	}
}