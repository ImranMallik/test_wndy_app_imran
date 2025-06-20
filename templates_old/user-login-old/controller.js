$(document).ready(function () {
  toggleScreen("ph_num_div");

});

function toggleScreen(screen_name) {
  _("#ph_num_div").style.display = "none";
  _("#otp_div").style.display = "none";
  _("#welcomeback_div").style.display = "none";
  _("#Register_div").style.display = "none";
  _("#usertype_div").style.display = "none";
  _("#buyer_type_div").style.display = "none";
  _("#seller_type_div").style.display = "none";
  _("#referral_div").style.display = "none";
  _("#" + screen_name).style.display = "block";
}

var x;

function start_countdown(countDownDateTimeTO) {
  var countDownDate = new Date(countDownDateTimeTO);

  //alert(countDownDate);
  clearInterval(x);
  otpValidtimeCountdown("start");

  function twoDigits(n) {
    return n <= 9 ? "0" + n : n;
  }

  // Update the count down every 1 second
  x = setInterval(function () {
    // Get todays date and time
    var now = new Date();

    seconds = Math.floor((countDownDate - now) / 1000);
    minutes = Math.floor(seconds / 60);
    hours = Math.floor(minutes / 60);
    days = Math.floor(hours / 24);

    hours = hours - days * 24;
    minutes = minutes - days * 24 * 60 - hours * 60;
    seconds = seconds - days * 24 * 60 * 60 - hours * 60 * 60 - minutes * 60;

    //alert(i);
    _(".otp_valid_time").innerHTML =
      twoDigits(minutes) + " : " + twoDigits(seconds);

    // If the count down is over, write some text
    if (days < 0) {
      clearInterval(x);
      otpValidtimeCountdown("finish");
    }
  }, 1000);
}

function otpValidtimeCountdown(type) {
  if (type == "start") {
    _(".otp_time_span").style.display = "block";
    _(".send_otp_again_a").style.display = "none";
  }
  if (type == "finish") {
    _(".otp_time_span").style.display = "none";
    _(".send_otp_again_a").style.display = "block";
  }
}

function checkPhoneNumber() {
  clearInputAleart();
  let execute = 1;
  toastr.clear();

  var numberRegex = /^\d+$/;

  if (!_("#ph_num").checkValidity()) {
    toastr["error"]("Phone Number : " + "Enter a Valid Phone Number", "");
    showInputAlert("ph_num", "error", "Enter a Valid Phone Number");
    _("#ph_num").focus();
    execute = 0;
    return false;
  }
  if (!numberRegex.test(_("#ph_num").value)) {
    toastr["warning"]("Phone Number : Enter a Valid Phone Number", "");
    showInputAlert("ph_num", "error", "Enter a Valid Phone Number");
    _("#ph_num").focus();
    save_no = 0;
    return false;
  }
  if (_("#ph_num").value.length < 10) {
    toastr["warning"]("Phone Number : Enter a Valid Phone Number", "");
    showInputAlert("ph_num", "error", "Enter a Valid Phone Number");
    _("#ph_num").focus();
    save_no = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      ph_num: _("#ph_num").value,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        // console.log(xhr.responseText);
        const response = JSON.parse(xhr.responseText);
        const status = response["status"];
        const status_text = response["status_text"];
        const otp = response["otp"];
        const valid_timestamp = response["valid_timestamp"];

        _("#otp").value = otp;
        _(".background_overlay").style.display = "none";

        if (status == "error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("ph_num", "error", status_text);
          _("#ph_num").focus();
          return false;
        } else if (status == "new_user") {
          _(".otp_mssg").innerHTML = status_text;
          start_countdown(valid_timestamp);
          toastr["success"](
            "OTP has been sent to your phone number",
            "SUCCESS!!"
          );
          toggleScreen("otp_div");
        } else {
          _(".otp_mssg").innerHTML = status_text;
          start_countdown(valid_timestamp);
          toastr["success"](
            "OTP has been sent to your phone number",
            "SUCCESS!!"
          );
          toggleScreen("otp_div");
          return false;
        }
      }
    };
    xhr.open("POST", "templates/user-login/check_ph_num.php", true);
    xhr.send(data);
  }
}

