
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
	// if(!_("#facebook").checkValidity()){
	// 	toastr['warning']("Facebook : "+_("#facebook").validationMessage, "WARNING");
	// 	showInputAlert('facebook','warning',_("#facebook").validationMessage);
	// 	_("#facebook").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#twitter").checkValidity()){
	// 	toastr['warning']("Twitter : "+_("#twitter").validationMessage, "WARNING");
	// 	showInputAlert('twitter','warning',_("#twitter").validationMessage);
	// 	_("#twitter").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#pinterest").checkValidity()){
	// 	toastr['warning']("Pinterest : "+_("#pinterest").validationMessage, "WARNING");
	// 	showInputAlert('pinterest','warning',_("#pinterest").validationMessage);
	// 	_("#pinterest").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#linkedin").checkValidity()){
	// 	toastr['warning']("Linkedin  : "+_("#linkedin").validationMessage, "WARNING");
	// 	showInputAlert('linkedin','warning',_("#linkedin").validationMessage);
	// 	_("#linkedin").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#instagram").checkValidity()){
	// 	toastr['warning']("Instagram : "+_("#instagram").validationMessage, "WARNING");
	// 	showInputAlert('instagram','warning',_("#instagram").validationMessage);
	// 	_("#instagram").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#youtube").checkValidity()){
	// 	toastr['warning']("Youtube : "+_("#youtube").validationMessage, "WARNING");
	// 	showInputAlert('youtube','warning',_("#youtube").validationMessage);
	// 	_("#youtube").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	
	
	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";

	

		let data = new FormData();
		const sendData = {
			facebook: _("#facebook").value, 
			twitter: _("#twitter").value,
			pinterest: _("#pinterest").value,
			linkedin: _("#linkedin").value,
			instagram: _("#instagram").value,
			youtube: _("#youtube").value,
			
		};
		  data.append("sendData", JSON.stringify(sendData));


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
			else{
				// When Data Save successfully
				toastr['success'](status_text, "SUCCESS!!");
				return false;
			}
		
		}}
		save_data.open('POST','templates/manage_social_link/save_details.php',true);	
		save_data.send(data);
	}
}