jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
	$('.bs-component select[name=selectRegion]').on('change', function() {
		var thisname = $(this).attr('name');
		var thisinput = thisname.replace("select","input");
		var thistext = $(this).find("option:selected").text();
		$('input[name='+thisinput+']').val(thistext);
	});
	$('.bs-component select[name=selectCountry]').on('change', function() {
		var thisname = $(this).attr('name');
		var thisinput = thisname.replace("select","input");
		var thistext = $(this).find("option:selected").text();
		$('input[name='+thisinput+']').val(thistext);
	});
	$(".select2_single").select2();
	$(".select2_multiple").select2({
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
      url:FullPath+'thaiembassy/territory-ajax-addnew.php',
      data:tb.serialize(),
      cache:false,
      success: function(data) {
        // $('#ErrorOtherResult').html(data);
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
