<?php 

include 'header.php';

?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Tutor List</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="tutor_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Image</th>
						<th>Tutor Name</th>
						<th>Email Address</th>
						<th>Gender</th>
						<th>Mobile No.</th>
						<th>Course Assigned</th>
						<th>Email Verified</th>
						<th>Account Verified</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- View Details Modal -->
<div class="modal" id="detailModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="modal-title">Tutor Details</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body" id="tutor_details">
				
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Course Assign Modal -->
<div class="modal" id="courseModal">
	<div class="modal-dialog" style="max-width:700px;">
		<form method="post" id="course_assign_form" enctype="multipart/form-data">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title">Course Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<label class="col-md-3 text-right">Course<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<select class="form-control" name="course_assign[]" id="course_assign" multiple>
								<?php
									echo $exam->Get_course_data();
								?>
							</select><br>
							<span class="text-danger" id="error_course"></span>
						</div>
					</div>
				</div>
				<div class="col-sm-12" align="center">
					<input type="hidden" name="tutor_id" id="hidden_tutor_id" />
					<input type="hidden" name="page" value="tutor" />
					<input type="hidden" name="action" value="add_course" />
					<input type="hidden" name="course_action" id="course_action" value="Add" />
					<input type="submit" id="add_course_assign" class="btn btn-success btn-" value="Add" />
				</div><br/>
				<div class="form-group">
					<div class="row">
						<table id="course_assign_data" class ="table table-bordered table-striped">
							
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
	</div>
</div>


<?php include 'footer.php'; ?>

<script>

$('#tutor_course').lwMultiSelect();
$('#course_assign').lwMultiSelect();

$(document).ready(function(){
	var dataTable = $('#tutor_data_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'tutor'}
		},
		"columnDefs":[
			{
				"targets":[0,6],
				"orderable":false
			},
		],
	});

	$(document).on('click', '.details', function(){
		var tutor_id = $(this).attr('id');
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'fetch_data', tutor_id:tutor_id, page:'tutor'},
			success:function(data)
			{
				$('#tutor_details').html(data);
				$('#detailModal').modal('show');
			}
		})
	});

	$(document).on('click', '#account_confirmation', function(){
		tutor_id = $('#account_confirmation').data('tutor_id');
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:"verify", page:"tutor", tutor_id:tutor_id, account_confirmation:'Confirm'},
			beforeSend:function()
			{
				$('#account_confirmation').attr('disabled', 'disabled');
				$('#account_confirmation').text('please wait...');
			},
			success:function(data)
			{
				$('#account_confirmation').attr('disabled', false);
				$('#account_confirmation').removeClass('btn-warning');
				$('#account_confirmation').addClass('btn-success');
				$('#account_confirmation').text('Confirmation Successful');
			}
		})
	});

	var tutor_id = '';

	$(document).on('click', '.view_course', function(){
		$('#course_assign_form')[0].reset();
		$('#error_course').empty();

		tutor_id = $(this).attr('id');
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{page:'tutor', action:'course_fetch', tutor_id:tutor_id},
			success:function(data)
			{
				$('#hidden_tutor_id').val(tutor_id);
				$('#courseModal').modal('show');
				$('#course_assign_data').html(data);
			}
		});
	});

	$('#course_assign_form').on('submit', function(event){
		event.preventDefault();
		
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data: new FormData(this),
			dataType:'json',
			contentType:false,
			processData:false,
			beforeSend:function()
			{
				$('#add_course_assign').attr('disabled', 'disabled');
				$('#add_course_assign').val('Validate...');
			},
			success:function(data)
			{
				$('#add_course_assign').attr('disabled', false);
				$('#add_course_assign').val($('#course_action').val());
				if(data.success) 
				{
					$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
					$('#course_assign').data('plugin_lwMultiSelect').updateList();
					$('#course_assign').data('plugin_lwMultiSelect').removeAll();
					$('#courseModal').modal('hide');
					dataTable.ajax.reload();
				}

				if(data.error)
				{
					if(data.error_course != '')
					{
						$('#error_course').text(data.error_course);
					}
					else
					{
						$('#error_course').text('');
					}
				}
			}
		});
	});

	$(document).on('click', '.remove', function(){
		course_assign_id = $(this).val();
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{page:'tutor', action:'delete_course', course_assign_id:course_assign_id},
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-danger">'+data+'</div>');
				$('#courseModal').modal('hide');
				dataTable.ajax.reload();
			}
		});
	});
});
</script>