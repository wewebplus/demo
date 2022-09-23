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
	var toResult = $('#ResultRating');
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
			'url': 'index-ajax-loadpagerating-json.php',
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
				html += '<div class="namecomment">'+json['result'][i].Rating+' <span>'+json['result'][i].CreateDate+'</span></div>';
			html += '</li>';
		}
	}
	toResult.html(html);
}
