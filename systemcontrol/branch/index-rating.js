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
			html += '<li class="listRItem">';
        html += '<div class="detailrating">';
          html += '<div class="boxrating">'+json['result'][i].ShowRating+'</div>';
          html += '<div class="boxdate">'+json['result'][i].CreateDate+'</div>';
          html += '<div class="boxname">'+json['result'][i].MemberFullName+'</div>';
          html += '<div class="boxstatus">';
            html +='<div class="btn-group text-right">';
      				html +='<button type="button" class="btn '+json['result'][i].StatusCss+' br2 btn-sm fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> '+json['result'][i].Statustxt;
      				html +='<span class="caret ml5"></span>';
      				html +='</button>';
      				html += json['result'][i].StatusBtn;
    				html +='</div>';
          html += '</div>';
        html += '</div>';
				html += '<div class="detailcomment">';
					html += json['result'][i].Comment;
				html += '</div>';
			html += '</li>';
		}
	}
	toResult.html(html);
}
function changeRatingStatus(t){
	var row = $(t).closest('li.listRItem');
	var button = row.find('div.boxstatus');
	var mydata = $(t).attr('rev');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.ajax({
		'beforeSend': function(){
			row.LoadingOverlay("show");
		},
		'async': false,
		'global': false,
		'type':'POST',
		'data': {MyData:mydata},
		'url': PathURL+"restaurant/index-dataaccess.php",
		'dataType': "json",
		'success': function (data) {
			if(data.status=='OK'){
				var txtbtn = data.StatusText+'<span class="caret ml5"></span>';
				button.find('button').removeClass(data.ClassStatusFrom);
				button.find('button').addClass(data.ClassStatusTo);
				button.find('button').html(txtbtn);
				button.find("[rel!='" + data.statusto + "']").closest('li').removeClass('active');
				button.find("[rel='" + data.statusto + "']").closest('li').addClass('active');
			}
		},
		complete: function(){
			row.LoadingOverlay("hide");
		}
	});
}
