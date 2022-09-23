$(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
	loadpagecomment(1);
});
function loadpagecomment(page){
	var toResult = $('#ResultComment');
	var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
		var saveData = $('#myFrm input[name=saveData]').val();
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,saveData:saveData},
			'url': 'index-ajax-loadpagecomment-json.php',
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
			html += '<li class="">';
				html += '<div class="namecomment">'+json['result'][i].CreateBy+' <span>'+json['result'][i].CreateDate+'</span></div>';
				html += '<div class="detailcomment">';
					html += json['result'][i].Detail;
				html += '</div>';
			html += '</li>';
		}
	}
	toResult.html(html);
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
  		url:FullPath+'content/index-comment-update.php',
  		data:frm.serialize(),
  		cache:false,
  		success: function(data) {
				// $('#ErrorResult').html(data);
				frm.each(function(){
					this.reset();
				});
				loadpagecomment(1);

  			//alert(data);
				// var mydata = $('#ajaxFrm input[name=LoginData]').val();
				// var url = getfullUrl()+'?'+mydata;
  			// $.alert({
  			// 	    //title: 'Set Employee!',
  			// 	    title: false,
  			// 	    content: 'Save Data Complete!',
  			// 	    buttons: {
  			// 	    	OK: function () {
  			// 	    		window.location = url;
  			// 	    	}
  			// 	    }
  			// 	});
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
