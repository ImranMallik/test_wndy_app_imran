function clear_input() {
  _("#contact_name").value = "";
  _("#contact_ph_num").value = "";
  _("#address_name").value = "";
  _("#country").value = "";
  _("#state").value = "";
  _("#city").value = "";
  _("#landmark").value = "";
  _("#pincode").value = "";
  _("#address_line_1").value = "";
  _("#default_address").checked = false;

  clearInputAleart();
}

function reload_table() {
  $("#data_table").DataTable().ajax.reload();
}

function save_details() {
  let save_no = 1;
  clearInputAleart();

  var numberRegex = /^\d+$/;

  if (!_("#contact_name").checkValidity()) {
    toastr["warning"]("Name : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("contact_name", "warning", "Field Cannot be Empty");
    _("#contact_name").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z\s]+$/.test(_("#contact_name").value)) {
    toastr["warning"]("Contact Name : " + "Invalid Name Format", "WARNING");
    showInputAlert("contact_name", "warning", "Invalid Name Format");
    _("#contact_name").focus();
    save_no = 0;
    return false;
  }
  if (!_("#contact_ph_num").checkValidity()) {
    toastr["warning"]("Phone Number : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("contact_ph_num", "warning", "Field Cannot be Empty");
    _("#contact_ph_num").focus();
    save_no = 0;
    return false;
  }
  if (!/^\d+$/.test(_("#contact_ph_num").value)) {
    toastr["warning"]("Phone Number : Invalid Phone Number", "WARNING");
    showInputAlert("contact_ph_num", "warning", "Invalid Phone Number");
    _("#contact_ph_num").focus();
    save_no = 0;
    return false;
  }
  if (_("#contact_ph_num").value.length < 10) {
    toastr["warning"]("Phone Number : Invalid Phone Number", "WARNING");
    showInputAlert("contact_ph_num", "warning", "Invalid Phone Number");
    _("#contact_ph_num").focus();
    save_no = 0;
    return false;
  }
  if (!_("#address_name").checkValidity()) {
    toastr["warning"]("Address Name : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("address_name", "warning", "Field Cannot be Empty");
    _("#address_name").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z\s]+$/.test(_("#address_name").value)) {
    toastr["warning"]("Address Name : " + "Invalid Address Format", "WARNING");
    showInputAlert("address_name", "warning", "Invalid Address Format");
    _("#address_name").focus();
    save_no = 0;
    return false;
  }
  if (!_("#country").checkValidity()) {
    toastr["warning"]("Country : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("country", "warning", "Field Cannot be Empty");
    _("#country").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z\s]+$/.test(_("#country").value)) {
    toastr["warning"]("Country : " + "Invalid Country Name", "WARNING");
    showInputAlert("country", "warning", "Invalid Country Name");
    _("#country").focus();
    save_no = 0;
    return false;
  }
  if (!_("#state").checkValidity()) {
    toastr["warning"]("State : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("state", "warning", "Field Cannot be Empty");
    _("#state").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z\s]+$/.test(_("#state").value)) {
    toastr["warning"]("State : " + "Invalid State Name", "WARNING");
    showInputAlert("state", "warning", "Invalid State Name");
    _("#state").focus();
    save_no = 0;
    return false;
  }
  if (!_("#city").checkValidity()) {
    toastr["warning"]("City : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("city", "warning", "Field Cannot be Empty");
    _("#city").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z\s]+$/.test(_("#city").value)) {
    toastr["warning"]("City : " + "Invalid City Name", "WARNING");
    showInputAlert("city", "warning", "Invalid City Name");
    _("#city").focus();
    save_no = 0;
    return false;
  }
  if (!_("#landmark").checkValidity()) {
    toastr["warning"]("Landmark : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("landmark", "warning", "Field Cannot be Empty");
    _("#landmark").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z0-9\s]+$/.test(_("#landmark").value)) {
    toastr["warning"]("Landmark : " + "Invalid Landmark Name", "WARNING");
    showInputAlert("landmark", "warning", "Invalid Landmark Name");
    _("#landmark").focus();
    save_no = 0;
    return false;
  }
  if (!_("#pincode").checkValidity()) {
    toastr["warning"]("Pincode : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("pincode", "warning", "Field Cannot be Empty");
    _("#pincode").focus();
    save_no = 0;
    return false;
  }
  if (!numberRegex.test(_("#pincode").value)) {
    toastr["warning"]("Pincode : Invalid Pincode Format", "WARNING");
    showInputAlert("pincode", "warning", "Invalid Pincode Format");
    _("#pincode").focus();
    save_no = 0;
    return false;
  }
  if (_("#pincode").value.length < 6) {
    toastr["warning"]("Pincode : Invalid Pincode Format", "WARNING");
    showInputAlert("pincode", "warning", "Invalid Pincode Format");
    _("#pincode").focus();
    save_no = 0;
    return false;
  }
  if (!_("#address_line_1").checkValidity()) {
    toastr["warning"]("Address : " + "Field Cannot be Empty", "WARNING");
    showInputAlert("address_line_1", "warning", "Field Cannot be Empty");
    _("#address_line_1").focus();
    save_no = 0;
    return false;
  }
  if (!/^[a-zA-Z0-9\s,./-]+$/.test(_("#address_line_1").value)) {
    toastr["warning"]("Address : " + "Invalid Address Format", "WARNING");
    showInputAlert("address_line_1", "warning", "Invalid Address Format");
    _("#address_line_1").focus();
    save_no = 0;
    return false;
  }

  if (save_no == 1) {
    _(".background_overlay").style.display = "block";
    let data = new FormData();

    let default_address = "No";
    if (_("#default_address").checked == true) {
      default_address = "Yes";
    }

    const sendData = {
      address_id: _("#address_id").value,
      contact_name: _("#contact_name").value,
      contact_ph_num: _("#contact_ph_num").value,
      address_name: _("#address_name").value,
      country: _("#country").value,
      state: _("#state").value,
      city: _("#city").value,
      landmark: _("#landmark").value,
      pincode: _("#pincode").value,
      address_line_1: _("#address_line_1").value,
      default_address: default_address,
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
            _(".background_overlay").style.display = "none";
            if (status == "SessionDestroy") {
              session_destroy();
              setTimeout(function () {
                window.location.reload();
              }, 5000);
              return false;
            } else {
              toastr["success"](status_text, "SUCCESS!!");
              setTimeout(function () {
                window.location.reload();
              }, 1500);
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
  // console.log(buyer_address_id);
  if (address_id > 0) {
    _(".background_overlay").style.display = "block";
    // clear_input();
    let data = new FormData();
    const sendData = {
      address_id: address_id,
    };
    // console.log(sendData);
    data.append("sendData", JSON.stringify(sendData));
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        const response = JSON.parse(xhr.responseText);
        // console.log(response);

        _("#address_id").value = response["address_id"];
        _("#contact_name").value = response["contact_name"];
        _("#contact_ph_num").value = response["contact_ph_num"];
        _("#address_name").value = response["address_name"];
        _("#country").value = response["country"];
        _("#state").value = response["state"];
        _("#city").value = response["city"];
        _("#landmark").value = response["landmark"];
        _("#pincode").value = response["pincode"];
        _("#address_line_1").value = response["address_line_1"];
        
         if (response["is_default"] === "Yes") {
      _("#default_address").checked = true;
    } else {
      _("#default_address").checked = false;
    }

        // chngMode('Update');
        $("#entryModal").modal();
        _(".background_overlay").style.display = "none";
      }
    };
    xhr.open("POST", "templates/address-book/update_data_input.php", true);
    xhr.send(data);
  } else {
    toastr["error"](
      "You Don't Have Permission To Update Any Data !!",
      "ERROR!!"
    );
    return false;
  }
}

function delete_alert(addressId) {
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
      delete_data(addressId);
    }
  });
}

