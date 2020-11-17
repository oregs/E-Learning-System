<?php 

include('header.php');

$exam->query = "
SELECT * FROM assignment_submission_table
INNER JOIN assignment_table ON  assignment_submission_table.assignment_id = assignment_table.assignment_id
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id  
INNER JOIN user_table ON assignment_submission_table.user_id = user_table.user_id
WHERE assignment_submission_id = ".$_GET["id"]."
";

$result = $exam->query_result();

?>
<div class="card">
	<div class="card-header">
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
						$assignment_num = str_replace('_', ' ', $row['assignment_num']);
					?>
						<table class="table table-bordered">
							<tr>
								<th>Matric Number:</th>
								<td><?= $row["matric_no"]; ?></td>
							</tr>
							<tr>
								<th>Student Fullname:</th>
								<td><?= $row["user_name"]; ?></td>
							</tr>
							<tr>
								<th>Course:</th>
								<td><?= $row["course_code"] ?> -  <?= $row["course_name"]; ?></td>
							</tr>
							<tr>
								<th>Assignment Number:</th>
								<td><?= $assignment_num ?></td>
							</tr>
							<tr>
								<th>Submission Date & Time:</th>
								<td><?= $row["assignment_submission_date"]; ?></td>
							</tr>
							<tr>
								<th>Deadline:</th>
								<td><?= $row["assignment_deadline"]; ?></td>
							</tr>
							<tr>
								<th style="background-color:#3C8DBC; color:white;"><h5><strong>Expected Score</strong></h5></th>
								<td style="background-color:#3C8DBC; color:white;"><h5><strong><?= $row["assignment_score"]; ?></strong></h5></td>
							</tr>
						</table>
							<div class="row form-group">
								<div class="col-md-12">
									<?php 
										$is_assignment_type = '';

										if($row['assignment_type'] == 'file_upload')
										{
											$is_assignment_type = '
											<table class="table table-bordered">
												<tr>
													<th style="color:blue;"><b>Assignment File:</b> Click and download assignment file/document</b></th>
													<td><a href="tutor/assignment_file/'.$row['assignment_bank'].'" class="btn btn-primary btn-md"><span class="fa fa-download"></span> download</a></td>
												</tr>
												</table>
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
								<div class="col-md-12">
									<?php 
										$is_assignment_answer_type = '';

										if($row['assignment_submission_type'] == 'file_upload')
										{
											$is_assignment_type = '
											<table class="table table-bordered">
												<tr>
													<th style="color:blue;"><b>Assignment Answer File:</b> Click and download assignment file/document</th>
													<td><a href="../assignment_file/'.$row['assignment_answer_bank'].'" class="btn btn-primary btn-md"><span class="fa fa-download"></span> download</a></td>
												</tr>
											</table>
											';
										}
										else
										{
											$is_assignment_type = '
											<p style="color:blue;"><b>Assignment Answer:</b></p><div>'. $row['assignment_answer_bank'] .'</div>
											';
										}

										echo '<div>'.$is_assignment_type.'</div>';
									?>
									<hr style="background-color:black;" />
					         	</div>
					        </div>
						<div class="row form-group">
				        <div class="col-sm-4 offset-sm-4">
				            <input type="number" name="mark_award" id="mark_award" class="form-control" placeholder="Input Score" />
				          </div>
				        </div><br />
				        <div class="row">
				        	<div class="col-sm-12" align="center">
				        		<input type="hidden" name="assignment_submission_id" value="<?= $row['assignment_submission_id']; ?>">
				        		<input type="hidden" name="assignment_format" value="<?= $row['assignment_format']; ?>">
				        		<input type="hidden" name="assignment_num" value="<?= $row['assignment_num']; ?>">
				        		<input type="hidden" name="assignment_id" value="<?= $row['assignment_id']; ?>">
				        		<input type="hidden" name="course_id" value="<?= $row['course_id']; ?>">
				        		<input type="hidden" name="tutor_id" value="<?= $row['tutor_id']; ?>">
				        		<input type="hidden" name="group_id" value="<?= $row['group_id']; ?>">
				        		<input type="hidden" name="user_id" value="<?= $row['user_id']; ?>">
            					<input type="hidden" name="page" value="grading" />
            					<input type="hidden" name="action" value="Add" />
            					<input type="submit" name="assignment_submit" id="assignment_submit" class="btn btn-info btn-md" value="Submit" />
          					</div>
        				</div>
        		</form>
        	</div><br>
			<?php } ?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#assignment_form').parsley();

  	$('#assignment_form').on('submit', function(event){
    	event.preventDefault();

      	$('#mark_award').attr('required', 'required');  

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
	          		$('#assignment_submit').val('Submit');

	          	if(data.success)
	          	{
	            	$('#assignment_form')[0].reset();
					swal({
		                title: data.success,
		               	icon: "success",
		                button: "ok",
		          	}).then(function(){
		          		window.location="grading.php";
		          	});
	          	}

	          	if(data.error)
	          	{
	          		swal({
		                title: data.error,
		               	icon: "warning",
		                button: "ok",
		          	});
	          	}
	        }
	      });
	    }
	  });
});
</script>

<?php include '../master/footer.php'; ?>