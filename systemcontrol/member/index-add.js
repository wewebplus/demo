jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('input[name=inputZipCode]').filter_input({regex:'[0-9]'});
	$('input[name=inputRefNo]').filter_input({regex:'[0-9]'});

	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});

    // Init Bootstrap Maxlength Plugin
    $('input[maxlength]').maxlength({
		threshold: 20,
      	placement: "right"
    });
		$('.bs-component select').on('change', function() {
			var thisname = $(this).attr('name');
			var thisinput = thisname.replace("select","input");
			var thistext = $(this).find("option:selected").text();
			$('input[name='+thisinput+']').val(thistext);
		});
		$(".toggle-password").click(function() {
	     $(this).toggleClass("fa-eye-slash fa-eye");
	     var input = $($(this).attr("toggle"));
	     if (input.attr("type") == "password") {
	       input.attr("type", "text");
	     } else {
	       input.attr("type", "password");
	     }
	     input.focusTextToEnd();
	  });
});
function submitFrm(t){
  var tb = $(t);
  var nreq = tb.find('.reqs').length;
  var nreqchk = 0;
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  for(i=0;i<nreq;i++){
		obj = tb.find('.reqs:eq('+i+')');
		objType = obj.attr('type');
		tagName = obj.get(0).tagName;
		title = obj.attr('placeholder');
		if(objType=='hidden'){
			var pre = '';
		}else{
      if(tagName=='SELECT'){
        var pre = '';//กรถณาเลือก
      }else{
        var pre = '';//กรุณากรอก
      }
		}
		var txtshow = pre+title;
		if(obj.val()==''){
      obj.closest('div.frmalert').find('.errorText').remove();
			obj.closest('div.frmalert').append('<div class="errorText">'+txtshow+'</div>');
			obj.focus();
			return false;
		}else{
			nreqchk = nreqchk+1;
			obj.closest('div.frmalert').find('.errorText').remove();
		}
	}
	var mypass = tb.find('input[name=inputPassword]');
  var myconfirmpass = tb.find('input[name=inputConfirmPassword]');
  if(chkPassKey($.trim(mypass.val()))){
		mypass.closest('div.frmalert').find('.errorText').remove();
    if($.trim(mypass.val())!=$.trim(myconfirmpass.val())){
      myconfirmpass.closest('div.frmalert').find('.errorText').remove();
      myconfirmpass.closest('div.frmalert').append('<div class="errorText">รหัสผ่านไม่ตรงกัน</div>');
      myconfirmpass.focusTextToEnd();
      $('#ErrorPassResult').hide();
      $('#ErrorPassResult').removeClass('fonnreq');
      return false;
    }else{
      myconfirmpass.closest('div.frmalert').find('.errorText').remove();
      //$('#ErrorOtherResult').hide();
      //$('#ErrorOtherResult').removeClass('fonnreq');
    }
  }else{
    mypass.closest('div.frmalert').find('.errorText').remove();
    mypass.closest('div.frmalert').append('<div class="errorText">รูปแบบรหัสผ่านไม่ถูกต้อง</div>');
    $('#ErrorPassResult').html('ความยาวอย่างน้อย 8 ตัวอักษรและประกอบไปด้วยตัวอักษร (A-Z, a-z, 0-9) และไม่มีเครื่องหมายหรืออักขระพิเศษ');
    $('#ErrorPassResult').show();
    $('#ErrorPassResult').addClass('fonnreq');
    mypass.focusTextToEnd();
    return false;
  }
	if(nreq==nreqchk){
		$.ajax({
      'beforeSend': function(){
        $("body").LoadingOverlay("show");
      },
      type:"POST",
      url:FullPath+'member/index-ajax-addnew.php',
      data:tb.serialize(),
      cache:false,
      success: function(data) {
        //$('#ErrorOtherResult').html(data);
				var mydata = $('#ajaxFrm input[name=LoginData]').val();
				var url = getfullUrl()+'?'+mydata;
				$.alert({
				    //title: 'Set Employee!',
				    title: false,
				    content: 'Save Data Complete!',
				    buttons: {
				    	OK: function () {
				    		window.location = url;
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