function verifyOtp(params) {
  clearInputAleart();
  let execute = 1;
  toastr.clear();
  var numberRegex = /^\d+$/;

  if (!_("#ph_num").checkValidity()) {
    toastr["error"]("Phone Number : " + "Fields Cannot be Empty", "");
    showInputAlert("ph_num", "error", "Fields Cannot be Empty");
    _("#ph_num").focus();
    execute = 0;
    return false;
  }
  if (!numberRegex.test(_("#ph_num").value)) {
    toastr["warning"]("Phone Number : Enter a Valid Phone Number", "");
    showInputAlert("ph_num", "error", "Enter a Valid Phone Number");
    _("#ph_num").focus();
    save_no = 0;
    return false;
  }
  if (_("#ph_num").value.length < 10) {
    toastr["warning"]("Phone Number : Enter a Valid Phone Number", "");
    showInputAlert("ph_num", "error", "Enter a Valid Phone Number");
    _("#ph_num").focus();
    save_no = 0;
    return false;
  }
  if (!_("#otp").checkValidity()) {
    toastr["error"]("OTP : " + "Please enter the OTP sent to your phone", "");
    showInputAlert("otp", "error", "Please enter the OTP sent to your phone");
    _("#otp").focus();
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      ph_num: _("#ph_num").value,
      otp: _("#otp").value,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        console.log(xhr.responseText);
        const response = JSON.parse(xhr.responseText);
        const status = response["status"];
        const status_text = response["status_text"];
        const previousLogin = response["previousLogin"];

        _(".background_overlay").style.display = "none";

        if (status == "error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("otp", "error", status_text);
          _("#otp").focus();
          return false;
        } else if (response["new_user"] == "Yes" && status == "success") {
          toastr["success"](status_text, "SUCCESS!!");
          toggleScreen("Register_div");
        } else {
          toastr["success"](status_text, "SUCCESS!!");

          if (previousLogin == "Yes") {
            loginConfirmation();
          } else {
            signIn();
          }

          // Display the welcome back message
          toggleScreen("welcomeback_div");
          _("#loginUserName").innerHTML = response["userName"];

          return false;
        }
      }
    };
    xhr.open("POST", "templates/user-login/check_otp.php", true);
    xhr.send(data);
  }
}

function loginConfirmation() {
  swal(
    {
      title: "Duplicate Login !!",
      text: "We have detected that you are already logged in on another device. Would you like to logout and continue on this device?",
      type: "warning",
      buttons: [
        {
          text: "save",
          type: "success",
          onClick: function () {
            //do stuff
          },
        },
      ],
      allowOutsideClick: false,
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonClass: " btn btn-info border-none confirm_btn",
      cancelButtonClass: " btn btn-secondary border-none cancel_btn",
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Signin!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
    },
    function (isConfirm) {
      if (isConfirm) {
        signIn();
      } else {
        window.location.reload();
      }
    }
  );
}

function signIn() {
  let execute = 1;
  toastr.clear();
  if (!_("#ph_num").checkValidity()) {
    toastr["error"]("Phone Number : " + "Fields Cannot be Empty", "");
    showInputAlert("ph_num", "error", "Fields Cannot be Empty");
    _("#ph_num").focus();
    execute = 0;
    return false;
  }
  if (_("#ph_num").value.length < 10) {
    toastr["warning"]("Phone Number : Enter a Valid Phone Number", "");
    showInputAlert("ph_num", "error", "Enter a Valid Phone Number");
    _("#ph_num").focus();
    save_no = 0;
    return false;
  }
  if (!_("#otp").checkValidity()) {
    toastr["error"]("OTP : " + "Incorrect OTP", "");
    showInputAlert("otp", "error", "Incorrect OTP");
    _("#otp").focus();
    execute = 0;
    return false;
  }
  if (!_("#otp").checkValidity()) {
    toastr["error"]("OTP : " + _("#otp").validationMessage, "");
    showInputAlert("otp", "error", _("#otp").validationMessage);
    _("#otp").focus();
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      ph_num: _("#ph_num").value,
      otp: _("#otp").value,
    };
    // console.log(sendData);
    data.append("sendData", JSON.stringify(sendData));

    let signin = new XMLHttpRequest();
    // console.log(signin);
    signin.onreadystatechange = function () {
      if (signin.readyState == 4) {
        // console.log(signin.responseText);
        const response = JSON.parse(signin.responseText);

        const status = response["status"];
        const status_text = response["status_text"];
        _(".background_overlay").style.display = "none";

        if (status == "otp Not Match") {
          toastr["error"](status_text, "ERROR!!");
          return false;
        } else if (status == "Match") {
          toastr["success"]("User Logged In Successfully.", "SUCCESS!!");
          setTimeout(function () {
            if (response["user_type"] === "Seller") {
              window.location.href = "./dashboard";
            } else if (response["user_type"] === "Buyer") {
              window.location.href = "./product_list";
            } else if (response["user_type"] === "Collector") {
              window.location.href = "./assigned_product_list";
            }
          }, 1500);
          return false;
        } else {
          toastr["error"]("Server error, please try again later.", "ERROR!!");
        }
      }
    };
    signin.open("POST", "templates/user-login/login_check.php", true);
    signin.send(data);
  }
}

function checkName() {
  clearInputAleart();
  let execute = 1;
  toastr.clear();
  if (!_("#user_name").checkValidity()) {
    toastr["warning"]("User Name : " + "Field Cannot be Empty", "");
    showInputAlert("user_name", "error", "Field Cannot be Empty");
    _("#user_name").focus();
    execute = 0;
    return false;
  }
  if (!/^[a-zA-Z\s]+$/.test(_("#user_name").value)) {
    toastr["warning"]("Name : " + "Invalid Name Format", "");
    showInputAlert("user_name", "error", "Invalid Name Format");
    _("#user_name").focus();
    execute = 0;
    return false;
  }
  if (!_("#termsCheckbox").checkValidity()) {
    toastr["error"]("Accept Our Terms & Conditions", "");
    showInputAlert(
      "termsCheckbox",
      "error",
      "Accept Our Terms & Conditions, Privacy Policy"
    );
    _("#termsCheckbox").focus();
    execute = 0;
    return false;
  }
  if (execute == 1) {
    toggleScreen("usertype_div");
  }
}

