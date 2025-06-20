$(document).ready(function () {
  if(selectedCredit!="" && order_id!=""){
    purchaseCredit();
  }
});

function scrollSlotPart(move) {
  if (move == "left") {
    _(".option-div").scrollBy(-250, 0);
  }
  if (move == "right") {
    _(".option-div").scrollBy(250, 0);
  }
}

function showConfirmOption(credit, amnt) {
  _(".confirm-text").innerHTML = "To purchase " + credit + " credit of amount " + amnt + " /-";
  selectedCredit = credit;
  _(".confirm-option-div").style.display = "block";
}

function closeConfirmation(params) {
  _(".confirm-option-div").style.display = "none";
}

function proceed_to_checkout() {
  let execute = 1;

  if (selectedCredit == "") {
    toastr["warning"]("Please select one credit option", "WARNING");
    showInputAlert("credit_option", "warning", "Please select one credit option");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      base_url: baseUrl,
      credit: selectedCredit,
    };

    data.append("sendData", JSON.stringify(sendData));

    let proceedCheckOutXhr = new XMLHttpRequest();
    proceedCheckOutXhr.onreadystatechange = function () {
      if (proceedCheckOutXhr.readyState == 4) {
        console.log(proceedCheckOutXhr.responseText);
        const response = JSON.parse(proceedCheckOutXhr.responseText);
        const status = response[0]['status'];
        const status_text = response[0]['status_text'];
        _(".background_overlay").style.display = "none";
        if (status == "SessionDestroy") {
          session_destroy();
          setTimeout(function () {
            window.location.reload();
          }, 5000);
          return false;
        }
        else if (status == "error") {
          toastr['error'](status_text, "ERROR!!");
          return false;
        }

        else {
          // When Data Save successfully
          window.location.href = status_text;
          return false;
        }

      }
    }
    proceedCheckOutXhr.open('POST', 'templates/credit_addon/proceed_to_checkout_save.php', true);
    proceedCheckOutXhr.send(data);
  }
}

function purchaseCredit(params) {
  let execute = 1;
  clearInputAleart();

  if (selectedCredit == "") {
    toastr["warning"]("Please select one credit option", "WARNING");
    showInputAlert("credit_option", "warning", "Please select one credit option");
    execute = 0;
    return false;
  }
  if (order_id == "") {
    toastr["error"]("At first do payment", "ERROR");
    execute = 0;
    return false;
  }

  if (execute == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();
    const sendData = {
      credit: selectedCredit,
      order_id: order_id,
    };
    data.append("sendData", JSON.stringify(sendData));

    let purchaseXhr = new XMLHttpRequest();
    purchaseXhr.onreadystatechange = function () {
      if (purchaseXhr.readyState == 4) {
        if (purchaseXhr.status === 200) {
          try {
            const response = JSON.parse(purchaseXhr.responseText);
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
              showInputAlert("credit_option", "error", status_text);
            }
            else if (status == "payment error") {
              toastr["error"](status_text, "ERROR!!");
            }
            else {
              toastr["success"](status_text, "SUCCESS!!");
              // redirecting to product list page
              setTimeout(function () {
                window.location.href = baseUrl + "/product_list";
              }, 1000);          
              return false;
            }
          } catch (e) {
            console.error("Parsing error:", e);
            toastr["error"]("Error parsing server response", "ERROR!!");
          }
        } else {
          console.error("Server error:", purchaseXhr.status, purchaseXhr.statusText);
          toastr["error"]("Server error: " + purchaseXhr.statusText, "ERROR!!");
        }
      }
    };
    purchaseXhr.open("POST", "templates/credit_addon/purchase_credit.php", true);
    purchaseXhr.send(data);
  }
}