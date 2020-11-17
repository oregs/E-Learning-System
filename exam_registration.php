<?php

include('header.php');

?>
<br />

	<?php

	if(isset($_SESSION['user_id']))
	{
	?>
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-9">Examination List</div>
					<div class="col-md-3" align="right">

					</div>
				</div>
			</div>

		
			<div class="card-body">
				<div class="table_responsive">
					<table id="exam_table" class ="table table-bordered table-striped">
						<thead class="alert alert-info">
							<tr>
								<th>Exam Title</th>
								<th>Exam Date & Time</th>
								<th>Exam Duration</th>
								<th>Exam Total Question</th>
								<th>Marks Per Right Answer</th>
								<th>Marks Per Wrong Answer</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>

	<?php
	}
	else
	{
	?>

	<div align="center">
		<p><a href="register.php" class="btn btn-warning btn-lg">Register</a></p>
		<p><a href="login.php" class="btn btn-primary btn-lg">Login</a></p>
	</div>

	<?php } ?>

<?php include 'master/footer.php'; ?>

<script>
$(document).ready(function(){
	var dataTable = $('#exam_table').DataTable({
	"processing":true,
	"serverSide":true,
	"order":[],
	"ajax":{
		url:"user_ajax_action.php",
		type:"POST",
		data:{page:'examination', action:'fetch_exam'}
		},
		"columnDefs":[
		{
			"target":[2],
			"orderable":false
		}
		]
	});

	$(document).on('click', '#enroll_button', function(){
		exam_id = $('#enroll_button').data('exam_id');
		$.ajax({
			url:"user_ajax_action.php",
			method:"POST",
			data:{action:"enroll_exam", page:"examination", exam_id:exam_id},
			beforeSend:function()
			{
				$('#enroll_button').attr('disabled', 'disabled');
				$('#enroll_button').text('please wait...');
			},
			success:function(data)
			{
				$('#enroll_button').attr('disabled', false);
				$('#enroll_button').removeClass('btn-warning');
				$('#enroll_button').addClass('btn-success');
				$('#enroll_button').text('Enroll success');
			}
		})
	});
});
</script>
