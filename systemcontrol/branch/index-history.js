jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  loadpagerating(1);
});
function loadpagerating(page){
	var toResult = $('#ResultHistory');
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
			'url': 'index-ajax-loadpagehistory-json.php',
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
			html += '<li class="listRItem">';
        html += '<div class="detailhistory">';
          html += '<div class="boxstatus">';
            html +='<button type="button" class="btn '+json['result'][i].StatusCss+' br2 btn-sm btn-block"> '+json['result'][i].Statustxt+'</button>';
          html += '</div>';
          html += '<div class="boxdate">'+json['result'][i].CreateDate+'</div>';
          html += '<div class="boxdateexpire">'+json['result'][i].DateshowExpire+'</div>';
        html += '</div>';
				html += '<div class="detailcomment">';
					html += json['result'][i].Comment;
				html += '</div>';
			html += '</li>';
		}
	}
	toResult.html(html);
}
