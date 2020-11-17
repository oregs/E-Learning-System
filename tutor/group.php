<?php

include('header.php');

?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-7">
				<h3 class="panel-title">Group Details</h3>
			</div>
			<div class="col-md-5" align="right" id="header_detail">
				<button type="button" id="setting_button" class="btn btn-warning btn-sm" style="color:#fff;">Group Setting</button>
         		<button type="button" id="add_button" class="btn btn-primary btn-sm">Manual Group</button>
         		<button type="button" id="auto_button" class="btn btn-info btn-sm">Auto Group</button>
        	</div>
        	<div class="col-md-3 offset-sm-2" align="right" id="back_detail" style="display:none;">
         		<button type="button" id="back_button" class="btn btn-success btn-sm">Back</button>
        	</div>
		</div>
	</div>
	<div class="card-body" id="group_detail">
		<span id="message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="group_detail_table" class="table table-bordered table-striped table-hover">
				<thead class="alert-info">
					<tr>
						<th>S/N</th>
						<th>Course Code</th>
						<th>Course Name</th>
						<th>Group Name</th>
						<!-- <th>Action</th> -->
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div class="card-body" id="member_detail" style="display:none;">
		<span id="group_message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="group_table" class="table table-bordered table-striped table-hover">
				<thead class="alert-info">
					<tr>
						<th>S/N</th>
						<th>Course</th>
						<th>Group Name</th>
						<th>Group Member</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- Manual Grouping Modal -->
<div class="modal" id="groupModal">
	<div class="modal-dialog">
		<form method="post" id="group_form">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title">Tutor Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="row form-group">
					    	<div class="col-md-5 offset-sm-1">
								<select class="form-control" id="group_id" name="group_id">
							    	<option value="" disabled="disabled" selected="selected">Select Group</option>
					              	<?php
					                	echo $exam->Get_data('group_table', 'group_id', 'group_name');
					              	?>
					            </select>
					    	</div>
						    <div class="col-md-5">
						      <div class="form-group">
						        <select class="form-control" id="course_id" name="course_id">
							    	<option value="" disabled="disabled" selected="selected">Select Course</option>
					              	<?php
					                	echo $exam->Get_tutor_course_assign($_SESSION['tutor_id']);
					              	?>
					            </select>
						      </div>
						   	</div>
						</div><br>
						<div class="row">
						    <div class = "col-md-8 form-group" align="center">
						     <label>Select Student</label><br />
							    <select id="user_id" name="user_id[]" class="form-control" multiple="multiple"></select>
							    <span class="text-danger" id="error_user"></span>
							    <!-- An hidden input collecting data from the multiple select 'Student' -->
						   	</div>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="page" value="group" />
			        <input type="hidden" name="action" id="action" value="Add" />
			        <input type="submit" name="group_submit" id="group_submit" class="btn btn-info" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Auto Grouping Modal -->
<div class="modal" id="autoModal">
	<div class="modal-dialog">
		<form method="post" id="auto_group_form">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title">Automatic Grouping</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="box-body">
				          	<div class="row" style="margin-bottom: 10px;">
				              	<div class="row form-group">
				              		<div class="col-md-6 col-sm-offset-1">
				                		<input type="number" name="per_group" id="per_group" placeholder="Students per Group" class="form-control" autocomplete="off">
				                		<span id="error_per_group" class="text-danger"></span>
				              		</div>
				              		<div class="col-md-6">
				                		<div class="form-group">
				                 			<select name="auto_course_id" id="auto_course_id" class="form-control">
				                  				<option value="" disabled="disabled" selected="selected">Select Course</option>
				                       			<?php echo $exam->Get_tutor_course_assign($_SESSION['tutor_id']); ?>
				                  			</select>
				                		</div>
				             		</div>
				            	</div>
				      		</div>
        				</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="page" value="group" />
			        <input type="hidden" name="action" value="auto_group" />
			        <input type="submit" name="auto_submit" id="auto_submit" class="btn btn-info" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Grouping Setting Modal -->
<div class="modal" id="settingModal">
	<div class="modal-dialog">
		<form method="post" id="setting_form">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title">Group Setting</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
	              	<div class="form-group">
	              		<div class="col-md-8 offset-sm-2">
	                		<input type="text" name="group_name" id="group_name" placeholder="Group Name" class="form-control" autocomplete="off">
	                		<span id="error_group_name" class="text-danger"></span>
	              		</div>
	            	</div>
	            	<div class="form-group offset-sm-5">
	            		<input type="submit" name="setting_submit" id="setting_submit" class="btn btn-info btn-sm" />
	            	</div><br />
	            	<span id="alert-message"></span>
	            	<div class="form-group">
		            	<table id="setting_table" class="table table-bordered table-striped table-hover">
							<thead class="alert-info">
								<tr>
									<th>S/N</th>
									<th>Group Name</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="page" value="group" />
			        <input type="hidden" name="action" value="group_setting" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- View Group Details Modal -->
