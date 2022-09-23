jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('input[name=inputEmail]').filter_input({regex:'[a-zA-Z0-9@._-]'});
	var saveData = $('input[name=saveData]').val();
	$('#myFrm select').on('change', function(){
    var thisname = $(this).attr('name');
    var thisval = $(this).val();
  	var thistext = $(this).find('option:selected').text();
		$('input[name='+thisname+'Text]').val(thistext);
  });
	$( "#ListBtn" ).on( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
function submitForm(t){
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var nreq = tb.find('.fieldreqs').length;
	var nreqchk = 0;
	for(i=0;i<nreq;i++){
		obj = tb.find('.fieldreqs:eq('+i+')');
		objType = obj.attr('type');
		tagName = obj.get(0).tagName;
		title = obj.attr('dataalert');
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
  		url:FullPath+'enew/index-ajax-update.php',
  		data:tb.serialize(),
  		cache:false,
  		success: function(data) {
				$('#ErrorResult').html(data);
  			//alert(data);
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
