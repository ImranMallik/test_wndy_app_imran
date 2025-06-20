$(document).ready(function () {
    // getAddress(product_update_address_id);
    // checkImageDeleteBtn();
});

function clear_input() {
    window.location.reload();
}

//////////////////////////////////////////////////////////
////======== For Adddress Realted Work Start ========/////
//////////////////////////////////////////////////////////

// function getAddress(address_id) {
//     console.log(address_id);
//     _(".background_overlay").style.display = "block";

//     addressXhr = new XMLHttpRequest();
//     addressXhr.onreadystatechange = function () {
//         if (addressXhr.readyState == 4) {
//             console.log(addressXhr.responseText);
//             _("#address_id").innerHTML = addressXhr.responseText;

//             if (address_id != undefined) {
//                 _("#address_id").value = address_id;
//                 showAddressDetails();
//             }
//             _(".background_overlay").style.display = "none";
//         }
//     }
//     addressXhr.open('POST', 'templates/add-collector/get_address_select_list.php', true);
//     addressXhr.send();
// }

////////////////////////////////////////////////////////////////
////=========== For Adding Collector Work Start ==========//////
///////////////////////////////////////////////////////////////

    function _(selector) {
        return document.querySelector(selector);
    }

    function showAddressDetails() {
        if (_("#address_id").value == "") {
            _(".address_details").innerHTML = "";
            return false;
        }
        _(".background_overlay").style.display = "block";
        let data = new FormData();
        const sendData = {
            address_id: _("#address_id").value,
        };
        data.append("sendData", JSON.stringify(sendData));

        let addressDetailsXhr = new XMLHttpRequest();
        addressDetailsXhr.onreadystatechange = function () {
            if (addressDetailsXhr.readyState == 4) {
                _(".address_details").innerHTML = addressDetailsXhr.responseText;
                _(".background_overlay").style.display = "none";
            }
        };
        addressDetailsXhr.open('POST', 'templates/add-collector/get_address_details.php', true);
        addressDetailsXhr.send(data);
    }

    function save_collector_details() {
        let save_no = 1;
        clearInputAleart();

        var numberRegex = /^\d+$/;
    
        if (!_("#address_id").checkValidity()) {
            toastr['warning']("Address ID: " + _("#address_id").validationMessage, "WARNING");
            showInputAlert('address_id', 'warning', _("#address_id").validationMessage);
            _("#address_id").focus();
            save_no = 0;
            return false;
        }
        if (!_("#name").checkValidity()) {
            toastr['warning']("Collector Name : " + _("#name").validationMessage, "WARNING");
            showInputAlert('name', 'warning', _("#name").validationMessage);
            _("#name").focus();
            save_no = 0;
            return false;
        }
        if (!/^[a-zA-Z\s]+$/.test(_("#name").value)) {
            toastr["warning"]("Collector Name : " + "Name should only contain letters and spaces", "WARNING");
            showInputAlert("name", "warning", "Name should only contain letters and spaces");
            _("#name").focus();
            save_no = 0;
            return false;
          }
        if (!_("#ph_num").checkValidity()) {
            toastr['warning']("Phone Number : " + _("#ph_num").validationMessage, "WARNING");
            showInputAlert('ph_num', 'warning', _("#ph_num").validationMessage);
            _("#ph_num").focus();
            save_no = 0;
            return false;
        }
        if (!numberRegex.test(_("#ph_num").value)) {
            toastr["warning"]("Phone Number : Only Number Accepted", "WARNING");
            showInputAlert("ph_num", "warning", "Only Number Accepted");
            _("#ph_num").focus();
            save_no = 0;
            return false;
        }
        if (_("#ph_num").value.length < 10) {
            toastr["warning"]("Phone Number : 10 Digits Number Accepted", "WARNING");
            showInputAlert("ph_num", "warning", "10 Digits Number Accepted");
            _("#ph_num").focus();
            save_no = 0;
            return false;
        }
    
        if (save_no == 1) {
            _(".background_overlay").style.display = "block";
    
            let data = new FormData();
            const sendData = {
                address_id: _("#address_id").value,
                name: _("#name").value,
                ph_num: _("#ph_num").value,
            };
    
            data.append("sendData", JSON.stringify(sendData));
    
            let save_data = new XMLHttpRequest();
            save_data.onreadystatechange = function () {
                if (save_data.readyState == 4) {
                    console.log(save_data.responseText);  // Debug: Log the raw response text
                    try {
                        const response = JSON.parse(save_data.responseText);
                        console.log(response);  // Debug: Log the parsed response object
                        const status = response[0]['status'];
                        const status_text = response[0]['status_text'];
                        _(".background_overlay").style.display = "none";
                        if (status == "SessionDestroy") {
                            session_destroy();
                            setTimeout(function () {
                                window.location.reload();
                            }, 5000);
                        } else if (status == "NoPermission") {
                            toastr['error'](status_text, "ERROR!!");
                        } else if (status == "ph_num Exist") {
                            toastr["error"](status_text, "ERROR!!");
                            showInputAlert("ph_num", "error", status_text);
                            _("#ph_num").focus();
                            return false;
                        } else {
                            toastr['success']('New Collector Added Successfully!', 'SUCCESS');
                            setTimeout(function () {
                              window.location.href = baseUrl + "/collector";
                            }, 1500);
                        }
                    } catch (e) {
                        console.error("Failed to parse response as JSON:", e);
                        toastr['error']("An error occurred while processing the request.", "ERROR!!");
                    }
                }
            };
            save_data.open('POST', 'templates/add-collector/save_details.php', true);
            save_data.send(data);
        }
    }    


