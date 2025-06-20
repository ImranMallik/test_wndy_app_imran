$(document).ready(function () {
    let selectedCategoryId = null;

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

    $('#continueStep1').click(function () {
        if (selectedCategoryId) {
            showStep(2);
        } else {
            toastr.warning("Please select a category before continuing.", "WARNING");
        }
    });

    $('#continueStep2').click(function (e) {
        e.preventDefault();
        validateStep2();
    });

    $('#backToStep1').click(() => showStep(1));
    $('#backToStep2').click(() => showStep(2));

    /** Step 2 Validation **/
    function validateStep2() {
        let isValid = true;

        const formFields = {
            post_name: $('#postName'),
            description: $('#description'),
            brand: $('#brand'),
            quantity: $('#quantity'),
            price: $('#price')
        };

        let unitChecked = $('input[name="unit"]:checked').val();
        let uploadedImages = $('.image-preview img').length;

        $('.form-control').removeClass('input-error border-danger');
        $('input[name="unit"]').closest('.form-check').removeClass('radio-error');
        $('.image-upload-container').removeClass('input-error');

        Object.values(formFields).forEach(inputField => {
            if (inputField.val().trim() === "") {
                isValid = false;
                inputField.addClass('input-error border-danger');
            }
        });

        // Ensure Quantity and Price are Numeric
        if (!/^\d+$/.test($('#quantity').val().trim())) {
            isValid = false;
            $('#quantity').addClass('input-error border-danger');
            // toastr.error("Quantity must be a numeric value.", "Validation Error");
        }

        if (!/^\d+$/.test($('#price').val().trim())) {
            isValid = false;
            $('#price').addClass('input-error border-danger');
            // toastr.error("Expected Price must be a numeric value.", "Validation Error");
        }

        if (!unitChecked) {
            isValid = false;
            $('input[name="unit"]').closest('.form-check').addClass('radio-error');
        }

        if (uploadedImages === 0) {
            isValid = false;
            $('.image-upload-container').addClass('input-error');
            // toastr.error("Please upload at least one item image.", "Validation Error");
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
    $(document).on("click", ".remove-image", function () {
        let index = $(this).data("index");
        selectedFiles.splice(index, 1); // Remove from array
        $(this).parent().remove(); // Remove from preview
    });



    /** Get All Addresses with Details **/
    function getAddress() {
        $(".background_overlay").show();

        $.ajax({
            type: "POST",
            url: "templates/seller-post/get_all_addresses.php",
            success: function (response) {
                $("#addressList").html(response);
                $(".background_overlay").hide();

                let firstAddress = $(".address-card").first();
                if (firstAddress.length) {
                    firstAddress.addClass("default-selected");
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
            url: "templates/seller-post/edit_address_details.php",
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
    $(document).on("click", ".addAddress", function () {
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
                url: "templates/seller-post/get_category_rate_list.php",
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
                setTimeout(function () {
                    $("#editAddressModal").modal('hide');
                    location.reload();
                }, 10000);
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




    $("#saveAllData").on("click", function (e) {
        e.preventDefault();

        let unitChecked = $('input[name="unit"]:checked').val();
        let formData = new FormData();

        // Append form data fields
        formData.append("item_name", $("#postName").val());
        formData.append("description", $("#description").val());
        formData.append("brand", $("#brand").val());
        formData.append("quantity", $("#quantity").val());
        formData.append("unit", unitChecked);
        formData.append("baseUrl", baseUrl);
        formData.append("category_id", selectedCategoryId);
        formData.append("expected_price", $("#price").val());

        // Get selected address ID
        let selectedAddressId = $("#selected_address_id").val();
        formData.append("address_id", selectedAddressId);
        
          if (!selectedAddressId) {
            toastr.warning("Please add an address before submitting!", "Warning");
            return;
        }

        // Handle image uploads
        // let files = $("#imageUploadInput")[0].files;
        // if (files.length === 0) {
        //     alert("Please upload at least one image!");
        //     return;
        // }
        selectedFiles.forEach((file, index) => {
            formData.append("images[]", file);
            // console.log(`Image ${index + 1}:`, file);
        });

        // console.log("Final FormData object:", formData);

        // console.log()

        let saveButton = $("#saveAllData");
        saveButton.prop("disabled", true).text("Saving...");

        // AJAX request to store data
        $.ajax({
            url: "templates/seller-post/save_details.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "Save") {
                    toastr.success(response.status_text, "Success");
                    $("#imageUploadInput").val("");
                    $(".image-upload-container").empty();
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



});
