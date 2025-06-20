$(document).ready(function () {
  getAddress(product_update_address_id);
  checkImageDeleteBtn();
  if (update_category_id != "") {
    selectCategory(update_category_id);
  }
});

function clear_input() {
  window.location.reload();
}

//////////////////////////////////////////////////////////
////======== For Adddress Realted Work Start ========/////
//////////////////////////////////////////////////////////

function getAddress(address_id) {
  _(".background_overlay").style.display = "block";

  addressXhr = new XMLHttpRequest();
  addressXhr.onreadystatechange = function () {
    if (addressXhr.readyState == 4) {
      // console.log(addressXhr.responseText);
      _("#address_id").innerHTML = addressXhr.responseText;

      if (address_id != undefined) {
        _("#address_id").value = address_id;
        showAddressDetails();
      }
      _(".background_overlay").style.display = "none";
    }
  };
  addressXhr.open(
    "POST",
    "templates/seller-post/get_address_select_list.php",
    true
  );
  addressXhr.send();
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

  addressDetailsXhr = new XMLHttpRequest();
  addressDetailsXhr.onreadystatechange = function () {
    if (addressDetailsXhr.readyState == 4) {
      
      _(".address_details").innerHTML = addressDetailsXhr.responseText;
      _(".background_overlay").style.display = "none";
    }
  };
  addressDetailsXhr.open(
    "POST",
    "templates/seller-post/get_address_details.php",
    true
  );
  addressDetailsXhr.send(data);
}

function clear_address_input() {
  _("#modal_address_id").value = "";
  _("#contact_name").value = "";
  _("#contact_ph_num").value = "";
  _("#alternative_num").value = "";
  _("#address_name").value = "";
  _("#address_tag").value = "";
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

  if (!_("#contact_name").checkValidity()) {
    toastr["warning"](
      "Name : " + _("#contact_name").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "contact_name",
      "warning",
      _("#contact_name").validationMessage
    );
    _("#contact_name").focus();
    save_no = 0;
    return false;
  }
  if (
    !_("#contact_ph_num").checkValidity() ||
    !/^\d{10}$/.test(_("#contact_ph_num").value)
  ) {
    const validationContactPhnMessage =
      _("#contact_ph_num").validationMessage || "Invalid Phone Number";
    toastr["warning"](
      "Phone Number: " + validationContactPhnMessage,
      "WARNING"
    );
    showInputAlert("contact_ph_num", "warning", validationContactPhnMessage);
    _("#contact_ph_num").focus();
    save_no = 0;
    return false;
  }
  // if (!_("#alternative_num").checkValidity() || !/^\d{10}$/.test(_("#alternative_num").value)) {
  //     const validationAlternativePhnMessage = _("#alternative_num").validationMessage || "Invalid Phone Number";
  //     toastr["warning"]("Alternative Number : " + validationAlternativePhnMessage, "WARNING");
  //     showInputAlert("alternative_num", "warning", validationAlternativePhnMessage);
  //     _("#alternative_num").focus();
  //     save_no = 0;
  //     return false;
  // }
  if (!_("#address_name").checkValidity()) {
    toastr["warning"](
      "Address Name : " + _("#address_name").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "address_name",
      "warning",
      _("#address_name").validationMessage
    );
    _("#address_name").focus();
    save_no = 0;
    return false;
  }
  if (!_("#address_tag").checkValidity()) {
    toastr["warning"](
      "Address Tag : " + _("#address_tag").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "address_tag",
      "warning",
      _("#address_tag").validationMessage
    );
    _("#address_tag").focus();
    save_no = 0;
    return false;
  }
  if (!_("#country").checkValidity()) {
    toastr["warning"](
      "Country : " + _("#country").validationMessage,
      "WARNING"
    );
    showInputAlert("country", "warning", _("#country").validationMessage);
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
  if (!_("#city").checkValidity()) {
    toastr["warning"]("City : " + _("#city").validationMessage, "WARNING");
    showInputAlert("city", "warning", _("#city").validationMessage);
    _("#city").focus();
    save_no = 0;
    return false;
  }
  if (!_("#landmark").checkValidity()) {
    toastr["warning"](
      "Landmark : " + _("#landmark").validationMessage,
      "WARNING"
    );
    showInputAlert("landmark", "warning", _("#landmark").validationMessage);
    _("#landmark").focus();
    save_no = 0;
    return false;
  }
  if (!_("#pincode").checkValidity()) {
    toastr["warning"](
      "Pincode : " + _("#pincode").validationMessage,
      "WARNING"
    );
    showInputAlert("pincode", "warning", _("#pincode").validationMessage);
    _("#pincode").focus();
    save_no = 0;
    return false;
  }
  if (!_("#address_line_1").checkValidity()) {
    toastr["warning"](
      "Address : " + _("#address_line_1").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "address_line_1",
      "warning",
      _("#address_line_1").validationMessage
    );
    _("#address_line_1").focus();
    save_no = 0;
    return false;
  }

  if (save_no == 1) {
    let data = new FormData();
    const sendData = {
      address_id: _("#modal_address_id").value,
      contact_name: _("#contact_name").value,
      contact_ph_num: _("#contact_ph_num").value,
      alternative_num: _("#alternative_num").value,
      address_name: _("#address_name").value,
      address_tag: _("#address_tag").value,
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
            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            } else {
              toastr["success"](status_text, "SUCCESS!!");
              getAddress(address_id);
              $("#addressModal").modal("hide");
              clear_address_input();
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error(
            "Server error:",
            save_data.status,
            save_data.statusText
          );
          toastr["error"]("Server error: " + save_data.statusText, "ERROR!!");
        }
      }
    };
    save_data.open(
      "POST",
      "templates/address-book/save_address_details.php",
      true
    );
    save_data.send(data);
  }
}

