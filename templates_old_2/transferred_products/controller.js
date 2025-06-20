$(document).ready(function () {
    $("#transferred_category_id").val("");
    getTransferredProductList();

});
function getTransferredProductList() {
    _("#transferred_products_list").innerHTML =
        '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
        category_id: $("#category_id").val(),
    };
    data.append("sendData", JSON.stringify(sendData));
    
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            $("#transferred_products_list").html(xhr.responseText);
            $(".background_overlay").css("display", "none");
        }
    };
    xhr.onerror = function () {
        console.error("An error occurred during the request.");
        $("#transferred_products_list").html(
            '<p style="color: red;">Failed to load products. Please try again later.</p>'
        );

        $(".background_overlay").css("display", "none");
    };
    xhr.open(
        "POST",
        "templates/transferred_products/get_transfered_product_list.php",
        true
    );
    xhr.send(data);
}

function fetchTransferCategory() {
    const categoryDropdown = _("#transferred_category_id");

    // Show loading indicator
    categoryDropdown.innerHTML = `
        <option value="" disabled selected>Loading...</option>
    `;

    // Show background overlay (if applicable)
    _(".background_overlay").style.display = "block";

    // Prepare data
    let data = new FormData();
    const sendData = {};
    data.append("sendData", JSON.stringify(sendData));

    // Initialize and send XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            _(".background_overlay").style.display = "none"; // Hide overlay

            if (xhr.status === 200) {
                // Populate dropdown with response
                categoryDropdown.innerHTML = xhr.responseText;
            } else {
                console.error("Failed to fetch category:", xhr.statusText);
                categoryDropdown.innerHTML = `
                    <option value="" disabled selected>Error loading categories</option>
                `;
            }
        }
    };

    xhr.open("POST", "templates/transferred_products/get_transfered_category.php", true);
    xhr.send(data);
}
