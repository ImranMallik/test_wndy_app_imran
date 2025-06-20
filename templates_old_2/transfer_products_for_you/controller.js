$(document).ready(function () {
    getTransProductList();
});

function getTransProductList() {
    // Show a preloader
    $("#transfer_products_for_you_list").html(
        '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" alt="Loading..." />'
    );
    $(".background_overlay").css("display", "block");

    // Prepare form data
    const sendData = {
        trans_category_id: $("#trans_category_id").val(), // Use the correct ID
    };

    const data = new FormData();
    data.append("sendData", JSON.stringify(sendData));

    // Create an AJAX request
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Update the list with the response
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

    // Send the request
    xhr.open("POST", "templates/transfer_products_for_you/get_transfer_products_for_you.php", true);
    xhr.send(data);
}

function acceptProduct(sessionUserCode) {
    // Show a loader
    $("#transferredProductList").html(
        '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />'
    );

    // Hide the accept button
    $("#acceptButton").hide();

    // Show background overlay
    $(".background_overlay").css("display", "block");

    // AJAX Request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "templates/direct_transfer/accept_products.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            $(".background_overlay").css("display", "none"); // Hide overlay

            if (xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.status === "success") {
                    alert(response.message);
                    // Reload content or page if needed
                    window.location.reload();
                } else {
                    alert("Error: " + response.message);
                    $("#acceptButton").show(); // Show button back in case of failure
                }
            } else {
                alert("AJAX Request failed with status: " + xhr.status);
                $("#acceptButton").show(); // Show button back in case of failure
            }
        }
    };

    const data = "session_user_code=" + sessionUserCode;

    xhr.send(data);
}

