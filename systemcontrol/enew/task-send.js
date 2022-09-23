jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  calEstimate();
});
function submitForm(t){
  var tb = $(t);
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  $.ajax({
    'beforeSend': function(){
      $("body").LoadingOverlay("show");
    },
    type:"POST",
    url:FullPath+'enew/task-send-update.php',
    data:tb.serialize(),
    cache:false,
    success: function(data) {
      $('#ErrorOtherResult').html(data);
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
function calEstimate() {
	var TotalSend=0;
	var TotalTime=0;
  var user_cat = $("input[name='inputSendType']:checked").val();
  /*
  if($('#radio_button').is(':checked')) {
    alert("it's checked");
  }
  */
  if(user_cat=='Waiting'){
    TotalSend = Math.ceil($('input[name=inputWaitingAccount]').val()/$('select[name=inputSendSize]').val());
    $('input[name=inputTotalSend]').val($('input[name=inputWaitingAccount]').val());
  }else{
    TotalSend = Math.ceil($('input[name=inputTotalAccount]').val()/$('select[name=inputSendSize]').val());
    $('input[name=inputTotalSend]').val($('input[name=inputTotalAccount]').val());
  }
  $('#txtTotalSend').html(TotalSend+' time');
  TotalTime = Math.ceil(TotalSend*$('select[name=inputTimeDelay]').val()/60);
  $('#txtTotalSendTime').html(TotalTime+' minute');
}
