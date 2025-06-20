
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

  if (inputName == "ac_price") {
    if (!_("#ac_price").checkValidity()) {
      toastr["warning"]("Price Range of AC : " + _("#ac_price").validationMessage, "WARNING");
      showInputAlert("ac_price", "warning", _("#ac_price").validationMessage);
      _("#ac_price").focus();
      execute = 0;
      return false;
    }
    value = _("#ac_price").value;
  }

  if (inputName == "washing_machine_price") {
    if (!_("#washing_machine_price").checkValidity()) {
      toastr["warning"]("Price Range of Washing Machine : " + _("#washing_machine_price").validationMessage, "WARNING");
      showInputAlert("washing_machine_price", "warning", _("#washing_machine_price").validationMessage);
      _("#washing_machine_price").focus();
      execute = 0;
      return false;
    }
    value = _("#washing_machine_price").value;
  }

  if (inputName == "fridge_price") {
    if (!_("#fridge_price").checkValidity()) {
      toastr["warning"]("Price Range of Fridge : " + _("#fridge_price").validationMessage, "WARNING");
      showInputAlert("fridge_price", "warning", _("#fridge_price").validationMessage);
      _("#fridge_price").focus();
      execute = 0;
      return false;
    }
    value = _("#fridge_price").value;
  }

  if (inputName == "tv_price") {
    if (!_("#tv_price").checkValidity()) {
      toastr["warning"]("Price Range of TV : " + _("#tv_price").validationMessage, "WARNING");
      showInputAlert("tv_price", "warning", _("#tv_price").validationMessage);
      _("#tv_price").focus();
      execute = 0;
      return false;
    }
    value = _("#tv_price").value;
  }

  if (inputName == "microwave_price") {
    if (!_("#microwave_price").checkValidity()) {
      toastr["warning"]("Price Range of Microwave : " + _("#microwave_price").validationMessage, "WARNING");
      showInputAlert("microwave_price", "warning", _("#microwave_price").validationMessage);
      _("#microwave_price").focus();
      execute = 0;
      return false;
    }
    value = _("#microwave_price").value;
  }

  if (inputName == "laptop_price") {
    if (!_("#laptop_price").checkValidity()) {
      toastr["warning"]("Price Range of Laptop : " + _("#laptop_price").validationMessage, "WARNING");
      showInputAlert("laptop_price", "warning", _("#laptop_price").validationMessage);
      _("#laptop_price").focus();
      execute = 0;
      return false;
    }
    value = _("#laptop_price").value;
  }

  if (inputName == "geyser_price") {
    if (!_("#geyser_price").checkValidity()) {
      toastr["warning"]("Price Range of Geyser : " + _("#geyser_price").validationMessage, "WARNING");
      showInputAlert("geyser_price", "warning", _("#geyser_price").validationMessage);
      _("#geyser_price").focus();
      execute = 0;
      return false;
    }
    value = _("#geyser_price").value;
  }

  if (inputName == "paper_price") {
    if (!_("#paper_price").checkValidity()) {
      toastr["warning"]("Price Range of Paper : " + _("#paper_price").validationMessage, "WARNING");
      showInputAlert("paper_price", "warning", _("#paper_price").validationMessage);
      _("#paper_price").focus();
      execute = 0;
      return false;
    }
    value = _("#paper_price").value;
  }

  if (inputName == "iron_price") {
    if (!_("#iron_price").checkValidity()) {
      toastr["warning"]("Price Range of Iron : " + _("#iron_price").validationMessage, "WARNING");
      showInputAlert("iron_price", "warning", _("#iron_price").validationMessage);
      _("#iron_price").focus();
      execute = 0;
      return false;
    }
    value = _("#iron_price").value;
  }

  if (inputName == "furniture_price") {
    if (!_("#furniture_price").checkValidity()) {
      toastr["warning"]("Price Range of Furniture : " + _("#furniture_price").validationMessage, "WARNING");
      showInputAlert("furniture_price", "warning", _("#furniture_price").validationMessage);
      _("#furniture_price").focus();
      execute = 0;
      return false;
    }
    value = _("#furniture_price").value;
  }

  if (inputName == "battery_price") {
    if (!_("#battery_price").checkValidity()) {
      toastr["warning"]("Price Range of Battery : " + _("#battery_price").validationMessage, "WARNING");
      showInputAlert("battery_price", "warning", _("#battery_price").validationMessage);
      _("#battery_price").focus();
      execute = 0;
      return false;
    }
    value = _("#battery_price").value;
  }

  if (inputName == "cardboard_price") {
    if (!_("#cardboard_price").checkValidity()) {
      toastr["warning"]("Price Range of Cardboard : " + _("#cardboard_price").validationMessage, "WARNING");
      showInputAlert("cardboard_price", "warning", _("#cardboard_price").validationMessage);
      _("#cardboard_price").focus();
      execute = 0;
      return false;
    }
    value = _("#cardboard_price").value;
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
    save_data.open("POST", "templates/buyer-ratelist-updation/update_profile_details.php", true);
    save_data.send(data);
  }
}

function skipProfileRateListDetails(inputName) {
  let execute = 1;
  clearInputAleart();
  
  let value = '';

  if (inputName == "ac_price") {
    value = "Skip";
  }

  if (inputName == "washing_machine_price") {
    value = "Skip";
  }

  if (inputName == "fridge_price") {
    value = "Skip";
  }

  if (inputName == "tv_price") {
    value = "Skip";
  }

  if (inputName == "microwave_price") {
    value = "Skip";
  }

  if (inputName == "laptop_price") {
    value = "Skip";
  }

  if (inputName == "geyser_price") {
    value = "Skip";
  }

  if (inputName == "paper_price") {
    value = "Skip";
  }

  if (inputName == "iron_price") {
    value = "Skip";
  }

  if (inputName == "furniture_price") {
    value = "Skip";
  }

  if (inputName == "battery_price") {
    value = "Skip";
  }

  if (inputName == "cardboard_price") {
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
    save_data.open("POST", "templates/buyer-ratelist-updation/update_profile_details.php", true);
    save_data.send(data);
  }
}