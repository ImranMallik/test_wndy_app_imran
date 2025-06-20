function clear_input() {
	window.location.reload();
}

function save_details() {
	let save_no =1;
	clearInputAleart();

	if(insert_per=="No"){
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no =0;
		return false;
	}
	if (!_("#description").checkValidity()) {
		toastr['warning']("Description : " + _("#description").validationMessage, "WARNING");
		showInputAlert('description', 'warning', _("#description").validationMessage);
		_("#description").focus();
		save_no = 0;
		return false;
	}
	if (!_("#keywords").checkValidity()) {
		toastr['warning']("Keywords : " + _("#keywords").validationMessage, "WARNING");
		showInputAlert('keywords', 'warning', _("#keywords").validationMessage);
		_("#keywords").focus();
		save_no = 0;
		return false;
	}
	if (!_("#author").checkValidity()) {
		toastr['warning']("Author : " + _("#author").validationMessage, "WARNING");
		showInputAlert('author', 'warning', _("#author").validationMessage);
		_("#author").focus();
		save_no = 0;
		return false;
	}

		let data = new FormData();
		const sendData = {
			description: _("#description").value,
			keywords: _("#keywords").value,
			author: _("#author").value,
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
			else{
				// When Data Save successfully
				toastr['success'](status_text, "SUCCESS!!");
				return false;
			}
		
		}}
		save_data.open('POST','templates/manage_seo_details/save_details.php',true);	
		save_data.send(data);
	}