<?php

include('header.php');

?>
<br />
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="exam.php">Exam list</a></li>
		<li class="breadcrumb-item active" aria-current="page">Question List</li>
	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Question List</h3>
			</div>
			<div class="col-md-3" align="right">
				<!-- <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button> -->
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="question_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Question Title</th>
						<th>Right Option</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

	<!-- Question Modal -->
<div class="modal" id="questionModal">
	<div class="modal-dialog modal-lg">
		<form method="post" id="question_form">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="question_modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Question Type<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<select class="form-control question_type" disabled="disabled">
								<option value="">Select Question Type</option>
									<option value="Subjunctive">Subjunctive</option>
									<option value="Objective">Objective</option>
								</select> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 text-right">Question Title<span class="text-danger">*</span></label>
							<div class="col-md-8">
								<textarea name="question_title" id="question_title1" class="form-control" rows="5" data-parsley-trigger="keyup"
			                  data-parsley-min-text-size="1"
			                  data-parsley-errors-container="#insdescription-errors"
			                  data-parsley-required-message="This field is required."
			                  data-parsley-min-text-size-message="This field is required.">
			                  	
			           			</textarea>
							</div>
						</div>
					</div>
					<div id="obj_question">
						<div class="form-group">
							<div class="row">
								<label class="col-md-4 text-right">Option 1<span class="text-danger">*</span></label>
								<div class="col-md-8">
									<input type="text" name="option_title_1" id="option_title_1"
									autocomplete="off" class="form-control" /> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-4 text-right">Option 2<span class="text-danger">*</span></label>
								<div class="col-md-8">
									<input type="text" name="option_title_2" id="option_title_2"
									autocomplete="off" class="form-control" /> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-4 text-right">Option 3<span class="text-danger">*</span></label>
								<div class="col-md-8">
									<input type="text" name="option_title_3" id="option_title_3"
									autocomplete="off" class="form-control" /> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-4 text-right">Option 4<span class="text-danger">*</span></label>
								<div class="col-md-8">
									<input type="text" name="option_title_4" id="option_title_4"
									autocomplete="off" class="form-control" /> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-4 text-right">Answer<span class="text-danger">*</span></label>
								<div class="col-md-8">
									<select name="answer_option" id="answer_option" class="form-control">
									<option value="">Select</option>
										<option value="1">1 Option</option>
										<option value="2">2 Option</option>
										<option value="3">3 Option</option>
										<option value="4">4 Option</option>
									</select> 
								</div>
							</div>
						</div>
					</div>
					<div id="contenteditable">
						<div class="form-group">
							<div class="row">
								<label class="col-md-4 text-right">Answer<span class="text-danger">*</span></label>
								<div class="col-md-8">
									<input type="text" name="sub_answer" id="sub_answer" autocomplete="off" class="form-control" />
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="question_id" id="question_id" />
					<input type="hidden" name="question_type" id="question_type" class="question_type" />
					<input type="hidden" name="online_exam_id" id="hidden_online_exam_id" />
					<input type="hidden" name="page" value="question" />
					<input type="hidden" name="action" id="hidden_action" value="edit" />
					<input type="submit" name="question_button_action" id="question_button_action" class="btn btn-success btn-sm" value="Add" />
					<button type="" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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
				<h3 align="center">Are you sure you want to remove this?</h3>
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
CKEDITOR.replace('question_title');
// CKEDITOR.disableAutoInline = true;
// CKEDITOR.inline('option_title_1');

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

$(document).ready(function(){
	var code = "<?php echo $_GET["code"]; ?>";
	var dataTable = $('#question_data_table').DataTable({
		"processing" :true,
		"serverSide" :true,
		"order" :[],
		"ajax" :{
			url:"ajax_action.php",
			method:"POST",
			data:{action:'fetch', page:'question', code:code}
		},
		"columnDefs":[
			{
				"targets" :[2],
				"orderable":false,
			}
		],
	});

	$('#question_form').parsley();
	$('#question_form').on('submit', function(event){
		event.preventDefault();

		var question_type = $('#question_type').val();

		if(question_type == 'Subjunctive')
		{
			$('#question_title').attr('required', 'required');
			$('#sub_answer').attr('required', 'required');
		}
		else if(question_type == 'Objective')
		{
			$('#question_title1').attr('required', '');
			$('#option_title_1').attr('required', 'required');
			$('#option_title_2').attr('required', 'required');
			$('#option_title_3').attr('required', 'required');
			$('#option_title_4').attr('required', 'required');
			$('#answer_option').attr('required', 'required');
		}
		else
		{
			$('#question_type').attr('required', 'required');
		}

		if($('#question_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#question_button_action').attr('disabled', 'disabled');
					$('#question_button_action').val('validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
						location.reload(true);
					}

					$('#question_button_action').attr('disabled', false);
					$('#question_button_action').val($('#hidden_action').val());
				}
			})
		}
	});

	function reset_question_form()
	{
		$('#question_button_action').val('Edit');
		$('#question_form')[0].reset();
		CKEDITOR.instances['question_title1'].setData('');
		$('#question_form').parsley().reset();
	}

	var question_id = '';

	$(document).on('click', '.edit', function(){
		question_id = $(this).attr('id');
		reset_question_form();
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			dataType:"json",
			data:{action:'edit_fetch', question_id:question_id, page:'question'},
			success:function(data)
			{
				if(data.question_type == 'Subjunctive')
				{
					$('#obj_question').attr('style', 'display: none');
					$('#contenteditable').attr('style', 'display: show');
					$('.question_type').val(data.question_type);
					CKEDITOR.instances['question_title1'].setData(data.question_title);
					$('#sub_answer').val(data.answer_option);
					$('#question_id').val(question_id);
					$('#question_modal_title').text('Edit Question Details');
					$('#questionModal').modal('show');
				}
				else if(data.question_type == 'Objective')
				{
					$('#contenteditable').attr('style', 'display: none');
					$('#obj_question').attr('style', 'display: show');
					$('.question_type').val(data.question_type);
					CKEDITOR.instances['question_title1'].setData(data.question_title);
					$('#option_title_1').val(data.option_title_1);
					$('#option_title_2').val(data.option_title_2);
					$('#option_title_3').val(data.option_title_3);
					$('#option_title_4').val(data.option_title_4);
					$('#answer_option').val(data.answer_option);
					$('#question_id').val(question_id);
					$('#question_modal_title').text('Edit Question Details');
					$('#questionModal').modal('show');					
				}
				else
				{
					dataTable.ajax.reload();
					$('#questionModal').modal('hide');
				}
			}
		})
	});

	$(document).on('click', '.delete', function(){
		question_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{question_id:question_id, action:'delete', page:'question'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		});
	});
});

</script>

<?php
include 'footer.php';
?>