////////////////////////////////////////////////////////////////
////======== For Adding Collector Work End ========/////////////
///////////////////////////////////////////////////////////////


function save_details() {
    let save_no = 1;
    clearInputAleart();
  
    var numberRegex = /^\d+$/;
  
    if (!_("#contact_name").checkValidity()) {
      toastr["warning"]("Name : " + _("#contact_name").validationMessage, "WARNING");
      showInputAlert("contact_name", "warning", _("#contact_name").validationMessage);
      _("#contact_name").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#contact_name").value)) {
      toastr["warning"]("Contact Name : " + "Landmark should only contain letters and spaces", "WARNING");
      showInputAlert("contact_name", "warning", "Contact Name should only contain letters and spaces");
      _("#contact_name").focus();
      save_no = 0;
      return false;
    }
    if (!_("#contact_ph_num").checkValidity()) {
      toastr["warning"]("Phone Number : " + _("#contact_ph_num").validationMessage, "WARNING");
      showInputAlert("contact_ph_num", "warning", _("#contact_ph_num").validationMessage);
      _("#contact_ph_num").focus();
      save_no = 0;
      return false;
    }
    if (!/^\d+$/.test(_("#contact_ph_num").value)) {
      toastr["warning"]("Phone Number : Only Number Accepted", "WARNING");
      showInputAlert("contact_ph_num", "warning", "Only Number Accepted");
      _("#contact_ph_num").focus();
      save_no = 0;
      return false;
    }
    if (_("#contact_ph_num").value.length < 10) {
      toastr["warning"]("Phone Number : 10 Digits Number Accepted", "WARNING");
      showInputAlert("contact_ph_num", "warning", "10 Digits Number Accepted");
      _("#contact_ph_num").focus();
      save_no = 0;
      return false;
    }
    if (!_("#address_name").checkValidity()) {
      toastr["warning"]("Address Name : " + _("#address_name").validationMessage, "WARNING");
      showInputAlert("address_name", "warning", _("#address_name").validationMessage);
      _("#address_name").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#address_name").value)) {
      toastr["warning"]("Address Name : " + "Address Name should only contain letters and spaces", "WARNING");
      showInputAlert("address_name", "warning", "Address Name should only contain letters and spaces");
      _("#address_name").focus();
      save_no = 0;
      return false;
    }
    if (!_("#country").checkValidity()) {
      toastr["warning"]("Country : " + _("#country").validationMessage, "WARNING");
      showInputAlert("country", "warning", _("#country").validationMessage);
      _("#country").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#country").value)) {
      toastr["warning"]("Country : " + "Country should only contain letters and spaces", "WARNING");
      showInputAlert("country", "warning", "Country should only contain letters and spaces");
      _("#country").focus();
      save_no = 0;
      return false;
    }
    if (!_("#state").checkValidity()) {
      toastr["warning"]("State : " + _("#state").validationMessage, "WARNING");
      showInputAlert("state", "warning", _("#state").validationMessage);
      _("#state").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#state").value)) {
      toastr["warning"]("State : " + "State should only contain letters and spaces", "WARNING");
      showInputAlert("state", "warning", "State should only contain letters and spaces");
      _("#state").focus();
      save_no = 0;
      return false;
    }
    if (!_("#city").checkValidity()) {
      toastr["warning"]("City : " + _("#city").validationMessage, "WARNING");
      showInputAlert("city", "warning", _("#city").validationMessage);
      _("#city").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#city").value)) {
      toastr["warning"]("City : " + "City should only contain letters and spaces", "WARNING");
      showInputAlert("city", "warning", "City should only contain letters and spaces");
      _("#city").focus();
      save_no = 0;
      return false;
    }
    if (!_("#landmark").checkValidity()) {
      toastr["warning"]("Landmark : " + _("#landmark").validationMessage, "WARNING");
      showInputAlert("landmark", "warning", _("#landmark").validationMessage);
      _("#landmark").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#landmark").value)) {
      toastr["warning"]("Landmark : " + "Landmark should only contain letters and spaces", "WARNING");
      showInputAlert("landmark", "warning", "Landmark should only contain letters and spaces");
      _("#landmark").focus();
      save_no = 0;
      return false;
    }
    if (!_("#pincode").checkValidity()) {
      toastr["warning"]("Pincode : " + _("#pincode").validationMessage, "WARNING");
      showInputAlert("pincode", "warning", _("#pincode").validationMessage);
      _("#pincode").focus();
      save_no = 0;
      return false;
    }
    if (!numberRegex.test(_("#pincode").value)) {
      toastr["warning"]("Pincode : Only Number Accepted", "WARNING");
      showInputAlert("pincode", "warning", "Only Number Accepted");
      _("#pincode").focus();
      save_no = 0;
      return false;
    }
    if (_("#pincode").value.length < 6) {
      toastr["warning"]("Pincode : 6 Digits Number Accepted", "WARNING");
      showInputAlert("pincode", "warning", "6 Digits Number Accepted");
      _("#pincode").focus();
      save_no = 0;
      return false;
    }
    if (!_("#address_line_1").checkValidity()) {
      toastr["warning"]("Address : " + _("#address_line_1").validationMessage, "WARNING");
      showInputAlert("address_line_1", "warning", _("#address_line_1").validationMessage);
      _("#address_line_1").focus();
      save_no = 0;
      return false;
    }
    if (!/^[a-zA-Z0-9\s,/]+$/.test(_("#address_line_1").value)) {
      toastr["warning"]("Address : " + "Address should only contain letters, numbers, spaces, and commas", "WARNING");
      showInputAlert("address_line_1", "warning", "Address should only contain letters, numbers, spaces, and commas");
      _("#address_line_1").focus();
      save_no = 0;
      return false;
    }
  
  
    if (save_no == 1) {
      _(".background_overlay").style.display = "block";
      let data = new FormData();
      const sendData = {
        address_id: _("#address_id").value,
        contact_name: _("#contact_name").value,
        contact_ph_num: _("#contact_ph_num").value,
        address_name: _("#address_name").value,
        country: _("#country").value,
        state: _("#state").value,
        city: _("#city").value,
        landmark: _("#landmark").value,
        pincode: _("#pincode").value,
        address_line_1: _("#address_line_1").value,
      };
      data.append("sendData", JSON.stringify(sendData));
      // console.log(sendData);
  
      let save_data = new XMLHttpRequest();
      save_data.onreadystatechange = function () {
        if (save_data.readyState == 4) {
          if (save_data.status === 200) {
            try {
              const response = JSON.parse(save_data.responseText);
              const status = response[0]["status"];
              const status_text = response[0]["status_text"];
              const address_id = response[0]["address_id"];
              _(".background_overlay").style.display = "none";
              if (status == "SessionDestroy") {
                session_destroy();
                setTimeout(function () {
                  window.location.reload();
                }, 5000);
                return false;
              } else {
                toastr["success"](status_text, "SUCCESS!!");
                setTimeout(function () {
                  window.location.reload();
                }, 1500);
              }
  
            } catch (e) {
              console.error("Parsing error:", e);
              toastr["error"]("Error parsing server response", "ERROR!!");
            }
          } else {
            console.error("Server error:", save_data.status, save_data.statusText);
            toastr["error"]("Server error: " + save_data.statusText, "ERROR!!");
          }
        }
      };
      save_data.open("POST", "templates/address-book/save_address_details.php", true);
      save_data.send(data);
    }
  }