function update_data(address_id) {
  _(".background_overlay").style.display = "block";
  clear_address_input();
  let data = new FormData();
  const sendData = {
    address_id: address_id,
  };
  data.append("sendData", JSON.stringify(sendData));
  xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      const response = JSON.parse(xhr.responseText);
      // console.log(response);

      _("#modal_address_id").value = response["address_id"];
      _("#contact_name").value = response["contact_name"];
      _("#contact_ph_num").value = response["contact_ph_num"];
      _("#alternative_num").value = response["alternative_num"];
      _("#address_name").value = response["address_name"];
      _("#address_tag").value = response["address_tag"];
      _("#country").value = response["country"];
      _("#state").value = response["state"];
      _("#city").value = response["city"];
      _("#landmark").value = response["landmark"];
      _("#pincode").value = response["pincode"];
      _("#address_line_1").value = response["address_line_1"];

      $("#addressModal").modal("show");
      _(".background_overlay").style.display = "none";
    }
  };
  xhr.open("POST", "templates/address-book/update_data_input.php", true);
  xhr.send(data);
}

//////////////////////////////////////////////////////////
////======== For Adddress Realted Work End ========/////
//////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////
///////======== Category Selection Part ========///////
//////////////////////////////////////////////////////////

function selectCategory(cate_id) {
  _(".main-cate-btn").innerHTML = _(".cate_btn_" + cate_id).innerHTML;
  _(".main-cate-btn").classList.remove("animate__bounceOut");
  _(".main-cate-btn").classList.add("animate__bounceIn");
  _(".catgory-show-div").style.display = "flex";
  _("#category_id").value = cate_id;
  // getAvaragePrice();

  // Show the rate list button if a valid category is selected
  const rateListButton = document.getElementById("rate_list_button");
  if (cate_id) {
    rateListButton.style.display = "block";
  } else {
    rateListButton.style.display = "none";
  }
}

