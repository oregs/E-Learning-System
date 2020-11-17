<?php 

include 'header.php';

?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">Course List</div>
			<div class="col-md-12" align="right">
				<button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<p id="message_operation"></p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="course_table">
				<thead>
					<tr>
						<th>Course Code</th>
						<th>Course Name</th>
						<th>Level</th>
						<th>Semester</th>
						<th>department</th>
						<th>Edit</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Form Modal -->
<div class="modal" id="formModal">
	<div class="modal-dialog">
		<form method="post" id="course_form">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<label class="col-md-4 text-right">Course Code<span class="text-danger">*</span></label>
						<div class="col-md-8">
							<input type="text" name="course_code" id="course_code" class="form-control" data-parsley-checkcourse data-parsley-checkcourse-message='Course already Exists' />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-4 text-right">Course Name <span class="text-danger">*</span></label>
						<div class="col-md-8">
							<input type="text" name="course_name" id="course_name" class="form-control" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-4 text-right">Course Unit <span class="text-danger">*</span></label>
						<div class="col-md-8">
							<input type="number" name="course_unit" id="course_unit" class="form-control" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-4 text-right">Level<span class="text-danger">*</span></label>
						<div class="col-md-8">
							<select class="form-control" name="level_id" id="level_id">
								<option  value="" disabled="disabled" selected="selected">Select level</option>
								<?php echo $exam->Get_data('level_table', 'level_id', 'level_code'); ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-4 text-right">Semester<span class="text-danger">*</span></label>
						<div class="col-md-8">
							<select class="form-control" name="semester_id" id="semester_id">
								<option  value="" disabled="disabled" selected="selected">Select Semester</option>
								<?php echo $exam->Get_data('semester_table', 'semester_id', 'semester_name'); ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-4 text-right">Department<span class="text-danger">*</span></label>
						<div class="col-md-8">
							<select class="form-control" name="department_id" id="department_id">
								<option  value="" disabled="disabled" selected="selected">Select Department</option>
								<?php echo $exam->Get_data('department_table', 'department_id', 'department_name'); ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<input type="hidden" name="course_id" id="course_id">
				<input type="hidden" name="page" value="course">
				<input type="hidden" name="action" id="action" value="Add" />
				<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
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
<script>
$(document).ready(function(){

	var dataTable = $('#course_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'course'},
		},
		"columnDefs": [
			{
				"targets":[0, 1, 2],
				"orderable":false
			}
		]
	});

/////////////////////////////////////////////////////////////////////////////
	// window.Parsley.addValidator('checkcourse', {
	// 	validateString: function(value)
	// 	{
	// 		return $.ajax({
	// 			url:"ajax_action.php",
	// 			method:"POST",
	// 			data:{page:'course', action:'check_course', course_code:value},
	// 			dataType:'json',
 //        		async:false,
	// 			success:function(data)
	// 			{
	// 				return true;
	// 			}
	// 		});
	// 	}
	// });
///////////////////////////////////////////////////////////////////////////////////
	function reset_form()
	{
		$('#modal-title').text('Add Course Details');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#course_form')[0].reset();
		$('#course_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});

	$('#course_form').parsley();

	$('#course_form').on('submit', function(event){
		event.preventDefault();

		$('#course_code').attr('required', 'required');
		$('#course_name').attr('required', 'required');
		$('#course_unit').attr('required', 'required');
		$('#level_id').attr('required', 'required');
		$('#semester_id').attr('required', 'required');
		$('#department_id').attr('required', 'required');

		if($('#course_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#button_action').attr('disabled', 'disabled');
					$('#button_action').val('Validate..');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_form();

						dataTable.ajax.reload();

						$('#formModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);
					$('#button_action').val($('#action'));
				}
			});
		}
	});

	var course_id = '';

	$(document).on('click', '.edit_course', function(){
		course_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', course_id:course_id, page:'course'},
			dataType:"json",
			success:function(data)
			{
				$('#course_code').val(data.course_code);
				$('#course_name').val(data.course_name);
				$('#course_unit').val(data.course_unit);
				$('#department_id').val(data.department_id);
				$('#semester_id').val(data.semester_id);
				$('#level_id').val(data.level_id);
				$('#course_id').val(course_id);
				$('#button_action').val('Edit');
				$('#action').val('Edit');
				$('#formModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete_course', function(){
		course_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{course_id:course_id, action:'delete', page:'course'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});

});
</script>