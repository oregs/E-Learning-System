<?php

include 'header.php';

$classroom_id = $exam->Get_specific_data('classroom_table', 'classroom_code', $_GET['code'], 'classroom_id');

$exam->Comment_viewed($classroom_id);

$exam->query = "
SELECT * FROM classroom_table WHERE classroom_id = ".$classroom_id."";
$result = $exam->query_result();

foreach($result as $row){


?>
 <br />
 <nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background-color:white;">
    <li class="breadcrumb-item"><a href="course_class.php?id=<?= $row['course_id']; ?>">Class List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Class Room</li>
  </ol>
</nav>

<!-- Class Details Section -->
<div class="card">
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-12" >
          <h3 class="panel-title" style="color:white;" align="center">Class Room</h3>
        </div>
      </div>
    </div>
  <div class="card-body">
    <?php
      
        echo '
        <br />
        <div class="col-md-10 offset-sm-1">
          <h5 align="center"><b>'.$row['classroom_title'].'</b></h5>
          <p>'.$row['classroom_description'].'</p>
        </div>
        ';
      }
    ?>
  </div>
</div> 
<br />

<!-- Comment Section -->
<div class="container">
  <form method="post" id="comment_form">
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
    </div>
    <div class="form-group">
      <input type="hidden" name="classroom_id" id="classroom_id" value="<?= $row['classroom_id']; ?>">
      <input type="hidden" name="page" value="classroom">
      <input type="hidden" name="comment_id" id="comment_id" value="0">
      <input type="hidden" name="action" value="add_comment">
      <input type="submit" name="comment_submit" id="comment_submit" class="btn btn-info" value="Submit">
      <div id="message_operation"></div>
    </div>
  </form>
  <div id="display_comment"></div>
</div>
<br />

<script>
$(document).ready(function(){
  $('#comment_form').parsley();

  $('#comment_form').on('submit', function(event){
    event.preventDefault();

      $('#comment_content').attr('required', 'required');  

      if($('#comment_form').parsley().validate())
      {
        $.ajax({
          url:"tutor_ajax_action.php",
          method:"POST",
          data:$(this).serialize(),
          dataType:"json",
          beforeSend:function()
          {
            $('#comment_submit').attr('disabled', 'disabled');
            $('#comment_submit').val('Validate..');
          },
          success:function(data)
          {
            $('#comment_submit').attr('disabled', false);
            $('#comment_submit').val('Submit');

            if(data.success)
            {
              $('#comment_form')[0].reset();
              $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
              $('#comment_form').parsley().reset();
              $('#comment_id').val('0');
              load_comment();
            }
          }
      })
      setInterval(function(){
        $('#message_operation').html('');
      }, 3000);
    }
  });

  load_comment();
  function load_comment()
  {
    var classroom_id = $('#classroom_id').val();
    $.ajax({
      url:"tutor_ajax_action.php",
      method:"POST",
      data:{page:'classroom', action:'fetch_comment', classroom_id:classroom_id},
      success:function(data)
      {
        $('#display_comment').html(data);
      }
    });
  }

  $(document).on('click', '.reply', function(){
    var comment_id = $(this).attr("id");
    $('#comment_id').val(comment_id);
    $('#comment_content').focus();
  });
});
</script>
<?php include '../master/footer.php'; ?>