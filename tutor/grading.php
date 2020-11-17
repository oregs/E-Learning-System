<?php 

include('header.php');

?>
<div class="card">
	<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="panel-title">Assignment Grading Module</h3>
				</div>
			</div>
		</div>
	<div class="card-body">
		<!-- <span id="message_operation"></span> -->
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="grading_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr><h5>
						<th>S/N</th>
						<th>Matric No.</th>
						<th>Full Name</th>
						<th>Assignment Details</th>
						<th>Assignment Format</th>
						<th>Course Code</th>
						<th>Submission Date & Time</th>
						<th>Action</th>
					</h5></tr>
				</thead>
			</table>
		</div>
	</div>
</div>	

<script>
$(document).ready(function(){
	var dataTable = $('#grading_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "tutor_ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'grading'}
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
<?php include '../master/footer.php'; ?>
