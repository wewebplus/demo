jQuery(document).ready(function() {
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
function sendEmail01(t){
  var tb = $(t);
  var PathURL = $('#ajaxFrm input[name=PathURL]').val();
  var saveData = $('#myFrm input[name=saveData]').val();
  $.ajax({
    'beforeSend': function(){
      $('.ajax-loader').css("visibility", "visible");
    },
    'type':'POST',
    'data':{saveData:saveData},//myFrm.serialize()
    'url': PathURL+"member/index-ajax-sendmail.php",
    'success': function (data) {
      tb.removeClass('btn-primary').addClass('btn-default');
      //$('#xxxxx').html(data);
      alert(data);
    },
    error: function () {
      alert("Error");
    },
    'complete': function(){
      $('.ajax-loader').css("visibility", "hidden");
    }
  });
}
