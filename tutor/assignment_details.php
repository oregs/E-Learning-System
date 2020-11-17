<?php 

include('header.php');

?>
<br />
<div class="card">
	<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="panel-title">Assignment Details</h3>
				</div>
				<div class="col-md-3" align="right">
					<button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
				</div>
			</div>
		</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="assignment_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Course</th>
						<th>Assignment Number</th>
						<th>Submission Time</th>
						<th>Category</th>
						<th>Assignment Question / File</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- Assignment Details Modal -->
<div class="modal" id="assignmentDetailsModal">
	<div class="modal-dialog" style="max-width:700px;">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Assignments Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal Body -->
			<div class="modal-body" id="assignment_details">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Assignment Details Modal -->
<div class="modal" id="assignmentModal">
	<div class="modal-dialog" style="max-width:700px;">
		<form method="post" enctype="multipart/form-data" id="assignment_form">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title"></h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">
					<div class="row form-group">
			           <div class="col-sm-6 offset-sm-3">
			            <select class="form-control" name="assignment_type" id="assignment_type" onchange="selectbox()">
			              <option disabled="disabled" selected="selected">Select Assignment Type</option>
			              <option value="text_input">Text Input</option>
			              <option value="file_upload">File Upload</option>
			            </select>
			          </div>
			        </div>

			        <div class="form-group" style="display:none;" id="text_input">
			          	<textarea id="assignment_text1" name="assignment_text" class="form-control" rows="5" data-parsley-trigger="keyup"
			                  data-parsley-min-text-size="1"
			                  data-parsley-errors-container="#insdescription-errors"
			                  data-parsley-required-message="This field is required."
			                  data-parsley-min-text-size-message="This field is required.">
			                  	
			           	</textarea>
			        </div><br>

			        <div class="row form-group" style="display:none;" id="file_upload">
			          <div class="col-sm-12 float-label-control offset-sm-3">
			            <input type="file" name="assignment_file" id="assignment_file" class="btn btn-primary ladda-button" data-parsley-fileextension='pdf,docx,ppt' /><br /><br />
			            <div id="hidden_assignment" style="display:none;">
				           <a href="" class="btn btn-info btn-sm" id="assignment_source">Download</a>
				           <input type="hidden" name="hidden_assignment_file" id="hidden_assignment_file" />
						</div>
			          </div>
			        </div><br />

			        <div class="row form-group">
			           <div class="col-sm-6">
			            <select class="form-control" id="assignment_num" name="assignment_num">
			              <option value="" disabled="disabled" selected="selected">Select AssignmentId</option>
			              <option value="Assignment_1">Assignment 1</option>
			              <option value="Assignment_2">Assignment 2</option>
			              <option value="Assignment_3">Assignment 3</option>
			              <option value="Assignment_4">Assignment 4</option>
			              <option value="Assignment_5">Assignment 5</option>
			            </select>
			            <span class="text-danger" id="error_assignment_num"></span>
			          </div>
			          <div class="col-sm-6">
			            <select class="form-control" id="course_id" name="course_id">
			              <option value="" disabled="disabled" selected="selected">Select Course Code</option>
			              <?php echo $exam->Get_tutor_course_assign($_SESSION['tutor_id']); ?>
			            </select>
			        </div>
			        </div>

			        <div class="row form-group">
			          <div class="col-sm-6">
			            <input type="text" class="form-control" id="assignment_score" name="assignment_score" Placeholder="Score">
			          </div>

			          <div class="col-sm-6">
			            <input type="text" name="assignment_deadline" id="assignment_deadline" class="form-control" placeholder="Submission Time" readonly="" />
			          </div>
			        </div>

			        <div class="row form-group">
			           <div class="col-sm-6">
			            <select class="form-control selectpicker"  name="assignment_format" id="assignment_format" onchange="selectformat()">
			              <option value="" disabled="disabled" selected="selected">Select Format</option>
			              <option value="individual">Individual</option>
			              <option value="group">Group</option>
			            </select>
			          </div>
			          <div class="col-sm-6" style="display:none;" id="group">
			            <select class="form-control" name="group_id" id="group_id">
			            </select>
			          </div>
			        </div><br />
			        <div class="row">
			          <div class="col-sm-12" align="center">
			          	<input type="hidden" name="assignment_id" id="assignment_id" />
			            <input type="hidden" name="page" value="assignment" />
			            <input type="hidden" name="action" id="action" value="Add" />
			            <input type="submit" name="assignment_submit" id="assignment_submit" class="btn btn-info" />
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

