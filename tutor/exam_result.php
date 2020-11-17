<?php

include 'header.php';

?>
<br />
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="exam_result_details.php">Exam List</a></li>
		<li class="breadcrumb-item active" aria-current="page">Exam Result</li>
	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Exam Result</h3>
			</div>
			<div class="col-md-3" align="right">
				<a href="pdf_exam_result.php?code=<?= $_GET["code"] ?>" class="btn btn-danger btn-sm" target="_blank">PDF</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="result_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Image</th>
						<th>User Name</th>
						<th>Course</th>
						<th>Attending Status</th>
						<th>Marks</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<?php include '../master/footer.php'; ?>

<script>
$(document).ready(function(){

	var code = "<?= $_GET["code"]; ?>";

	var dataTable = $('#result_table').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"tutor_ajax_action.php",
			method:"POST",
			data:{action:'fetch_result', page:'exam_result', code:code}
		}
	});
});
</script>