function checkUserType(user_type) {
  clearInputAleart();

  if (!user_type) {
      toastr["error"]("Please choose an option", "");
      showInputAlert("user_type", "error", "Please choose an option");
      return false;
  }

  if (user_type === "Buyer") {
      toggleScreen("buyer_type_div");
  } else {
      toggleScreen("seller_type_div");
  }
}

function showBuyerTypeDetails(id) {
  _("#scrap_dealer-details").style.display = "none";
  _("#aggregator-details").style.display = "none";
  _("#recycler-details").style.display = "none";
  _("#" + id + "-details").style.display = "block";
}

// function checkReferral() {
//   toggleScreen("referral_div");
// }

function confirmBuyerCheck() {
  clearInputAleart();
  let buyer_type = $("input[type='radio'][name='buyer_type']:checked").val();

  if (buyer_type == undefined) {
    toastr["error"]("Please choose an option", "");
    showInputAlert("buyer_type", "error", "Please choose an option");
    return false;
  }

  swal(
    {
      title: "Register Confirmation !!",
      text: "Are you sure to register as a buyer in our app ?",
      type: "info",
      allowOutsideClick: false,
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonClass: " btn btn-info border-none confirm_btn",
      cancelButtonClass: " btn btn-secondary border-none cancel_btn",
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Confirm!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      confirmButtonId: "buyer_confirm",
      cancelButtonId: "buyer_cancel",
    },
    function (isConfirm) {
      if (isConfirm) {
        save_user_details();
      } else {
        // window.location.reload();
      }
    }
  );
}

function confirmSellerCheck() {
  clearInputAleart();
  let seller_type = $("input[type='radio'][name='seller_type']:checked").val();

  if (seller_type == undefined) {
    toastr["error"]("Please choose an option", "");
    showInputAlert("seller_type", "error", "Please choose an option");
    return false;
  }

  swal(
    {
      title: "Register Confirmation !!",
      text: "Are you sure to register as a seller in our app ?",
      type: "info",
      allowOutsideClick: false,
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonClass: " btn btn-info border-none confirm_btn",
      cancelButtonClass: " btn btn-secondary border-none cancel_btn",
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Confirm!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      confirmButtonId: "seller_confirm",
      cancelButtonId: "seller_cancel",
    },
    function (isConfirm) {
      if (isConfirm) {
        save_user_details();
      } else {
        // window.location.reload();
      }
    }
  );
}

function save_user_details() {
  toastr.clear();
  _(".background_overlay").style.display = "block";
  let data = new FormData();

  let user_type = $("input[type='radio'][name='user_type']:checked").val();
  let buyer_type = $("input[type='radio'][name='buyer_type']:checked").val();
  let seller_type = $("input[type='radio'][name='seller_type']:checked").val();

  const sendData = {
    user_name: _("#user_name").value,
    ph_num: _("#ph_num").value,
    user_type: user_type,
    buyer_type: buyer_type,
    seller_type: seller_type,
    referral_code: _("#referral_code").value,
  };
  data.append("sendData", JSON.stringify(sendData));

  save_data = new XMLHttpRequest();
  save_data.onreadystatechange = function () {
    if (save_data.readyState == 4) {
      _(".background_overlay").style.display = "none";

      const responseText = save_data.responseText;
      const jsonStartIndex = responseText.indexOf('['); // Find the start of the JSON string
      if (jsonStartIndex !== -1) {
        const jsonString = responseText.substring(jsonStartIndex); // Extract the JSON string
        try {
          const response = JSON.parse(jsonString);
          const status = response[0]["status"];
          const status_text = response[0]["status_text"];

          if (status == "ph_num Exist") {
            toastr["error"](status_text, "ERROR!!");
            showInputAlert("ph_num", "error", status_text);
            _("#ph_num").focus();
            return false;
          } else if (status == "referral_code Not Exists") {
            toastr["error"](status_text, "ERROR!!");
            showInputAlert("referral_code", "error", status_text);
            _("#referral_code").focus();
            return false;
          } else {
            toastr["success"](status_text, "SUCCESS!!");
            signIn();
            return false;
          }
        } catch (e) {
          console.error("Invalid JSON data:", e);
          toastr["error"]("An error occurred while processing the response.", "ERROR!!");
        }
      } else {
        console.error("No JSON data found in the response.");
        toastr["error"]("An error occurred while processing the response.", "ERROR!!");
      }

    }
  };
  save_data.open("POST", "templates/user-login/save_details.php", true);
  save_data.send(data);
}
