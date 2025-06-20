// =========================================================================
// ===================== buyer use credit functionality ====================
// =========================================================================

function viewConfirmation(params) {
  let showTitle = "Are You Sure ?";
  let showtext = product_view_credit + " credits will be used to view the contact details. Would you like to proceed?";
  let showicon = "info";
  let sa_allowOutsideClick = true;
  let sa_showConfirmButton = true;
  let sa_showCancelButton = true;
  let sa_confirmButtonClass = "btn btn-info border-none confirm_btn";
  let sa_cancelButtonClass = "btn btn-secondary border-none cancel_btn";
  let showconfirmButtonText = "Yes, Use Credits";
  let showcancelButtonText = "No, Cancel!";
  swal(
    {
      title: showTitle,
      text: showtext,
      type: showicon,
      allowOutsideClick: sa_allowOutsideClick,
      showConfirmButton: sa_showConfirmButton,
      showCancelButton: sa_showCancelButton,
      confirmButtonClass: sa_confirmButtonClass,
      cancelButtonClass: sa_cancelButtonClass,
      confirmButtonText: showconfirmButtonText,
      cancelButtonText: showcancelButtonText,
    },
    function (isConfirm) {
      if (isConfirm) {
        userViewSellerDetails();
      } else {
      }
    }
  );
}

function userViewSellerDetails(params) {

  let execute = 1;
  clearInputAleart();

  if (create_post_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      create_post_id: create_post_id,
      baseUrl: baseUrl,
    };
    data.append("sendData", JSON.stringify(sendData));
    console.log(sendData);


    let viewXhr = new XMLHttpRequest();
    viewXhr.onreadystatechange = function () {
      if (viewXhr.readyState == 4) {
        if (viewXhr.status === 200) {
          try {
            console.log(viewXhr.responseText);

            const response = JSON.parse(viewXhr.responseText);

            // Ensure that response is not undefined and contains status
            if (response && response.status) {
              const status = response.status;
              const status_text = response.status_text;

              _(".background_overlay").style.display = "none";

              // Handle different statuses
              if (status == "SessionDestroy") {
                session_destroy();
                setTimeout(function () {
                  window.location.reload();
                }, 5000);
                return false;
              } else if (status == "balance error") {
                toastr["error"](status_text, "ERROR!!");
                setTimeout(function () {
                  window.location.href = baseUrl + "/credit_addon";
                }, 2000);
              } else if (status == "error") {
                toastr["error"](status_text, "ERROR!!");
              } else {
                toastr["success"](status_text, "SUCCESS!!");
                setTimeout(function () {
                  window.location.reload();
                }, 1500);
                return false;
              }
            } else {
              console.error("Invalid response structure:", response);
              toastr["error"]("Invalid response structure", "ERROR!!");
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", viewXhr.status, viewXhr.statusText);
          toastr["error"]("Server error: " + viewXhr.statusText, "ERROR!!");
        }
      }
    };


    viewXhr.open("POST", "templates/create_post_details/buyer_view_product.php", true);
    viewXhr.send(data);
  }
}

// =================================================================================
// ===================== buyer assigned collector functionality ====================
// =================================================================================

function assignCollector(params) {
  let execute = 1;
  clearInputAleart();

  if (!_("#collector_id").checkValidity()) {
    toastr['warning']("Collector : " + _("#collector_id").validationMessage, "WARNING");
    showInputAlert('collector_id', 'warning', _("#collector_id").validationMessage);
    _("#collector_id").focus();
    execute = 0;
    return false;
  }
  if (product_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      baseUrl: baseUrl,
      product_id: product_id,
      collector_id: _("#collector_id").value,
    };
    data.append("sendData", JSON.stringify(sendData));



    let assignXhr = new XMLHttpRequest();
    assignXhr.onreadystatechange = function () {
      if (assignXhr.readyState == 4) {
        if (assignXhr.status === 200) {
          try {
            const response = JSON.parse(assignXhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", assignXhr.status, assignXhr.statusText);
          toastr["error"]("Server error: " + assignXhr.statusText, "ERROR!!");
        }
      }
    };
    assignXhr.open("POST", "templates/create_post_details/buyer_assign_collector.php", true);
    assignXhr.send(data);
  }
}

// =================================================================================================
// ===================== send price request and accept from buyer functionality ====================
// =================================================================================================

function buyerNegotiate() {
  _(".buyer_confirm_box").style.display = "none";
  _(".buyer_negotiate_div").style.display = "block";
}

function buyerCancel() {
  _(".buyer_negotiate_div").style.display = "none";
  _(".buyer_confirm_box").style.display = "block";
}

function buyerSendRequest() {
  let execute = 1;
  clearInputAleart();

  var numberRegex = /^\d+$/;

  if (!_("#negotiation_amount").checkValidity()) {
    toastr['warning']("Negotiate Price : " + _("#negotiation_amount").validationMessage, "WARNING");
    showInputAlert('negotiation_amount', 'warning', _("#negotiation_amount").validationMessage);
    _("#negotiation_amount").focus();
    execute = 0;
    return false;
  }
  if (!numberRegex.test(_("#negotiation_amount").value)) {
    toastr["warning"]("Negotiate Price : Only Number Accepted", "WARNING");
    showInputAlert("negotiation_amount", "warning", "Only Number Accepted");
    _("#negotiation_amount").focus();
    execute = 0;
    return false;
  }
  if (!/^\d+(\.\d{1,2})?$/.test(_("#negotiation_amount").value)) {
    toastr['warning']("Negotiate Price: Please enter a valid decimal price (e.g., 123.45)", "WARNING");
    showInputAlert('negotiation_amount', 'warning', "Please enter a valid decimal price (e.g., 123.45)");
    _("#negotiation_amount").focus();
    execute = 0;
    return false;
  }
  if (create_post_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      baseUrl: baseUrl,
      create_post_id: create_post_id,
      negotiation_amount: _("#negotiation_amount").value,
      mssg: _("#mssg").value,
    };
    data.append("sendData", JSON.stringify(sendData));
    console.log(sendData);


    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            console.log(xhr.responseText);

            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/buyer_send_request.php", true);
    xhr.send(data);
  }
}

function buyerAcceptPrice() {
  let execute = 1;
  clearInputAleart();

  if (create_post_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      create_post_id: create_post_id,
      baseUrl: baseUrl,
    };
    data.append("sendData", JSON.stringify(sendData));

    console.log(sendData);


    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/buyer_accept_price.php", true);
    xhr.send(data);
  }
}

