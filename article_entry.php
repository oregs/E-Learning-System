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
			</div>
		</div>
	<div class="card-body">
		<!-- <span id="message_operation"></span> -->
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="article_table" class="table table-bordered table-striped table-hover">
				<thead class="alert alert-info">
					<tr>
						<th>S/N</th>
						<th>Staff No.</th>
						<th>Full Name</th>
						<th>Article Title</th>
						<th>Document</th>
						<th>Upload Date</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>	
<script>
$(document).ready(function(){
	var dataTable = $('#article_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "user_ajax_action.php",
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
});
</script>
<?php include 'master/footer.php'; ?>