<div class="modal" id="viewModal">
	<div class="modal-dialog">
		<form method="post">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title">Group Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="box-body">
							<form class="form-horizontal">
								<div id="alert_message"></div>
								<div id="view_group"></div>
							</form>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
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
				<button type="button" name="confirm_button" id="confirm_button" class="btn btn-primary btn-sm">OK</button>
				<button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php include '../master/footer.php'; ?>

<script>

$('#user_id').lwMultiSelect();

$(document).ready(function(){

	var groupTable = $('#group_detail_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"tutor_ajax_action.php",
			type:"POST",
			data:{action:'fetch_group', page:'group'}
		},
		"columnDefs":[
			{
				"targets":[],
				"orderable":false
			},
		],
	});

	$('#back_detail').click(function(){
		window.location="group.php";
	});

	function reset_form()
	{
	    $('#group_submit').val('Add');
	    $('#action').val('Add');
	    $('#group_form')[0].reset();
	    $('#user_id').data('plugin_lwMultiSelect').removeAll();
	    $('#group_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
	    $('#groupModal').modal('show');
	    $('#message_operation').html('');
	});

	$('#course_id').change(function(){

		if($(this).val() != '')
		{
			var query = $(this).val();
			var result = '';

			if($(this).attr("id") == 'course_id')
			{
				result = 'user_id';
			}

			$.ajax({
				url:"tutor_ajax_action.php",
	     		method:"POST",
	     		data:{page:'group', action:'get_user', query:query},
	     		success:function(data)
	     		{
	     			$('#'+result).html(data);
	     			if(result == 'user_id')
	     			{
	     				$('#user_id').data('plugin_lwMultiSelect').updateList();
	     			}
	     		}
			})
		}
	});	

	$('#group_form').parsley();

	$('#group_form').on('submit', function(event){
		event.preventDefault();

		$('#course_id').attr('required', 'required');
		$('#group_id').attr('required', 'required');


		if($('#group_form').parsley().validate())
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
		      $('#group_submit').attr('disabled', 'disabled');
		      $('#group_submit').val('Validate..');
		    },
		    success:function(data)
		    {
		      $('#group_submit').attr('disabled', false);
		      $('#group_submit').val($('#action').val());
		      if(data.success)
		      {
		        $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
		       	reset_form();
		       	$('#user_id').data('plugin_lwMultiSelect').updateList();
				$('#user_id').data('plugin_lwMultiSelect').removeAll();
		       	groupTable.ajax.reload();
		       	$('#groupModal').modal('hide');
		      }

		      if(data.error)
		      {
		        $('#error_user').text(data.error_user);
		      }
		    }
		  });
		  setInterval(function(){
				$('#message_operation').html('');
		}, 5000);
		}
	});

	var course_id = '';

	$(document).on('click', '.view_member', function(){
		$('#header_detail').hide();
		$('#back_detail').show();
		$('#member_detail').slideDown();
		$('#group_detail').slideUp();

		course_id = $(this).attr('id');

		group_data();
	}); 

	var group_id = '';

	function group_data(){
		var dataTable = $('#group_table').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"tutor_ajax_action.php",
				type:"POST",
				data:{action:'fetch', page:'group', course_id:course_id}
			},
			"columnDefs":[
				{
					"targets":[2],
					"orderable":false
				},
			],
		});

		$(document).on('click', '.view', function(){

			group_id = $(this).attr('id');
			course_id = $(this).data('course_id');
			$.ajax({
				url:"tutor_ajax_action.php",
				method:"POST",
				data:{page:'group', action:'view', group_id:group_id, course_id:course_id},
				success:function(data)
				{
					$('#viewModal').modal('show');
					$('#view_group').html(data);
				}
			});
		});

		$(document).on('click', '.delete', function(){
			group_id = $(this).attr('id');
			course_id = $(this).data('course_id');
			$('#confirm_button').hide();
			$('#ok_button').show();
			$('#deleteModal').modal('show');
		});

		$('#ok_button').click(function(){
			$.ajax({
				url:"tutor_ajax_action.php",
				method:"POST",
				data:{group_id:group_id, course_id:course_id, action:'delete', page:'group'},
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

		var group_member_id = '';

		$(document).on('click', '.delete_member', function(){
			group_member_id = $(this).attr('id');
			$('#ok_button').hide();
			$('#confirm_button').show();
			$('#deleteModal').modal('show');
		});

		$('#confirm_button').click(function(){
			$.ajax({
				url:"tutor_ajax_action.php",
				method:"POST",
				data:{group_member_id:group_member_id, action:'delete_member', page:'group'},
				success:function(response)
				{
					if(response == "success"){
						$('#deleteModal').modal('hide');
						$('#viewModal').modal('hide');
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
	}

	function auto_reset_form()
	{
	    $('#auto_submit').val('Generate Group');
	    $('#action').val('Add');
	    $('#auto_group_form')[0].reset();
	    $('#error_per_group').empty();
	    $('#auto_group_form').parsley().reset();
	}

	$('#auto_button').click(function(){
		auto_reset_form();
	    $('#autoModal').modal('show');
	    $('#message_operation').html('');
	});

	$('#auto_group_form').parsley();

	$('#auto_group_form').on('submit', function(event){
		event.preventDefault();

		$('#auto_course_id').attr('required', 'required');
		$('#per_group').attr('required', 'required');


		if($('#auto_group_form').parsley().validate())
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
		      $('#auto_submit').attr('disabled', 'disabled');
		      $('#auto_submit').val('Validate..');
		    },
		    success:function(data)
		    {
		      $('#auto_submit').attr('disabled', false);
		      $('#auto_submit').val('Generate Group');
		      if(data.success)
		      {
		        $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
		       	auto_reset_form();
		       	groupTable.ajax.reload();
		       	$('#autoModal').modal('hide');
		      }

		      if(data.error)
		      {
		        $('#error_per_group').text(data.error);
		      }
		    }
		  });
		  setInterval(function(){
				$('#message_operation').html('');
		}, 5000);
		}
	});

	$('#setting_button').click(function(){
		$('#setting_form')[0].reset();
		$('#setting_submit').val('Add');
		$('#error_group_name').empty();
		$('.update').removeAttr('contenteditable');
		$('.update').removeAttr('style');
	    $('#settingModal').modal('show');
	    $('#message_operation').html('');
	});

	$('#setting_form').parsley();

	$('#setting_form').on('submit', function(event){
		event.preventDefault();

		$('#group_name').attr('required', 'required');

		if($('#setting_form').parsley().validate())
		{
		  $.ajax({
		    url:"tutor_ajax_action.php",
		    method:"POST",
		    data:$(this).serialize(),
		    dataType:"json",
		    beforeSend:function()
		    {
		      $('#setting_submit').attr('disabled', 'disabled');
		      $('#setting_submit').val('Validate..');
		    },
		    success:function(data)
		    {
		      $('#setting_submit').attr('disabled', false);
		      $('#setting_submit').val($('#action').val());
		      if(data.success)
		      {
		       	$('#settingModal').modal('hide');
		       	swal({
	                title: data.success,
	                icon: "success",
	                timer: 1000,
	               	button: false,
	          	}).then(function(){
	          			location.reload(true);
	          		});
		      	}

		      if(data.error)
		      {
		     	$('#error_group_name').text(data.error);
		      }
		    }
		  });
		}
	});

	update_field();
	function update_field()
	{
		var settingTable = $('#setting_table').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"tutor_ajax_action.php",
				type:"POST",
				data:{action:'fetch_setting', page:'group'}
			},
			"columnDefs":[
				{
					"targets":[],
					"orderable":false
				},
			],
		});

		$(document).on('click', '.edit_setting', function(e)
		{
			e.preventDefault();
			// alert('yes');
			var add = $(this).attr("id");
			$('#update'+add).attr('contenteditable', true);
			$('#update'+add).attr('style', 'background-color:#fff;border:1px solid #00C0EF;');


			$(document).on('blur', '#update'+add, function(e)
			{
				e.preventDefault();

				group_id = $(this).data("id");
				var value = $(this).text();

				$.ajax({
					url:"tutor_ajax_action.php",
					method:"POST",
					data:{page:'group', action:'update_group', group_id:group_id, value:value},
					dataType:'json',
					success:function(data)
					{
						if(data.success)
						{
							$('#alert-message').html('<div class="alert alert-success">'+data.success+'</div>');
							$('#update'+add).removeAttr('contenteditable');
							$('#update'+add).removeAttr('style');
							settingTable.ajax.reload();
						}

						if(data.error)
						{
							$('#alert-message').html('<div class="alert alert-danger">'+data.error+'</div>');
							$('#update'+add).removeAttr('contenteditable');
							$('#update'+add).removeAttr('style');
						}
						
					}
				})
				setInterval(function(){
					$('#alert-message').html('');
				}, 5000);
			});
		});

		
	}
});
</script>