////////////////////////////////////////////////////////////////
////======== For Address Modal Related Work Start ========/////
///////////////////////////////////////////////////////////////

function clear_address_input() {
    _("#address_id").value = "";
    _("#contact_name").value = "";
    _("#contact_ph_num").value = "";
    _("#address_name").value = "";
    _("#country").value = "";
    _("#state").value = "";
    _("#city").value = "";
    _("#landmark").value = "";
    _("#pincode").value = "";
    _("#address_line_1").value = "";

    clearInputAleart();
}

function save_address_details(params) {
    let save_no = 1;
    clearInputAleart();

    const validationFields = [
        { id: "contact_name", name: "Name" },
        { id: "contact_ph_num", name: "Phone Number" },
        { id: "address_name", name: "Address Name" },
        { id: "country", name: "Country" },
        { id: "state", name: "State" },
        { id: "city", name: "City" },
        { id: "landmark", name: "Landmark" },
        { id: "pincode", name: "Pincode" },
        { id: "address_line_1", name: "Address" }
    ];

    for (let field of validationFields) {
        let element = _(`#${field.id}`);
        if (element && !element.checkValidity()) {
            toastr["warning"](`${field.name} : ${element.validationMessage}`, "WARNING");
            showInputAlert(field.id, "warning", element.validationMessage);
            element.focus();
            save_no = 0;
            return false;
        }
    }

    if (save_no == 1) {
        let data = new FormData();
        const sendData = {
            address_id: _("#address_id").value,
            contact_name: _("#contact_name").value,
            contact_ph_num: _("#contact_ph_num").value,
            address_name: _("#address_name").value,
            country: _("#country").value,
            state: _("#state").value,
            city: _("#city").value,
            landmark: _("#landmark").value,
            pincode: _("#pincode").value,
            address_line_1: _("#address_line_1").value,
        };
        data.append("sendData", JSON.stringify(sendData));
        // console.log(sendData);

        let save_data = new XMLHttpRequest();
        save_data.onreadystatechange = function () {
            if (save_data.readyState == 4) {
                if (save_data.status === 200) {
                    try {
                        const response = JSON.parse(save_data.responseText);
                        const status = response[0]["status"];
                        const status_text = response[0]["status_text"];
                        if (status == "SessionDestroy") {
                            session_destroy();
                            setTimeout(function () {
                                window.location.reload();
                            }, 5000);
                            return false;
                        } else {
                            toastr["success"](status_text, "SUCCESS!!");
                            // getAddress(ph_num);
                            $("#addressModal").modal('hide');
                            clear_address_input();
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }
                    } catch (e) {
                        console.error("Parsing error:", e, save_data.responseText);
                        toastr["error"]("Error parsing server response", "ERROR!!");
                    }
                } else {
                    console.error("Server error:", save_data.status, save_data.statusText);
                    toastr["error"]("Server error: " + save_data.statusText, "ERROR!!");
                }
            }
        };
        save_data.open("POST", "templates/address-book/save_address_details.php", true);
        save_data.send(data);
    }
}



function update_data(address_id) {
    // console.log(address_id);
    _(".background_overlay").style.display = "block";
    clear_address_input();
    let data = new FormData();
    const sendData = {
        address_id: address_id
    };
    data.append("sendData", JSON.stringify(sendData));
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            const response = JSON.parse(xhr.responseText);
            // console.log(response);

            _("#address_id").value = response['address_id'];
            _("#contact_name").value = response['contact_name'];
            _("#contact_ph_num").value = response['contact_ph_num'];
            _("#address_name").value = response['address_name'];
            _("#country").value = response['country'];
            _("#state").value = response['state'];
            _("#city").value = response['city'];
            _("#landmark").value = response['landmark'];
            _("#pincode").value = response['pincode'];
            _("#address_line_1").value = response['address_line_1'];

            $("#addressModal").modal('show');
            _(".background_overlay").style.display = "none";
        }
    }
    xhr.open('POST', 'templates/address-book/update_data_input.php', true);
    xhr.send(data);

}

////////////////////////////////////////////////////////////////
////======== For Address Modal Related Work End ========///////
///////////////////////////////////////////////////////////////

