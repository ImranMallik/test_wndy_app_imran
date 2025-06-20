
function noGstNum(inputName) {
  _("#gst_num").value = "No";
  _("#gst_num").style.display = "none";
  updateProfileDetails(inputName)
}

function noCompany(inputName) {
  _("#company_name").value = "No";
  _("#company_name").style.display = "none";
  updateProfileDetails(inputName)
}

function updateProfileDetails(inputName) {
  let execute = 1;
  clearInputAleart();

  var numberRegex = /^\d+$/;

  let count = 0;
  let value = '';

  if (inputName == "waste_cate") {
    count = 0;
    for (let index = 0; index < __("waste_cate").length; index++) {
      if (__("waste_cate")[index].checked == true) {
        if (count == 0) {
          value += __("waste_cate")[index].getAttribute('data-value');
        }
        else {
          value += ", " + __("waste_cate")[index].getAttribute('data-value');
        }
        count++;
      }
    }
    if (count == 0) {
      toastr["warning"]("Please select an option", "WARNING");
      showInputAlert("waste_cate", "warning", 'Please select an option');
      execute = 0;
      return false;
    }
  }

  if (inputName == "working_days") {
    count = 0;
    for (let index = 0; index < __("working_days").length; index++) {
      if (__("working_days")[index].checked == true) {
        if (count == 0) {
          value += __("working_days")[index].getAttribute('data-value');
        }
        else {
          value += ", " + __("working_days")[index].getAttribute('data-value');
        }
        count++;
      }
    }
    if (count == 0) {
      toastr["warning"]("Please select an option", "WARNING");
      showInputAlert("working_days", "warning", 'Please select an option');
      execute = 0;
      return false;
    }
  }

  if (inputName == "working_method") {
    count = 0;
    for (let index = 0; index < __("working_method").length; index++) {
      if (__("working_method")[index].checked == true) {
        if (count == 0) {
          value += __("working_method")[index].getAttribute('data-value');
        }
        else {
          value += ", " + __("working_method")[index].getAttribute('data-value');
        }
        count++;
      }
    }
    if (count == 0) {
      toastr["warning"]("Please select an option", "WARNING");
      showInputAlert("working_method", "warning", 'Please select an option');
      execute = 0;
      return false;
    }
  }

  if (inputName == "livelihood_source") {
    count = 0;
    for (let index = 0; index < __("livelihood_source").length; index++) {
      if (__("livelihood_source")[index].checked == true) {
        if (count == 0) {
          value += __("livelihood_source")[index].getAttribute('data-value');
        }
        else {
          value += ", " + __("livelihood_source")[index].getAttribute('data-value');
        }
        count++;
      }
    }
    if (count == 0) {
      toastr["warning"]("Please select an option", "WARNING");
      showInputAlert("livelihood_source", "warning", 'Please select an option');
      execute = 0;
      return false;
    }
  }

  if (inputName == "deal_customer") {
    count = 0;
    for (let index = 0; index < __("deal_customer").length; index++) {
      if (__("deal_customer")[index].checked == true) {
        if (count == 0) {
          value += __("deal_customer")[index].getAttribute('data-value');
        }
        else {
          value += ", " + __("deal_customer")[index].getAttribute('data-value');
        }
        count++;
      }
    }
    if (count == 0) {
      toastr["warning"]("Please select an option", "WARNING");
      showInputAlert("deal_customer", "warning", 'Please select an option');
      execute = 0;
      return false;
    }
  }

  if (inputName == "gst_num") {
    if (!_("#gst_num").checkValidity()) {
      toastr["warning"]("GST Number : " + _("#gst_num").validationMessage, "WARNING");
      showInputAlert("gst_num", "warning", _("#gst_num").validationMessage);
      _("#gst_num").focus();
      execute = 0;
      return false;
    }
    value = _("#gst_num").value;
  }

  if (inputName == "company_name") {
    if (!_("#company_name").checkValidity()) {
      toastr["warning"]("Company Name : " + _("#company_name").validationMessage, "WARNING");
      showInputAlert("company_name", "warning", _("#company_name").validationMessage);
      _("#company_name").focus();
      execute = 0;
      return false;
    }
    value = _("#company_name").value;
  }

  if (inputName == "pan_num") {
    if (!_("#pan_num").checkValidity()) {
      toastr["warning"]("PAN Card Number : " + _("#pan_num").validationMessage, "WARNING");
      showInputAlert("pan_num", "warning", _("#pan_num").validationMessage);
      _("#pan_num").focus();
      execute = 0;
      return false;
    }
    value = _("#pan_num").value;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      type: inputName,
      value: value,
    };
    data.append("sendData", JSON.stringify(sendData));

    save_data = new XMLHttpRequest();
    save_data.onreadystatechange = function () {
      if (save_data.readyState == 4) {
        
        const response = JSON.parse(save_data.responseText);
        const status = response[0]["status"];
        const status_text = response[0]["status_text"];
        if (status == "SessionDestroy") {
          session_destroy();
          setTimeout(function () {
            window.location.reload();
          }, 5000);
        }
        else {
          toastr["success"](status_text, "SUCCESS!!");
          setTimeout(function () {
            _(".background_overlay").style.display = "none";
            window.location.reload();
          }, 1500);
        }
      }
    };
    save_data.open("POST", "templates/buyer-profile-updation/update_profile_details.php", true);
    save_data.send(data);
  }
}

function skipProfileDetails(inputName){
  let execute = 1;
  clearInputAleart();
  
  let value = '';

  if (inputName == "waste_cate") {
    value = "Skip";
  }

  if (inputName == "working_days") {
    value = "Skip";
  }

  if (inputName == "working_method") {
    value = "Skip";
  }

  if (inputName == "livelihood_source") {
    value = "Skip";
  }

  if (inputName == "deal_customer") {
    value = "Skip";
  }

  if (inputName == "gst_num") {
    value = "Skip";
  }

  if (inputName == "company_name") {
    value = "Skip";
  }

  if (inputName == "pan_num") {
    value = "Skip";
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      type: inputName,
      value: value,
    };
    data.append("sendData", JSON.stringify(sendData));

    save_data = new XMLHttpRequest();
    save_data.onreadystatechange = function () {
      if (save_data.readyState == 4) {
        
        const response = JSON.parse(save_data.responseText);
        const status = response[0]["status"];
        const status_text = response[0]["status_text"];
        if (status == "SessionDestroy") {
          session_destroy();
          setTimeout(function () {
            window.location.reload();
          }, 5000);
        }
        else {
          toastr["success"](status_text, "SUCCESS!!");
          setTimeout(function () {
            _(".background_overlay").style.display = "none";
            window.location.reload();
          }, 1500);
        }
      }
    };
    save_data.open("POST", "templates/buyer-profile-updation/update_profile_details.php", true);
    save_data.send(data);
  }
}