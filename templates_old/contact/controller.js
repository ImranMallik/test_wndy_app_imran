$(document).ready(function () {
});
function clear_input() {
	_("#name").value = "";
	_("#email").value = "";
	_("#phone").value = "";
	_("#subject").value = "";
	_("#message").value = "";



	clearInputAleart();
}



function save_details() {
	let save_no = 1;
	clearInputAleart();

	if (!_("#name").checkValidity()) {
		toastr['warning']("Name : " + _("#name").validationMessage, "WARNING");
		showInputAlert('name', 'warning', _("#name").validationMessage);
		_("#name").focus();
		save_no = 0;
		return false;
	}
	if (!_("#email").checkValidity()) {
		toastr['warning']("email : " + _("#email").validationMessage, "WARNING");
		showInputAlert('email', 'warning', _("#email").validationMessage);
		_("#email").focus();
		save_no = 0;
		return false;
	}	if (!_("#phone").checkValidity()) {
		toastr['warning']("phone : " + _("#phone").validationMessage, "WARNING");
		showInputAlert('phone', 'warning', _("#phone").validationMessage);
		_("#phone").focus();
		save_no = 0;
		return false;
	}

	if (save_no == 1 ) {
		// _(".background_overlay").style.display = "block";


		let data = new FormData();
		const sendData = {
			name: _("#name").value,
			email: _("#email").value,
			phone: _("#phone").value,
			subject: _("#subject").value,
			message: _("#message").value,
		};
		console.log(sendData);
		data.append("sendData", JSON.stringify(sendData));

		save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
			if (save_data.readyState == 4) {
				const response = JSON.parse(save_data.responseText);
				const status = response[0]['status'];
				const status_text = response[0]['status_text'];
				// _(".background_overlay").style.display = "none";
				if (status == "SessionDestroy") {
					session_destroy();
					setTimeout(function () {
						window.location.reload();
					}, 5000);
					return false;
				}
				else {
					
					clear_input();
					toastr['success'](status_text, "SUCCESS!!");
					return false;
				}

			}
		}
		save_data.open('POST', 'templates/contact/save_details.php', true);
		save_data.send(data);
	}
}

