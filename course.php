<?php 

include 'header.php';

?>

<br />
<!-- <div class="container"> -->
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-9">Course Selection</div>
					<div class="col-md-3" align="right">

					</div>
				</div>
			</div>

		
			<div class="card-body">
				<div class="field-wrap form-group">
					<label>Level:<span class="req"></span></label>
			         	<select name="level" id="level" class="form-control">
			            	<option value = "" selected = "selected" disabled = "disabled">Select Level</option>
							<?php echo $exam->Get_data('level_table', 'level_id', 'level_code');	?>
						</select>
				</div>
				<div class="table_responsive">
					<table id="course_table" class ="table table-bordered table-striped">
						<thead class="aler alert-info">
							<tr>
								<th>S/N</th>
								<th>Course Code</th>
								<th>Course name</th>
								<th>course Unit</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-9">Current Selections</div>
						<div class="col-md-3" align="right">

					</div>
				</div>
			</div>
	
		
			<div class="card-body">
				<div class="table_responsive">
					<table id="enroll_table" class ="table table-bordered table-striped">
						<thead class ="alert alert-info">
							<tr>
								<th>S/N</th>
								<th>Course Code</th>
								<th>Course name</th>
								<th>course Unit</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="modal-title">Delete Confirmation</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<h3 align="center">Are you sure you want to remove this</h3>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- </div> -->


<?php include 'master/footer.php'; ?>

<script>
$(document).ready(function(){
	load_data();
	function load_data(is_level){
		var dataTable = $('#course_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"user_ajax_action.php",
			type:"POST",
			data:{page:'course', action:'fetch', is_level:is_level}
			}
		});

		$(document).on('click', '.register', function(e){
		e.preventDefault();

		var course_id = $(this).val();	

		$.ajax({
			url:"user_ajax_action.php",
			type:"POST",
			data:{page:'course', action:'enroll', course_id:course_id},
			success:function(response)
			{
				if(response == "success"){
					swal({
		                title: "Registration Successful!!!",
		                icon: "success",
		                timer: 1000,
		               	button: false,
		          	}).then(function(){
		          		dataTable.ajax.reload();
		          		enrollTable.ajax.reload();
		          	});
				}
			}
		});
	});

	$(document).on('change', '#level', function(e){
		e.preventDefault();
		var level = $(this).val();
		$('#course_table').DataTable().destroy();
		if(level != '')
		{
			load_data(level);
		}
		else
		{
			load_data();
		}
	});

	var enrollTable = $('#enroll_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"user_ajax_action.php",
			type:"POST",
			data:{page:'course', action:'enroll_fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2],
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.delete', function(){
		course_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"user_ajax_action.php",
			method:"POST",
			data:{course_id:course_id, action:'delete', page:'course'},
			success:function(response)
			{
				if(response == "success"){
					$('#deleteModal').modal('hide');
					swal({
		                title: "Delete Successful!!!",
		                icon: "warning",
		                timer: 1000,
		               	button: false,
		          	}).then(function(){
		          		enrollTable.ajax.reload();
		          		dataTable.ajax.reload();
		          	});
				}
			}
		})
	});

	}
});
</script>