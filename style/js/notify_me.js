$(document).ready(function(){
  
  setInterval(function(){
    load_unseen_notification();
  }, 5000);

function load_unseen_notification(view = '')
{
  $.ajax({
    url:"tutor_ajax_action.php",
    method:"POST",
    data:{page:'classroom', action:'notification', view:view},
    dataType:"json",
    success:function(data)
    {
      if(data.unseen_notification > 0)
      {
        $('.count').html(data.unseen_notification);
        $('.count').attr('style', 'background-color: red;')
      }

    }
  })
}
});
