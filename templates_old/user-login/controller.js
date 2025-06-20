$(document).ready(function () {
  toggleScreen("ph_num_div");
  let selectedUserType = null;

  $(".role-card").click(function () {

    selectedUserType = $(this).data("user-type");


    $(".role-card").removeClass("selected-role");
    $(this).addClass("selected-role");

    checkUserType(selectedUserType);
  });
});

function toggleScreen(screen_name) {
  _("#ph_num_div").style.display = "none";
  _("#otp_div").style.display = "none";
  _("#welcomeback_div").style.display = "none";
  _("#Register_div").style.display = "none";
  _("#usertype_div").style.display = "none";
  // _("#buyer_type_div").style.display = "none";
  // _("#seller_type_div").style.display = "none";
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
  toastr.clear();

  const phoneNumberInput = document.querySelector("#ph_num");
  const phoneNumber = phoneNumberInput.value.trim();
  const numberRegex = /^\d{10}$/;

  // Validate phone number
  if (!phoneNumberInput.checkValidity() || !numberRegex.test(phoneNumber)) {
    toastr.error("Please enter a valid 10 Digit Phone Number", "Error");
    // showInputAlert("error", "Please enter a valid phone number");
    phoneNumberInput.focus();
    return false;
  }
  
   const fakePattern = /^(\d)\1{9}$/;
  if (fakePattern.test(phoneNumber)) {
    toastr.error("Please enter a valid phone number","Error");
    // showInputAlert("ph_num", "error", "Please enter a real phone number");
    phoneNumberInput.focus();
    return false;
  }

  // Show loading overlay
  document.querySelector(".background_overlay").style.display = "block";

  // Prepare form data
  const formData = new FormData();
  formData.append("sendData", JSON.stringify({ ph_num: phoneNumber }));

  // Send AJAX request using fetch
  fetch("templates/user-login/check_ph_num.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(response => {
      document.querySelector(".background_overlay").style.display = "none";

      if (response.status === "error") {
        toastr.error(response.status_text, "ERROR!!");
        showInputAlert("ph_num", "error", response.status_text);
        phoneNumberInput.focus();
      } else {
        document.querySelector(".otp_mssg").innerHTML = response.status_text;
        start_countdown(response.valid_timestamp);
        toastr.success("OTP has been sent to your phone number", "SUCCESS!!");
        toggleScreen("otp_div");

        // Display OTP in input fields and hidden input
        if (response.otp && response.otp.length === 6) {
          populateOtpInputs(response.otp);
        }
      }
    })
    .catch(error => {
      console.error("Error in request:", error);
      toastr.error("An error occurred. Please try again.", "ERROR!!");
      document.querySelector(".background_overlay").style.display = "none";
    });
}

function populateOtpInputs(otp) {
  const otpHiddenInput = document.getElementById("otp");

  otp.split("").forEach((digit, index) => {
    const otpField = document.querySelector(`#otp-${index}`);
    if (otpField) {
      otpField.value = digit;
      otpField.dispatchEvent(new Event("input")); // Trigger input event for UI updates
    }
  });

  // Store OTP in the hidden field
  otpHiddenInput.value = otp;
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
          // toggleScreen("welcomeback_div");
          // _("#loginUserName").innerHTML = response["userName"];

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
      confirmButtonText: 'Yes, Signin!',
      cancelButtonText: 'No, cancel!',
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
              window.location.href = "./dashboard";
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
    $("#buyerTypeModal").modal("show");
  } else if (user_type === "Seller") {
    $("#sellerTypeModal").modal("show");
  }

}

function showBuyerTypeDetails(id) {
  _("#scrap_dealer-details").style.display = "none";
  _("#aggregator-details").style.display = "none";
  _("#recycler-details").style.display = "none";
  _("#" + id + "-details").style.display = "block";
}

