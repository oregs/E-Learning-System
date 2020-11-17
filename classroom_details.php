<?php

include 'header.php';

?>
<div class="card"><br />
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-9">
          <h3 class="panel-title" align="center">Class Room Details</h3>
        </div>
        <div class="col-md-3" align="right">
          <button type="button" id="add_button" class="btn btn-primary btn-sm">Add</button>
        </div>
      </div>
    </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive" style="overflow-x:hidden;">
      <table id="classroom_table" class="table table-bordered table-striped table-hover">
        <thead class="alert-info">
          <tr>
            <th>S/N</th>
            <th>Course</th>
            <th>Topic</th>
            <th>Document</th>
            <th>Date & Time</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>  

<!-- Classroom Details Modal -->
<div class="modal" id="classroomModal">
  <div class="modal-dialog" style="max-width:700px;">
    <form method="post" enctype="multipart/form-data" id="classroom_form">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-2 text-right">Course<span class="text-danger">*</span></label>
              <div class="col-md-10">
                <select class="form-control" id="course_id" name="course_id">
                    <option value="" disabled="disabled" selected="selected">Select Course Code</option>
                    <?php echo $exam->Get_tutor_course_assign($_SESSION['tutor_id']); ?>
                  </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-2 text-right">Title<span class="text-danger">*</span></label>
              <div class="col-md-10">
                <input type="text" name="classroom_title" id="classroom_title" class="form-control" />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-2 text-right">Desciption<span class="text-danger">*</span></label>
                <div class="col-md-10">
                 <textarea id="classroom_description1" name="classroom_description" class="form-control" rows="5" data-parsley-trigger="keyup" data-parsley-min-text-size="1" data-parsley-errors-container="#insdescription-errors" data-parsley-required-message="This field is required." data-parsley-min-text-size-message="This field is required.">
                </textarea>
              </div>
            </div>
          </div>
    
          <div class="form-group">
            <div class="row">
              <label class="col-md-2 text-right">Document<span class="text-danger">*</span></label>
              <div class="col-md-10">
                <input type="file" name="classroom_file" id="classroom_file" class="btn btn-primary ladda-button" data-parsley-fileextension='pdf,docx,ppt' />
                <input type="hidden" name="hidden_classroom_file" id="hidden_classroom_file"  />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="classroom_id" id="classroom_id" />
          <input type="hidden" name="page" value="classroom" />
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="classroom_submit" id="classroom_submit" class="btn btn-info" />
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

CKEDITOR.replace('classroom_description');

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

  var dataTable = $('#classroom_table').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
      url: "tutor_ajax_action.php",
      method:"POST",
      data:{page:'classroom', action:'fetch'}
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
    $('#modal-title').text('Add Classroom Details');
    $('#classroom_submit').val('Add');
    $('#action').val('Add');
    $('#classroom_form')[0].reset();
    CKEDITOR.instances['classroom_description1'].setData('');
    $('#classroom_form').parsley().reset();
  }

  $('#add_button').click(function(){
    reset_form();
    $('#classroomModal').modal('show');
    $('#message_operation').html('');
  });

  $('#classroom_form').parsley();

    $('#classroom_form').on('submit', function(event){
      event.preventDefault();

        $('#course_id').attr('required', 'required');
        $('#classroom_title').attr('required', 'required');
        $('#classroom_description1').attr('required', 'required'); 

        window.Parsley.addValidator('fileextension', function(value, requirement){
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

      if($('#classroom_form').parsley().validate())
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
            $('#classroom_submit').attr('disabled', 'disabled');
            $('#classroom_submit').val('Validate..');
          },
          success:function(data)
          {
            $('#classroom_submit').attr('disabled', false);
            $('#classroom_submit').val('Submit');

            if(data.success)
            {
              $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
              reset_form();
              dataTable.ajax.reload();
              $('#classroomModal').modal('hide');
            }
          }
      })
      setInterval(function(){
        $('#message_operation').html('');
      }, 5000);
    }
  });

  var classroom_id = '';

  $(document).on('click', '.edit', function(){
    classroom_id = $(this).attr('id');

    reset_form();

    $.ajax({
      url:"tutor_ajax_action.php",
      method:"POST",
      data:{action:'edit_fetch', classroom_id:classroom_id, page:'classroom'},
      dataType:"json",
      success:function(data)
      {
        $('#classroom_id').val(classroom_id);
        $('#classroom_title').val(data.classroom_title); 
        $('#hidden_classroom_file').val(data.classroom_file);       
        CKEDITOR.instances['classroom_description1'].setData(data.classroom_description);
        $('#course_id').val(data.course_id);
        $('#classroom_submit').val('Edit');
        $('#action').val('Edit');
        $('#classroomModal').modal('show');        
      }
    })
  });

  $(document).on('click', '.delete', function(){
    classroom_id = $(this).attr('id');
    $('#deleteModal').modal('show');
  });

  $('#ok_button').click(function(){
    $.ajax({
      url:"tutor_ajax_action.php",
      method:"POST",
      data:{classroom_id:classroom_id, action:'delete', page:'classroom'},
      dataType:'json',
      success:function(data)
      {
        if(data.success)
        {
          $('#message_operation').html('<div class="alert alert-danger">'+data.success+'</div>');
          dataTable.ajax.reload();
          $('#deleteModal').modal('hide');
        }
      }
    })
    setInterval(function(){
        $('#message_operation').html('');
      }, 5000);
  });
});
</script>
<?php include '../master/footer.php'; ?>