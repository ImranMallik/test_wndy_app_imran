$(document).ready(function () {
	show_list();
});

function show_list() {
	if (view_per == "Yes") {
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url': 'templates/unverified_user/list.php',
				'data': function (d) {
					d.filter_from_date = $('#filter_from_date').val();
					d.filter_to_date = $('#filter_to_date').val();
					d.filter_type = $('#filter_type').val();
				},
			},
			'drawCallback': function (data) {
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'entry_timestamp' },
				{ data: 'ph_num' },
				{ data: 'type' },
			],
			dom: 'lBfrtip',
			lengthMenu: [50, 100, 250, 500, 1000, { label: 'All', value: -1 }],
			buttons: [
				{ extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'copy', className: 'btn red btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: ':visible' } },
				{ extend: 'excel', className: 'btn yellow btn-outline ', exportOptions: { columns: ':visible' } },
				{ extend: 'csv', className: 'btn purple btn-outline ', exportOptions: { columns: ':visible' } },
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