function closeCategory() {
  _(".main-cate-btn").innerHTML = "";
  _(".main-cate-btn").classList.remove("animate__bounceIn");
  _(".main-cate-btn").classList.add("animate__bounceOut");
  setTimeout(function () {
    _(".catgory-show-div").style.display = "none";
  }, 500);
  _("#category_id").value = "";
  // getAvaragePrice();

  // hide the rate list button
  document.getElementById("rate_list_button").style.display = "none";
}

//////////////////////////////////////////////////////////
///////======== Category Selection Part ========///////
//////////////////////////////////////////////////////////

// function getAvaragePrice() {
//     _(".avg_price_p").style.display = "none";
//     let data = new FormData();
//     const sendData = {
//         category_id: _("#category_id").value,
//         product_name: _("#product_name").value,
//     };
//     data.append("sendData", JSON.stringify(sendData));
//     xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState == 4) {
//             const response = JSON.parse(xhr.responseText);
//             if(response['avgPrice'] > 0){
//                 _(".avg_price_p").innerHTML = "Average Price : "+ "₹ " + response['avgPrice']+" /-";
//                 _(".avg_price_p").style.display = "block";
//             }
//             else{
//                 _(".avg_price_p").style.display = "none";
//             }
//             // console.log(response['avgPrice']);
//         }
//     }
//     xhr.open('POST', 'templates/seller-post/get_avg_price.php', true);
//     xhr.send(data);
// }

// ======================================
// Product Multiple Images start
// ======================================

function chooseImg(rw_num, type) {
  if (type == "gallery") {
    _("#busimg_" + rw_num).removeAttribute("capture");
  }
  if (type == "camera") {
    _("#busimg_" + rw_num).setAttribute("capture", "");
  }
  _("#busimg_" + rw_num).click();
}

let busimgtableRow = 2;

function createBusimgRow(rw_num) {
  let execute = 1;
  clearInputAleart();

  if (!_("#busimg_" + rw_num).checkValidity()) {
    toastr["warning"](
      "Item Image : " + _("#busimg_" + rw_num).validationMessage,
      "WARNING"
    );
    showInputAlert(
      "busimg_" + rw_num,
      "warning",
      _("#busimg_" + rw_num).validationMessage
    );
    _("#busimg_" + rw_num).focus();
    execute = 0;
    return false;
  }

  if (execute == 1) {
    let tr = document.createElement("tr");
    tr.setAttribute("class", "tr_busimg tr_busimg_" + busimgtableRow);
    tr.innerHTML =
      `<td scope="row" class="busimg_sl_num" style="text-align: center;">
                1
            </td>
            <td scope="row">
                <div class="form-group product_img_div">
                    <input style="display: none;" type="file" onchange="loadFile(this,'preview_img_` +
      busimgtableRow +
      `'); checkFile(` +
      busimgtableRow +
      `)" checkFile(` +
      busimgtableRow +
      `) id="busimg_` +
      busimgtableRow +
      `" class=" form-control image" required />
                    <img style="max-width: 80px; height: 50px !important;" onclick="chooseImg(` +
      busimgtableRow +
      `,'gallery')" data-blank-image="../upload_content/upload_img/product_img/no_image.png" src="frontend_assets/img-icon/gallery.png" />
                    <img style="max-width: 80px; height: 50px !important;" onclick="chooseImg(` +
      busimgtableRow +
      `,'camera')" data-blank-image="../upload_content/upload_img/product_img/no_image.png" src="frontend_assets/img-icon/camera.png" />
                    <img id="preview_img_` +
      busimgtableRow +
      `" style="max-height: 80px; max-width: 100px; margin-left: 20px;"/>
                </div>
                <label data-default-mssg="" class="input_alert busimg_` +
      busimgtableRow +
      `-inp-alert"></label>
            </td>
            <td class="busimgactionTd_` +
      busimgtableRow +
      `" style="text-align: center;">
            <button onclick="createBusimgRow(` +
      busimgtableRow +
      `)"
                class="btn btn-icon btn-primary btn-lg mt-2">
                <i class="fa fa-plus"></i>
            </button>
            </td>
            `;

    _(".BusinessImageDetailsEntryTbody").appendChild(tr);

    busimgtableRow++;

    _(".busimgactionTd_" + rw_num).innerHTML =
      `<button onclick="busimgdeleteRow(` +
      rw_num +
      `)" class="btn btn-icon btn-danger btn-lg mt-2">
                <i class="fa fa-trash"></i>
            </button>`;
  }
}

