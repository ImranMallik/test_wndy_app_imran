function _(x) {
  return document.querySelector(x);
}

function __(x) {
  return document.getElementsByClassName(x);
}

toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-top-full-width",
  "onclick": null,
  "showDuration": "1000",
  "hideDuration": "1000",
  "timeOut": "4000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

function show_del_data_confirm_box(
  delete_details,
  title,
  text,
  icon,
  confirmButtonText,
  cancelButtonText
) {
  let showTitle = title == null ? "Are you sure?" : title;
  let showtext = text == null ? "You won't be able to revert this!" : text;
  let showicon = icon == null ? "warning" : icon;
  let sa_allowOutsideClick = true;
  let sa_showConfirmButton = true;
  let sa_showCancelButton = true;
  let sa_confirmButtonClass = " btn btn-info border-none confirm_btn";
  let sa_cancelButtonClass = " btn btn-secondary border-none cancel_btn";
  let showconfirmButtonText =
    confirmButtonText == null ? "Yes, delete it!" : confirmButtonText;
  let showcancelButtonText =
    cancelButtonText == null ? "No, cancel!" : cancelButtonText;
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
        delete_data(delete_details);
      } else {
      }
    }
  );
}

function session_destroy(
  title,
  text,
  icon,
  confirmButtonText,
  cancelButtonText
) {
  let showTitle = title == null ? "Session Expired!!" : title;
  let showtext =
    text == null
      ? "Your session has expired. Please log in again to continue."
      : text;
  let showicon = icon == null ? "error" : icon;
  let sa_allowOutsideClick = false;
  let sa_showConfirmButton = true;
  let sa_showCancelButton = false;
  let sa_confirmButtonClass = "btn btn-info border-none";
  let sa_cancelButtonClass = "btn btn-secondary border-none";
  let showconfirmButtonText =
    confirmButtonText == null ? "Re-Login" : confirmButtonText;
  let showcancelButtonText =
    cancelButtonText == null ? "No, cancel!" : cancelButtonText;
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
        window.location.href = baseUrl;
      } else {
      }
    }
  );
}

clearInputAleart();

function clearInputAleart() {
  for (let index = 0; index < __("input_alert").length; index++) {
    __("input_alert")[index].innerHTML = __("input_alert")[index].getAttribute("data-default-mssg");
    __("input_alert")[index].classList.add("inp-alert-default");
    __("input_alert")[index].classList.remove("text-warning");
    __("input_alert")[index].classList.remove("text-danger");
  }
}

function showInputAlert(inp, alertType, alertMssg) {
  _("." + inp + "-inp-alert").classList.remove("inp-alert-default");
  _("." + inp + "-inp-alert").classList.remove("text-warning");
  _("." + inp + "-inp-alert").classList.remove("text-danger");
  _("." + inp + "-inp-alert").classList.remove("text-info");

  if (alertType == "warning") {
    _("." + inp + "-inp-alert").classList.add("text-warning");
    _("." + inp + "-inp-alert").innerHTML =
      '<i class="fa fa-exclamation-triangle text-warning"></i> ' + alertMssg;
  }
  if (alertType == "error") {
    _("." + inp + "-inp-alert").classList.add("text-danger");
    _("." + inp + "-inp-alert").innerHTML =
      '<i class="fa fa-exclamation-triangle text-danger"></i> ' + alertMssg;
  }
  if (alertType == "success") {
    _("." + inp + "-inp-alert").classList.add("text-info");
    _("." + inp + "-inp-alert").innerHTML =
      '<i class="fa fa-check text-info"></i> ' + alertMssg;
  }
}

function showLogoutAlert() {
  let showTitle = "Are you sure?";
  let showtext = "If You Logout Your Session Will Be Destroy";
  let showicon = "warning";
  let sa_allowOutsideClick = true;
  let sa_showConfirmButton = true;
  let sa_showCancelButton = true;
  let sa_confirmButtonClass = "btn btn-danger border-none";
  let sa_cancelButtonClass = "btn btn-secondary border-none";
  let showconfirmButtonText = "Yes, Logout!";
  let showcancelButtonText = "No, cancel!";
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
        log_out();
      } else {
      }
    }
  );
}

function log_out() {
  xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      //alert(xhr.responseText);
      window.location.href = "./user-login";
    }
  };
  xhr.open("POST", "frontend_assets/common_assets/log_out.php", true);
  xhr.send();
}

$(document).ready(function () {
  showCartDetails();
});

function showCartDetails() {
  if (login == "Yes") {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        // console.log(xhr.responseText);
        // _(".shoping_cart_list").innerHTML = xhr.responseText;
        // _(".cart-count").innerHTML = _("#totalCartRw").value;
      }
    };
    xhr.open("POST", "frontend_assets/common_assets/show_cart_list.php", true);
    xhr.send();
  }
}

function subscribeNewsLetter() {
  if (!_("#newsletter_email").checkValidity()) {
    toastr["warning"](
      "E-mail Address : " + _("#newsletter_email").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "newsletter_email",
      "warning",
      _("#newsletter_email").validationMessage
    );
    _("#newsletter_email").focus();
    return false;
  }

  _(".background_overlay").style.display = "block";
  let data = new FormData();
  const sendData = {
    newsletter_email: _("#newsletter_email").value,
  };
  data.append("sendData", JSON.stringify(sendData));
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      // console.log(xhr.responseText);
      _(".background_overlay").style.display = "none";
      const response = JSON.parse(xhr.responseText);
      const status = response["status"];
      const status_text = response["status_text"];

      if (status == "Exist") {
        toastr["error"](status_text, "ERROR");
        showInputAlert("newsletter_email", "error", status_text);
        _("#newsletter_email").focus();
        return false;
      } else {
        toastr["success"](status_text, "SUCCESS");
        showInputAlert("newsletter_email", "success", status_text);
        _("#newsletter_email").value = "";
        return false;
      }
    }
  };
  xhr.open("POST", "frontend_assets/common_assets/save_newsletter.php", true);
  xhr.send(data);
}

function handleSearch(e) {
  if (e.keyCode === 13) {
    e.preventDefault(); // Ensure it is only this code that runs
    showResult();
  }
}

function showResult() {
  window.location.href = baseUrl + "/product-list/" + _("#search_category").value + "/search/" + _("#search_product").value;
}


function share(productCode, productName) {

  if (navigator.share) {
    navigator.share({
      title: productName,
      text: 'To Show This Product Click The Link : ',
      url: baseUrl + "/product-details/" + productCode,
    }).then(() => {
      //console.log('Thanks for sharing!');
      // toastr['success']("Thanks for sharing!", "SUCCESS!!");
    })
      .catch(console.error);
  } else {
    //shareDialog.classList.add('is-open');
    toastr['error']("Share Option Does Not Work", "ERROR!!");
  }
}


function refreshCaptcha() {
  var img = document.images['captchaimg'];
  img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
}
// New SideBar Add IMRAN MALLIK
function toggleSidebar() {
  const sidebar = document.getElementById('mobileSidebar');
  sidebar.classList.toggle('show');
}

// Close sidebar when clicking outside
document.addEventListener('click', function (event) {
  const sidebar = document.getElementById('mobileSidebar');
  const isClickInside = sidebar.contains(event.target);
  const isToggleButton = event.target.closest('[onclick="toggleSidebar()"]');

  if (!isClickInside && !isToggleButton && sidebar.classList.contains('show')) {
      sidebar.classList.remove('show');
  }
});

// Prevent clicks inside sidebar from closing it
document.getElementById('mobileSidebar').addEventListener('click', function (event) {
  event.stopPropagation();
});