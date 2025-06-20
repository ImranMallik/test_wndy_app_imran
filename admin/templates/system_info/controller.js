
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
	if(!_("#system_name").checkValidity()){
		toastr['warning']("System Name : "+_("#system_name").validationMessage, "WARNING");
		showInputAlert('system_name','warning',_("#system_name").validationMessage);
		_("#system_name").focus();
		save_no = 0;
		return false;
	}
	if(!_("#email").checkValidity()){
		toastr['warning']("Email : "+_("#email").validationMessage, "WARNING");
		showInputAlert('email','warning',_("#email").validationMessage);
		_("#email").focus();
		save_no = 0;
		return false;
	}
	if(!_("#address").checkValidity()){
		toastr['warning']("Address : "+_("#address").validationMessage, "WARNING");
		showInputAlert('address','warning',_("#address").validationMessage);
		_("#address").focus();
		save_no = 0;
		return false;
	}
	if(!_("#ph_num").checkValidity()){
		toastr['warning']("Phone Number : "+_("#ph_num").validationMessage, "WARNING");
		showInputAlert('ph_num','warning',_("#ph_num").validationMessage);
		_("#ph_num").focus();
		save_no = 0;
		return false;
	}
	// if(!_("#profile_image_max_kb_size").checkValidity()){
	// 	toastr['warning']("Profile Image Max Size : "+_("#profile_image_max_kb_size").validationMessage, "WARNING");
	// 	showInputAlert('profile_image_max_kb_size','warning',_("#profile_image_max_kb_size").validationMessage);
	// 	_("#profile_image_max_kb_size").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#category_image_max_kb_size").checkValidity()){
	// 	toastr['warning']("Category Image Max Size : "+_("#category_image_max_kb_size").validationMessage, "WARNING");
	// 	showInputAlert('category_image_max_kb_size','warning',_("#category_image_max_kb_size").validationMessage);
	// 	_("#category_image_max_kb_size").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#product_image_max_kb_size").checkValidity()){
	// 	toastr['warning']("Product Image Max Size : "+_("#product_image_max_kb_size").validationMessage, "WARNING");
	// 	showInputAlert('product_image_max_kb_size','warning',_("#product_image_max_kb_size").validationMessage);
	// 	_("#product_image_max_kb_size").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#product_file_max_kb_size").checkValidity()){
	// 	toastr['warning']("Product File Max Size : "+_("#product_file_max_kb_size").validationMessage, "WARNING");
	// 	showInputAlert('product_file_max_kb_size','warning',_("#product_file_max_kb_size").validationMessage);
	// 	_("#product_file_max_kb_size").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	// if(!_("#home_slider_max_kb_size").checkValidity()){
	// 	toastr['warning']("Home Slider Max Size : "+_("#home_slider_max_kb_size").validationMessage, "WARNING");
	// 	showInputAlert('home_slider_max_kb_size','warning',_("#home_slider_max_kb_size").validationMessage);
	// 	_("#home_slider_max_kb_size").focus();
	// 	save_no = 0;
	// 	return false;
	// }
	if(!_("#product_view_credit").checkValidity()){
		toastr['warning']("Product Viewing Credit : "+_("#product_view_credit").validationMessage, "WARNING");
		showInputAlert('product_view_credit','warning',_("#product_view_credit").validationMessage);
		_("#product_view_credit").focus();
		save_no = 0;
		return false;
	}
	
	if(save_no==1 && insert_per=="Yes"){
		_(".background_overlay").style.display = "block";

		//============================= FOR COMAPNY LOGO =====================================
		let d = new Date();
		let logo_file_name = "logo_"+d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear()+"-"+d.getTime();
		let logo_fl= _("#logo").files[0];
		
		var original_file_name=_("#logo").value;
		var ext = original_file_name.split('.').pop();
		let logo = "";
		if(_("#logo").value!=""){
			logo = logo_file_name+"."+ext;
		}

		//============================= FOR FAVICON =====================================
		let favicon_file_name = "favicon_"+d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear()+"-"+d.getTime();
		let favicon_fl= _("#favicon").files[0];
		
		var original_file_name=_("#favicon").value;
		var ext = original_file_name.split('.').pop();
		let favicon = "";
		if(_("#favicon").value!=""){
			favicon = favicon_file_name+"."+ext;
		}

		let data = new FormData();
		const sendData = {
			system_name: _("#system_name").value, 
			email: _("#email").value,
			address: _("#address").value,
			ph_num: _("#ph_num").value,
			// profile_image_max_kb_size: _("#profile_image_max_kb_size").value,
			// category_image_max_kb_size: _("#category_image_max_kb_size").value,
			// product_image_max_kb_size: _("#product_image_max_kb_size").value,
			// product_file_max_kb_size: _("#product_file_max_kb_size").value,
			// home_slider_max_kb_size: _("#home_slider_max_kb_size").value,
			product_view_credit: _("#product_view_credit").value,
			logo: logo,
			favicon: favicon
		};
		data.append("sendData",JSON.stringify(sendData));
		data.append("logo_fl", logo_fl);
		data.append("favicon_fl", favicon_fl);

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
			else if(status=="logo error"){
				toastr['error'](status_text, "ERROR!!");
				showInputAlert('logo','error',status_text);
				return false;
			}
			else if(status=="favicon error"){
				toastr['error'](status_text, "ERROR!!");
				showInputAlert('favicon','error',status_text);
				return false;
			}
			else{
				// When Data Save successfully
				toastr['success'](status_text, "SUCCESS!!");
				window.location.reload();
				return false;
			}
		
		}}
		save_data.open('POST','templates/system_info/save_details.php',true);	
		save_data.send(data);
	}
}