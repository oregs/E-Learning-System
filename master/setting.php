<?php 

include 'header.php';

?>
<br />
<div class="container">
<div class="card">
	<div class="card-header alert alert-info">
			<div class="row">
				<div class="col-md-9">
					<b class="panel-title">SESSION SETTINGS</b>
				</div>
				<div class="col-md-3" align="right">
					<button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
				</div>
			</div>
		</div>
	<div class="card-body">
		<p id="message_operation"></p>
		<div class="row">
			<div class="col-md-12">
				<div class="table_responsive">
					<table id="session_table" class ="table table-bordered table-striped table-hover">
						<thead class ="alert-success">
							<tr>
								<th>S/N</th>
								<th>Session Code</th>
								<th>sessio Start Date</th>
								<th>Session End Date</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><br />
<div class="card">
	<div class="card-header alert alert-info"><div class="col-md-9"><b>SEMESTER SETTING</b></div></div>
	<div class="card-body">
		<p id="semester_message_operation"></p>
		<form class="semester_form" method="post">
			<div class="row">
				<div class="col-md-12">
					<div class="table_responsive">
						<table id="semester_table" class ="table table-bordered table-striped table-hover">
							<thead class ="alert-success">
								<tr>
									<th>S/N</th>
									<th>Semester Name</th>
									<th>semester Start Date</th>
									<th>Semester End Date</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>	
</div><br>
<div class="card">
	<div class="card-header alert alert-info">
			<div class="row">
				<div class="col-md-9">
					<b class="panel-title">DEPARTMENTAL SETTINGS</b>
				</div>
				<div class="col-md-3" align="right">
					<button type="button" id="add_dept_button" class="btn btn-info btn-sm">Add</button>
				</div>
			</div>
		</div>
	<div class="card-body">
		<p id="department_message_operation"></p>
		<div class="row">
			<div class="col-md-12">
				<div class="table_responsive">
					<table id="department_table" class ="table table-bordered table-striped table-hover">
						<thead class ="alert-success">
							<tr>
								<th>S/N</th>
								<th>Department Name</th>
								<th>Department Description</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!-- Session Modal -->
<div class="modal" id="sessionModal">
	<div class="modal-dialog">
		<form id="session_form" method="post">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title">Edit Session Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Session Code<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="session_code" id="session_code" class="form-control" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Session Start Date<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="session_start_date" id="session_start_date" class="form-control session_date" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Session End Date<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="session_end_date" id="session_end_date" class="form-control session_date" autocomplete="off" />
							</div>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="session_id" id="session_id" />
					<input type="hidden" name="page" value="session" />
					<input type="hidden" name="action" id="action" value="Add" />
					<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Semester Modal -->
<div class="modal" id="semesterModal">
	<div class="modal-dialog">
		<form id="semester_form" method="post">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title">Edit Semester Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Semester Start Date<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="semester_start_date" id="semester_start_date" class="form-control session_date" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Semester End Date<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="semester_end_date" id="semester_end_date" class="form-control session_date" autocomplete="off" />
							</div>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="semester_id" id="semester_id" />
					<input type="hidden" name="page" value="semester" />
					<input type="hidden" name="action" id="semester_action" value="Edit" />
					<input type="submit" id="semester_button_action" class="btn btn-success btn-sm" value="Edit" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Department Modal -->
<div class="modal" id="departmentModal">
	<div class="modal-dialog">
		<form id="department_form" method="post">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="department-modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Department Name<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="department_name" id="department_name" class="form-control" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Department Description<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<input type="text" name="department_description" id="department_description" class="form-control" autocomplete="off" />
							</div>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="department_id" id="department_id" />
					<input type="hidden" name="page" value="department" />
					<input type="hidden" name="action" id="department_action" value="Add" />
					<input type="submit" id="department_button_action" class="btn btn-success btn-sm" value="Add" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include 'footer.php'; ?>

