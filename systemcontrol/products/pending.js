function loadpageajax(page){
	var LoginData = $('#ajaxFrm #LoginData').val();
	var actionlang = $('#ajaxFrm input[name=actionlang]').val();
	var json = (function () {
		var json = null;
		var dataGroup = $('.form-search select[name=selectGroup]').val();
		var dataKeyword = $('.form-search input[id=fooFilter]').val();
		var loadtype = "loadpage";
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataGroup:dataGroup,dataKeyword:dataKeyword,loadtype:loadtype},
			'url': 'pending-ajax-loadpageindex-json.php',
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
	// return false;
	var groupheader = json['foundgroupcount'];
	var len = json['result'].length;
	var pagesize = json['pagesize'];
	var html = '';
	html +='<thead>';
	html +='<tr>';
		html +='<th class="w40 text-center">';
			html +='<label class="option block mn">';
				html +='<input type="checkbox" name="CheckOrderAll" value="Yes" onclick="CheckOrderAll(this)">';
				html +='<span class="checkbox mn"></span>';
			html +='</label>';
		html += '</th>';
		html +='<th class="w75">No.</th>';
		html +='<th class="w75"> </th>';
		html +='<th class="">'+Array_Mod_Lang["txt:Subject"][actionlang]+'</th>';
		html +='<th class="w175">'+Array_Mod_Lang["txt:Brand"][actionlang]+'</th>';
		html +='<th class="w250">'+Array_Mod_Lang["txt:Company"][actionlang]+'</th>';
		html +='<th  class="w175 text-left">'+Array_Lang["txt:Last Update"][actionlang]+'</th>';
		html +='<th class="w150 text-left">'+Array_Lang["txt:Action"][actionlang]+'</th>';
	html +='</tr>';
	html +='</thead>';
	html +='<tbody>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			var numberindex = json['result'][i].valueid;
			html +='<tr class="listitem" data-z="'+numberindex+'">';
				html +='<td class="text-center">';
					html +='<input type="hidden" name="MyDataList[]" value="'+numberindex+'" />';
					html +='<label class="option block mn">';
						html +='<input type="checkbox" name="CheckOrder[]" value="Yes">';
						html +='<span class="checkbox mn"></span>';
					html +='</label>';
				html +='</td>';
				html +='<td class="text-left">'+json['result'][i].ListIndex+'</td>';
				html += '<td class="">';
					html += '<div class="img">'+json['result'][i].valuePicture+'</div>';
				html += '</td>';
				html += '<td>';
					html += '<p>'+json['result'][i].valueSubject+'</p>';
					html += '<p>( '+json['result'][i].valueSubjectDefault+' )</p>';
					if(groupheader>0){
						html +='<p class="">'+Array_Mod_Lang["txt:Group"][actionlang]+' : '+json['result'][i].valueProductType+'</p>';
					}
				html += '</td>';
				html += '<td class="text-left">'+json['result'][i].valueBrand+'</td>';
				html += '<td class="text-left">'+json['result'][i].valueMemberName+'</td>';
				html += '<td class="text-left liststatus">';
					html += '<div>'+json['result'][i].valueDateshow+'</div>';
				html += '</td>';
				html +='<td class="text-left">';
				html +='<div class="btn-group text-right">';
				html +='<button type="button" class="btn '+json['result'][i].valueStatusCss+' br2 btn-sm fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> '+json['result'][i].valueStatustxt;
				html +='<span class="caret ml5"></span>';
				html +='</button>';
				html += json['result'][i].valueBtn;
				html +='</div>';
				html +='</td>';
			html +='</tr>';
		}
	}
	html +='</tbody>';
	html +='<tfoot class="footer-menu">';
		html +='<tr>';
			html +='<td colspan="10" class="text-right">';
				html +='<nav>';
					html += '<ul class="pagination">';
						if(page>1){
							html += '<li class="footable-page-nav" data-page="first"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax(1)">«</a></li>';
							html += '<li class="footable-page-nav" data-page="prev"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax('+json['backpage']+')">‹</a></li>';
						}else{
							html += '<li class="footable-page-nav disabled" data-page="first"><a class="footable-page-link" href="javascript:void(0)">«</a></li>';
							html += '<li class="footable-page-nav disabled" data-page="prev"><a class="footable-page-link" href="javascript:void(0)">‹</a></li>';
						}
						if(json['spstart']==1){
							html += '<li class="footable-page-nav disabled" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)">...</a></li>';
						}else{
							html += '<li class="footable-page-nav" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax('+(json['spstart']-1)+')">...</a></li>';
						}
						for(var j = json['spstart']; j<= json['spend']; j++){
							if(j==page){
								html += '<li class="footable-page visible active" data-page="'+j+'"><a class="footable-page-link" href="javascript:void(0)">'+j+'</a></li>';
							}else{
								html += '<li class="footable-page visible" data-page="'+j+'"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax('+j+')">'+j+'</a></li>';
							}
						}
						if(json['spend']==json['noofpage']){
							html += '<li class="footable-page-nav disabled" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)">...</a></li>';
						}else{
							html += '<li class="footable-page-nav" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax('+(json['spend']+1)+')">...</a></li>';
						}
						if(page==json['noofpage']){
							html += '<li class="footable-page-nav disabled" data-page="next"><a class="footable-page-link" href="javascript:void(0)">›</a></li>';
							html += '<li class="footable-page-nav disabled" data-page="last"><a class="footable-page-link" href="javascript:void(0)">»</a></li>';
						}else{
							html += '<li class="footable-page-nav" data-page="next"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax('+json['nextpage']+')">›</a></li>';
							html += '<li class="footable-page-nav" data-page="last"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpageajax('+json['noofpage']+')">»</a></li>';
						}
					html +='</ul>';
				html +='</nav>';
				html += '<div class="label label-default">'+Array_Lang["txt:Page"][actionlang]+' '+page+' '+Array_Lang["txt:Of"][actionlang]+' '+json['noofpage']+'</div>';
			html +='</td>';
		html +='</tr>';
	html +='</tfoot>';
	$("#datatable > table").html(html);
}
function changeStatus(t){
	var row = $(t).closest('tr');
	var button = row.find('div.btn-group');
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
		'url': PathURL+"products/pending-dataaccess.php",
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
function clicktoaction(t){
	var mydata = $(t).attr('rev');
	var footer = $(t).closest('table').find('tfoot');
	var pagination = footer.find('ul.pagination');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	//var pagenumber = getpagenumber(t);
	var pagenumber = parseInt(footer.find('li.active a').html());
	var url = getfullUrl()+'?page='+pagenumber+'&'+mydata;
	window.location = url;
}
function checkAll(type){
	var countmnu = $('#countmnu').val();
	for(var i=1;i<=countmnu;i++){
		$('#'+type+'Admin'+i).prop('checked', true);
	}
}
