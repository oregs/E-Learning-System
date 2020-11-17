<?php

include('header.php');

?>
<br />
<div class="card">
	<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="panel-title">Article List</h3>
				</div>
				<div class="col-md-3" align="right">
					<button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
				</div>
			</div>
		</div>
	<div class="card-body">
		<!-- <span id="message_operation"></span> -->
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="article_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>S/N</th>
						<th>Staff No.</th>
						<th>Full Name</th>
						<th>Article Title</th>
						<th>Document</th>
						<th>Upload Date</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>	

<!-- Session Modal -->
<div class="modal" id="uploadModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title">Edit Session Details</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<label class="col-md-12 alert alert-info"><span class="text-danger"><b>NOTE:</b></span> Before upload named your document(s) by it title</label>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="wrapper">
							<div class="upload-console" style="color:#fefefe;">
								<div class="upload-console-body">
									<h5>Select files from computer</h5>
									<form action="upload.php" method="post" enctype="multipart/form-data" id="article_form">
										<input type="file" name="files[]" id="standard-upload-files" multiple>
										<input type="submit" value="Upload files" id="standard-upload" class="btn btn-primary">
									</form><br />

									<h5>Or drag and drop files below</h5>
									<div class="upload-console-drop" id="drop-zone">
										Just drag and drop files here
									</div>

									<div class="bar">
										<div class="bar-fill" id="bar-fill">
											<div class="bar-fill-text" id="bar-fill-text"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<!-- <div class="modal-footer"> -->
				<button type="button" id="close_button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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

<script src="../style/js/upload.js"></script>
<script src="../style/js/global.js"></script>

<script>
$(document).ready(function(){
	var dataTable = $('#article_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "tutor_ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'article'}
		},
		"columnDef" : [
			{
				"targets" : [3],
				"orderable" : false
			}
		]
	});

	$('#add_button').click(function(){
		$('#article_form')[0].reset();
		$('#bar-fill').css('width', '0');
		$('#bar-fill-text').empty();
		$('#uploadModal').modal('show');
	});

	var article_id = '';

	$(document).on('click', '.delete', function(){
		article_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"tutor_ajax_action.php",
			method:"POST",
			data:{article_id:article_id, action:'delete', page:'article'},
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
});
</script>
<?php include '../master/footer.php'; ?>