<script>
$(document).ready(function(){
	var sessionTable = $('#session_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'session'}
		},
		"columnDef" : [
			{
				"targets" : [3],
				"orderable" : false
			}
		]
	});

	var semesterTable = $('#semester_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'semester'}
		},
		"columnDef" : [
			{
				"targets" : [3],
				"orderable" : false
			}
		]
	});

	var departmentTable = $('#department_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'department'}
		},
		"columnDef" : [
			{
				"targets" : [3],
				"orderable" : false
			}
		]
	});

	function reset_form()
	{
		$('#modal-title').text('Add Session Details');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#session_form')[0].reset();
		$('#session_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#sessionModal').modal('show');
		$('#message_operation').html('');
	});

	var date = new Date();

	date.setDate(date.getDate());

	$('.session_date').datetimepicker({
		startDate :date,
		format: 'yyyy-mm-dd',
		autoclose:true
	});


	$('#session_form').parsley();

	$('#session_form').on('submit', function(e){
		e.preventDefault();
		$('#session_code').attr('required', 'required');
		$('#session_start_date').attr('required', 'required');
		$('#session_end_date').attr('required', 'required');
		
		if($('#session_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#semester_button_action').attr('disabled', 'disabled');
					$('#semester_button_action').val('Validate..');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_form();

						sessionTable.ajax.reload();

						$('#sessionModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);
					$('#button_action').val($('#action'));
				}
			})
			setInterval(function(){
				$('#message_operation').html('');
			}, 5000);
		}
	});

	var session_id = '';

	$(document).on('click', '.edit', function(){
		session_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', session_id:session_id, page:'session'},
			dataType:"json",
			success:function(data)
			{
				$('#session_id').val(data.session_id);
				$('#session_code').val(data.session_code);
				$('#session_start_date').val(data.session_start_date);
				$('#session_end_date').val(data.session_end_date);
				$('#button_action').val('Edit');
				$('#modal-title').text('Edit Session Details');
				$('#action').val('Edit');
				$('#sessionModal').modal('show');
			}
		})
	});

	$('#semester_form').parsley();

	$('#semester_form').on('submit', function(e){
		e.preventDefault();
		
		$('#semester_start_date').attr('required', 'required');
		$('#semester_end_date').attr('required', 'required');
		
		if($('#session_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#semester_button_action').attr('disabled', 'disabled');
					$('#semester_button_action').val('Validate..');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#semester_message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_form();

						semesterTable.ajax.reload();

						$('#semesterModal').modal('hide');
					}

					$('#semester_button_action').attr('disabled', false);
					$('#semester_button_action').val($('#semester_ction'));
				}
			})
			setInterval(function(){
				$('#semester_message_operation').html('');
			}, 5000);
		}
	});

	var semester_id = '';

	$(document).on('click', '.edit_semester', function(){
		semester_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', semester_id:semester_id, page:'semester'},
			dataType:"json",
			success:function(data)
			{
				$('#semester_id').val(data.semester_id);
				$('#semester_start_date').val(data.semester_start_date);
				$('#semester_end_date').val(data.semester_end_date);
				$('#semesterModal').modal('show');
			}
		})
	});

	function reset_department_form()
	{
		$('#department-modal-title').text('Add Department Details');
		$('#department_button_action').val('Add');
		$('#department_action').val('Add');
		$('#department_form')[0].reset();
		$('#department_form').parsley().reset();
	}

	$('#add_dept_button').click(function(){
		reset_department_form();
		$('#departmentModal').modal('show');
		$('#department_message_operation').html('');
	});

	$('#department_form').parsley();

	$('#department_form').on('submit', function(e){
		e.preventDefault();
		$('#department_name').attr('required', 'required');
		$('#department_description').attr('required', 'required');
		
		if($('#department_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#department_button_action').attr('disabled', 'disabled');
					$('#department_button_action').val('Validate..');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#department_message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_department_form();

						departmentTable.ajax.reload();

						$('#departmentModal').modal('hide');
					}

					$('#department_button_action').attr('disabled', false);
					$('#department_button_action').val($('#action'));
				}
			})
			setInterval(function(){
				$('#department_message_operation').html('');
			}, 5000);
		}
	});

	var department_id = '';

	$(document).on('click', '.edit_department', function(){
		department_id = $(this).attr('id');

		reset_department_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', department_id:department_id, page:'department'},
			dataType:"json",
			success:function(data)
			{
				$('#department_id').val(data.department_id);
				$('#department_name').val(data.department_name);
				$('#department_description').val(data.department_description);
				$('#department_button_action').val('Edit');
				$('#department-modal-title').text('Edit Department Details');
				$('#department_action').val('Edit');
				$('#departmentModal').modal('show');
			}
		})
	});

});
</script>