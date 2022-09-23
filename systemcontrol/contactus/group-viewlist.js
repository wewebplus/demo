jQuery(document).ready(function() {
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  loadhistoryreply(1);
});
function submitFrm(t){

  return false;
}
function ReplyMessage(t){
  var tb = $(t);
  var frm = tb.closest('form');
  // var saveData = frm.find('input[name=saveData]').val();
	var insubmit = false;
  var form = $(document.createElement('form'));
  $(form).attr("action", "?");
  $(form).attr("method", "POST");
  var input = $("<input>").attr("type", "hidden").attr("name", "inAction").val('Sendmail');
  $(form).append($(input));
  frm.find('input:text,input:hidden,select,textarea').each(function() {
    if($.trim($(this).val())==''){
      insubmit = false;
      $(this).focusTextToEnd();
      return false;
    }else{
      insubmit = true;
      var input = $("<input>").attr("type", "hidden").attr("name", $(this).attr('name')).val($(this).val());
      $(form).append($(input));
    }
  });
  if(insubmit){
    $.ajax({
  			'beforeSend': function(){
          $("body").LoadingOverlay("show");
  			},
  			'async': false,
  			'global': false,
  			'type':'POST',
  			'data':$(form).serialize(),
  			'url': 'ajax-message-reply.php',
  			'success': function (data) {
          console.log(data);
          $.confirm({
            title: 'แจ้งเตือน!',
            content: 'บันทึกการตอบกลับการติดต่อ เรียบร้อยแล้ว?',
            buttons: {
              confirm: {
              	text: 'ตกลง',
              	btnClass: 'btn-blue',
              	keys: ['enter', 'shift'],
              	action: function(){
                  frm.each(function(){
                    this.reset();
                  });
                  loadhistoryreply(1);
              	}
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
  }
  return false;
}
function loadhistoryreply(page){
  var showhistory = $('#showhistory');
  var json = (function () {
		var json = null;
		var saveData = $('#myFrm input[name=saveData]').val();
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,saveData:saveData},
			'url': 'ajax-loadpagehistoryreply-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
			complete: function(){
				$('.ajax-loader').css("visibility", "hidden");
			}
		});
		return json;
	})();
  var len = json['result'].length;
  var html = '';
  if(len>0){
    for (var i = 0; i< len; i++) {
      html += '<li>';
        html += '<div class="ind1">'+json['result'][i].ListIndex+' '+json['result'][i].StaffName+' '+json['result'][i].CreateDate+'</div>';
        html += '<div class="ind2">'+json['result'][i].Detail+'</div>';
        html += '<div class="ind3">'+json['result'][i].MSGStatus+'</div>';
      html += '</li>';
    }
  }
  showhistory.html(html);
}
