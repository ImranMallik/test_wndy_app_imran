function sign_in(){
	let signin = 1;
	if(!_("#user_id").checkValidity()){
		toastr['warning']("User Id : "+_("#user_id").validationMessage, "WARNING");
		_("#user_id").focus();
		signin = 0;
		return false;
	}
	if(!_("#password").checkValidity()){
		toastr['warning']("Password : "+_("#password").validationMessage, "WARNING");
		_("#password").focus();
		signin = 0;
		return false;
	}
	
	if(signin==1){
		_(".background_overlay").style.display = "block";
		let remember = 'No';
		if (_("#remember").checked==true) {
			remember = 'Yes';
		}
		let data = new FormData();
		const sendData = {
			user_id: _("#user_id").value, 
			password: _("#password").value,
			remember: remember
		};
		data.append("sendData",JSON.stringify(sendData));
		
		signin = new XMLHttpRequest();
		signin.onreadystatechange = function() {if(signin.readyState == 4) {
			// console.log(signin.responseText);
			const response = JSON.parse(signin.responseText);
			const login = response[0]['login'];
			_(".background_overlay").style.display = "none";
			if(login=="No"){
				toastr['error']("User Data Not Match", "NOT MATCH !!");
				return false;
			}
			if(login=="Yes"){
				toastr['success']("Login Successfully.", "SUCCESS!!");
				setTimeout(function(){ 
					window.location.reload();
				 }, 2000);
				return false;
			}
		}}
		signin.open('POST','templates/login/login_check.php',true);	
		signin.send(data);
	}
}