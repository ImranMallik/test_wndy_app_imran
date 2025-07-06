// get catagory wise data----------------------------------

function get_demand_post_list_category() {
    const category_id = document.getElementById("category_id").value;

    if (!category_id) {
        document.getElementById("errorToast").style.display = "block";
        return;
    } else {
        document.getElementById("errorToast").style.display = "none";
    }

    console.log(category_id);

    // Show loading spinner
    document.getElementById("product-grid").innerHTML = `
        <img src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" alt="Loading..." style="display: block; margin: 0 auto;">
    `;

    // Send AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "templates/imran_manage_demand_post/manage_demand_post_list.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("product-grid").innerHTML = xhr.responseText;

            const sidebar = document.querySelector('.filterbar');
            sidebar.classList.remove('active');
        } else {
            document.getElementById("product-grid").innerHTML = `
        <div style="text-align: center; color: red;">Failed to load posts. Please try again later.</div>
      `;
        }
    };


    const data = JSON.stringify({ category_id });
    xhr.send(data);
}


function populateEditModal(demandPostId, demandPostName, categoryId, brand, quantity_pcs, quantity_kg) {
    document.getElementById("editDemandPostId").value = demandPostId;
    document.getElementById("editDemandPostName").value = demandPostName;
    document.getElementById("editCategoryId").value = categoryId;
    document.getElementById("editBrand").value = brand;
    document.getElementById('editQuantitypcs').value = quantity_pcs;
    document.getElementById('editQuantitykg').value = quantity_kg;
}



function submitEditForm() {
    const formData = new FormData(document.getElementById("editForm"));
    console.log(formData);

    fetch("templates/manage_demand_post/update_demand_post.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success("Demand post updated successfully!", "SUCCESS!!");

                location.reload();
            } else {
                toastr.error("Failed to update demand post.", "ERROR!!");
            }
        })
        .catch(error => {
            console.error("Error:", error);

        });
}



function delete_alert(demand_post_id) {
    Swal.fire({
        title: "Are You Sure?",
        text: "You Won't Be Able To Revert This!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete It!",
        confirmButtonClass: "confirm_btn",
        cancelButtonClass: "cancel_btn",
    }).then(function (result) {
        if (result.isConfirmed) {
            delete_demand_data(demand_post_id);
        }
    });
}


function delete_demand_data(demand_post_id) {
    if (demand_post_id > 0) {
        _(".background_overlay").style.display = "block";

        let data = new FormData();
        const sendData = {
            demand_post_id: demand_post_id,
        };

        console.log(sendData);
        data.append("sendData", JSON.stringify(sendData));

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                _(".background_overlay").style.display = "none";
                toastr["success"]("Data Deleted Successfully.", "SUCCESS!!");
                setTimeout(function () {
                    window.location.reload();
                }, 1500);
            }
        };
        xhr.open("POST", "templates/manage_demand_post/delete_demand_post.php", true);
        xhr.send(data);
    } else {
        toastr["error"](
            "You Don't Have Permission To Delete Any Data !!",
            "ERROR!!"
        );
    }
}






// Function to show confirmation alert before deletion




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
            baseUrl: baseUrl,
        };
        data.append("sendData", JSON.stringify(sendData));

        let viewXhr = new XMLHttpRequest();
        viewXhr.onreadystatechange = function () {
            if (viewXhr.readyState == 4) {
                if (viewXhr.status === 200) {
                    try {
                        // console.log(viewXhr.responseText);

                        const response = JSON.parse(viewXhr.responseText);
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
                        else if (status == "balance error") {
                            toastr["error"](status_text, "ERROR!!");
                            setTimeout(function () {
                                window.location.href = baseUrl + "/credit_addon";
                            }, 2000);
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
                    console.error("Server error:", viewXhr.status, viewXhr.statusText);
                    toastr["error"]("Server error: " + viewXhr.statusText, "ERROR!!");
                }
            }
        };
        viewXhr.open("POST", "templates/product-details/buyer_view_product.php", true);
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
        assignXhr.open("POST", "templates/product-details/buyer_assign_collector.php", true);
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
        xhr.open("POST", "templates/product-details/buyer_send_request.php", true);
        xhr.send(data);
    }
}

