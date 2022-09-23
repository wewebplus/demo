$(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
});
function clickThisAddLink(t){
	var numItems = $('.item').length;
	$("#boxMyLink").append($("#boxMyLinkMaster").clone().attr({"id": "Clone_Type_"+numItems, "class":"a item clone"}));
	$("#Clone_Type_"+numItems+" input").val('');
	$("#Clone_Type_"+numItems+" select").val('');
}
function clickThisReomveLink(t){
	var tb = $(t);
	tb.closest('div.clone').remove();
}
function saveFrmData(t){
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var frm = tb.closest('form');
	var nreq = frm.find('.fieldreqs').length;
	var nreqchk = 0;
	for(i=0;i<nreq;i++){
		obj = frm.find('.fieldreqs:eq('+i+')');
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
  		url:FullPath+'content/index-link-update.php',
  		data:frm.serialize(),
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
