$(document).ready(function () {
  show_list();
});
function clear_input() {
  _("#slider_id").value = "";
  _("#heading").value = "";
  _("#sub_text").value = "";
  _("#button_text").value = "";
  _("#link").value = "";
  _("#active").value = "Yes";
  _("#order_num").value = "";
  _(".slider_img").setAttribute("data-blank-image", "../upload_content/upload_img/slider_img/no_image.png");
  $("#slider_img").val("").trigger("change");
  chngMode("Insert");
  clearInputAleart();
}

function chngMode(mode) {
  if (mode == "Update") {
    _(".entry_modal_title").innerHTML = "Update Home Slider Details :";
    _(".save_btn").innerHTML = "Update Data";
  } else {
    _(".entry_modal_title").innerHTML = "Enter Home Slider Details :";
    _(".save_btn").innerHTML = "Save Data";
  }
}

function show_list() {
  if (view_per == "Yes") {
    $("#data_table").DataTable({
      processing: true,
      serverSide: true,
      serverMethod: "post",
      ajax: {
        url: "templates/slider_master/list.php",
      },
      drawCallback: function (data) {
        // Here the response
        // var response = data.json;
        // console.log(response);
      },
      columns: [
        { data: "action" },
        { data: "entry_timestamp" },
        { data: "slider_img" },
        { data: "heading" },
        { data: "sub_text" },
        { data: "button_text"},
        { data: "link" },
        { data: "order_num" },
        { data: "active" }
      ],
      dom: "lBfrtip",
      buttons: [
        { extend: "print", className: "btn dark btn-outline" },
        { extend: "copy", className: "btn red btn-outline" },
        { extend: "pdf", className: "btn green btn-outline" },
        { extend: "excel", className: "btn yellow btn-outline " },
        { extend: "csv", className: "btn purple btn-outline " },
        {
          extend: "colvis",
          className: "btn dark btn-outline",
          text: "Columns",
        },
        {
          extend: "pageLength",
          className: "btn dark btn-outline",
          text: "Show Entries",
        },
      ],
      order: [[1, "desc"]],
      aoColumnDefs: [
        {
          bSortable: false,
          aTargets: ["nosort"],
        },
      ],
    });
  }
}

function reload_table() {
  $("#data_table").DataTable().ajax.reload();
}


function checkSliderImage() {
  const fileInput = _("#slider_img");

  if (fileInput.files.length == 0) {
    if (_("#slider_id").value == "") {
        toastr["warning"]( "Slider Image : Slider Image is Required", "WARNING" );
        showInputAlert( "slider_img", "warning", "Slider Image is Required" );
    }
    else {
      save_details();
    }
  }

  /*************************** Newly Revised Code starts*****************************/
  if (fileInput.files.length > 0) {
    const img = document.createElement("img");
    const selectedImage = fileInput.files[0];
    const objectURL = URL.createObjectURL(selectedImage);

    img.onload = function() {
        // console.log(`Width: ${img.width}, Height: ${img.height}`);

        if (img.width !== 1600 || img.height !== 700) {
            toastr["warning"](
                "Slider Image: width must be 1600px or, height must be 700px",
                "WARNING"
            );
            showInputAlert(
                "slider_img",
                "warning",
                "Image width must be 1600px or, height must be 700px"
            );
            save_no = 0;
        } else {
            save_details();
        }

        URL.revokeObjectURL(objectURL);
    };

    img.src = objectURL;
  }
}
/*************************** Newly Revised Code ends *****************************/

function save_details() {
  let save_no = 1;

  clearInputAleart();

  if (insert_per === "No") {
    toastr["error"]("You Don't Have Permission To Entry Any Data !!", "ERROR");
    save_no = 0;
    return false;
  }
  if (!_("#heading").checkValidity()) {
    toastr["warning"]("Slider Heading : " + _("#heading").validationMessage, "WARNING");
    showInputAlert("heading", "warning", _("#heading").validationMessage);
    _("#heading").focus();
    save_no = 0;
    return false;
  }
  if (!_("#sub_text").checkValidity()) {
    toastr["warning"]("Slider Paragraph Text : " + _("#sub_text").validationMessage, "WARNING");
    showInputAlert("sub_text", "warning", _("#sub_text").validationMessage);
    _("#sub_text").focus();
    save_no = 0;
    return false;
  }
  if (!_("#button_text").checkValidity()) {
    toastr["warning"]("Slider Button Text : " + _("#button_text").validationMessage, "WARNING");
    showInputAlert("button_text", "warning", _("#button_text").validationMessage);
    _("#button_text").focus();
    save_no = 0;
    return false;
  }
  if (!_("#order_num").checkValidity()) {
    toastr["warning"]("Slider Image Order Number : " + _("#order_num").validationMessage, "WARNING");
    showInputAlert("order_num", "warning", _("#order_num").validationMessage);
    _("#order_num").focus();
    save_no = 0;
    return false;
  }

  if (save_no === 1 && insert_per === "Yes") {
    _(".background_overlay").style.display = "block";
    //============================= FOR PROFILE IMAGE =====================================
    let d = new Date();
    let slider_img_file_name =
      "slider_img_" +
      d.getDate() +
      "-" +
      d.getMonth() +
      "-" +
      d.getFullYear() +
      "-" +
      d.getTime();
    let slider_img_fl = _("#slider_img").files[0];

    var original_file_name = _("#slider_img").value;
    var ext = original_file_name.split(".").pop();
    let slider_img = "";
    if (_("#slider_img").value != "") {
      slider_img = slider_img_file_name + "." + ext;
    }
    let data = new FormData();
    const sendData = {
      slider_id: _("#slider_id").value,
      heading: _("#heading").value,
      sub_text: _("#sub_text").value,
      button_text: _("#button_text").value,
      link: _("#link").value,
      active: _("#active").value,
      order_num: _("#order_num").value,
      slider_img: slider_img,
    };
    data.append("sendData", JSON.stringify(sendData));
    data.append("slider_img_fl", slider_img_fl);

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
        } else if (status == "slider_img error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("slider_img", "error", status_text);
          return false;
        } else if (status == "NoPermission") {
          toastr["error"](status_text, "ERROR!!");
          return false;
        } else {
          // When Data Save successfully
          // if (slider_img != "") {
          //   upload_image_file(slider_img_fl, slider_img_file_name, "Slider Image");
          // }
          reload_table();
          clear_input();
          toastr["success"](status_text, "SUCCESS!!");
          return false;
        }
      }
    };
    save_data.open("POST", "templates/slider_master/save_details.php", true);
    save_data.send(data);
  }
}