<script src="../style/ckeditor/ckeditor.js"></script>

<script>
CKEDITOR.replace('assignment_text');

 CKEDITOR.on('instanceReady', function () {
  $.each(CKEDITOR.instances, function (instance) {
    CKEDITOR.instances[instance].on("change", function (e) {
      for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
        $('form textarea').parsley().validate();
      }
    });
  });
});

function selectbox()
{
  var assignment_type = $('#assignment_type').val();

  if(assignment_type == 'text_input')
  {
    $('#text_input').show();
    $('#file_upload').hide();
  }
  else if(assignment_type == 'file_upload')
  {
    $('#file_upload').show();
    $('#text_input').hide();
  }
  else
  {
    $('#text_input').hide();
    $('#file_upload').hide();
  }
}

function selectformat()
{
  var assignment_format = $('#assignment_format').val();

  if(assignment_format == 'group')
  {
    $('#group').show();
  }
  else
  {
    $('#group').hide();
  }
}

$(document).ready(function(){

	var dataTable = $('#assignment_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "tutor_ajax_action.php",
			method:"POST",
			data:{page:'assignment', action:'fetch'}
		},
		"columnDef" : [
			{
				"targets" : [4],
				"orderable" : false
			}
		]
	});

	function reset_form()
	{
		$('#modal-title').text('Add Assignment Details');
		$('#assignment_submit').val('Add');
		$('#action').val('Add');
		$('#text_input').attr('style', 'display:none');
		$('#file_upload').attr('style', 'display:none');
		$('#assignment_form')[0].reset();
		CKEDITOR.instances['assignment_text1'].setData('');
		$('#assignment_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#assignmentModal').modal('show');
		$('#hidden_assignment').attr('style', 'display: none');
		$('#message_operation').html('');
	});

	var date = new Date();

  	date.setDate(date.getDate());

	$('#assignment_deadline').datetimepicker({
	startDate :date,
	format: 'yyyy-mm-dd hh:ii',
	autoclose:true
	});

	$('#assignment_form').parsley();

	$('#assignment_form').on('submit', function(event){
		event.preventDefault();
		// alert($('#assignment_type').val());
		if($('#assignment_type').val() === 'text_input')
		{
			$('#assignment_type').attr('required', 'required');
			$('#assignment_text1').attr('required', '');
		  	$('#assignment_score').attr('required', 'required');
		  	$('#course_id').attr('required','required');
		  	$('#assignment_deadline').attr('required', 'required');
		  	$('#assignment_format').attr('required', 'required');
		  	$('#assignment_num').attr('required','required');
		}
		else if ($('#assignment_type').val() === 'file_upload')
		{
			if($('#action').val() === 'edit')
			{
				$('#assignment_type').attr('required', 'required');
				$('#assignment_score').attr('required', 'required');
				$('#course_id').attr('required','required');
				$('#assignment_deadline').attr('required', 'required');
				$('#assignment_format').attr('required', 'required');
				$('#assignment_num').attr('required','required');
			}
			else if($('#action').val() === 'Add')
			{
				$('#assignment_type').attr('required', 'required');
				$('#assignment_file').attr('required', 'required');
				$('#assignment_score').attr('required', 'required');
				$('#course_id').attr('required','required');
				$('#assignment_deadline').attr('required', 'required');
				$('#assignment_format').attr('required', 'required');
				$('#assignment_num').attr('required','required');

				window.ParsleyValidator.addValidator('fileextension', function(value, requirement){
				var tagslistarr = requirement.split(',');
				var fileExtension = value.split('.').pop();
				var arr = [];
				$.each(tagslistarr, function(i, val){
				  arr.push(val);
				});

				if(jQuery.inArray(fileExtension, arr) != '-1')
				{
				  console.log("Is in array");
				  return true;
				}
				else
				{
				  console.log("Is NOT in array");
				  return false;
				}
				  }, 32).addMessage('en', 'fileextension', 'The extension doesn\'t match the required');
			}
		}
		else
		{
		   $('#assignment_type').attr('required', 'required');
		}

		if($('#assignment_form').parsley().validate())
		{
		  $.ajax({
		    url:"tutor_ajax_action.php",
		    method:"POST",
		    data:new FormData(this),
		    dataType:"json",
		    contentType:false,
		    cache:false,
		    processData:false,
		    beforeSend:function()
		    {
		      $('#assignment_submit').attr('disabled', 'disabled');
		      $('#assignment_submit').val('Validate..');
		    },
		    success:function(data)
		    {
		      $('#assignment_submit').attr('disabled', false);
		      $('#assignment_submit').val($('#action').val());
		      if(data.success)
		      {
		        $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
		       	reset_form();
		       	location.reload(true);
		       	// dataTable.ajax.reload();
		       	// $('#assignmentModal').modal('hide');
		      }

		      if(data.error)
		      {
		        $('#error_assignment_num').text(data.error);
		      }
		    }
		  });
		}
	});

	var assignment_id = '';

	$(document).on('click', '.view', function(){

		assignment_id = $(this).attr('id');
		$.ajax({
			url:"tutor_ajax_action.php",
			method:"POST",
			data:{page:'assignment', action:'view', assignment_id:assignment_id},
			success:function(data)
			{
				$('#assignmentDetailsModal').modal('show');
				$('#assignment_details').html(data);
			}
		});
	});

	$(document).on('click', '.edit', function(){
		assignment_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"tutor_ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', assignment_id:assignment_id, page:'assignment'},
			dataType:"json",
			success:function(data)
			{
				// alert(data.assignment_type);
				if(data.assignment_type === 'file_upload')
				{
					$('#text_input').attr('style', 'display: none');
					$('#file_upload').attr('style', 'display: show');
					$('#group').attr('style', 'display: show');
					$('#hidden_assignment').attr('style', 'display: show');
					$('#assignment_id').val(assignment_id);
					$('#assignment_type').val(data.assignment_type);
					$('#assignment_source').attr('href', 'assignment_file/'+data.assignment_bank+'');
					$('#hidden_assignment_file').val(data.assignment_bank);
					$('#assignment_num').val(data.assignment_num);
					$('#assignment_score').val(data.assignment_score);
					$('#course_id').val(data.course_id);
					$('#assignment_format').val(data.assignment_format);
					$('#assignment_deadline').val(data.assignment_deadline);
					$('#assignment_submit').val('Edit');
					$('#action').val('edit');
					$('#assignmentModal').modal('show');
				}
				else if(data.assignment_type === 'text_input')
				{
					$('#file_upload').attr('style', 'display: none');
					$('#hidden_assignment').attr('style', 'display: none');
					$('#text_input').attr('style', 'display: show');
					$('#group').attr('style', 'display: show');
					$('#assignment_id').val(assignment_id);
					$('#assignment_type').val(data.assignment_type);
					CKEDITOR.instances['assignment_text1'].setData(data.assignment_bank);
					$('#assignment_num').val(data.assignment_num);
					$('#assignment_score').val(data.assignment_score);
					$('#course_id').val(data.course_id);
					$('#assignment_format').val(data.assignment_format);
					$('#assignment_deadline').val(data.assignment_deadline);
					$('#assignment_submit').val('Edit');
					$('#action').val('edit');
					$('#assignmentModal').modal('show');
				}
				else
				{
					dataTable.ajax.reload();
					$('#assignmentModal').modal('hide');
				}
			}
		})
	});

	$(document).on('click', '.delete', function(){
		assignment_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"tutor_ajax_action.php",
			method:"POST",
			data:{assignment_id:assignment_id, action:'delete', page:'assignment'},
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
		          		dataTable.ajax.reload();
		          	});
				}
			}
		})
	});

	var course_id = '';
	$('#course_id').on('click', function(){
		course_id = $(this).val();
		$.ajax({
			url:"tutor_ajax_action.php",
			method:"POST",
			data:{page:'assignment', action:'get_group', course_id:course_id},
			success:function(data)
			{
				$('#group_id').html(data);
			}
		});
	});
});

</script>

<?php include '../master/footer.php'; ?>