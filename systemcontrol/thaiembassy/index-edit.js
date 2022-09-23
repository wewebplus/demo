jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('input[name=inputZipCode]').filter_input({regex:'[0-9]'});
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
		$('.bs-component select[name=selectCountry]').on('change', function() {
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
		$(".select2_single").select2();
		$(".select2-multiple").select2({
			placeholder: "Select a state",
			allowClear: true
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
	if(nreq==nreqchk){
		$.ajax({
      'beforeSend': function(){
        $("body").LoadingOverlay("show");
      },
      type:"POST",
      url:FullPath+'thaiembassy/index-ajax-update.php',
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
