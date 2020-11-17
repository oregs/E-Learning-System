<?php

include('header.php');

$exam->query = "
	SELECT * FROM tutor_table
	WHERE tutor_id = '".$_SESSION['tutor_id']."'
";

$result = $exam->query_result();

// die(var_dump($result));

?>

	<!-- <div class="container"> -->
		<!-- <div class="d-flex justify-content-center"> -->
			<!-- <br /><br /> -->
			<span id="message"></span>
			<div class="card" style="margin-top:50px; margin-bottom: 100px;">
				<div class="card-header"><h4>Profile</h4></div>
				<div class="card-body">
					<form method="post" id="profile_form">
					<?php
					foreach($result as $row)
					{
					?>
						<script>
							$(document).ready(function(){
								$('#tutor_gender').val("<?= $row["tutor_gender"]; ?>");
							});
						</script>
						<div class="form-group">
							<label>Enter Name</label>
							<input type="text" name="tutor_full_name" id="tutor_full_name" class="form-control" value="<?= $row["tutor_full_name"]; ?>" />
						</div>
						<div class="form-group">
							<label>Select Gender</label>
							<select name="tutor_gender" id="tutor_gender" class="form-control">
								<option value="Male">Male</option>		
								<option value="Female">Female</option>
							</select>
						</div>
						<!-- <div class="form-group">
							<label>Enter Address</label>
							<textarea name="tutor_address" id="tutor_address" class="form-control"><?= $row["tutor_address"]; ?></textarea>
						</div> -->
						<div class="form-group">
							<label>Enter Mobile Number</label>
							<input type="text" name="tutor_mobile_no" id="tutor_mobile_no" class="form-control" value="<?= $row["tutor_mobile_no"]; ?>" />
						</div>
						<div class="form-group">
							<label>Select Profile Image</label>
							<input type="file" name="tutor_image" id="tutor_image" accept="image/*" /><br />
							<img src="upload/<?= $row["tutor_image"]; ?>" class="img-thumbnail" width="250" />
							<input type="hidden" name="hidden_tutor_image" value="<?= $row["tutor_image"] ?>" />
						</div>
						<br />
						<div class="form-group" align="center">
							<input type="hidden" name="page" value="profile" />
							<input type="hidden" name="action" value="profile" />
							<input type="submit" name="tutor_profile" id="tutor_profile" class="btn btn-info" value="Save" />
						</div>
					<?php
					}
					?>
					</form>
				</div>
			</div>	
			<br /><br />
			<br /><br />	
		<!-- </div> -->
	<!-- </div> -->
<script>
$(document).ready(function(){
	$('#profile_form').parsley();
	$('#profile_form').on('submit', function(event){
		event.preventDefault();

		$('#tutor_name').attr('required', 'required');
		$('#tutor_name').attr('data-parsley-pattern', '^[a-z A-Z]+$');
		// $('#tutor_address').attr('required', 'required');
		$('#tutor_mobile_no').attr('required', 'required');
		$('#tutor_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');
		if($('#profile_form').parsley().validate())
		{
			$.ajax({
				url:"tutor_ajax_action.php",
				method:"POST",
				data:new FormData(this),
				dataType:'json',
				contentType:false,
				cache:false,
				processData:false,
				beforeSend:function()
				{
					$('#tutor_profile').attr('disabled', 'disabled');
					$('#tutor_profile').val('please wait...');
				},
				success:function(data)
				{
					if(data.success)
					{
						location.reload(true);
					}
					else
					{
						$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
					}
					$('#tutor_profile').attr('disabled', false);
					$('#tutor_profile').val('Save');
				}
			})
		}
	});
});
</script>
<?php include("../master/footer.php"); ?>