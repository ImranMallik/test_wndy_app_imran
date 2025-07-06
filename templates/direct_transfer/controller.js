$(document).ready(function () {
  $("#category_id").val("");
  $("#cat_id").val("");
  getPurchasedProductList();
  getTransProductList();

  $("#category_id").change(function () {
    fetchBuyers();
  });
});



//Fetch Buyer 
function fetchBuyers() {
  $("#user_id").html('<option value="">Loading...</option>');
  const categoryInput = $("#category_id").val();
  if (!categoryInput) {
    $("#user_id").html('<option value="">Please select a category</option>');
    return;
  }

  let data = new FormData();
  const sendData = { category_id: categoryInput };
  data.append("sendData", JSON.stringify(sendData));

  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);

          if (response.error) {
            console.error("Server error:", response.error);
            $("#user_id").html('<option value="">No buyers found</option>');
          } else if (response.success && response.data.length > 0) {
            const options = response.data
              .map(
                (buyer) =>
                  `<option value="${buyer.user_id}">${buyer.name}</option>`
              )
              .join("");
            $("#user_id").html(
              `<option value="" selected disabled>Choose Buyer</option>` + options
            );
          } else {
            $("#user_id").html('<option value="">No buyers found</option>');
          }
        } catch (e) {
          console.error("Parsing error:", e);
          $("#user_id").html('<option value="">Error loading buyers</option>');
        }
      } else {
        console.error("Request failed:", xhr.status);
        $("#user_id").html('<option value="">Error loading buyers</option>');
      }
    }
  };

  xhr.onerror = function () {
    console.error("Network error occurred.");
    $("#user_id").html('<option value="">Failed to load buyers</option>');
  };

  xhr.open("POST", "templates/direct_transfer/fetch_buyers.php", true);
  xhr.send(data);
}


function getTransProductList() {
  $("#transfer_products_for_you_list").html(
    '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />'
  );
  $(".background_overlay").css("display", "block");

  let data = new FormData();
  const sendData = {
    category_id: $("#cat_id").val(),
  };

  data.append("sendData", JSON.stringify(sendData));


  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      $("#transfer_products_for_you_list").html(xhr.responseText);

      $(".background_overlay").css("display", "none");
    }
  };

  xhr.onerror = function () {
    console.error("An error occurred during the request.");
    $("#transfer_products_for_you_list").html(
      '<p style="color: red;">Failed to load products. Please try again later.</p>'
    );
    $(".background_overlay").css("display", "none");
  };

  xhr.open("POST", "templates/direct_transfer/get_trans_product_list.php", true);
  xhr.send(data);

}

function getPurchasedProductList() {
  $("#purchased_product_list").html(
    '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />'
  );
  $(".background_overlay").css("display", "block");


  // console.log("Category ID:", $("#category_id").val());
  // console.log("Selected Product IDs:", $(".product_id:checked").map(function () {
  //   return $(this).val();
  // }).get());

  let data = new FormData();
  const sendData = {
    category_id: $("#category_id").val(),
    product_id: $(".product_id:checked").map(function () {
      return $(this).val();
    }).get()
  };

  data.append("sendData", JSON.stringify(sendData));
  // console.log(sendData);



  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      // console.log(xhr.responseText);

      $("#purchased_product_list").html(xhr.responseText);
      $(".background_overlay").css("display", "none");
    }
  };

  xhr.onerror = function () {
    console.error("An error occurred during the request.");
    $("#purchased_product_list").html(
      '<p style="color: red;">Failed to load products. Please try again later.</p>'
    );
    $(".background_overlay").css("display", "none");
  };

  xhr.open("POST", "templates/direct_transfer/get_purchased_product_list.php", true);
  xhr.send(data);

  fetchBuyers();

  // if (selectedValue) {
  //   console.log('Selected Category ID:', selectedValue);
  // } else {
  //   console.log('No category selected.');
  // }
}
// Code Update By Imran-------------------------
function getAllProductIds() {
  const productIds = $(".product_id:checked")
    .map(function () {
      return $(this).val();
    })
    .get();


  const categoryId = $("#category_id").val() || $(".category_id").text();

  const data = new FormData();
  data.append("sendDataIDs", JSON.stringify({ product_id: productIds }));
  data.append("sendData", JSON.stringify({ category_id: categoryId }));

  console.log("Sending Data:", { product_id: productIds, category_id: categoryId });

  // AJAX Request
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("Server Response:", xhr.responseText);


      try {
        const response = JSON.parse(xhr.responseText);
        console.log("Server Response:", response);

        if (response.status === "success") {
          document.getElementById("product_name").value = response.product_name_new || "null";
          document.getElementById("description").value = response.description || "null";
          document.getElementById("brand").value = response.brand || "null";

          // $("#createPostModal").modal("show");
        } else {
          console.error("Error:", response.message);
        }
      } catch (error) {
        console.error("JSON Parsing Error:", error);
      }
    }
  };

  xhr.onerror = function () {
    console.error("AJAX request failed.");
  };

  xhr.open("POST", "templates/direct_transfer/get_purchased_product_lcategory_list.php", true);
  xhr.send(data);
}

