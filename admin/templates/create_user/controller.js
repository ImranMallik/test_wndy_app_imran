$(document).ready(function () {
  show_list();
  make_select2_ajx("user_mode_code");
});
function clear_input() {
  _("#user_code").value = "";
  _("#user_id").value = "";
  _("#user_password").value = "";
  _("#name").value = "";
  _("#email").value = "";
  $("#user_mode_code").val("").trigger("change");
  _("#active").value = "Yes";
  _("#entry_permission").value = "Yes";
  _("#view_permission").value = "Yes";
  _("#edit_permission").value = "Yes";
  _("#delete_permissioin").value = "Yes";

  _(".profile_img").setAttribute("data-blank-image", "../upload_content/upload_img/profile_img/user_icon.png");
  $("#profile_img").val("").trigger("change");
  chngMode("Insert");
  clearInputAleart();
}

function chngMode(mode) {
  if (mode == "Update") {
    _(".entry_modal_title").innerHTML = "Update User Details :";
    _(".save_btn").innerHTML = "Update Data";
  } else {
    _(".entry_modal_title").innerHTML = "Enter User Details :";
    _(".save_btn").innerHTML = "Save Data";
  }
}

function make_select2_ajx(id) {
  let fileName, sendData;
  switch (id) {
    case "user_mode_code":
      fileName = "select_user_mode_list";
      break;
  }

  $("#" + id).select2({
    dropdownParent: $("#entryModal"),
    minimumInputLength: 0,
    allowClear: true,
    width: "100%",
    ajax: {
      url: "templates/create_user/" + fileName + ".php",
      dataType: "json",
      type: "post",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term, // search term
          sendData: JSON.stringify(sendData),
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

function show_list() {
  if (view_per == "Yes") {
    $("#data_table").DataTable({
      processing: true,
      serverSide: true,
      serverMethod: "post",
      ajax: {
        url: "templates/create_user/list.php",
      },
      drawCallback: function (data) {
        // Here the response
        // var response = data.json;
        // console.log(response);
      },
      columns: [ { data: "entry_timestamp" }, { data: "profile_img" }, { data: "name" }, { data: "user_id" }, { data: "email" }, { data: "user_mode" }, { data: "entry_permission" }, { data: "view_permission" }, { data: "edit_permission" }, { data: "delete_permissioin" }, { data: "active" }, { data: "action" } ],
      dom: "lBfrtip",
      buttons: [
        { extend: "print", className: "btn dark btn-outline" },
        { extend: "copy", className: "btn red btn-outline" },
        { extend: "pdf", className: "btn green btn-outline" },
        { extend: "excel", className: "btn yellow btn-outline " },
        { extend: "csv", className: "btn purple btn-outline " },
        { extend: "colvis", className: "btn dark btn-outline", text: "Columns" },
        { extend: "pageLength", className: "btn dark btn-outline", text: "Show Entries" },
      ],
      order: [[0, "desc"]],
      'aoColumnDefs': [{
				'bSortable': false,
				'aTargets': ['nosort']
			}]
    });
  }
}

function reload_table() {
  $("#data_table").DataTable().ajax.reload();
}

function save_details() {
  let save_no = 1;
  clearInputAleart();

  if (insert_per == "No") {
    toastr["error"]("You Don't Have Permission To Entry Any Data !!", "ERROR");
    save_no = 0;
    return false;
  }
  if (!_("#user_id").checkValidity()) {
    toastr["warning"]("User Id : " + _("#user_id").validationMessage, "WARNING");
    showInputAlert("user_id", "warning", _("#user_id").validationMessage);
    _("#user_id").focus();
    save_no = 0;
    return false;
  }
  if (!_("#name").checkValidity()) {
    toastr["warning"]("Name : " + _("#name").validationMessage, "WARNING");
    showInputAlert("name", "warning", _("#name").validationMessage);
    _("#name").focus();
    save_no = 0;
    return false;
  }
  if (!_("#user_mode_code").checkValidity()) {
    toastr["warning"]("User Mode : " + _("#user_mode_code").validationMessage, "WARNING");
    showInputAlert("user_mode_code", "warning", _("#user_mode_code").validationMessage);
    _("#user_mode_code").focus();
    save_no = 0;
    return false;
  }
  if (!_("#user_password").checkValidity() && _("#user_code").value == "") {
    toastr["warning"]("Password : " + _("#user_password").validationMessage, "WARNING");
    showInputAlert("user_password", "warning", _("#user_password").validationMessage);
    _("#user_password").focus();
    save_no = 0;
    return false;
  }
  if (!_("#email").checkValidity()) {
    toastr["warning"]("Email : " + _("#email").validationMessage, "WARNING");
    showInputAlert("email", "warning", _("#email").validationMessage);
    _("#email").focus();
    save_no = 0;
    return false;
  }

  if (save_no == 1 && insert_per == "Yes") {
    _(".background_overlay").style.display = "block";
    //============================= FOR PROFILE IMAGE =====================================
    let d = new Date();
    let profile_img_file_name = "profile_img_" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getTime();
    let profile_img_fl = _("#profile_img").files[0];

    var original_file_name = _("#profile_img").value;
    var ext = original_file_name.split(".").pop();
    let profile_img = "";
    if (_("#profile_img").value != "") {
      profile_img = profile_img_file_name + "." + ext;
    }
    let data = new FormData();
    const sendData = {
      user_code: _("#user_code").value,
      user_id: _("#user_id").value,
      user_password: _("#user_password").value,
      name: _("#name").value,
      email: _("#email").value,
      user_mode_code: _("#user_mode_code").value,
      active: _("#active").value,
      entry_permission: _("#entry_permission").value,
      view_permission: _("#view_permission").value,
      edit_permission: _("#edit_permission").value,
      delete_permissioin: _("#delete_permissioin").value,
      profile_img: profile_img,
    };
    data.append("sendData", JSON.stringify(sendData));
    data.append("profile_img_fl", profile_img_fl);

    save_data = new XMLHttpRequest();
    save_data.onreadystatechange = function () {
      if (save_data.readyState == 4) {
        const response = JSON.parse(save_data.responseText);
        const status = response[0]["status"];
        const status_text = response[0]["status_text"];
        _(".background_overlay").style.display = "none";
        if (status == "SessionDestroy") {
          session_destroy();
          setTimeout(function () {
            window.location.reload();
          }, 5000);
          return false;
        } else if (status == "NoPermission") {
          toastr["error"](status_text, "ERROR!!");
          return false;
        } else if (status == "profile_img error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("profile_img", "error", status_text);
          return false;
        } else if (status == "user_id error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("user_id", "error", status_text);
          _("#user_id").focus();
          return false;
        } else if (status == "email_id error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("email_id", "error", status_text);
          _("#email_id").focus();
          return false;
        } else {
          // When Data Save successfully
          reload_table();
          clear_input();
          toastr["success"](status_text, "SUCCESS!!");
          return false;
        }
      }
    };
    save_data.open("POST", "templates/create_user/save_details.php", true);
    save_data.send(data);
  }
}

function update_data(rw_num) {
  if (edit_per == "Yes") {
    _(".background_overlay").style.display = "block";
    clear_input();
    let data = new FormData();
    const sendData = {
      user_code: _(".user_code_" + rw_num).value,
    };
    data.append("sendData", JSON.stringify(sendData));
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        const response = JSON.parse(xhr.responseText);

        const user_mode = response[0]["user_mode"] == null ? "Not Found" : response[0]["user_mode"];

        _("#user_code").value = response[0]["user_code"];
        _("#user_id").value = response[0]["user_id"];
        _("#name").value = response[0]["name"];
        _("#email").value = response[0]["email"];
        _("#user_mode_code").innerHTML = `<option value="` + response[0]["user_mode_code"] + `" selected>` + user_mode + `</option>`;
        _("#active").value = response[0]["active"];
        _("#entry_permission").value = response[0]["entry_permission"];
        _("#view_permission").value = response[0]["view_permission"];
        _("#edit_permission").value = response[0]["edit_permission"];
        _("#delete_permissioin").value = response[0]["delete_permissioin"];

        _(".profile_img").src = "../upload_content/upload_img/profile_img/" + response[0]["profile_img"];
        _(".profile_img").setAttribute("data-blank-image", "../upload_content/upload_img/profile_img/" + response[0]["profile_img"]);
        chngMode("Update");
        $("#entryModal").modal();
        _(".background_overlay").style.display = "none";
      }
    };
    xhr.open("POST", "templates/create_user/update_data_input.php", true);
    xhr.send(data);
  } else {
    toastr["error"]("You Don't Have Permission To Update Any Data !!", "ERROR!!");
    return false;
  }
}

function delete_data(rw_num) {
  if (del_per == "Yes") {
    _(".background_overlay").style.display = "block";
    clear_input();

    let data = new FormData();
    const sendData = {
      user_code: _(".user_code_" + rw_num).value,
    };
    data.append("sendData", JSON.stringify(sendData));

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        reload_table();
        _(".background_overlay").style.display = "none";
        toastr["info"]("Data Deleted Successfully.", "SUCCESS!!");
        return false;
      }
    };
    xhr.open("POST", "templates/create_user/delete_data.php", true);
    xhr.send(data);
  } else {
    toastr["error"]("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
    return false;
  }
}