function busimgdeleteRow(rw_num) {
  _(".tr_busimg_" + rw_num).remove();
}

function checkFile(rw_num) {
  _(".img_name_" + rw_num).innerHTML = "Choose Image";

  if (_("#busimg_" + rw_num).value != "") {
    clearInputAleart();
    //============================= Check product image size and ext validation  =====================================
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    data.append("product_img_fl", _("#busimg_" + rw_num).files[0]);

    imgCheckXhr = new XMLHttpRequest();
    imgCheckXhr.onreadystatechange = function () {
      if (imgCheckXhr.readyState == 4) {
        // console.log(imgCheckXhr.responseText);
        const response = JSON.parse(imgCheckXhr.responseText);
        const status = response[0]["status"];
        const status_text = response[0]["status_text"];
        _(".background_overlay").style.display = "none";

        if (status == "product_img error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("busimg_" + rw_num, "error", status_text);
          _("#busimg_" + rw_num).focus();
          $("#busimg_" + rw_num)
            .val("")
            .trigger("change");
          return false;
        } else {
          _(".img_name_" + rw_num).innerHTML = _(
            "#busimg_" + rw_num
          ).files[0].name;
        }
      }
    };
    imgCheckXhr.open("POST", "templates/seller-post/image_check.php", true);
    imgCheckXhr.send(data);
  }
}

// ======================================
// Product Multi Images End
// ======================================

let product_img_file_array = [];
let product_img_array = [];