// 


// Old wrong code -------------------------------
// function getAllProductIds() {
//   const productIds = $(".product_id:checked")
//     .map(function () {
//       return $(this).val();
//     })
//     .get();

//   const data = new FormData();
//   data.append("sendDataIDs", JSON.stringify({ product_id: productIds }));

//   console.log("Sending Product IDs:", productIds);

//   // AJAX Request
//   const xhr = new XMLHttpRequest();
//   xhr.onreadystatechange = function () {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // console.log("Server Response:", xhr.responseText);

//       // Split and parse the response
//       // const responseParts = xhr.responseText.split("]");
//       // if (responseParts.length > 1) {
//       //   const productDetails = JSON.parse(responseParts[1]);
//       //   // console.log("Product Details", productDetails);


//       //   // Call a function to update the form
//       //   setFormValues(
//       //     productDetails.product_name_new,
//       //     productDetails.description,
//       //     productDetails.brand
//       //   );
//       // } else {
//       //   console.error("Invalid server response format.");
//       // }
//     }
//   };

//   xhr.onerror = function () {
//     console.error("AJAX request failed.");
//   };

//   xhr.open("POST", "templates/direct_transfer/get_purchased_product_list.php", true);
//   xhr.send(data);
// }

// Old -----------------

// Function to update form values
function setFormValues(productName, description, brand) {
  document.getElementById("product_name").value = productName || "";
  document.getElementById("description").value = description || "";
  document.getElementById("brand").value = brand || "";
}




//Checked the Category
function showAlert(checkbox) {
  const nextButtonDiv = $("#nextButtonDiv")[0];
  const categoryInput = $("#category_id")[0];

  if (checkbox.checked) {
    if (categoryInput.value !== "") {
      $("#errorToast").hide();
      nextButtonDiv.style.display = "block";
    } else {
      $("#errorToast").show();
      checkbox.checked = false;
    }
  } else {
    nextButtonDiv.style.display = "none";
  }
}


//next page Move
function nextAction() {
  $("#nextButton").show();
  $("#product-listview-loadmore").hide();
  $("#buyer-listview-loadmore").show();
  $("#prevButton").show();
}

// Old Code ---------------------------------------


// function CheckboxButton(selectedValues) {
//   //console.log(selectedValues);
//   let save_no = 1;
//   clearInputAleart();
//   toastr.clear();

//   if (save_no == 1) {
//     _(".background_overlay").style.display = "block";

//     let data = new FormData();
//     const sendData = {
//       selected_values: selectedValues,

//     };
//     data.append("sendData", JSON.stringify(sendData));
//     //console.log(sendData);
//     let save_data = new XMLHttpRequest();
//     save_data.onreadystatechange = function () {
//       if (save_data.readyState == 4) {
//         _(".background_overlay").style.display = "none";
//         if (save_data.status == 200) {
//           console.log(save_data.responseText);
//           const response = JSON.parse(save_data.responseText);
//           const status = response[0]["status"];
//           const status_text = response[0]["status_text"];
//           if (status == "SessionDestroy") {
//             session_destroy();
//             setTimeout(function () {
//               window.location.reload();
//             }, 5000);
//             return false;
//           } else if (status == "NoPermission") {
//             toastr["error"](status_text, "ERROR!!");
//             return false;
//           } else {
//             toastr["success"](status_text, "SUCCESS!!");
//             return false;
//           }
//         }
//         else {
//           toastr["error"](
//             "Some Server Error Occured. Please Try Again",
//             "ERROR!!"
//           );
//         }

//       }

//     };
//     save_data.open("POST", "templates/direct_transfer/save_transferred_items.php", true);

//     //save_data.send(data);



//     save_data.send(data);
//   }
// }

// End -----------------------------------

