
function clear_input(){
	window.location.reload();
}

function save_details(){
	let save_no =1;
	clearInputAleart();
	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if(!_("#old_password").checkValidity()){
		toastr['warning']("Old Password : "+_("#old_password").validationMessage, "WARNING");
		showInputAlert('old_password','warning',_("#old_password").validationMessage);
		_("#old_password").focus();
		save_no = 0;
		return false;
	}
	if(!_("#new_password").checkValidity()){
		toastr['warning']("New Password : "+_("#new_password").validationMessage, "WARNING");
		showInputAlert('new_password','warning',_("#new_password").validationMessage);
		_("#new_password").focus();
		save_no = 0;
		return false;
	}
		
	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";

		let data = new FormData();
		const sendData = {
			old_password: _("#old_password").value,
			new_password: _("#new_password").value,
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
			else if(status=="Not_Match"){
				toastr['error'](status_text, "ERROR!!");
				showInputAlert('old_password','error',status_text);
				_("#old_password").focus();
				return false;
			}
			else{
				// When Data Save successfully
				setTimeout(function(){ 
					clear_input();
				}, 1500);
				toastr['success'](status_text, "SUCCESS!!");
				return false;
			}
		
		}}
		save_data.open('POST','templates/change_password/save_details.php',true);	
		save_data.send(data);
	}
}