function save_details() {
  let save_no = 1;
  clearInputAleart();
  toastr.clear();

  // var numberRegex = /^\d+$/;

  if (!_("#category_id").checkValidity()) {
    toastr["warning"](
      "Category : " + _("#category_id").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "category_id",
      "warning",
      _("#category_id").validationMessage
    );
    _("#category_id").focus();
    save_no = 0;
    return false;
  }
  if (!_("#address_id").checkValidity()) {
    toastr["warning"](
      "Address : " + _("#address_id").validationMessage,
      "WARNING"
    );
    showInputAlert("address_id", "warning", _("#address_id").validationMessage);
    _("#address_id").focus();
    save_no = 0;
    return false;
  }
  if (!_("#product_name").checkValidity()) {
    toastr["warning"](
      "Product Name: " + _("#product_name").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "product_name",
      "warning",
      _("#product_name").validationMessage
    );
    _("#product_name").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z0-9,\.\s]+$/.test(_("#product_name").value)) {
    toastr["warning"](
      "Product Name : " +
      "Product Name should only contain letters, digits, commas, dots, and spaces",
      "WARNING"
    );
    showInputAlert(
      "product_name",
      "warning",
      "Product Name should only contain letters, digits, commas, dots, and spaces"
    );
    _("#product_name").focus();
    save_no = 0;
    return false;
  }

  if (!_("#sale_price").checkValidity()) {
    toastr["warning"](
      "Expected Price: " + _("#sale_price").validationMessage,
      "WARNING"
    );
    showInputAlert("sale_price", "warning", _("#sale_price").validationMessage);
    _("#sale_price").focus();
    save_no = 0;
    return false;
  }
  // if (!numberRegex.test(_("#sale_price").value)) {
  //   toastr["warning"]("Expected Price : Only Number Accepted", "WARNING");
  //   showInputAlert("sale_price", "warning", "Only Number Accepted");
  //   _("#sale_price").focus();
  //   save_no = 0;
  //   return false;
  // }
  // if (!/^\d+(\.\d{1,2})?$/.test(_("#sale_price").value)) {
  //   toastr["warning"](
  //     "Expected Price: Please enter a valid decimal price (e.g., 123.45)",
  //     "WARNING"
  //   );
  //   showInputAlert(
  //     "sale_price",
  //     "warning",
  //     "Please enter a valid decimal price (e.g., 123.45)"
  //   );
  //   _("#sale_price").focus();
  //   save_no = 0;
  //   return false;
  // }
  if (!_("#description").checkValidity()) {
    toastr["warning"](
      "Description: " + _("#description").validationMessage,
      "WARNING"
    );
    showInputAlert(
      "description",
      "warning",
      _("#description").validationMessage
    );
    _("#description").focus();
    save_no = 0;
    return false;
  }
  // if (!/^[a-zA-Z\s]+$/.test(_("#description").value)) {
  //   toastr["warning"](
  //     "Description : " + "Description should only contain letters and spaces",
  //     "WARNING"
  //   );
  //   showInputAlert(
  //     "description",
  //     "warning",
  //     "Description should only contain letters and spaces"
  //   );
  //   _("#description").focus();
  //   save_no = 0;
  //   return false;
  // }

  product_img_array = [];
  product_img_file_array = [];

  let rw = 0;
  let d = new Date();

  for (z = 0; z < __("tr_busimg").length; z++) {
    if (__("image")[z].checkValidity()) {
      let product_img_file_name =
        "product_image_" +
        (rw + 1) +
        "_" +
        d.getDate() +
        "-" +
        d.getMonth() +
        "-" +
        d.getFullYear() +
        "-" +
        d.getTime();
      let product_img_file = __("image")[z].files[0];

      var ext = __("image")[z].value.split(".").pop();
      let product_img = product_img_file_name + "." + ext;

      product_img_array[rw] = product_img;
      product_img_file_array[rw] = product_img_file;

      rw++;
    }
  }

  // check image in insert mode
  if (rw == 0 && _("#product_id").value == "") {
    toastr["warning"]("Please Select At Least One Product Image", "WARNING");
    save_no = 0;
    return false;
  }

  if (save_no == 1) {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      product_id: _("#product_id").value,
      category_id: _("#category_id").value,
      address_id: _("#address_id").value,
      product_name: _("#product_name").value,
      description: _("#description").value,
      brand: _("#brand").value,
      quantity: _("#quantity").value,
      sale_price: _("#sale_price").value,
      baseUrl: baseUrl,

      product_img_array: product_img_array,
      total_img_rw: rw,
    };

    data.append("sendData", JSON.stringify(sendData));

    let save_data = new XMLHttpRequest();
    save_data.onreadystatechange = function () {
      if (save_data.readyState == 4) {
        _(".background_overlay").style.display = "none";

        if (save_data.status == 200) {
          console.log(save_data.responseText); // Uncomment this line
          const response = JSON.parse(save_data.responseText);
          const status = response[0]["status"];
          const status_text = response[0]["status_text"];

          if (status == "SessionDestroy") {
            session_destroy();
            setTimeout(function () {
              window.location.reload();
            }, 5000);
            return false;
          } else if (status == "NoPermission") {
            toastr["error"](status_text, "ERROR!!");
            return false;
          } else if (status == "product_name Exist") {
            toastr["error"](status_text, "ERROR!!");
            showInputAlert("product_name", "error", status_text);
            _("#product_name").focus();
            return false;
          } else {
            toastr["success"](status_text, "SUCCESS!!");
            if (product_img_array.length > 0) {
              uploadImageFile(0);
            } else {
              setTimeout(function () {
                clear_input();
              }, 1000);
            }
            return false;
          }
        } else {
          toastr["error"](
            "Some Server Error Occured. Please Try Again",
            "ERROR!!"
          );
        }
      }
    };
    save_data.open("POST", "templates/seller-post/save_details.php", true);
    save_data.send(data);
  }
}
function uploadImageFile(file_num) {
  toastr.clear();
  const file_name = product_img_array[file_num];
  const type = "Product Image " + (file_num + 1);
  const file = product_img_file_array[file_num];

  _(".preloader_inner_text").innerHTML = "Wait For " + type + " Uploading...";
  _(".background_overlay_preloader").style.display = "block";

  const data = new FormData();
  const sendData = {
    file_name: file_name,
    type: type,
  };
  data.append("sendData", JSON.stringify(sendData));
  data.append("uploaded_file", file);

  console.log("Uploading:", file_name);

  const fileUploadXHR = new XMLHttpRequest();

  // Preloader progress
  fileUploadXHR.upload.addEventListener(
    "progress",
    function (evt) {
      if (evt.lengthComputable) {
        const percentComplete = parseInt((evt.loaded / evt.total) * 100);
        if (
          parseFloat(percentComplete) >
          parseFloat(_(".preloader_inner_number").innerHTML)
        ) {
          _(".preloader_inner_number").innerHTML = percentComplete;
        }
      }
    },
    false
  );

  fileUploadXHR.onreadystatechange = function () {
    if (fileUploadXHR.readyState === 4) {
      try {
        const response = JSON.parse(fileUploadXHR.responseText);
        console.log("Server Response:", response);

        const status = response.status;
        const message = response.message;

        _(".background_overlay_preloader").style.display = "none";
        _(".preloader_inner_number").innerHTML = 0;

        if (status === "Success") {
          toastr["success"](message, "SUCCESS!!");
          file_num++;

          // Proceed with the next file upload
          if (file_num < product_img_array.length) {
            uploadImageFile(file_num);
          } else {
            setTimeout(function () {
              clear_input();
            }, 2000);
          }
        } else {
          toastr["error"]("Error uploading file. Please try again.", "ERROR!!");
        }
      } catch (error) {
        console.error("JSON Parsing Error:", error.message);
        console.log("Raw Response:", fileUploadXHR.responseText);
        toastr["error"]("Invalid server response. Please try again.", "ERROR!!");
      }
    }
  };

  fileUploadXHR.open(
    "POST",
    "templates/seller-post/upload_image_file.php",
    true
  );
  fileUploadXHR.send(data);
}