function delete_data(address_id) {
  if (address_id > 0) {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      address_id: address_id,
    };
    data.append("sendData", JSON.stringify(sendData));

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        _(".background_overlay").style.display = "none";
        toastr["info"]("Data Deleted Successfully.", "SUCCESS!!");
        setTimeout(function () {
          window.location.reload();
        }, 1500);
      }
    };
    xhr.open("POST", "templates/address-book/delete_data.php", true);
    xhr.send(data);
  } else {
    toastr["error"](
      "You Don't Have Permission To Delete Any Data !!",
      "ERROR!!"
    );
  }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////// API calling part using js dynamically to call the address as per search //////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
let autocompleteService = null;
let geocoder = null;

function initializeGoogleServices() {
  // Initialize Google services only once
  if (!autocompleteService) {
    autocompleteService = new google.maps.places.AutocompleteService();
  }
  if (!geocoder) {
    geocoder = new google.maps.Geocoder();
  }
}

function fetchGoogleAddresses() {
  initializeGoogleServices();

  const addressInput = document.getElementById("address_line_1");
  const suggestionsContainer = document.getElementById("suggestions");

  if (addressInput.value.trim() === "") {
    suggestionsContainer.style.display = "none";
    return;
  }

  autocompleteService.getPlacePredictions(
    {
      input: addressInput.value,
      types: ["address"],
    },
    (predictions, status) => {
      if (
        status === google.maps.places.PlacesServiceStatus.OK &&
        predictions.length
      ) {
        let suggestionsHtml = "";
        predictions.forEach((prediction) => {
          suggestionsHtml += `
                        <div class="suggestion-item" data-place-id="${prediction.place_id}">
                            ${prediction.description}
                        </div>`;
        });
        suggestionsContainer.innerHTML = suggestionsHtml;
        suggestionsContainer.style.display = "block";

        // Attach click event to dynamically created suggestions
        attachClickEventToSuggestions();
      } else {
        suggestionsContainer.style.display = "none";
      }
    }
  );
}

function attachClickEventToSuggestions() {
  const suggestionItems = document.querySelectorAll(".suggestion-item");
  suggestionItems.forEach((item) => {
    item.addEventListener("click", function () {
      const placeId = this.getAttribute("data-place-id");
      fetchPlaceDetails(placeId);
    });
  });
}

function fetchPlaceDetails(placeId) {
  // console.log(placeId);
  geocoder.geocode({ placeId: placeId }, (results, status) => {
    if (status === google.maps.GeocoderStatus.OK && results[0]) {
      const addressComponents = results[0].address_components;

      document.getElementById("address_line_1").value =
        results[0].formatted_address;
      document.getElementById("landmark").value =
        getAddressComponent(addressComponents, "sublocality") ||
        getAddressComponent(addressComponents, "neighborhood") ||
        "";
      document.getElementById("city").value =
        getAddressComponent(addressComponents, "locality") || "";
      document.getElementById("pincode").value =
        getAddressComponent(addressComponents, "postal_code") || "";
      document.getElementById("state").value =
        getAddressComponent(addressComponents, "administrative_area_level_1") ||
        "";
      document.getElementById("country").value =
        getAddressComponent(addressComponents, "country") || "";

      // Hide suggestions after selection
      document.getElementById("suggestions").style.display = "none";
    }
  });
}

function getAddressComponent(components, type) {
  const component = components.find((c) => c.types.includes(type));
  return component ? component.long_name : null;
}
