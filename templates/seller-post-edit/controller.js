$(document).ready(function () {
    let selectedCategoryId = $('#selectedCategory').val();

    /** Step Navigation **/
    function showStep(step) {
        $('#step1, #step2, #step3').addClass('d-none');
        $('#step' + step).removeClass('d-none');
    }

    $('.category-item').click(function () {
        $('.category-item').removeClass('active');
        $(this).addClass('active');
        selectedCategoryId = $(this).attr('data-category');
    });

$('#continueStep1').click(function (e) {
    e.preventDefault();
    // alert();

    if (selectedCategoryId) {
        let category_id = selectedCategoryId;
        let productId = $("#product_id").val();
        console.log(category_id,productId);

        $.ajax({
            url: "templates/seller-post-edit/step1_save_category.php",
            type: "POST",
            data: { category_id: category_id, product_id: productId },
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            processData: true,
            dataType: 'json',
            success: function (response) {
                console.log(response); // Add this line to debug the response
                if (response.status === "DraftUpdated") {
                    draftPostId = response.post_id;
                    showStep(2); // Proceed to the next step
                } else {
                    toastr.error(response.status_text, "Error");
                }
            },
            error: function () {
                toastr.error("Something went wrong at Step 1", "Error");
            }
        });
    } else {
        toastr.warning("Please select a category.", "Warning");
    }
});



    $('#continueStep2').click(function (e) {
        e.preventDefault();
        validateStep2();
    });
    
//     $('#continueStep2').click(function (e) {
//         // alert();
//     e.preventDefault();

//     let isValid = validateStep2(); // First validate

//     if (isValid) {
//         let formData = new FormData();
//         formData.append("post_id", draftPostId);
//         formData.append("product_id", $("#product_id").val());
//         formData.append("item_name", $("#postName").val());
//         formData.append("description", $("#description").val());
//         formData.append("brand", $("#brand").val());
//         formData.append("price", $("#price").val());
//         formData.append("quantity", $("#quantity").val());
//         formData.append("unit", $('input[name="unit"]:checked').val());
//         formData.append("baseUrl", baseUrl);
//         formData.append("category_id", selectedCategoryId);
//         formData.append("expected_price", $("#price").val());

//         selectedFiles.forEach((file, index) => {
//             formData.append("images[]", file);
//         });

//         console.log("Submitting FormData:");
//         for (var pair of formData.entries()) {
//             console.log(pair[0] + ':', pair[1]);
//         }

//         $.ajax({
//             url: "templates/seller-post-edit/step2_save_item_details.php",
//             type: "POST",
//             data: formData,
//             contentType: false,
//             processData: false,
//             dataType: 'json',
//             success: function (response) {
//                 if (response.status === "DraftUpdated") {
//                     showStep(3);
//                     getAddress();
//                 } else {
//                     toastr.error(response.status_text || "Error while saving item details.", "Error");
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error("AJAX Error:", error);
//                 toastr.error("Something went wrong during Step 2 Save.", "Error");
//             }
//         });
//     } else {
//         // toastr.warning("Please fill all required fields properly before continuing.", "Validation Warning");
//     }
// });


function autoSaveSingleField(fieldName, value) {
    const formData = new FormData();
    formData.append("post_id", draftPostId); // This is the draft post ID
    formData.append("product_id", $("#product_id").val()); // Pass the product_id as well
    formData.append(fieldName, value);

    $.ajax({
        url: "templates/seller-post-edit/part_darft_edit.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === "DraftUpdated") {
                console.log(fieldName + " saved.");
            } else {
                console.warn("Failed to save:", response.status_text);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error saving " + fieldName + ":", error);
        }
    });
}


function autoSaveImageField(fieldName, selectedFiles) {
      const formData = new FormData();
      const productId = $("#product_id").val();
    formData.append("product_id", productId);

    selectedFiles.forEach((file, index) => {
        formData.append(fieldName + '[]', file);
        // console.log(`Image ${index + 1}:`, file);
    });

    $.ajax({
        url: "templates/seller-post-edit/part_darft_edit.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === "ImagesSaved") {
                console.log("Images saved successfully.");
                // Optional image preview
                selectedFiles.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = $('<img>').attr('src', e.target.result).css({
                            width: '60px',
                            height: '60px',
                            marginRight: '10px',
                            objectFit: 'cover',
                            border: '1px solid #ddd',
                            borderRadius: '4px'
                        });
                        $('.image-upload-container').append(img);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                console.warn("Image upload failed:", response.status_text);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error uploading images:", error);
        }
    });
}

        $('#imageUploadInput').on('change', function () {
    const selectedFiles = Array.from(this.files); 
    if (selectedFiles.length > 0) {
        autoSaveImageField('images', selectedFiles);
    }
});


