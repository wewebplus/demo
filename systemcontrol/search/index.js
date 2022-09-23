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
function loadpagelistajax(page){
	var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
		var dataKeyword = $('#ListSearchForm input[id=ListFilter]').val();
		var selectGroup = $('#ListSearchForm select[name=selectGroup]').val();
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword,selectGroup:selectGroup},
			'url': 'index-ajax-loadpageindex-json.php',
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
	html +='<thead>';
		html +='<tr>';
			html +='<th class="w75 text-center">Select</th>';
			html +='<th class="">Keyword</th>';
			html +='<th class="w200">Date</th>';
			html +='<th class="w150 text-left">Count</th>';
			html +='<th class="w150 text-left"></th>';
		html +='</tr>';
	html +='</thead>';
	html +='<tbody>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			var numberindex = json['result'][i].valueid;
			html +='<tr>';
				html +='<td class="text-center">';
					html +='<input type="hidden" name="MyDataList[]" value="'+numberindex+'" />';
					html +='<label class="option block mn">';
						html +='<input type="checkbox" name="CheckOrder[]" value="Yes">';
						html +='<span class="checkbox mn"></span>';
					html +='</label>';
				html +='</td>';
				html +='<td class="">'+json['result'][i].ListKeyword+'</td>';
				html +='<td class="">'+json['result'][i].valueDateshow+'</td>';
				html +='<td class="">'+json['result'][i].ListCount+'</td>';
				html +='<td class="">';
					html += '<a rev="'+json['result'][i].valueView+'" rel="" href="javascript:void(0);" onclick="clicktoaction(this);">View Logs</a>';
				html += '</td>';
			html +='</tr>';
		}
	}
	html +='</tbody>';
	html +='<tfoot class="footer-menu">';
		html +='<tr>';
			html +='<td colspan="9" class="text-right">';
				html +='<nav>';
					html += '<ul class="pagination">';
						if(page>1){
							html += '<li class="footable-page-nav" data-page="first"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax(1)">«</a></li>';
							html += '<li class="footable-page-nav" data-page="prev"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax('+json['backpage']+')">‹</a></li>';
						}else{
							html += '<li class="footable-page-nav disabled" data-page="first"><a class="footable-page-link" href="javascript:void(0)">«</a></li>';
							html += '<li class="footable-page-nav disabled" data-page="prev"><a class="footable-page-link" href="javascript:void(0)">‹</a></li>';
						}
						if(json['spstart']==1){
							html += '<li class="footable-page-nav disabled" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)">...</a></li>';
						}else{
							html += '<li class="footable-page-nav" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax('+(json['spstart']-1)+')">...</a></li>';
						}
						for(var j = json['spstart']; j<= json['spend']; j++){
							if(j==page){
								html += '<li class="footable-page visible active" data-page="'+j+'"><a class="footable-page-link" href="javascript:void(0)">'+j+'</a></li>';
							}else{
								html += '<li class="footable-page visible" data-page="'+j+'"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax('+j+')">'+j+'</a></li>';
							}
						}
						if(json['spend']==json['noofpage']){
							html += '<li class="footable-page-nav disabled" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)">...</a></li>';
						}else{
							html += '<li class="footable-page-nav" data-page="prev-limit"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax('+(json['spend']+1)+')">...</a></li>';
						}
						if(page==json['noofpage']){
							html += '<li class="footable-page-nav disabled" data-page="next"><a class="footable-page-link" href="javascript:void(0)">›</a></li>';
							html += '<li class="footable-page-nav disabled" data-page="last"><a class="footable-page-link" href="javascript:void(0)">»</a></li>';
						}else{
							html += '<li class="footable-page-nav" data-page="next"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax('+json['nextpage']+')">›</a></li>';
							html += '<li class="footable-page-nav" data-page="last"><a class="footable-page-link" href="javascript:void(0)" onclick="loadpagelistajax('+json['noofpage']+')">»</a></li>';
						}
					html +='</ul>';
				html +='</nav>';
				html += '<div class="label label-default">PAGE '+page+' OF '+json['noofpage']+'</div>';
			html +='</td>';
		html +='</tr>';
	html +='</tfoot>';
	$("#datatablelist > table").html(html);
	$('.footablelist').footable({
		"columns": [{
			"filterable": false,"sortable": false
		},{
			"name": "Group","filterable": false,"sortable": true
		},{
			"name": "Date","filterable": false,"sortable": true
		},{
			"name": "Count","filterable": false,"sortable": true
		}],
		"filtering": {
			"enabled": true,
			"container": "#ListFilter",
			"space": "AND"
		},
		"sorting": {
			"enabled": true
		}
	});
}
function clicktodeletelist(t){
	var tb = $(t);
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var searchIDs = $("#datatablelist input:checkbox:checked").map(function(){var tbc = $(this).closest('tr').find('input[name^=MyDataList]').val();return tbc;}).toArray();
	console.log (searchIDs.length);
	if(searchIDs.length>0){
		$.confirm({
		    title: 'Confirm!',
		    content: 'Are you sure to delete this record?',
		    buttons: {
					Submit: {
	            text: 'Confirm',
	            btnClass: 'btn-blue',
	            action: function () {
								var json = (function () {
									var json = null;
									$.ajax({
										'beforeSend': function(){
											$('.ajax-loader').css("visibility", "visible");
										},
										'async': false,
										'global': false,
										'type':'POST',
										'data':{ paramName: searchIDs ,myaction:'selectdelete'},
										'url': FullPath+'search/index-dataaction.php',
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
								var status = json['status'];
								if(status=='ok'){
									var footer = $('table.footablelist').find('tfoot');
									var pagination = footer.find('ul.pagination');
									var ActivePage = parseInt(footer.find('li.active a').html());
									loadpagelistajax(ActivePage);
								}
								// console.log (json);
	            }
					},
	        cancel: function () {
	            //$.alert('Canceled!');
	        }
		    }
		});
	}else{
		$.alert({
		    title: 'Alert!',
		    content: 'Please select item!',
		});
	}
}
function clicktodeleteinlist(t){
	$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this record?',
			buttons: {
				Submit: {
						text: 'Confirm',
						btnClass: 'btn-blue',
						action: function () {
							var mydata = $(t).attr('rev');
							var PathURL = $('#ajaxFrm input[name=PathURL]').val();
							var footer = $(t).closest('table').find('tfoot');
							var pagination = footer.find('ul.pagination');
							var pagenumber = parseInt(footer.find('li.active a').html());
							$.ajax({
								'beforeSend': function(){
										$('.ajax-loader').css("visibility", "visible");
								},
								'type':'POST',
								'data':{MyData:mydata},
								'url': PathURL+"search/index-dataaccess.php",
								'success': function (data) {
									if($.trim(data)=='OK'){
										loadpagelistajax(pagenumber);
									}
								},
								complete: function(){
									$('.ajax-loader').css("visibility", "hidden");
								}
							});
						}
				},
				cancel: function () {
						//$.alert('Canceled!');
				}
			}
	});
}
function clicktoexportinfo(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#ajaxFrm input[name=LoginData]').val();
	var url = PathURL+'search/printexcelall.php?'+LoginData;
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
