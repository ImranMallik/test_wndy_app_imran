function _(x) {
  return document.querySelector(x);
}

function __(x) {
  return document.getElementsByClassName(x);
}

toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: true,
  progressBar: true,
  positionClass: "toast-bottom-left",
  preventDuplicates: false,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};

const list_preloader =
  '<div style="text-align:center;width:100%;margin:100px auto;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>';

let confirmBoxTitle = "";
let confirmBoxText = "";
let confirmBoxIcon = "";
let confirmBoxConfirmButtonText = "";
let confirmBoxCancelButtonText = "";

function show_del_data_confirm_box(deleteDetails, deleteType) {
  let showTitle = confirmBoxTitle == "" ? "Are you sure?" : confirmBoxTitle;
  let showtext =
    confirmBoxText == "" ? "You won't be able to revert this!" : confirmBoxText;
  let showicon = confirmBoxIcon == "" ? "warning" : confirmBoxIcon;
  let showconfirmButtonText =
    confirmBoxConfirmButtonText == ""
      ? "Yes, delete it!"
      : confirmBoxConfirmButtonText;
  let showcancelButtonText =
    confirmBoxCancelButtonText == ""
      ? "No, cancel!"
      : confirmBoxCancelButtonText;
  Swal.fire({
    title: showTitle,
    text: showtext,
    icon: showicon,
    showCancelButton: true,
    confirmButtonText: showconfirmButtonText,
    cancelButtonText: showcancelButtonText,
    reverseButtons: true,
  }).then(function (result) {
    if (result.value) {
      delete_data(deleteDetails, deleteType);
    } else if (result.dismiss === "cancel") {
      // If run function in cancel
    }
  });
}
function show_del_all_data_confirm_box() {
  let showTitle = confirmBoxTitle == "" ? "Are you sure?" : confirmBoxTitle;
  let showtext =
    confirmBoxText == "" ? "You won't be able to revert this!" : confirmBoxText;
  let showicon = confirmBoxIcon == "" ? "warning" : confirmBoxIcon;
  let showconfirmButtonText =
    confirmBoxConfirmButtonText == ""
      ? "Yes, delete it!"
      : confirmBoxConfirmButtonText;
  let showcancelButtonText =
    confirmBoxCancelButtonText == ""
      ? "No, cancel!"
      : confirmBoxCancelButtonText;
  Swal.fire({
    title: showTitle,
    text: showtext,
    icon: showicon,
    showCancelButton: true,
    confirmButtonText: showconfirmButtonText,
    cancelButtonText: showcancelButtonText,
    reverseButtons: true,
  }).then(function (result) {
    if (result.value) {
      delete_chack_box_data();
    } else if (result.dismiss === "cancel") {
      // If run function in cancel
    }
  });
}

function session_destroy(
  title,
  text,
  icon,
  confirmButtonText,
  cancelButtonText
) {
  let showTitle = title == null ? "Session Destroy!!" : title;
  let showtext =
    text == null
      ? "You won't be able to access anthing! Please Do Re-Login"
      : text;
  let showicon = icon == null ? "error" : icon;
  let showconfirmButtonText =
    confirmButtonText == null ? "Re-Login" : confirmButtonText;
  Swal.fire({
    title: showTitle,
    text: showtext,
    icon: showicon,
    showCancelButton: true,
    confirmButtonText: showconfirmButtonText,
  }).then(function (result) {
    if (result.value) {
      window.location.reload();
    } else if (result.dismiss === "cancel") {
      // If run function in cancel
    }
  });
}

function log_out() {
  xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      window.location.href = "";

    }
  };
  xhr.open("POST", "main_assets/log_out.php", true);
  xhr.send();
}

function loadFile(fileInput, imgClass) {
  if (fileInput.files && fileInput.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("." + imgClass).attr("src", e.target.result);
    };

    reader.readAsDataURL(fileInput.files[0]);
  } else {
    const blankImage = _("." + imgClass).getAttribute("data-blank-image");
    $("." + imgClass).attr("src", blankImage);
    // _("." + fileInput.id + "_label").innerHTML = "Choose file";
  }
}

$(document).ready(function () {
  showNotification();
  // make_search_select2_ajax();
});

function showNotification() {
  noti = new XMLHttpRequest();
  noti.onreadystatechange = function () {
    if (noti.readyState == 4) {
      _(".notification_item_list").innerHTML = noti.responseText;
      _(".noti_count").innerHTML = _("#totalPendingNotification").value;
      if (Number(_("#totalPendingNotification").value) > 0) {
        _(".noti_icon_img").src = "../backend_assets/img_icon/noti_icon.gif";
      } else {
        _(".noti_icon_img").src = "../backend_assets/img_icon/noti_icon.png";
      }
    }
  };
  noti.open("POST", "main_assets/notification.php", true);
  // noti.send();
}

function make_search_select2_ajax() {
  $("#search_details").select2({
    minimumInputLength: 1,
    allowClear: false,
    width: "100%",
    ajax: {
      url: "main_assets/search_details.php",
      dataType: "json",
      type: "post",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term, // search term
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });
}

function showSearchDetails() {
  if (_("#search_details").value != "") {
    window.location.href = baseUrl + "/" + _("#search_details").value;
  }
}

clearInputAleart();

function clearInputAleart() {
  for (let index = 0; index < __("input_alert").length; index++) {
    __("input_alert")[index].innerHTML =
      __("input_alert")[index].getAttribute("data-default-mssg");
    __("input_alert")[index].classList.add("inp-alert-default");
    __("input_alert")[index].classList.remove("text-warning");
    __("input_alert")[index].classList.remove("text-danger");
  }
}

function showInputAlert(inp, alertType, alertMssg) {
  _("." + inp + "-inp-alert").classList.remove("inp-alert-default");
  _("." + inp + "-inp-alert").classList.remove("text-warning");
  _("." + inp + "-inp-alert").classList.remove("text-danger");

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
}