//Previous Button
function previousAction() {
  $("#nextButton").show();
  $("#product-listview-loadmore").show();
  $("#buyer-listview-loadmore").hide();
  $("#prevButton").hide();
}

function DirectButton() {
  const userId = $("#user_id").val();
  const priceInput = $("#price").val();
  const quantityInput = $("#quantity").val();

  // Clear previous error messages
  $("#doneErrorToast").hide();
  $("#priceError").hide();
  $("#quantityError").hide();

  // Start validation
  console.log("User ID:", userId);

  if (!userId) {
    $("#doneErrorToast").show();
  }
  if (!quantityInput) {
    $("#quantityError").show();
    return; // Exit function early
  }
  if (!priceInput) {
    $("#priceError").show();
    return; // Exit function early
  }


  const selectedValues = $(".product_id:checked").map(function () {
    return $(this).val();
  }).get();

  let save_no = 1;
  clearInputAleart();
  toastr.clear();

  if (save_no === 1) {
    _(".background_overlay").style.display = "block";

    // Prepare data for sending
    let data = new FormData();
    const sendData = {
      product_id: selectedValues,
      user_id: userId,
      category_id: _("#category_id").value,
      price: priceInput,
      quantity: quantityInput,
    };
    console.log(sendData);

    data.append("sendData", JSON.stringify(sendData));

    // Send AJAX request
    let save_data = new XMLHttpRequest();
    save_data.onreadystatechange = function () {
      if (save_data.readyState === 4) {
        _(".background_overlay").style.display = "none";

        if (save_data.status === 200) {
          try {
            const response = JSON.parse(save_data.responseText);
            const status = response[0]?.status;
            const status_text = response[0]?.status_text;

            if (status === "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
            } else if (status === "NoPermission") {
              toastr["error"](status_text, "ERROR!!");
            } else if (status === "Success") {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }
                , 2000);
            } else {
              toastr["error"]("Unexpected status in response", "ERROR!!");
            }
          } catch (error) {
            console.error("Invalid JSON response:", save_data.responseText);
            toastr["error"]("Invalid response from server. Please try again.", "ERROR!!");
          }
        } else {
          toastr["error"]("Some Server Error Occurred. Please Try Again", "ERROR!!");
        }
      }
    };

    save_data.open("POST", "templates/direct_transfer/save_transferred_items.php", true);
    save_data.send(data);
  }
}

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
function updateSerialNumbers() {
  const rows = document.querySelectorAll(".BusinessImageDetailsEntryTbody .tr_busimg");
  rows.forEach((row, index) => {
    const serialCell = row.querySelector(".busimg_sl_num");
    if (serialCell) {
      serialCell.textContent = index + 1; // Update the serial number
    }
  });
}

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
          </td>
          <td scope="row">
              <div class="form-group product_img_div">
                  <input style="display: none;" type="file" onchange="loadFile(this,'preview_img_` +
      busimgtableRow +
      `'); checkFile(` +
      busimgtableRow +
      `)" id="busimg_` +
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

    updateSerialNumbers();
  }
}

function busimgdeleteRow(rw_num) {
  _(".tr_busimg_" + rw_num).remove();
  updateSerialNumbers();
}