function buyerPickupComplete(view_id) {
  let execute = 1;
  clearInputAleart();

  if (create_post_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      create_post_id: create_post_id,
      view_id: view_id,
      baseUrl: baseUrl,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/buyer_pickup_complete.php", true);
    xhr.send(data);
  }
}

function buyerSaveRatings() {
  let execute = 1;
  clearInputAleart();

  if (!_("#rating").checkValidity()) {
    toastr['warning']("Rating : " + _("#rating").validationMessage, "WARNING");
    showInputAlert('rating', 'warning', _("#rating").validationMessage);
    _("#rating").focus();
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      rating_seller_id: _("#rating_seller_id").value,
      rating_view_id: _("#rating_view_id").value,
      rating: _("#rating").value,
      review: _("#review").value,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/buyer_save_ratings.php", true);
    xhr.send(data);
  }
}

// =================================================================================================
// ===================== send price request and accept from buyer functionality ====================
// =================================================================================================

function sellerNegotiate(view_id) {
  _("#negotiation_amount").value = "";
  _("#mssg").value = "";
  _("#nego_view_id").value = view_id;
  $("#price_request_modal").modal('show');
}

function sellerSendRequest() {
  let execute = 1;
  clearInputAleart();

  var numberRegex = /^\d+$/;

  if (!_("#negotiation_amount").checkValidity()) {
    toastr['warning']("Negotiate Price : " + _("#negotiation_amount").validationMessage, "WARNING");
    showInputAlert('negotiation_amount', 'warning', _("#negotiation_amount").validationMessage);
    _("#negotiation_amount").focus();
    execute = 0;
    return false;
  }
  if (!numberRegex.test(_("#negotiation_amount").value)) {
    toastr["warning"]("Negotiate Price : Only Number Accepted", "WARNING");
    showInputAlert("negotiation_amount", "warning", "Only Number Accepted");
    _("#negotiation_amount").focus();
    execute = 0;
    return false;
  }
  if (!/^\d+(\.\d{1,2})?$/.test(_("#negotiation_amount").value)) {
    toastr['warning']("Negotiate Price: Please enter a valid decimal price (e.g., 123.45)", "WARNING");
    showInputAlert('negotiation_amount', 'warning', "Please enter a valid decimal price (e.g., 123.45)");
    _("#negotiation_amount").focus();
    execute = 0;
    return false;
  }
  if (product_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      baseUrl: baseUrl,
      product_id: product_id,
      view_id: _("#nego_view_id").value,
      negotiation_amount: _("#negotiation_amount").value,
      mssg: _("#mssg").value,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/seller_send_request.php", true);
    xhr.send(data);
  }
}

