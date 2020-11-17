<?php

include('header.php');

?>
<div class="card"><br />
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-9">
          <h3 class="panel-title offset-sm-6">Attendance Module</h3>
        </div>
        <div class="col-md-3" align="right" id="button_detail" style="display:none;">
          <button type="button" id="overall_report_button" class="btn btn-danger btn-sm" style="color:#fff;">Overall Report</button>
          <button type="button" id="back_button" class="btn btn-success btn-sm">Back</button>
        </div>
      </div>
    </div>
  	<div class="card-body" id="attendance_detail">
	    <span id="message_operation"></span>
	    <div class="table-responsive" style="overflow-x:hidden;">
	      	<table id="attendance_table" class="table table-bordered table-striped table-hover">
		        <thead class="alert-info">
			        <tr>
			            <th>Course Code</th>
			            <th>Course Name</th>
			            <th>Total Student</th>
			            <th>Attendance</th>
			        </tr>
			    </thead>
		    </table>
	    </div>
  	</div>
	<div class="card-body" id="student_attendance_detail" style="display:none;">
		<span id="group_message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="student_attendance_table" class="table table-bordered table-striped table-hover">
				<thead class="alert-info">
					<tr>
						<th>Matric No.</th>
						<th>Full Name</th>
						<th>Course</th>
						<th>Attendance Percentage</th>
						<th>Report</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>  

<!-- Report Modal -->
<div class="modal" id="reportModal">
	<div class="modal-dialog">
		<form id="report_form">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title">Make Report</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">
					<div class="form-group">
						<input type="text" name="from_date" id="from_date" class="form-control input-daterange" placeholder="From Date" readonly /><br/>
						<input type="text" name="to_date" id="to_date" class="form-control input-daterange" placeholder="To Date" readonly/>
						
					</div>
				</div>
				<div class="modal-footer"> 
					<input type="hidden" id="report_action" value="pdf_report" />
					<button type="button" name="create_report" id="create_report" class="btn btn-success btn-sm">Create Report</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Overall Report Modal -->
<div class="modal" id="overall_reportModal">
	<div class="modal-dialog">
		<form id="overall_report_form">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Make Report</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">
					<div class="form-group">
						<select class="form-control" name="course_id" id="course_id">
							<option  value="" disabled="disabled" selected="selected">Select Course Code</option>
							<?php echo $exam->Get_tutor_course_assign($_SESSION['tutor_id']); ?>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="report_from_date" id="report_from_date" class="form-control input-daterange" placeholder="From Date" readonly/><br/>
						<input type="text" name="report_to_date" id="report_to_date" class="form-control input-daterange" placeholder="To Date" readonly/>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="button" name="create_overall_report" id="create_overall_report" class="btn btn-success btn-sm">Create Report</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
$(document).ready(function(){

  var dataTable = $('#attendance_table').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
      url: "tutor_ajax_action.php",
      method:"POST",
      data:{page:'attendance', action:'fetch'}
    },
    "columnDef" : [
      {
        "targets" : [4],
        "orderable" : false
      }
    ]
  });

  $('#back_button').click(function(){
		window.location="attendance.php";
	});

  var course_id = '';
  $(document).on('click', '.view', function(){
		$('#button_detail').show();
		$('#student_attendance_detail').slideDown();
		$('#attendance_detail').slideUp();

		course_id = $(this).attr('id');

		attendance_data();
	});

  function attendance_data()
  {
  	var attendanceTable = $('#student_attendance_table').DataTable({
	    "processing" : true,
	    "serverSide" : true,
	    "order" : [],
	    "ajax" : {
	      url: "tutor_ajax_action.php",
	      method:"POST",
	      data:{page:'attendance', action:'fetch_attendance', course_id:course_id}
	    },
	    "columnDef" : [
	      {
	        "targets" : [4],
	        "orderable" : false
	      }
	    ]
	});

	var date = new Date();

  	date.setDate(date.getDate());

	$('.input-daterange').datetimepicker({
		format: 'yyyy-mm-dd',
		autoclose:true
	});

  	var enroll_id = '';
	$(document).on('click', '.report_button', function(){
		enroll_id = $(this).attr('id');
		$('#from_date').val('');
		$('#to_date').val('');
		$('#reportModal').modal('show');
	});

	$('#create_report').click(function(){
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var action = $('#report_action').val();
		
		$('#report_form').parsley();
		$('#from_date').attr('required', 'required');
		$('#to_date').attr('required', 'required');

		if($('#report_form').parsley().validate())
		{
			if(action == 'pdf_report')
			{
				window.open("report.php?action=student_report&enroll_id="+enroll_id+"&from_date="+from_date+"&to_date="+to_date);
				$('#reportModal').modal('hide');
			}
		}
	});
  }

	$(document).on('click', '#overall_report_button', function(){
		$('#course_id').val('');
		$('#report_from_date').val('');
		$('#report_to_date').val('');
		$('#overall_reportModal').modal('show');
	});

	$('#create_overall_report').click(function(){
		var course_id = $('#course_id').val();
		var from_date = $('#report_from_date').val();
		var to_date = $('#report_to_date').val();
		var action = 'overall_pdf_report';
		
		$('#overall_report_form').parsley();
		$('#course_id').attr('required', 'required');
		$('#report_from_date').attr('required', 'required');
		$('#report_to_date').attr('required', 'required');

		if($('#overall_report_form').parsley().validate())
		{
			if(action == 'overall_pdf_report')
			{
				window.open("report.php?action=overall_report&course_id="+course_id+"&report_from_date="+from_date+"&report_to_date="+to_date);
				$('#overall_reportModal').modal('hide');
			}
		}
	});
});
</script>