function checkFile(rw_num) {
  var imgNameElement = _(".img_name_" + rw_num);
  var busImgElement = _("#busimg_" + rw_num);

  if (imgNameElement) {
    imgNameElement.innerHTML = "Choose Image";
  }

  if (busImgElement && busImgElement.value != "") {
    clearInputAleart();
    //============================= Check product image size and ext validation  =====================================
    var backgroundOverlay = _(".background_overlay");
    if (backgroundOverlay) {
      backgroundOverlay.style.display = "block";
    }

    let data = new FormData();
    data.append("product_img_fl", busImgElement.files[0]);

    imgCheckXhr = new XMLHttpRequest();
    imgCheckXhr.onreadystatechange = function () {
      if (imgCheckXhr.readyState == 4) {
        // console.log(imgCheckXhr.responseText);
        const response = JSON.parse(imgCheckXhr.responseText);
        const status = response[0]["status"];
        const status_text = response[0]["status_text"];

        if (backgroundOverlay) {
          backgroundOverlay.style.display = "none";
        }

        if (status == "product_img error") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("busimg_" + rw_num, "error", status_text);
          if (busImgElement) {
            busImgElement.focus();
            $(busImgElement).val("").trigger("change");
          }
          return false;
        } else {
          if (imgNameElement) {
            imgNameElement.innerHTML = busImgElement.files[0].name;
          }
        }
      }
    };
    imgCheckXhr.open("POST", "templates/direct_transfer/image_check.php", true);
    imgCheckXhr.send(data);
  }
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
function save_details() {
  const categoryInput = $("#category_id")[0];
  if (categoryInput.value === "") {
    $("#errorToast").show();
    return;
  } else {
    $("#errorToast").hide();
  }

  const selectedValues = $(".product_id:checked").map(function () {
    return $(this).val();
  }).get();

  if (selectedValues.length === 0) {
    toastr["error"]("No products selected. Please select at least one product.", "ERROR!!");
    return;
  }

  let save_no = 1;
  clearInputAleart();
  toastr.clear();

  var numberRegex = /^\d+$/;

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
  if (!numberRegex.test(_("#sale_price").value)) {
    toastr["warning"]("Expected Price : Only Number Accepted", "WARNING");
    showInputAlert("sale_price", "warning", "Only Number Accepted");
    _("#sale_price").focus();
    save_no = 0;
    return false;
  }
  if (!/^\d+(\.\d{1,2})?$/.test(_("#sale_price").value)) {
    toastr["warning"](
      "Expected Price: Please enter a valid decimal price (e.g., 123.45)",
      "WARNING"
    );
    showInputAlert(
      "sale_price",
      "warning",
      "Please enter a valid decimal price (e.g., 123.45)"
    );
    _("#sale_price").focus();
    save_no = 0;
    return false;
  }
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


  if (!/^[a-zA-Z0-9,\.\s]+$/.test(_("#description").value)) {
    toastr["warning"](
      "Description : " + "Description should only contain letters, numbers, spaces, commas, and dots",
      "WARNING"
    );
    showInputAlert(
      "description",
      "warning",
      "Description should only contain letters, numbers, spaces, commas, and dots"
    );
    _("#description").focus();
    save_no = 0;
    return false;
  }


  product_img_array = [];
  product_img_file_array = [];

  let rw = 0;
  let d = new Date();


  if (save_no == 1) {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      product_id: selectedValues,
      category_id: categoryInput.value,
      product_name: _("#product_name").value,
      description: _("#description").value,
      brand: _("#brand").value,
      sale_price: _("#sale_price").value,
      baseUrl: baseUrl,
      // address_id: address_id,
    };


    data.append("sendData", JSON.stringify(sendData));
    console.log(sendData);

    let save_data = new XMLHttpRequest();
    save_data.onreadystatechange = function () {
      if (save_data.readyState === 4) {
        _(".background_overlay").style.display = "none";

        if (save_data.status === 200) {
          console.log(save_data.responseText);
          try {
            // Parse the server response
            const response = JSON.parse(save_data.responseText);
            console.log(response);

            const status = response[0]?.status;
            const status_text = response[0]?.status_text;

            // Handle different statuses
            if (status === "SessionDestroy") {
              session_destroy();
              setTimeout(() => window.location.reload(), 5000);
            } else if (status === "NoPermission") {
              toastr["error"](status_text, "ERROR!!");
            } else if (status === "product_name Exist") {
              toastr["error"](status_text, "ERROR!!");
              showInputAlert("product_name", "error", status_text);
              _("#product_name").focus();
            } else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(() => {
                console.log("Reloading the page");
                window.location.reload();
              }, 2000);
              // if (product_img_array.length > 0) {
              //   uploadImageFile(0);
              // } else {
              // }
            }
          } catch (error) {
            console.error("Error parsing response:", error.message);
            toastr["error"]("Invalid response from server", "ERROR!!");
          }
        } else {
          // Handle server errors
          toastr["error"]("Some Server Error Occurred. Please Try Again", "ERROR!!");
        }
      }
    };



    save_data.open("POST", "templates/direct_transfer/save_post_items.php", true);
    save_data.send(data);
  }
}


