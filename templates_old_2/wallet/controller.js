$(document).ready(function () {
    $("#addCredit").click(function () {
        var amount = $("#creditAmount").val().trim();
        amount = parseFloat(amount); // Convert input to float

        // Debugging: Check amount before sending
        // console.log("Amount to send:", amount);

        if (isNaN(amount) || amount <= 0) {
            $("#creditAmount").css("border", "1px solid red");
            $("#responseMessage").html("<p style='color: red;'>Please enter a valid amount!</p>");
            return;
        } else {
            $("#creditAmount").css("border", ""); 
            $("#responseMessage").html(""); 
        }

        $.ajax({
            url: "templates/wallet/add_credit.php",
            type: "POST",
            data: { amount: amount },
            dataType: "json", 
            success: function (response) {

                if (response.status  === "success") {
                    $("#responseMessage").html("<p style='color: green;'>Credit added successfully!</p>");
                    
                   
                    $("#creditAmount").val("").css("border", "");

                    
                    updateWalletBalance();

                    
                    setTimeout(function () {
                        $("#responseMessage").fadeOut();
                    }, 3000);
                } else {
                    $("#responseMessage").html("<p style='color: red;'>" + response + "</p>");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", status, error);
                console.log("Server Response:", xhr.responseText);
                $("#responseMessage").html("<p style='color: red;'>Error adding credit.</p>");
            }
        });
    });

    
    function updateWalletBalance() {
        $.ajax({
            url: "templates/wallet/get_balance.php",
            type: "GET",
            success: function (response) {
                let balanceColor = (response === 0.00) ? "red" : "black"; 
                $("#walletBalance").html("Rs " + response).css("color", balanceColor);
            },
            error: function () {
                console.log("Error fetching wallet balance.");
            }
        });
    }

 
    updateWalletBalance();
});


function setAmount(value) {
    $("#creditAmount").val(value);
}



