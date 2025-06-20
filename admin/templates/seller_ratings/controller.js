$(document).ready(function () {
  show_list();
});

function show_list() {
  if (view_per == "Yes") {
    $("#data_table").DataTable({
      processing: true,
      serverSide: true,
      serverMethod: "post",
      ajax: {
        url: "templates/seller_ratings/list.php",
      },
      drawCallback: function (data) {
        // Here the response
        // var response = data.json;
        // console.log(response);
      },
      columns: [
        { data: 'entry_timestamp' },
        { data: 'seller_details' },
        { data: 'buyer_details' },
        { data: 'rating' },
        { data: 'review' },
        { data: "action" }
      ],
      dom: "lBfrtip",
      lengthMenu: [50, 100, 250, 500, 1000, { label: 'All', value: -1 }],
      buttons: [
        { extend: "print", className: "btn dark btn-outline", exportOptions: { columns: ':visible' } },
        { extend: "copy", className: "btn red btn-outline", exportOptions: { columns: ':visible' } },
        { extend: "pdf", className: "btn green btn-outline", exportOptions: { columns: ':visible' } },
        { extend: "excel", className: "btn yellow btn-outline ", exportOptions: { columns: ':visible' } },
        { extend: "csv", className: "btn purple btn-outline ", exportOptions: { columns: ':visible' } },
        { extend: "colvis", className: "btn dark btn-outline", text: "Columns" },
        { extend: "pageLength", className: "btn dark btn-outline", text: "Show Entries" },
      ],
      order: [[0, "desc"]],
      aoColumnDefs: [
        {
          bSortable: false,
          aTargets: ["nosort"],
        },
      ],
    });
  }
}

function reload_table() {
  $("#data_table").DataTable().ajax.reload();
}

function delete_data(rating_id) {
  if (del_per == "Yes") {
    _(".background_overlay").style.display = "block";

    let data = new FormData();
    const sendData = {
      rating_id: rating_id,
    };
    data.append("sendData", JSON.stringify(sendData));

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        reload_table();
        _(".background_overlay").style.display = "none";
        toastr["info"]("Data Deleted Successfully.", "SUCCESS!!");
        return false;
      }
    };
    xhr.open("POST", "templates/buyer_ratings/delete_data.php", true);
    xhr.send(data);
  } else {
    toastr["error"]("You Don't Have Permission To Delete Any Data !!", "ERROR!!");
    return false;
  }
}