// function upload_image_file(file, file_name, type) {
//   _(".background_overlay_preloader").style.display = "block";
//   let url = "templates/slider_master/img_save.php?file_name=" + file_name;
//   let img_save = new XMLHttpRequest();
//   let img = new FormData();

//   img_save.open("POST", url, true);

//   //================== RUN PRELOADER ================//
//   img_save.upload.addEventListener(
//     "progress",
//     function (evt) {
//       if (evt.lengthComputable) {
//         var percentComplete = parseInt((evt.loaded / evt.total) * 100);

//         if (
//           parseFloat(percentComplete) >
//           parseFloat(_(".preloader_inner_number").innerHTML)
//         ) {
//           _(".preloader_inner_number").innerHTML = percentComplete;
//         }
//       }
//     },
//     false
//   );

//   img_save.onreadystatechange = function () {
//     if (img_save.readyState == 4 && img_save.status == 200) {
//       // alert(img_save.responseText);
//       _(".background_overlay_preloader").style.display = "none";
//       _(".preloader_inner_number").innerHTML = 0;
//       if (img_save.responseText == "session destroy") {
//         _(".session_des_box_background_overlay").style.display = "block";
//       } else if (img_save.responseText == "error") {
//         toastr["error"]("File Error !!", "ERROR!!");
//         return false;
//       } else {
//         toastr["success"](type + " Saved Successfully.", "SUCCESS!!");
//       }
//     }
//   };
//   img.append("uploaded_file", file);
//   img_save.send(img);
// }


function update_data(slider_id) {
  // console.log(slider_id);
	if (edit_per == "Yes") {
	  _(".background_overlay").style.display = "block";
	  clear_input();
	  let data = new FormData();
	  const sendData = {
      slider_id: slider_id,
	  };
	  data.append("sendData", JSON.stringify(sendData));
	  xhr = new XMLHttpRequest();
	  xhr.onreadystatechange = function () {
		if (xhr.readyState == 4) {
      // console.log(xhr.responseText);
		  const response = JSON.parse(xhr.responseText);
  
		  _("#slider_id ").value = response[0]["slider_id"];
		  _("#heading").value = response[0]["heading"];
		  _("#sub_text").value = response[0]["sub_text"];
      _("#button_text").value = response[0]["button_text"];
		  _("#link").value = response[0]["link"];
		  _("#active").value = response[0]["active"];
		  _("#order_num").value = response[0]["order_num"];
		  _(".slider_img").src = "../upload_content/upload_img/slider_img/" + response[0]["slider_img"];
		  _(".slider_img").setAttribute("data-blank-image", "../upload_content/upload_img/slider_img/" + response[0]["slider_img"]);
  
		  chngMode("Update");
		  $("#entryModal").modal();
		  _(".background_overlay").style.display = "none";
		}
	  };
	  xhr.open("POST", "templates/slider_master/update_data_input.php", true);
	  xhr.send(data);
	} else {
	  toastr["error"]("You Don't Have Permission To Update Any Data !!", "ERROR!!");
	  return false;
	}
  }

function delete_data(slider_id) {
  if (del_per == "Yes") {
    _(".background_overlay").style.display = "block";
    clear_input();

    let data = new FormData();
    const sendData = {
      slider_id: slider_id,
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
    xhr.open("POST", "templates/slider_master/delete_data.php", true);
    xhr.send(data);
  } else {
    toastr["error"](
      "You Don't Have Permission To Delete Any Data !!",
      "ERROR!!"
    );
    return false;
  }
}
