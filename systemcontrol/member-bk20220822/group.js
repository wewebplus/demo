$(document).ready(function() {

});
function submitFrm(t){
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  var tb = $(t);
  $.ajax({
    'beforeSend': function(){
      $("body").LoadingOverlay("show");
    },
    type:"POST",
    url:FullPath+'member/group-ajax-update.php',
    data:tb.serialize(),
    cache:false,
    success: function(data) {
      // $('#ErrorOtherResult').html(data);
      $.alert({
          //title: 'Set Employee!',
          title: false,
          content: 'Save Data Complete!',
          buttons: {
            OK: function () {

            }
          }
      });
    },
    error: function () {
      alert("Error");
    },
    complete: function(){
      $("body").LoadingOverlay("hide");
    }
  });
  return false;
}