$('#postName').on('keyup change', function () {
    autoSaveSingleField('item_name', $(this).val());
});

 $('#description').on('keyup change', function () {
            autoSaveSingleField('description', $(this).val());
            
        });
           $('#brand').on('keyup change', function () {
            autoSaveSingleField('brand', $(this).val());
        });
        
        
           $('#quantityPcs').on('keyup change',function(){
          autoSaveSingleField('quantityPcs', $(this).val());
        });
        
$('#quantityKg').on('keyup change', function () {
    autoSaveSingleField('quantityKg', $(this).val());
});

        $('#quantity').on('keyup change', function () {
            autoSaveSingleField('quantity', $(this).val());
        });

        $('#price').on('keyup change', function () {
            autoSaveSingleField('price', $(this).val());
            autoSaveSingleField('expected_price', $(this).val());
        });

        // Radio buttons (unit)
        $('input[name="unit"]').on('change', function () {
            autoSaveSingleField('unit', $('input[name="unit"]:checked').val());
        });
    
    

    /** Numeric Input Restriction for Quantity & Price **/
    $('#quantity, #price ,#quantityKg ,#quantityPcs').on('input', function () {
        let value = $(this).val();
        if (!/^\d*$/.test(value)) {
            $(this).val(value.replace(/\D/g, ''));
            $(this).addClass('border-danger');
            // toastr.warning("Only numeric values are allowed.", "Validation Warning");
        } else {
            $(this).removeClass('border-danger');
        }
    });



    $('#backToStep1').click(() => showStep(1));
    $('#backToStep2').click(() => showStep(2));

    
   function validateStep2() {
    let isValid = true;

    const formFields = {
        postName: $('#postName'),
        description: $('#description'),
        price: $('#price')
    };

    const quantityKg = $('#quantityKg');
    const uploadedImages = $('.image-preview img').length;

    // Clear previous errors
    $('.form-control').removeClass('input-error border-danger');
    $('.image-upload-container').removeClass('input-error');

    // Validate required text fields
    for (const key in formFields) {
        if (formFields[key].val().trim() === "") {
            isValid = false;
            formFields[key].addClass('input-error border-danger');
        }
    }

    // Validate quantity in kgs
    const qtyKgVal = quantityKg.val().trim();
    if (qtyKgVal === "" || !/^\d+(\.\d+)?$/.test(qtyKgVal)) {
        isValid = false;
        quantityKg.addClass('input-error border-danger');
    }

    // Validate price (numeric)
    const priceVal = $('#price').val().trim();
    if (!/^\d+(\.\d+)?$/.test(priceVal)) {
        isValid = false;
        $('#price').addClass('input-error border-danger');
    }

    // Validate at least one image is uploaded
    if (uploadedImages === 0) {
        isValid = false;
        $('.image-upload-container').addClass('input-error');
    }

     if (isValid) {
            showStep(3);
            getAddress();
        }
}

    /** Numeric Input Restriction for Quantity & Price **/
    $('#quantity, #price').on('input', function () {
        let value = $(this).val();
        if (!/^\d*$/.test(value)) {
            $(this).val(value.replace(/\D/g, ''));
            $(this).addClass('border-danger');
            // toastr.warning("Only numeric values are allowed.", "Validation Warning");
        } else {
            $(this).removeClass('border-danger');
        }
    });

    /** Handle Image Upload **/

    let selectedFiles = [];

    // Handle image selection and preview
    // $('#imageUploadInput').on('change', function (event) {
    //     const files = event.target.files;
    //     const container = $('.image-upload-container');

    //     if (files.length > 0) {
    //         Array.from(files).forEach((file, index) => {
    //             if (!file.type.startsWith("image/")) {
    //                 // alert("Only image files are allowed!");
    //                 return;
    //             }

    //             const reader = new FileReader();
    //             reader.onload = function (e) {
    //                 const imageDiv = $(`
    //                     <div class="position-relative image-preview">
    //                         <img src="${e.target.result}" class="img-fluid rounded-15" style="max-width: 80px; height: 80px;">
    //                         <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 rounded-circle remove-image" data-index="${selectedFiles.length}">
    //                             <i class="bi bi-x"></i>
    //                         </button>
    //                     </div>
    //                 `);
    //                 container.prepend(imageDiv);
    //             };
    //             reader.readAsDataURL(file);

    //             selectedFiles.push(file); // Store file in array
    //         });
    //     }
    // });

    // Add Image Compression
    $('#imageUploadInput').on('change', function (event) {
        const files = event.target.files;
        const container = $('.image-upload-container');

        if (files.length > 0) {
            Array.from(files).forEach((file, index) => {
                if (!file.type.startsWith("image/")) {
                    return;
                }

                // Compress image before adding it to selectedFiles
                compressImage(file, function (compressedFile) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imageDiv = $(`
                            <div class="position-relative image-preview">
                                <img src="${e.target.result}" class="img-fluid rounded-15" style="max-width: 80px; height: 80px;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 rounded-circle remove-image" data-index="${selectedFiles.length}">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        `);
                        container.prepend(imageDiv);
                    };
                    reader.readAsDataURL(compressedFile);

                    // Store compressed file in selectedFiles
                    selectedFiles.push(compressedFile);
                });
            });
        }
    });

    // Compress image using JavaScript
    // Function to compress images before upload
    function compressImage(file, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function (event) {
            const img = new Image();
            img.src = event.target.result;

            img.onload = function () {
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                const MAX_WIDTH = 800;
                const MAX_HEIGHT = 800;
                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(
                    function (blob) {
                        const compressedFile = new File([blob], file.name, {
                            type: "image/jpeg",
                            lastModified: Date.now(),
                        });
                        callback(compressedFile);
                    },
                    "image/jpeg",
                    0.7
                );
            };
        };
    }

    // Remove selected image
    // $(document).on("click", ".remove-image", function () {
    //     let index = $(this).data("index");
    //     selectedFiles.splice(index, 1); // Remove from array
    //     $(this).parent().remove(); // Remove from preview
    // });



    /** Get All Addresses with Details **/
    function getAddress() {
        $(".background_overlay").show();
        let selectedAddressId = $("#address_id").val();
        $.ajax({
            type: "POST",
            url: "templates/seller-post-edit/get_all_addresses.php",
            data: { selected_address_id: selectedAddressId },
            success: function (response) {
                $("#addressList").html(response);
                $(".background_overlay").hide();

                let firstAddress = $(".address-card").first();
                if (firstAddress.length) {
                    // firstAddress.addClass("default-selected");
                    firstAddress.find(".default-text").show();
                    let defaultAddressId = firstAddress.attr("data-address-id");
                    $("#selected_address_id").val(defaultAddressId);
                }
            },
            error: function () {
                toastr.error("Failed to load addresses.", "Error");
                $(".background_overlay").hide();
            }
        });
    }

    /** Select Another Address **/
    $(document).on("click", ".address-card", function () {
        $(".address-card").removeClass("selected default-selected");
        $(".default-text").hide();

        $(this).addClass("selected");
        let selectedAddressId = $(this).attr("data-address-id");
        // alert(selectedAddressId);
        $("#selected_address_id").val(selectedAddressId);

        let firstAddress = $(".address-card").first();
        if ($(this).is(firstAddress)) {
            $(this).addClass("default-selected");
            $(this).find(".default-text").show();
        }
    });

    /** Edit Address Modal with Data **/
    $(document).on("click", ".edit-address-btn", function () {
        let addressId = $(this).data("address-id");

        $.ajax({
            type: "POST",
            url: "templates/seller-post-edit/edit_address_details.php",
            data: { address_id: addressId },
            success: function (response) {
                let data = JSON.parse(response);

                $("#edit_address_id").val(data.address_id);
                $("#edit_address_id").val(data.address_id);
                $("#edit_address_name").val(data.address_name);
                $("#edit_contact_name").val(data.contact_name);
                $("#edit_contact_phone").val(data.contact_ph_num);
                $("#edit_country").val(data.country);
                $("#edit_state").val(data.state);
                $("#edit_city").val(data.city);
                $("#edit_pincode").val(data.pincode);
                $("#edit_landmark").val(data.landmark);
                $("#edit_address_line").val(data.address_line_1);

                $("#editAddressModalLabel").text("Edit Address");
                $("#saveAddressBtn").text("Update Address");

                $("#editAddressModal").modal("show");
            },
            error: function () {
                toastr.error("Failed to load address details.", "Error");
            }
        });
    });

    /** Add New Address Using the Same Modal **/
    $(document).on("click", ".addAddress", function (e) {
 e.preventDefault();
        $("#edit_address_id").val("");
        $("#edit_address_name").val("");
        $("#edit_contact_name").val("");
        $("#edit_contact_phone").val("");
        $("#edit_country").val("");
        $("#edit_state").val("");
        $("#edit_city").val("");
        $("#edit_pincode").val("");
        $("#edit_landmark").val("");
        $("#edit_address_line").val("");

        $("#editAddressModalLabel").text("Add New Address");
        $("#saveAddressBtn").text("Add Address");

        $("#editAddressModal").modal("show");
    });

    // rate details 
    $("#viewRateListBtn").on("click", function () {
        fetchCategoryWiseRateList();
    });

    const fetchCategoryWiseRateList = async () => {
        try {
            // Show loading overlay
            $(".background_overlay").show();

            // Get category ID value
            if (!selectedCategoryId) {
                alert("Please select a category.");
                $(".background_overlay").hide();
                return;
            }


            const data = new FormData();
            data.append("sendData", JSON.stringify({ category_id: selectedCategoryId }));


            $.ajax({
                url: "templates/seller-post-edit/get_category_rate_list.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {

                    $("#exampleModal .modal-body").html(response);
                    $("#exampleModal").modal("show");
                },
                error: function (xhr) {
                    console.error("Error fetching data:", xhr.statusText);
                },
                complete: function () {

                    $(".background_overlay").hide();
                }
            });

        } catch (error) {
            console.error("Error:", error);
            $(".background_overlay").hide();
        }
    };

    // Submit Data Address And Update

    $("#saveAddressBtn").on('click', function (e) {
        e.preventDefault();
        let isValid = true;
        // Remove previous error styles
        $('.form-control').removeClass('is-invalid');
        $("#editAddressForm .form-control[required]").each(function () {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            }
        });

        if (!isValid) {
            return;
        }

        // Proceed with AJAX request
        let formData = {
            address_id: $("#edit_address_id").val(),
            address_name: $("#edit_address_name").val(),
            contact_name: $("#edit_contact_name").val(),
            contact_phone: $("#edit_contact_phone").val(),
            country: $("#edit_country").val(),
            state: $("#edit_state").val(),
            city: $("#edit_city").val(),
            pincode: $("#edit_pincode").val(),
            landmark: $("#edit_landmark").val(),
            address_line: $("#edit_address_line").val()
        };

        console.log(formData);

        $.ajax({
            url: 'templates/address-book/new_save_address_details.php',
            type: 'POST',
            data: JSON.stringify({ sendData: formData }),
            contentType: 'application/json',
            success: function (response) {
                toastr.success("Address updated successfully!", "Success");
                $("#editAddressForm")[0].reset();
                $("#editAddressModal").modal('hide');
                getAddress();
                
                // setTimeout(function () {
                //     $("#editAddressModal").modal('hide');
                //     location.reload();
                // }, 10000);
                

            },
            error: function (error) {
                toastr.error("Something went wrong! Please try again.", "Error");
            }
        });
    });

    // Remove red border when user types
    $(".form-control").on("input", function () {
        if ($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
        }
    });




    $("#updateAllData").on("click", function (e) {
        e.preventDefault();

        let unitChecked = $('input[name="unit"]:checked').val();
        let formData = new FormData();
        let productId = $("#product_id").val();
        formData.append("product_id", productId);

        // Append form data fields
        formData.append("item_name", $("#postName").val());
        formData.append("description", $("#description").val());
        formData.append("brand", $("#brand").val());
        // formData.append("quantity", $("#quantity").val());
        // formData.append("unit", unitChecked);
        formData.append("baseUrl", baseUrl);
        formData.append("category_id", selectedCategoryId);
        formData.append("expected_price", $("#price").val());

        // Get selected address ID
        let selectedAddressId = $("#selected_address_id").val();
        formData.append("address_id", selectedAddressId);
        formData.append("quantity_pcs", $("#quantityPcs").val());
            formData.append("quantity_kg", $("#quantityKg").val());

       
        selectedFiles.forEach((file, index) => {
            formData.append("images[]", file);
            // console.log(`Image ${index + 1}:`, file);
        });
     

        let saveButton = $("#saveAllData");
        saveButton.prop("disabled", true).text("Saving...");

        // AJAX request to store data
        $.ajax({
            url: "templates/seller-post-edit/save_details.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // console.log("Server Response:", response); // Debugging log

                if (response.status === "Save" || response.status === "Updated") {
                    toastr.success(response.status_text, "Success");

                    // Reset image inputs
                    $("#imageUploadInput").val("");
                    $(".image-upload-container").empty();
                    // Redirect after success
                    window.location.href = baseUrl + "/product_list";
                } else {
                    toastr.error("Error: " + response.status_text, "Error");
                }
            },

            error: function (xhr, status, error) {

                toastr.error("Something went wrong. Please try again.", "Error");
            },
            complete: function () {
                // Re-enable the button and reset text
                saveButton.prop("disabled", false).text("Save");
            }
        });
    });
    
    
    // remove image alert 
    
$(document).on("click", ".remove-image", function (e) {
  e.preventDefault();
  e.stopPropagation();

  const $button = $(this);
  const imageContainer = $button.closest(".image-preview");
  const imageName = $button.data("image");
  const imageIndex = $button.data("index");

swal({
  title: "Remove Image?",
  text: "Do you want to remove this image from your post?",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn btn-danger border-none confirm_btn",
  cancelButtonClass: "btn btn-secondary border-none cancel_btn",
  confirmButtonText: "Yes, Remove!",
  cancelButtonText: "No, Keep it",
  closeOnConfirm: false, 
}, function (isConfirm) {
  if (isConfirm) {
    
    $.ajax({
      url: "templates/seller-post-edit/delete_image.php",
      type: "POST",
      data: { image_name: imageName },
      success: function (response) {
        const res = JSON.parse(response);
        if (res.status === "success") {
          imageContainer.remove();

          if (typeof selectedFiles !== "undefined" && imageIndex !== undefined) {
            selectedFiles.splice(imageIndex, 1);
          }
            swal.close();
          toastr.success(res.message);
        } else {
          toastr.error(res.message || "Failed to delete image.");
        }
      },
      error: function () {
        toastr.error("Server error while deleting image.");
      }
    });
  }
});

});








});
