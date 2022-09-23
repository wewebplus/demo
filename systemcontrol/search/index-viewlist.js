jQuery(document).ready(function() {
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  loadpageajaxview(1);
});
function loadpageajaxview(page){
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
			'url': 'index-ajax-loadpageviewshow-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
        $('.ajax-loader').css("visibility", "hidden");
			},
		  complete: function(){
		    // $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();
	var len = json['result'].length;
  var noofpage = json['noofpage'];
  var selectpage = '';
  selectpage += 'Page : ';
  selectpage += '<select onchange="loadpageajaxview($(this).val())">';
    for (var p = 1; p<=noofpage; p++) {
      if(page==p){
        selectpage += '<option value="'+p+'" selected="selected">'+p+'</option>';
      }else{
        selectpage += '<option value="'+p+'">'+p+'</option>';
      }
    }
  selectpage += '</select>';
	$('#boxselectpage').html(selectpage);
	var html = '';
	if(len>0){
		for (var i = 0; i< len; i++) {
			html += '<tr class="detail">';
				html += '<td>'+json['result'][i].CreateDate+'</td>';
				html += '<td>'+json['result'][i].ListIP+'</td>';
				html += '<td>'+json['result'][i].Browser+'</td>';
				html += '<td>'+json['result'][i].Platform+'</td>';
				html += '<td>'+json['result'][i].userAgent+'</td>';
			html += '</tr>'
		}
	}
	$('.tableDetail tbody').html(html);
}
function clicktoexport(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#myFrm input[name=saveData]').val();
	var url = PathURL+'search/printexcellogs.php?'+LoginData;
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
