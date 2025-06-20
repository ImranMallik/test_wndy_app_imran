$(document).ready(function () {
	make_select2_ajx('filter_seller_id');
	make_select2_ajx('filter_category_id');
	make_select2_ajx('filter_product_id');
	// make_select2_ajx('buyer_id');
	show_list();
	make_select2_ajx('seller_id');
	make_select2_ajx('product_id');
	make_select2_ajx('buyer_id');
	make_select2_ajx('assigned_collecter');
	make_select2_ajx('filter_seller_pincode');
	make_select2_ajx('filter_buyer_pincode');
	make_select2_ajx('product_status');
	make_select2_ajx('seller_post_status');
});

function clear_input() {
	_("#view_id").value = "";
	$("#seller_id").val('').trigger('change');
	$("#product_id").val('').trigger('change');
	$("#buyer_id").val('').trigger('change');
	$("#assigned_collecter").val('').trigger('change');
	$("#filter_seller_pincode").val('').trigger('change');
	$("#filter_buyer_pincode").val('').trigger('change');
	$("#product_status").val('').trigger('change');
	$("#seller_post_status").val('').trigger('change');
	_("#view_date").value = "";
	_("#deal_status").value = "";
	_("#purchased_price").value = "";
	_("#negotiation_amount").value = "";
	_("#negotiation_by").value = "";
	_("#mssg").value = "";
	_("#negotiation_date").value = "";
	_("#accept_date").value = "";
	_("#pickup_date").value = "";
	_("#pickup_time").value = "";
	_("#complete_date").value = "";

	chngMode('Insert');
	clearInputAleart();
}

function onStartDateChange() {
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');
    const toLabel = document.getElementById('to_label');

    if (startInput.value) {
        toLabel.style.display = 'inline';
        endInput.style.display = 'inline';
        endInput.min = startInput.value; 
    } else {
        toLabel.style.display = 'none';
        endInput.style.display = 'none';
        endInput.value = '';
        document.getElementById('custom_date_range').value = '';
    }
}

function onEndDateChange() {
    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    const hiddenField = document.getElementById('custom_date_range');

    if (!start || !end) return;

    if (start > end) {
        toastr.warning("End date cannot be before start date", "Date Range Error");
        hiddenField.value = '';
        return;
    }

    hiddenField.value = `${start} to ${end}`;
    reload_table();
}

function chngMode(mode) {
	if (mode == "Update") {
		_(".entry_modal_title").innerHTML = 'Update Post Transactions Details :';
		_(".save_btn").innerHTML = 'Update Data';
	}
	else {
		_(".entry_modal_title").innerHTML = 'Enter Post Transactions Details :';
		_(".save_btn").innerHTML = 'Save Data';
	}
}

function make_select2_ajx(id) {
	let fileName;
	let sendData = '';
	switch (id) {
		case 'seller_id':
		case 'filter_seller_id':
			fileName = 'select_seller_list';
			break;

		case 'filter_category_id':
			fileName = 'select_category_list';
			break;

		case 'filter_product_id':
			fileName = 'select_product_list';
			sendData = {
				category_id: _("#filter_category_id").value,
				// seller_id: _("#filter_seller_id").value,
			};
			break;

		case 'product_id':
			fileName = 'select_product_list';
			sendData = {
				seller_id: _("#seller_id").value,
			};
			break;

		case 'buyer_id':
			fileName = 'select_buyer_list';
			break;

		case 'assigned_collecter':
			fileName = 'select_collector_list';
			sendData = {
				buyer_id: _("#buyer_id").value,
			};
			break;

			case 'filter_seller_pincode':
			fileName = 'select_seller_pincode_list';
			break;
			case 'filter_buyer_pincode':
			fileName = 'select_buyer_pincode_list';
			break;
			case 'product_status':
			fileName = 'get_product_status';
			break;
			case 'seller_post_status':
			fileName = 'get_seller_product_status';
			break;
	}

	$("#" + id).select2({
		minimumInputLength: 0,
		allowClear: true,
		width: '100%',
		ajax: {
			url: "templates/manage_post_transactions/" + fileName + ".php",
			dataType: 'json',
			type: "post",
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					sendData: JSON.stringify(sendData),
				};
			},
			processResults: function (response) {
				return {
					results: response
				};
			},
			cache: true
		},
	});
}