function delete_data(product_file_id) {
  _(".background_overlay").style.display = "block";
  toastr.clear();
  let data = new FormData();
  const sendData = {
    product_file_id: product_file_id,
  };


  xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      _(".background_overlay").style.display = "none";
      $(".previous_image_" + product_file_id).remove();
      checkImageDeleteBtn();
      toastr["info"]("Photo Deleted Successfully.", "SUCCESS!!");
      return false;
    }
  };
  xhr.open("POST", "templates/seller-post/delete_product_file.php", true);
  xhr.send(data);
}

function checkImageDeleteBtn(params) {
  if (__("image-delete-btn").length == 1) {
    __("image-delete-btn")[0].style.display = "none";
  }
}

function loadFile(fileInput, imgId) {
  if (fileInput.files && fileInput.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.getElementById(imgId).src = e.target.result;
    };

    reader.readAsDataURL(fileInput.files[0]);
  } else {
    // Handle case where no file is selected
    const blankImage = document
      .getElementById(imgId)
      .getAttribute("data-blank-image");
    document.getElementById(imgId).src = blankImage;
  }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// close category modal & get category wise rate list ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function closeCategoryRateList() {
  $('#exampleModal').modal('hide');
}

function getCategoryWiseRateList() {
  _(".background_overlay").style.display = "block";

  // Create FormData object
  const data = new FormData();
  const sendData = {
    category_id: _("#category_id").value,
  };
  data.append("sendData", JSON.stringify(sendData));

  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Update modal content and show it
        const response = xhr.responseText;
        _("#exampleModal .modal-body").innerHTML = response;

        $("#exampleModal").modal("show");
      } else {
        // console.error("Error fetching data: " + xhr.statusText);
      }
      _(".background_overlay").style.display = "none";
    }
  };
  xhr.open("POST", "templates/seller-post/get_category_rate_list.php", true);
  xhr.send(data);
}
