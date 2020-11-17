<?php

include 'header.php';

$exam->Change_exam_status($_SESSION['user_id']);

?>

<br />
	<div class="card">
	<div class="card-header">Online Exam List</div>
		<div class="card-body">
			<!-- <span id="message_operation"></span> -->
			<div class="table-responsive" style="overflow-x:hidden;">
				<table id="exam_data_table" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Exam Title</th>
							<th>Date & Time</th>
							<th>Duration</th>
							<th>Total Question</th>
							<th>Right Answer Mark</th>
							<th>Wrong Answer Mark</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
<?php include 'master/footer.php'; ?>

<script>
$(document).ready(function(){
	var dataTable = $('#exam_data_table').dataTable({
		"processing":true,
		"serverSide":true,
		"order": [],
		"ajax": {
			url:"user_ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'enroll_exam'}
		},
		"columnDefs":[
		{
			"target":[7],
			"orderable":false
		}
		]
	});
});
</script>