function show_list() {
    // alert();
	if (view_per == "Yes") {
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url': 'templates/manage_post_transactions/list.php',
				'data': function (d) {
					d.seller_id = $('#filter_seller_id').val();
					d.category_id = $('#filter_category_id').val();
					d.product_id = $('#filter_product_id').val();
					d.buyer_id = $('#buyer_id').val();
					d.seller_pincode = $('#filter_seller_pincode').val();
					d.buyer_pincode = $('#filter_buyer_pincode').val();
					d.product_status = $('#product_status').val();
					d.seller_post_status = $('#seller_post_status').val();

					  const range = $('#custom_date_range').val();
                    if (range.includes(' to ')) {
                        const [from, to] = range.split(' to ');
                        d.from_date = from.trim();
                        d.to_date = to.trim();
                    }
				},
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
  'columns': [
    { data: 'entry_timestamp' },
    { data: 'post_id' },
    { data: 'seller_details' },
    { data: 'seller_number' },
    { data: 'seller_address' },
    { data: 'seller_pincode' },
    { data: 'category_name' },
    { data: 'product_name' },
	{data:'product_image'},
    { data: 'description' },
    { data: 'brand' },
    { data: 'quantity_kg' },
    { data: 'quantity_pcs' },
    { data: 'product_price' },
    { data: 'product_status' },
    { data: 'closure_remark' },
    { data: 'withdrawal_date' },
    { data: 'close_reason' },
    { data: 'no_of_post' },
    { data: 'buyer_action_time' },
    { data: 'product_status_history' },
    { data: 'buyer_details' },
    { data: 'buyer_number' },
    { data: 'buyer_address' },
    { data: 'buyer_pincode' },
    { data: 'trans_id' },
    { data: 'deal_status' },
    { data: 'used_credits' },
    { data: 'purchased_price' },
    { data: 'negotiation_amount' },
    { data: 'mssg' },
    { data: 'message_history' },
	{data:'negotiation_price_history'},
    { data: 'negotiation_by' },
    { data: 'negotiation_date' },
    { data: 'accept_date' },
    { data: 'pickup_date' },
    { data: 'complete_date' },
    { data: 'duration_for_post_completion' },
    { data: 'collector_details' },
    { data: 'assigned_date_for_collector' },
    { data: 'view_date' },
    { data: 'seller_rating_for_buyer' },
    { data: 'buyer_rating_for_seller' },
    { data: 'action' }
  ],

			dom: 'lBfrtip',
			lengthMenu: [50, 100, 250, 500, 1000, { label: 'All', value: -1 }],
				buttons: [
				{ extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'copy', className: 'btn red btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: ':visible' } },
				{
  extend: 'excel',
  className: 'btn yellow btn-outline',
  exportOptions: {
    columns: ':visible',
    format: {
      body: function (data, row, column, node) {
        if (column === 20) { // column index of Status Update Date
          if (typeof data === 'string') {
            const html = $('<div>').html(data);
            let output = '';
            html.find('li').each(function () {
              const status = $(this).find('strong').text().trim();
              const time = $(this).find('span').text().trim();
              // ✅ Use ASCII line break (char code 10)
              output += `• ${status} ${time}${String.fromCharCode(10)}`;
            });
            return output.trim();
          }
        }

        // Strip HTML for other columns
        return typeof data === 'string'
          ? data.replace(/<[^>]*>/g, '').trim()
          : data;
      }
    }
  }
},

				{ extend: 'csv', className: 'btn purple btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns' },
				{ extend: 'pageLength', className: 'btn dark btn-outline', text: 'Show Entries' }
			],
			'order': [[0, "desc"]],
			'aoColumnDefs': [{
				'bSortable': false,
				'aTargets': ['nosort']
			}]
		});
	}
}

function reload_table() {
	$('#data_table').DataTable().ajax.reload();
}

function save_details() {
	let save_no = 1;
	clearInputAleart();

	if (insert_per == "No") {
		toastr['error']("You Don't Have Permission To Entry Any Data !!", "ERROR");
		save_no = 0;
		return false;
	}
	if (!_("#seller_id").checkValidity()) {
		toastr['warning']("Seller: " + _("#seller_id").validationMessage, "WARNING");
		showInputAlert('seller_id', 'warning', _("#seller_id").validationMessage);
		_("#seller_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#product_id").checkValidity()) {
		toastr['warning']("Seller's Item : " + _("#product_id").validationMessage, "WARNING");
		showInputAlert('product_id', 'warning', _("#product_id").validationMessage);
		_("#product_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#buyer_id").checkValidity()) {
		toastr['warning']("Buyer: " + _("#buyer_id").validationMessage, "WARNING");
		showInputAlert('buyer_id', 'warning', _("#buyer_id").validationMessage);
		_("#buyer_id").focus();
		save_no = 0;
		return false;
	}
	if (!_("#view_date").checkValidity()) {
		toastr['warning']("View Date : " + _("#view_date").validationMessage, "WARNING");
		showInputAlert('view_date', 'warning', _("#view_date").validationMessage);
		_("#view_date").focus();
		save_no = 0;
		return false;
	}
	if (!_("#deal_status").checkValidity()) {
		toastr['warning']("Deal Status : " + _("#deal_status").validationMessage, "WARNING");
		showInputAlert('deal_status', 'warning', _("#deal_status").validationMessage);
		_("#deal_status").focus();
		save_no = 0;
		return false;
	}
	if (!_("#purchased_price").checkValidity() && (_("#deal_status").value == "Waiting For Pickup" || _("#deal_status").value == "Complete")) {
		toastr['warning']("Purchased Price : " + _("#purchased_price").validationMessage, "WARNING");
		showInputAlert('purchased_price', 'warning', _("#purchased_price").validationMessage);
		_("#purchased_price").focus();
		save_no = 0;
		return false;
	}

	if (save_no == 1 && insert_per == "Yes") {
		_(".background_overlay").style.display = "block";

		let data = new FormData();
		const sendData = {
			view_id: _("#view_id").value,
			seller_id: _("#seller_id").value,
			product_id: _("#product_id").value,
			buyer_id: _("#buyer_id").value,
			assigned_collecter: _("#assigned_collecter").value,
			view_date: _("#view_date").value,
			deal_status: _("#deal_status").value,
			purchased_price: _("#purchased_price").value,
			negotiation_amount: _("#negotiation_amount").value,
			negotiation_by: _("#negotiation_by").value,
			mssg: _("#mssg").value,
			negotiation_date: _("#negotiation_date").value,
			accept_date: _("#accept_date").value,
			pickup_time: _("#pickup_time").value,
			pickup_date: _("#pickup_date").value,
			complete_date: _("#complete_date").value,
			quantity_pcs: _("#quantity_pcs").value,
	        quantity_kg: _("#quantity_kg").value,
	        withdrawal_date: _("#withdrawn_date").value,
	       close_reason: _("#widthdrawn_reason").value 
		};

		console.log(sendData)

		data.append("sendData", JSON.stringify(sendData));

		save_data = new XMLHttpRequest();
		save_data.onreadystatechange = function () {
			if (save_data.readyState == 4) {
				// console.log(save_data.responseText);
				const response = JSON.parse(save_data.responseText);
				const status = response[0]["status"];
				const status_text = response[0]["status_text"];
				_(".background_overlay").style.display = "none";
				if (status == "SessionDestroy") {
					session_destroy();
					setTimeout(function () {
						window.location.reload();
					}, 5000);
					return false;
				} else if (status == "NoPermission") {
					toastr["error"](status_text, "ERROR!!");
					return false;
				} else if (status == "error") {
					toastr["error"](status_text, "ERROR!!");
					return false;
				} else {
					// When Data Save successfully
					reload_table();
					clear_input();
					toastr["success"](status_text, "SUCCESS!!");
					return false;
				}
			}
		};
		save_data.open('POST', 'templates/manage_post_transactions/save_details.php', true);
		save_data.send(data);
	}
}