// -----------------------------===  Add For New Desing By -------------Imran Mallik
document.addEventListener('DOMContentLoaded', function () {
  const roleCards = document.querySelectorAll('.role-card');
  const hiddenUserTypeInput = document.getElementById('selectedUserType');
  let selectedUserType = null;

  const sellerButtons = document.querySelectorAll('#sellerTypeModal .selection-button');
  const sellerNextButton = document.querySelector('#sellerTypeModal .next-button');
  const hiddenSellerInput = document.getElementById('selectedSellerType');
  let selectedSellerType = null;

  const buyerButtons = document.querySelectorAll('#buyerTypeModal .selection-button');
  const buyerNextButton = document.querySelector('#buyerTypeModal .next-button');
  const hiddenBuyerInput = document.getElementById('selectedBuyerType');
  let selectedBuyerType = null;

  // Handle Role Selection (Seller/Buyer)

  roleCards.forEach(card => {
    card.addEventListener('click', function () {
      roleCards.forEach(card => card.classList.remove('selected'));
      this.classList.add('selected');

      selectedUserType = this.getAttribute('data-user-type');
      if (hiddenUserTypeInput) {
        hiddenUserTypeInput.value = selectedUserType;
      }

      console.log("Selected User Type:", selectedUserType);
    });
  });

  // Handle Seller Type Selection
  sellerButtons.forEach(button => {
    button.addEventListener('click', function () {
      sellerButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      sellerNextButton.disabled = false;
      selectedSellerType = this.dataset.type;
      if (hiddenSellerInput) {
        hiddenSellerInput.value = selectedSellerType;
      }
      console.log("Selected User Type:", selectedSellerType);
    });
  });

  // Handle Buyer Type Selection
  buyerButtons.forEach(button => {
    button.addEventListener('click', function () {
      buyerButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      buyerNextButton.disabled = false;
      selectedBuyerType = this.dataset.type;
      if (hiddenBuyerInput) {
        hiddenSellerInput.value = hiddenBuyerInput;
      }
      console.log("Selected User Type:", selectedBuyerType);
    });
  });

  // Seller Modal Next Button Logic
  sellerNextButton.addEventListener('click', function () {
    handleModalTransitionSeller("sellerTypeModal");
  });

  // Buyer Modal Next Button Logic
  buyerNextButton.addEventListener('click', function () {
    handleModalTransition("buyerTypeModal");
  });

  function handleModalTransition(modalId) {
    const modal = document.getElementById(modalId);
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) {
      bootstrapModal.hide();
    } else {
      modal.classList.remove("show");
      modal.setAttribute("aria-hidden", "true");
      modal.style.display = "none";
      document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }

    // Show the referral section
    
    document.getElementById("referral_div").style.display = "block";

    // Open the referral modal automatically
    const referralModal = new bootstrap.Modal(document.getElementById("referralModal"));
    referralModal.show();

    console.log(`Selected Type from ${modalId}:`, modalId === "sellerTypeModal" ? selectedSellerType : selectedBuyerType);
  }
  
    function handleModalTransitionSeller(modalId) {
    const modal = document.getElementById(modalId);
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) {
      bootstrapModal.hide();
    } else {
      modal.classList.remove("show");
      modal.setAttribute("aria-hidden", "true");
      modal.style.display = "none";
      document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }

    // Show the referral section
    
    // document.getElementById("referral_div").style.display = "block";

    // // Open the referral modal automatically
    // const referralModal = new bootstrap.Modal(document.getElementById("referralModal"));
    // referralModal.show();

    // console.log(`Selected Type from ${modalId}:`, modalId === "sellerTypeModal" ? selectedSellerType : selectedBuyerType);
  }
});
// --------------

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
      confirmButtonText: 'Yes, Confirm!',
      cancelButtonText: 'No, cancel!',
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
      confirmButtonText: 'Yes, Confirm!',
      cancelButtonText: 'No, cancel!',
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

  // let user_type = $("input[type='radio'][name='user_type']:checked").val();
  // let buyer_type = $("input[type='radio'][name='buyer_type']:checked").val();
  // let seller_type = $("input[type='radio'][name='seller_type']:checked").val();
  // Update fOr New Desing
  let user_type = $("#selectedUserType").val();
  let seller_type = $("#selectedSellerType").val();
  let buyer_type = $("#selectedBuyerType").val();

  const sendData = {
    user_name: _("#user_name").value,
    ph_num: _("#ph_num").value,
    user_type: user_type,
    buyer_type: buyer_type,
    seller_type: seller_type,
    referral_code: _("#referral_code").value,
  };
  // console.log(sendData);
  data.append("sendData", JSON.stringify(sendData));

  save_data = new XMLHttpRequest();
  save_data.onreadystatechange = function () {
    if (save_data.readyState == 4) {
      _(".background_overlay").style.display = "none";

      const responseText = save_data.responseText;
      const jsonStartIndex = responseText.indexOf('[');
      if (jsonStartIndex !== -1) {
        const jsonString = responseText.substring(jsonStartIndex);
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
