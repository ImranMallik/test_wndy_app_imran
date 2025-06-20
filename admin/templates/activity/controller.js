$(document).ready(function(){
	show_list();
});

function show_list(){
	if(view_per=="Yes"){
		$('#data_table').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url':'templates/activity/list.php'
			},
			'order': [[ 1, "desc" ]],
			'drawCallback': function (data) { 
				// Here the response
				// var response = data.json;
				// console.log(response);
			},
			'columns': [
				{ data: 'activity_timestamp' },
				{ data: 'activity_details' }
			],
			dom: 'lBfrtip',
			buttons: [
				{ extend: 'print', className: 'btn dark btn-outline' },
				{ extend: 'copy', className: 'btn red btn-outline' },
				{ extend: 'pdf', className: 'btn green btn-outline' },
				{ extend: 'excel', className: 'btn yellow btn-outline ' },
				{ extend: 'csv', className: 'btn purple btn-outline ' },
				{ extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'},
				{ extend: 'pageLength', className: 'btn dark btn-outline', text: 'Show Entries' }
			],
			'aoColumnDefs': [{
				'bSortable': false,
				'aTargets': ['nosort']
			}]
		});
	}
}

function reload_table(){
	$('#data_table').DataTable().ajax.reload();
}