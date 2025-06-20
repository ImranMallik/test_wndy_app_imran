$(document).ready(function () {
    // get_demand_post_list();
    // alert();
});

function get_demand_post_list() {

    $("#demand_post_list").html(
        '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />'
    );
    $(".background_overlay").css("display", "block");

    let data = new FormData();
    const sendData = {
        category_id: $("#category_id").val(),
    };

    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // On success, insert the fetched data into the demand_post_list div
            $("#demand_post_list").html(xhr.responseText);
            $(".background_overlay").css("display", "none");
        } else if (xhr.readyState == 4 && xhr.status != 200) {
            // Handle error in case of a failed request
            console.error("Failed to load posts.");
            $("#demand_post_list").html(
                '<p style="color: red;">Failed to load posts. Please try again later.</p>'
            );
            $(".background_overlay").css("display", "none");
        }
    };

    xhr.onerror = function () {
        console.error("An error occurred during the request.");
        $("#demand_post_list").html(
            '<p style="color: red;">An error occurred. Please try again later.</p>'
        );
        $(".background_overlay").css("display", "none");
    };

    xhr.open("POST", "templates/demand_post/demand_post_list.php", true);
    xhr.send(data);
}


function delete_alert(demand_post_id, event) {
    event.preventDefault();
    console.log(demand_post_id);

    Swal.fire({
        title: 'Are you sure?', text: 'You won\'t be able to revert this!', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, delete it!', customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger' }
    }).then(function (result) {
        if (result.isConfirmed) {
            delete_data(demand_post_id);
        }
    });
}

function delete_data(demand_post_id) {
    console.log("Post ID to delete:", demand_post_id);

    if (demand_post_id > 0) {
        document.querySelector(".background_overlay").style.display = "block";

        let data = new FormData();
        const sendData = { demand_post_id: demand_post_id };
        console.log("Data being sent:", sendData);
        data.append("sendData", JSON.stringify(sendData));

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                document.querySelector(".background_overlay").style.display = "none";

                if (xhr.status === 200) {
                    console.log("Server response:", xhr.responseText);
                    toastr.info("Data Deleted Successfully.", "SUCCESS!!");

                    // Reload the browser after success
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    console.error("Error deleting data:", xhr.responseText);
                    toastr.error("Failed to delete data. Please try again.", "ERROR!!");
                }
            }
        };

        xhr.open('POST', 'templates/demand_post/delete_data.php', true);
        xhr.send(data);
    } else {
        toastr.error("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
    }
}

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
        toastr["warning"]("Please select a valid   ", "WARNING");
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
    // alert();
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



// Demand Post Add
let selectedCategoryId = "";
    let selectedProductId = "";

    function storeCategoryAndProduct() {
        const selectElement = document.getElementById('category_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        selectedCategoryId = selectedOption.value;
        selectedProductId = selectedOption.getAttribute('data-product-id');
    }



    function save_demand_details() {

        let save_no = 1;
        clearInputAleart();
        toastr.clear();

        var numberRegex = /^\d+$/;
        if (!_("#demand_product_name").checkValidity()) {
            toastr["warning"](
                "demand_product_name: " + _("#demand_product_name").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_product_name",
                "warning",
                _("#demand_product_name").validationMessage
            );
            _("#demand_product_name").focus();
            save_no = 0;
            return false;
        }

        if (!_("#demand_description").checkValidity()) {
            toastr["warning"](
                "demand_description: " + _("#demand_description").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_description",
                "warning",
                _("#demand_description").validationMessage
            );
            _("#demand_product_name").focus();
            save_no = 0;
            return false;
        }
        if (!_("#demand_brand").checkValidity()) {
            toastr["warning"](
                "demand_brand: " + _("#demand_brand").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_brand",
                "warning",
                _("#demand_brand").validationMessage
            );
            _("#demand_product_name").focus();
            save_no = 0;
            return false;
        }
        if (!_("#demand_sale_price").checkValidity()) {
            toastr["warning"](
                "demand_sale_price: " + _("#demand_sale_price").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_sale_price",
                "warning",
                _("#demand_sale_price").validationMessage
            );
            _("#demand_sale_price").focus();
            save_no = 0;
            return false;
        }
        if (!_("#demand_sale_price").checkValidity()) {
            toastr["warning"](
                "demand_sale_price: " + _("#demand_sale_price").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_sale_price",
                "warning",
                _("#demand_sale_price").validationMessage
            );
            _("#demand_sale_price").focus();
            save_no = 0;
            return false;
        }
       

        if (!_("#demand_quantity").checkValidity()) {
            toastr["warning"](
                "demand_quantity: " + _("#demand_quantity").validationMessage,
                "WARNING"
            );
            showInputAlert(
                "demand_quantity",
                "warning",
                _("#demand_quantity").validationMessage
            );
            _("#demand_quantity").focus();
            save_no = 0;
            return false;
        }

        const formData = new FormData(document.getElementById('demandForm'));
        console.log(formData);
        const qtyType = document.querySelector('input[name="qty_type"]:checked');
        formData.append('category_id', selectedCategoryId);
        formData.append('product_id', selectedProductId);
        if (qtyType) {
            formData.append('qty_type', qtyType.value);
        } else {
            toastr["warning"]("Please select a quantity type (kg or pcs).", "WARNING");
            return; // Prevent the fetch call if qty_type is not selected
        }
        fetch('templates/demand_post/save_demand_details.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                
                if (data.success) {
                    toastr["success"](
                        "Demand post saved successfully!",
                        "Success"
                    );
                    save_notification_details();
                    // console.log(data.demand_post_id);
                    document.getElementById('demandForm').reset();
                } else {
                    alert('Error saving demand post: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the demand post.');
            });
    }

    function save_notification_details() {
        const nextId = document.getElementById('nextDemandId').value;
        // Prepare notification data
        const notificationData = {
            title: "New Demand Post Created",
            details: "A new demand post has been created",
            notification_url: "demand_post_details/" + nextId,
            from_user_id: "<?php echo $session_user_code; ?>",
            entry_user_code: "<?php echo $session_user_code; ?>"
        };

        console.log("Sending Notification Data:", notificationData);


        fetch('templates/demand_post/save_notification_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(notificationData),
            })
            .then(response => response.json()) // Automatically parse JSON
            .then(data => {
                console.log('Server Response:', data);
                // alert(data.message); // Show success message
            })
            .catch(error => {
                console.error('Fetch error:', error.message);
                alert('Failed to send data');
            });






    }