function buyerAcceptPrice() {
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
        xhr.open("POST", "templates/product-details/buyer_accept_price.php", true);
        xhr.send(data);
    }
}

function buyerPickupComplete(view_id) {
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
        xhr.open("POST", "templates/product-details/buyer_pickup_complete.php", true);
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
        xhr.open("POST", "templates/product-details/buyer_save_ratings.php", true);
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
        xhr.open("POST", "templates/product-details/seller_send_request.php", true);
        xhr.send(data);
    }
}

function sellerAcceptPrice(view_id) {
    _("#pickup_date").value = "";
    _("#pickup_view_id").value = view_id;
    $("#pickup_schedule_modal").modal('show');
}

function updatePickupDate() {
    let execute = 1;
    clearInputAleart();

    if (!_("#pickup_date").checkValidity()) {
        toastr['warning']("Pickup Date : " + _("#pickup_date").validationMessage, "WARNING");
        showInputAlert('pickup_date', 'warning', _("#pickup_date").validationMessage);
        _("#pickup_date").focus();
        execute = 0;
        return false;
    }
    if (!_("#pickup_time").checkValidity()) {
        toastr['warning']("Pickup Time : " + _("#pickup_time").validationMessage, "WARNING");
        showInputAlert('pickup_time', 'warning', _("#pickup_time").validationMessage);
        _("#pickup_time").focus();
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
            view_id: _("#pickup_view_id").value,
            pickup_date: _("#pickup_date").value,
            pickup_time: _("#pickup_time").value,
        };
        data.append("sendData", JSON.stringify(sendData));

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status === 200) {
                    try {
                        // console.log(xhr.responseText);
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
        xhr.open("POST", "templates/product-details/seller_update_pickup_date.php", true);
        xhr.send(data);
    }
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
        xhr.open("POST", "templates/product-details/seller_close_product.php", true);
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
        xhr.open("POST", "templates/product-details/seller_save_ratings.php", true);
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

// function update_details(demand_post_id) {
//     if (demand_post_id > 0) {
//         document.querySelector(".background_overlay").style.display = "block";

//         // Get values from input fields
//         const productName = document.querySelector("#product_name").value;
//         const description = document.querySelector("#description").value;
//         const brand = document.querySelector("#brand").value;
//         const salePrice = document.querySelector("#sale_price").value;

//         // Create FormData object to send data
//         let data = new FormData();
//         const sendData = {
//             demand_post_id: demand_post_id,
//             productName: productName,
//             description: description,
//             brand: brand,
//             salePrice: salePrice
//         }
//         data.append("sendData", JSON.stringify(sendData));

//         console.log(sendData);

//         let xhr = new XMLHttpRequest();
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === 4) {
//                 document.querySelector(".background_overlay").style.display = "none";

//                 if (xhr.status === 200) {
//                     console.log("Server response:", xhr.responseText);
//                     toastr["success"](status_text, "SUCCESS!!");
//                     setTimeout(function () {
//                         window.location.reload();
//                     }, 1500);
//                     return false;
//                 } else {
//                     console.error("Error updating data:", xhr.responseText);
//                     toastr["error"](status_text, "ERROR!!");
//                 }
//             }
//         };
//         // Send POST request to the server
//         xhr.open('POST', 'templates/manage_demand_post/edit_demand_post.php', true);
//         xhr.send(data);
//     } else {
//         toastr.error("You Don't Have Permission To Update Any Data !!", "ERROR!!");
//     }
// }

function createPost() {
    // alert();
    window.location.href = `${baseUrl}/demand_post_new`;
}
