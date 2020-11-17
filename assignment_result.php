<?php 

include('header.php');

?>
<br />
<div class="card">
	<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="panel-title">Assignment Result</h3>
				</div>
			</div>
		</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="result_table" class="table table-bordered table-striped table-hover">
				<thead class="alert-primary">
					<tr>
						<th>S/N</th>
						<th>Course Code</th>
						<th>Assignment 1</th>
						<th>Assignment 2</th>
						<th>Assignment 3</th>
						<th>Assignment 4</th>
						<th>Assignment 5</th>
						<th>Total Score</th>
						<th>Average Score</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script src ="style/js/datatable_tableexport.js"></script>
<script>
$(document).ready(function(){

	var dataTable = $('#result_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "user_ajax_action.php",
			method:"POST",
			data:{page:'assignment', action:'fetch_result'}
		},
		"columnDef" : [
			{
				"targets" : [2],
				"orderable" : false
			}
		],
		dom: 'lBfrtip',
		buttons: [
			'excel', 'pdf', 'copy'
		],
		"lengthMenu":[ [10, 25, 50, -1], [10, 25, 50, "All"] ]
	});
});
	
</script>