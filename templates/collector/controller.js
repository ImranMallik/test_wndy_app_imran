$(document).ready(function () {
	_("#address_line_1").value = "All";
	// _("#address_id").value = "";
	getCollectorList();
});

function clear_filter() {
	_("#address_line_1").value = "All";
	getCollectorList();
}

function getAddress() {
	_(".background_overlay").style.display = "block";
	let data = new FormData();
	const sendData = {
		address_id: _("#address_id").value,
	};
	data.append("sendData", JSON.stringify(sendData));

	landmarkXhr = new XMLHttpRequest();
	landmarkXhr.onreadystatechange = function () {
		if (landmarkXhr.readyState == 4) {
			// console.log(landmarkXhr.responseText);
			_("#address_line_1").innerHTML = landmarkXhr.responseText;
			getCollectorList();
			_(".background_overlay").style.display = "none";
		}
	}
	landmarkXhr.open('POST', 'templates/collector/get_address_list.php', true);
	landmarkXhr.send(data);
}

function getCollectorList() {
	_("#address_list").innerHTML = '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';
	_(".background_overlay").style.display = "block";
	let data = new FormData();
	const sendData = {
		address_line_1: _("#address_line_1").value,
	};
	data.append("sendData", JSON.stringify(sendData));

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4) {
			// console.log(xhr.responseText);
			_("#address_list").innerHTML = xhr.responseText;
			_(".background_overlay").style.display = "none";
		}
	}
	xhr.open('POST', 'templates/collector/get_collector_list.php', true);
	xhr.send(data);
}

function delete_alert(userId) {
    Swal.fire({
        title: "Are You Sure?",
        text: "You Won't Be Able To Revert This!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete It!",
        confirmButtonClass: 'confirm_btn',
        cancelButtonClass: 'cancel_btn',
    }).then(function (result) {
        if (result.isConfirmed) {
            delete_data(userId);
        }
    });
}

function delete_data(user_id) {
	// console.log(user_id);
    if (user_id > 0) {
        document.querySelector(".background_overlay").style.display = "block";

        let data = new FormData();
        const sendData = {
            user_id: user_id
        };
        data.append("sendData", JSON.stringify(sendData));

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                document.querySelector(".background_overlay").style.display = "none";
                toastr.info("Data Deleted Successfully.", "SUCCESS!!");
                setTimeout(function () {
                    window.location.reload();
                }, 1500);
            }
        };
        xhr.open('POST', 'templates/collector/delete_data.php', true);
        xhr.send(data);
    } else {
        toastr.error("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
    }
}