function sellerAcceptPrice(view_id) {
  _("#pickup_date").value = "";
  _("#pickup_view_id").value = view_id;
  $("#pickup_schedule_modal").modal('show');
}

function updatePickupDate() {
  clearInputAleart();

  if (!validateInput("#pickup_date", "Pickup Date")) return false;
  if (!validateInput("#pickup_time", "Pickup Time")) return false;
  if (!create_post_id) {
    toastr["warning"]("Please select a valid product", "WARNING");
    return false;
  }

  _(".background_overlay").style.display = "block";
  let data = new FormData();
  const sendData = {
    baseUrl: baseUrl,
    create_post_id: create_post_id,
    view_id: _("#pickup_view_id").value,
    pickup_date: _("#pickup_date").value,
    pickup_time: _("#pickup_time").value,
  };
  data.append("sendData", JSON.stringify(sendData));

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      _(".background_overlay").style.display = "none";
      if (xhr.status === 200) {
        handleResponse(xhr.responseText);
      } else {
        handleError(xhr.status, xhr.statusText);
      }
    }
  };
  xhr.open("POST", "templates/create_post_details/seller_update_pickup_date.php", true);
  xhr.send(data);
}

function validateInput(selector, fieldName) {
  const input = _(selector);
  if (!input.checkValidity()) {
    toastr['warning'](`${fieldName} : ${input.validationMessage}`, "WARNING");
    showInputAlert(selector.substring(1), 'warning', input.validationMessage);
    input.focus();
    return false;
  }
  return true;
}

function handleResponse(responseText) {
  try {
    const response = JSON.parse(responseText);
    const { status, status_text } = response[0];

    if (status === "SessionDestroy") {
      session_destroy();
      setTimeout(() => window.location.reload(), 5000);
    } else if (status === "error") {
      toastr["error"](status_text, "ERROR!!");
    } else {
      toastr["success"](status_text, "SUCCESS!!");
      setTimeout(() => window.location.reload(), 1500);
    }
  } catch (e) {
    console.error("Parsing error:", e);
    toastr["error"]("Error parsing server response", "ERROR!!");
  }
}

function handleError(status, statusText) {
  console.error("Server error:", status, statusText);
  toastr["error"](`Server error: ${statusText}`, "ERROR!!");
}

function sellerCloseProduct(view_id) {
  let execute = 1;
  clearInputAleart();

  if (product_id == "") {
    toastr["warning"]("Please select a valid product", "WARNING");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      product_id: product_id,
      view_id: view_id,
      baseUrl: baseUrl,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/seller_close_product.php", true);
    xhr.send(data);
  }
}

function openRatingModal(buyer_id, view_id) {
  _("#rating_buyer_id").value = buyer_id;
  _("#rating_view_id").value = view_id;
  $("#buyer_ratings_modal").modal('show');
}

function sellerSaveRatings() {
  let execute = 1;
  clearInputAleart();

  if (!_("#rating").checkValidity()) {
    toastr['warning']("Rating : " + _("#rating").validationMessage, "WARNING");
    showInputAlert('rating', 'warning', _("#rating").validationMessage);
    _("#rating").focus();
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      rating_buyer_id: _("#rating_buyer_id").value,
      rating_view_id: _("#rating_view_id").value,
      rating: _("#rating").value,
      review: _("#review").value,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status === 200) {
          try {

            const response = JSON.parse(xhr.responseText);
            const status = response[0]["status"];
            const status_text = response[0]["status_text"];
            _(".background_overlay").style.display = "none";

            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            }
            else if (status == "error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", xhr.status, xhr.statusText);
          toastr["error"]("Server error: " + xhr.statusText, "ERROR!!");
        }
      }
    };
    xhr.open("POST", "templates/create_post_details/seller_save_ratings.php", true);
    xhr.send(data);
  }
}

// ============================================================================
// ===================== star rating related functionality ====================
// ============================================================================

function ratingStar(starNum) {

  for (let index = 1; index <= starNum; index++) {
    _(".star-" + index).classList.add("active-star");
  }

  for (let index = starNum + 1; index <= 5; index++) {
    _(".star-" + index).classList.remove("active-star");
  }

  _("#rating").value = starNum;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// Credit Used Toggle the visibility of the confirmation box //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function toggleConfirmBox() {
  const confirmBox = document.getElementById('confirmBox');
  confirmBox.style.display = confirmBox.style.display === 'none' ? 'block' : 'none';
}

// Close the confirmation box
function closeConfirmBox() {
  document.getElementById('confirmBox').style.display = 'none';
}

// Confirm action logic
function confirmAction() {
  closeConfirmBox();
}