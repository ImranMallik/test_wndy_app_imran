
function shareReferLink() {
    var share_title = user_name;
    var share_url = baseUrl + "/user-login/" + referral_id;
    if (navigator.share) {
      navigator.share({
        title: share_title,
        text: 'To Register Please Click On The Link : ',
        url: share_url
      }).then(() => {
        //console.log('Thanks for sharing!');
        toastr['success']("Thanks for sharing!", "SUCCESS!!");
      })
        .catch(console.error);
    } else {
      //shareDialog.classList.add('is-open');
      toastr['error']("Share Option Does Not Work", "ERROR!!");
    }
  }
  
  function updateProfileDetails() {
    let execute = 1;
    clearInputAleart();
  
    var numberRegex = /^\d+$/;
  
    if (!_("#name").checkValidity()) {
      toastr["warning"]("Your Name : " + _("#name").validationMessage, "WARNING");
      showInputAlert("name", "warning", _("#name").validationMessage);
      _("#name").focus();
      execute = 0;
      return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(_("#name").value)) {
      toastr["warning"]("Your Name : " + "Invalid Name Format", "WARNING");
      showInputAlert("name", "warning", "Invalid Name Format");
      _("#name").focus();
      execute = 0;
      return false;
    }
    if (!_("#email_id").checkValidity()) {
      toastr["warning"]("Email : " + _("#email_id").validationMessage, "WARNING");
      showInputAlert("email_id", "warning", _("#email_id").validationMessage);
      _("#email_id").focus();
      execute = 0;
      return false;
    }
    if (!/@(gmail\.com|hotmail\.com|yahoo\.com)$/.test(_("#email_id").value) && _("#email_id").value != "") {
      // Check if the email does not contain @gmail.com, @hotmail.com, or @yahoo.com
      toastr['warning']("Email : Invalid Email Format", "WARNING");
      showInputAlert('email_id', 'warning', "Invalid Email Format");
      _("#email_id").focus();
      execute = 0;
      return false;
    }
    if (!_("#ph_num").checkValidity()) {
      toastr["warning"]("Phone Number : " + _("#ph_num").validationMessage, "WARNING");
      showInputAlert("ph_num", "warning", _("#ph_num").validationMessage);
      _("#ph_num").focus();
      execute = 0;
      return false;
    }
    if (!numberRegex.test(_("#ph_num").value)) {
      toastr["warning"]("Phone Number : Invalid Phone Number", "WARNING");
      showInputAlert("ph_num", "warning", "Invalid Phone Number");
      _("#ph_num").focus();
      execute = 0;
      return false;
    }
    if (!_("#pan_num").checkValidity()) {
      toastr["warning"]("PAN Number : " + _("#pan_num").validationMessage, "WARNING");
      showInputAlert("pan_num", "warning", _("#pan_num").validationMessage);
      _("#pan_num").focus();
      execute = 0;
      return false;
    }
    if (!_("#aadhar_num").checkValidity()) {
      toastr["warning"]("Aadhaar Number : " + _("#aadhar_num").validationMessage, "WARNING");
      showInputAlert("aadhar_num", "warning", _("#aadhar_num").validationMessage);
      _("#aadhar_num").focus();
      execute = 0;
      return false;
    }
    if (!numberRegex.test(_("#aadhar_num").value) && _("#aadhar_num").value != "") {
      toastr["warning"]("Aadhaar Number : Invalid Aadhaar Number", "WARNING");
      showInputAlert("aadhar_num", "warning", "Invalid Aadhaar Number");
      _("#aadhar_num").focus();
      execute = 0;
      return false;
    }
    if (!_("#gst_num").checkValidity()) {
      toastr["warning"]("GST Number : " + _("#gst_num").validationMessage, "WARNING");
      showInputAlert("gst_num", "warning", _("#gst_num").validationMessage);
      _("#gst_num").focus();
      execute = 0;
      return false;
    }
    if (!numberRegex.test(_("#gst_num").value) && _("#gst_num").value != "") {
      toastr["warning"]("GST Number : Invalid GST Number", "WARNING");
      showInputAlert("gst_num", "warning", "Invalid GST Number");
      _("#gst_num").focus();
      execute = 0;
      return false;
    }
    if (!_("#authorization_certificate_num").checkValidity()) {
      toastr["warning"]("Authorization Certificate Num : " + _("#authorization_certificate_num").validationMessage, "WARNING");
      showInputAlert("authorization_certificate_num", "warning", _("#authorization_certificate_num").validationMessage);
      _("#authorization_certificate_num").focus();
      execute = 0;
      return false;
    }
  
    if (execute == 1) {
      _(".background_overlay").style.display = "block";
  
      let d = new Date();
      let user_img_file_name = "user_img_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
      let user_img_fl = _("#user_img").files[0];
  
      var original_file_name = _("#user_img").value;
      var ext = original_file_name.split(".").pop();
      let user_img = "";
      if (_("#user_img").value != "") {
        user_img = user_img_file_name + "." + ext;
      }
  
      let data = new FormData();
      const sendData = {
        name: _("#name").value,
        ph_num: _("#ph_num").value,
        email_id: _("#email_id").value,
        dob: _("#dob").value,
        pan_num: _("#pan_num").value,
        aadhar_num: _("#aadhar_num").value,
        gst_num: _("#gst_num").value,
        authorization_certificate_num: _("#authorization_certificate_num").value,
        user_img: user_img,
      };
      data.append("sendData", JSON.stringify(sendData));
  
      save_data = new XMLHttpRequest();
      save_data.onreadystatechange = function () {
        if (save_data.readyState == 4) {
          _(".background_overlay").style.display = "none";
          const response = JSON.parse(save_data.responseText);
          const status = response[0]["status"];
          const status_text = response[0]["status_text"];
          if (status == "SessionDestroy") {
            session_destroy();
            setTimeout(function () {
              window.location.reload();
            }, 5000);
          }
          else if (status == "ph_num Exist") {
            toastr["error"](status_text, "ERROR!!");
            showInputAlert("ph_num", "error", status_text);
            _("#ph_num").focus();
          }
          else if (status == "email_id Exist") {
            toastr["error"](status_text, "ERROR!!");
            showInputAlert("email_id", "error", status_text);
            _("#email_id").focus();
          }
          else {
            toastr["success"](status_text, "SUCCESS!!");
            if (user_img != "") {
              uploadImageFile(user_img_fl, user_img_file_name, "Profile Image", function (success, message) {
                if (success) {
                  toastr["info"](message, "SUCCESS!!");
                }
                setTimeout(function () {
                  window.location.reload();
                }, 1500);
              });
            }
            else {
              setTimeout(function () {
                window.location.reload();
              }, 1500);
            }
          }
        }
      };
      save_data.open("POST", "templates/my-account/update_profile_details.php", true);
      save_data.send(data);
    }
  }
  
  ////////////////////////////////////////////////////////////////
  /////////////////////// Image Upload For Both Start ////////////
  ////////////////////////////////////////////////////////////////
  function showFile(params) {
    if (_("#user_img").files && _("#user_img").files[0]) {
      var reader = new FileReader();
  
      reader.onload = function (e) {
        $("#blah").attr("src", e.target.result);
      };
  
      reader.readAsDataURL(_("#user_img").files[0]);
    } else {
      const blankImage = _("#blah").getAttribute("data-default");
      $("#blah").attr("src", blankImage);
    }
  }
  
  function uploadImageFile(file, file_name, type) {
    return new Promise((resolve, reject) => {
      let data = new FormData();
      const sendData = {
        file_name: file_name,
        type: type,
      };
      data.append("sendData", JSON.stringify(sendData));
      data.append("uploaded_file", file);
  
      let fileUploadXHR = new XMLHttpRequest();
  
      fileUploadXHR.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = parseInt((evt.loaded / evt.total) * 100);
          if (parseFloat(percentComplete) > parseFloat(_(".preloader_inner_number").innerHTML)) {
            _(".preloader_inner_number").innerHTML = percentComplete;
          }
        }
      }, false);
  
      fileUploadXHR.onreadystatechange = function () {
        if (fileUploadXHR.readyState == 4) {
          const response = JSON.parse(fileUploadXHR.responseText);
          const status = response["status"];
          const message = response["message"];
  
          _(".preloader_inner_number").innerHTML = 0;
  
          if (status == "File Type Error") {
            toastr["error"](message, "ERROR!!");
            reject(message);
          } else if (status == "Success") {
            toastr["info"](message, "SUCCESS!!");
            setTimeout(function () {
              window.location.reload();
            }, 1500);
            resolve(message);
          }
        }
      };
  
      fileUploadXHR.open("POST", "templates/my-account/upload_img.php", true);
      fileUploadXHR.send(data);
    });
  }
  ////////////////////////////////////////////////////////////////
  /////////////////////// Image Upload For Both End //////////////
  ////////////////////////////////////////////////////////////////