function update_data(view_id) {
	if (edit_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();
		let data = new FormData();
		const sendData = {
			view_id: view_id
		};
		data.append("sendData", JSON.stringify(sendData));
		let xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					const response = JSON.parse(xhr.responseText);
					// console.log(response);

					if (response.error) {
						toastr["error"](response.error, "ERROR!!");
						_(".background_overlay").style.display = "none";
						return;
					}

					_("#view_id").value = response["view_id"];
					_("#seller_id").innerHTML = `<option value="` + response['seller_id'] + `" selected>` + response['seller_details'] + `</option>`;
					make_select2_ajx('product_id');
					_("#product_id").innerHTML = `<option value="` + response['product_id'] + `" selected>` + response['product_name'] + `</option>`;
					_("#buyer_id").innerHTML = `<option value="` + response['buyer_id'] + `" selected>` + response['buyer_details'] + `</option>`;
					make_select2_ajx('assigned_collecter');
					if (response['assigned_collecter'] != null) {
						_("#assigned_collecter").innerHTML = `<option value="` + response['assigned_collecter'] + `" selected>` + response['collector_details'] + `</option>`;
					}

					_("#view_date").value = response["view_date"];
					_("#deal_status").value = response["deal_status"];
					_("#purchased_price").value = response["purchased_price"];
					_("#negotiation_amount").value = response["negotiation_amount"];
					_("#negotiation_by").value = response["negotiation_by"];
					_("#mssg").value = response["mssg"];
					_("#widthdrawn_reason").value = response["widthdraw_reason"];
					_("#quantity_pcs").value = response["quantity_pcs"];
					_("#quantity_kg").value = response["quantity_kg"];
					_("#withdrawn_date").value = response["withdrawal_date"];
					_("#negotiation_date").value = response["negotiation_date"];
					_("#accept_date").value = response["accept_date"];
					_("#pickup_date").value = response["pickup_date"];
					_("#pickup_time").value = response["pickup_time"];
					_("#complete_date").value = response["complete_date"];

					chngMode("Update");
					$("#entryModal").modal();
					_(".background_overlay").style.display = "none";
				} else {
					toastr["error"]("Failed to retrieve data!", "ERROR!!");
					_(".background_overlay").style.display = "none";
				}
			}
		};
		xhr.open("POST", "templates/manage_post_transactions/update_data_input.php", true);
		xhr.send(data);
	} else {
		toastr["error"]("You Don't Have Permission To Update Any Data !!", "ERROR!!");
		return false;
	}
}

function delete_data(view_id) {
	if (del_per == "Yes") {
		_(".background_overlay").style.display = "block";
		clear_input();

		let data = new FormData();
		const sendData = {
			view_id: view_id,
		};
		data.append("sendData", JSON.stringify(sendData));

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				reload_table();
				_(".background_overlay").style.display = "none";
				toastr['info']("Data Deleted Successfully.", "SUCCESS!!");
				return false;
			}
		}
		xhr.open('POST', 'templates/manage_post_transactions/delete_data.php', true);
		xhr.send(data);

	}
	else {
		toastr['error']("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
		return false;
	}
}