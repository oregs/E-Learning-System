<?php

include 'header.php';

if(isset($_GET['code']))
{
	$assignment_id = $exam->Get_assignment_id($_GET['code']);
}
else
{
	$assignment_id = $_GET['assignment_id'];
}

$exam->query = "SELECT * FROM assignment_table 
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
INNER JOIN tutor_table ON assignment_table.tutor_id = tutor_table.tutor_id
WHERE assignment_id = ".$assignment_id."
";

$result = $exam->query_result();
date_default_timezone_set('Africa/Lagos');
$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

?>

<div class="card">
	<div class="card-header alert-info">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Assignment Details</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="col-md-12">
			<form method="post" enctype="multipart/form-data" id="assignment_form">
				<?php 
					foreach($result as $row)
					{ 
						if($current_datetime < $row['assignment_deadline'])
						{
							$assignment_num = str_replace('_', ' ', $row['assignment_num']);
					?>
							<table class="table table-bordered">
								<tr>
									<th>Assignment Format:</th>
									<td><?= strtoupper($row["assignment_format"]); ?></td>
								</tr>
								<tr>
									<th>Course:</th>
									<td><?= $row["course_code"] ?> -  <?= $row["course_name"] ?></td>
								</tr>
								<tr>
									<th>Assignment Number:</th>
									<td><?= $assignment_num ?></td>
								</tr>
								<tr>
									<th>Deadline:</th>
									<td><?= $row["assignment_deadline"] ?></td>
								</tr>
								<tr>
									<th style="background-color:#3C8DBC; color:white;"><h5><strong>Score</strong></h5></th>
									<td style="background-color:#3C8DBC; color:white;"><h5><strong><?= $row["assignment_score"] ?></strong></h5></td>
								</tr>
							</table>
							<div class="row form-group">
								<div class="col-sm-12">
									<?php 
										$is_assignment_type = '';

										if($row['assignment_type'] == 'file_upload')
										{
											$is_assignment_type = '
											<p style="color:blue;"><b>Assignment File</b></p>
											<div align="center">
												<a href="tutor/assignment_file/'.$row['assignment_bank'].'" class="btn btn-primary btn-md"><span class="fa fa-download"></span> download</a>
											</div>
											';
										}
										else
										{
											$is_assignment_type = '
											<p style="color:blue;"><b>Assignment Question:</b></p><div>'. $row['assignment_bank'] .'</div>
											';
										}

										echo '<div>'.$is_assignment_type.'</div>';
									?>
									<hr style="background-color:black;" />
					         	</div>
					        </div>
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
								<textarea id="assignment_text1" name="assignment_text" class="form-control" rows="5" data-parsley-trigger="keyup" data-parsley-min-text-size="1" data-parsley-errors-container="#insdescription-errors"data-parsley-required-message="This field is required."data-parsley-min-text-size-message="This field is required."></textarea>
							</div>
							<div class="row form-group" style="display:none;" id="file_upload">
								<div class="col-sm-12 float-label-control offset-sm-4">
									<input type="file" name="assignment_file" id="assignment_file" class="btn btn-primary ladda-button" data-parsley-fileextension='pdf,docx,ppt' />
					          	</div>
					        </div><br />
					        <div class="row">
					        	<div class="col-sm-12" align="center">
					        		<input type="hidden" name="assignment_id" value="<?= $row['assignment_id'] ?>">
	            					<input type="hidden" name="page" value="assignment" />
	            					<input type="hidden" name="action" value="Add" />
	            					<input type="submit" name="assignment_submit" id="assignment_submit" class="btn btn-info btn-md"  />
	          					</div>
	        				</div>
        	</form>
        </div><br>
			<?php }} ?>
		</div>
	</div>
</div>

<script src="style/ckeditor/ckeditor.js"></script>
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

$(document).ready(function(){
	$('#assignment_form').parsley();

	$('#assignment_form').on('submit', function(event){
	    event.preventDefault();
	    // alert($('#assignment_type').val());
	    if($('#assignment_type').val() == 'text_input')
	    {
	      	$('#assignment_type').attr('required', 'required');
	      	$('#assignment_text1').attr('required', '');
	    }
	    else if ($('#assignment_type').val()== 'file_upload')
	    {
	      	$('#assignment_type').attr('required', 'required');
	      	$('#assignment_file').attr('required', 'required');

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
	    else
	    {
	       $('#assignment_type').attr('required', 'required');
	    }

	    if($('#assignment_form').parsley().validate())
	    {
	    	$.ajax({
	    		url:"user_ajax_action.php",
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
	          		$('#assignment_submit').val('Submit');

	          		if(data)
	          		{
	          			$('#assignment_form')[0].reset();
		                swal({
		                	title: "Successfully Submitted",
		                    icon: "success",
		                    button: "ok",
		                }).then(function(){
		                	window.location="index.php";
		                });
		            }
	        	}
	      	});
	    }
	});
});
</script>