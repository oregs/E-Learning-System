<?php

include('header.php');

?>
<br />
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="panel-title">Online Exam List</h3>
				</div>			
			</div>
		</div>
		<div class="card-body">
			<span id="message_operation"></span>
			<div class="table-responsive" style="overflow-x:hidden;">
				<table id="exam_data_table" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Exam Title</th>
							<th>Date & Time</th>
							<th>Status</th>
							<th>Result</th>
							<th>Enroll</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
<script>

$(document).ready(function(){
var dataTable = $('#exam_data_table').DataTable({
	"processing" : true,
	"serverSide" : true,
	"order" : [],
	"ajax" : {
		url: "tutor_ajax_action.php",
		method:"POST",
		data:{action:'fetch', page:'exam_result'}
	},
	"columnDef" : [
		{
			"targets" : [5],
			"orderable" : false
		}
	]
});
});
</script>

<?php
include('../master/footer.php');
?>