function save_demand_details() {
  // Ensure required input fields are correctly accessed
  const categoryInput = document.getElementById("category_id");
  const productName = document.getElementById("demand_product_ name").value.trim();
  const description = document.getElementById("demand_description").value.trim();
  const address = document.getElementById("demand_address").value.trim();
  const brandInput = document.getElementById("demand_brand").value.trim();
  const salePriceInput = document.getElementById("demand_sale_price").value.trim();


  const selectedValues = $(".product_id:checked").map(function () {
    return $(this).val();
  }).get();

  if (selectedValues.length === 0) {
    toastr["error"]("No products selected. Please select at least one product.", "ERROR!!");
    return;
  }



  //alert(brandInput);

  // Check for required inputs


  // Prepare product images
  let product_img_array = [];
  let product_img_file_array = [];
  const imageElements = document.getElementsByClassName("image");
  const date = new Date();
  let rw = 0;

  Array.from(imageElements).forEach((imageElement, index) => {
    if (imageElement.files.length > 0) {
      const file = imageElement.files[0];
      const fileExtension = file.name.split(".").pop();
      const fileName = `product_image_${index + 1}_${date.getDate()}-${date.getMonth()}-${date.getFullYear()}-${date.getTime()}.${fileExtension}`;
      product_img_array.push(fileName);
      product_img_file_array.push(file);
      rw++;
    }
  });

  // Validate image upload if no product ID exists
  if (rw === 0 && !document.getElementById("product_id").value) {
    toastr["warning"]("Please Select At Least One Product Image", "WARNING");
    return;
  }

  // Construct the data payload
  const sendData = {
    product_id: selectedValues,
    category_id: categoryInput.value,
    product_name: productName,
    description: description,
    address: address,
    brand: brandInput,
    sale_price: salePriceInput,
    baseUrl: baseUrl,
    product_img_array: product_img_array,
    total_img_rw: rw,
  };

  // Display the overlay
  document.querySelector(".background_overlay").style.display = "block";

  // Prepare FormData
  const data = new FormData();
  data.append("sendData", JSON.stringify(sendData));

  console.log(sendData);
  // AJAX Request
  const save_data = new XMLHttpRequest();
  save_data.onreadystatechange = function () {
    if (save_data.readyState === 4) {
      document.querySelector(".background_overlay").style.display = "none";

      if (save_data.status === 200) {
        const response = JSON.parse(save_data.responseText);
        const status = response[0]["status"];
        const status_text = response[0]["status_text"];

        if (status === "SessionDestroy") {
          session_destroy();
          setTimeout(() => window.location.reload(), 5000);
        } else if (status === "NoPermission") {
          toastr["error"](status_text, "ERROR!!");
        } else if (status === "product_name Exist") {
          toastr["error"](status_text, "ERROR!!");
          showInputAlert("product_name", "error", status_text);
          productNameInput.focus();
        } else {
          toastr["success"](status_text, "SUCCESS!!");
          if (product_img_array.length > 0) {
            uploadImageFile(0);
          } else {
            setTimeout(() => clear_input(), 1000);
          }
        }
      } else {
        toastr["error"]("Some Server Error Occurred. Please Try Again", "ERROR!!");
      }
    }
  };
  save_data.open("POST", "templates/direct_transfer/save_demand_post_items.php", true);
  save_data.send(data);
}


function uploadImageFile(file_num) {
  toastr.clear();
  let file_name = product_img_array[file_num];
  let type = "Product Image " + (file_num + 1);
  let file = product_img_file_array[file_num];

  _(".preloader_inner_text").innerHTML = "Wait For " + type + " Uploading...";
  _(".background_overlay_preloader").style.display = "block";

  let data = new FormData();
  const sendData = {
    file_name: file_name,
    type: type,
  };
  data.append("sendData", JSON.stringify(sendData));
  data.append("uploaded_file", file);

  let fileUploadXHR = new XMLHttpRequest();

  //================== RUN PRELOADER ================//
  fileUploadXHR.upload.addEventListener(
    "progress",
    function (evt) {
      if (evt.lengthComputable) {
        var percentComplete = parseInt((evt.loaded / evt.total) * 100);

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
    if (fileUploadXHR.readyState == 4) {
      // console.log(fileUploadXHR.responseText);
      const response = JSON.parse(fileUploadXHR.responseText);
      const status = response["status"];
      const message = response["message"];

      _(".background_overlay_preloader").style.display = "none";
      _(".preloader_inner_number").innerHTML = 0;

      toastr["success"](message, "SUCCESS!!");
      file_num++;

      if (file_num < product_img_array.length) {
        uploadImageFile(file_num);
      } else {
        setTimeout(function () {
          clear_input();
        }, 2000);
      }
    }
  };
  fileUploadXHR.open(
    "POST",
    "templates/direct_transfer/upload_image_file.php",
    true
  );
  fileUploadXHR.send(data);
}
function update_data(address_id) {
  _(".background_overlay").style.display = "block";
  clear_address_input();
  let data = new FormData();
  const sendData = {

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