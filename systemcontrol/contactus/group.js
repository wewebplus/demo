function loadpageajax(page){
	var LoginData = $('#ajaxFrm #LoginData').val();
	var actionlang = $('#ajaxFrm input[name=actionlang]').val();
	var json = (function () {
		var json = null;
		var dataKeyword = $('.form-searchGroup input[id=fooFilter]').val();
		var loadtype = "loadpage";
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword,loadtype:loadtype},
			'url': 'ajax-loadpagegroup-json.php',
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
			html +='<th class="w75 text-left">'+Array_Mod_Lang["txt:No"][actionlang]+'</th>';
			html +='<th class="">'+Array_Mod_Lang["txt:Group"][actionlang]+'</th>';
			html +='<th class="w250">'+Array_Mod_Lang["txt:Email"][actionlang]+'</th>';
			html +='<th class="w175">'+Array_Mod_Lang["txt:Contact"][actionlang]+'</th>';
			html +='<th class="w175 text-left">'+Array_Lang["txt:Status"][actionlang]+'</th>';
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
				html +='<td class="text-left">'+json['result'][i].ListIndex+'</td>';
				html +='<td>';
					html +='<span>'+json['result'][i].valueSubject+'</span>';
				html +='</td>';
				html +='<td>';
					html +='<span>'+json['result'][i].valueEmail+'</span>';
				html +='</td>';
				html +='<td>'+json['result'][i].CountLogs+'</td>';
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
			html +='<td colspan="9" class="text-right">';
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
	//$("#datatable > tbody").append(html);
}
function clicktodeletelistgroup(t){
	var tb = $(t);
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var searchIDs = $("#datatable input:checkbox:checked").map(function(){var tbc = $(this).closest('tr').find('input[name^=MyDataList]').val();return tbc;}).toArray();
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
										'url': FullPath+'contactus/group-dataaction.php',
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
									var footer = $('#datatable > table').find('tfoot');
									var pagination = footer.find('ul.pagination');
									var ActivePage = parseInt(footer.find('li.active a').html());
									loadpageajax(ActivePage);
									loadpageselectgroup(1);
								}
								console.log (json);
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
function changeStatus(t){
	var row = $(t).closest('tr');
	var button = row.find('div.btn-group');
	var mydata = $(t).attr('rev');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.ajax({
		'beforeSend': function(){
			row.LoadingOverlay("show");
		},
		'type':'POST',
		'data': {MyData:mydata},
		'url': PathURL+"contactus/group-dataaccess.php",
		'success': function (data) {
			var arr = $.trim(data).split(':');
			if($.trim(arr[0])=='OK'){
				var txtbtn = arr[4]+'<span class="caret ml5"></span>';
				button.find('button').removeClass(arr[2]);
				button.find('button').addClass(arr[3]);
				button.find('button').html(txtbtn);
				button.find("[rel!='" + arr[1] + "']").closest('li').removeClass('active');
				button.find("[rel='" + arr[1] + "']").closest('li').addClass('active');
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

function clicktodelete(t){
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
								'url': PathURL+"contactus/group-dataaccess.php",
								'success': function (data) {
									if($.trim(data)=='OK'){
										loadpageajax(pagenumber);
										loadpageselectgroup(1);
									}
								},
								complete: function(){
									$('.ajax-loader').css("visibility", "hidden");
								}
							});
							// console.log (json);
						}
				},
				cancel: function () {
						//$.alert('Canceled!');
				}
			}
	});
}
function checkAll(type){
	var countmnu = $('#countmnu').val();
	for(var i=1;i<=countmnu;i++){
		$('#'+type+'Admin'+i).prop('checked', true);
	}
}
function changeSortable(tsort){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var MyData = $('#myFrm input[name=saveData]').val();
	$.ajax({
		'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
		},
		'type':'POST',
		'data':{MyData:MyData,tsort:tsort},
		'url': PathURL+"contactus/group-dataaccess.php",
		'success': function (data) {

		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});
}
function loadpageselectgroup(page){
	var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData},
			'url': 'ajax-loadpagegroupselect-json.php',
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
	html += '<option value=""> - - Select Group - - </option>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			html += '<option value="'+json['result'][i].valueid+'">'+json['result'][i].valueSubject+'</option>';
		}
	}
	$('#ListSearchForm select[name=selectGroup]').html(html);
}
function loadpagelistajax(page){
	var LoginData = $('#ajaxFrm #LoginData').val();
	var actionlang = $('#ajaxFrm input[name=actionlang]').val();
	var json = (function () {
		var json = null;
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
			'url': 'ajax-loadpageindex-json.php',
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
			html +='<th class="w75 text-center">'+Array_Mod_Lang["txt:No"][actionlang]+'</th>';
			html +='<th class="w200">'+Array_Mod_Lang["txt:Group"][actionlang]+'</th>';
			html +='<th class="">'+Array_Mod_Lang["txt:Contact Name"][actionlang]+'</th>';
			// html +='<th class="w75">File</th>';
			html +='<th class="w200">Subject</th>';
			html +='<th class="w160">'+Array_Mod_Lang["txt:Date"][actionlang]+'</th>';
			html +='<th class="w150 text-left">'+Array_Lang["txt:Status"][actionlang]+'</th>';
			html +='<th class="w175 text-left">'+Array_Lang["txt:Action"][actionlang]+'</th>';
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
				html +='<td class="text-left">'+(i+1)+'</td>';
				html +='<td class="">'+json['result'][i].valueGroupname+'</td>';
				html +='<td>';
				html +='<span>'+json['result'][i].valueName+'</span>';
				html +='</td>';
				// html +='<td class="tddownload">'+json['result'][i].FileAtt+'</td>';
				html +='<td class="">'+json['result'][i].valueSubject+'</td>';
				html +='<td class="">'+json['result'][i].valueDateshow+'</td>';
				html +='<td class="text-left">';
					html +='<div class="btn-group text-right">';
					html +='<button type="button" class="btn '+json['result'][i].valueStatusCss+' br2 btn-sm fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> '+json['result'][i].valueStatustxt;
					html +='<span class="caret ml5"></span>';
					html +='</button>';
					html += json['result'][i].valueBtn;
					html +='</div>';
				html +='</td>';
				html +='<td class="text-left">';
					html += '<div>';
						html += '<a rev="'+json['result'][i].valueView+'" href="javascript:void(0)" class="btn btn-primary" onclick="clicktoaction(this);"><i class="fa fa-envelope"></i></a>';
						html += '<a rev="'+json['result'][i].valueView+'" href="javascript:void(0)" class="btn btn-primary" onclick="clicktoaction(this);"><i class="fa fa-file-text-o"></i></a>';
						html += '<a rev="'+json['result'][i].valueDelete+'" href="javascript:void(0)" class="btn btn-danger" onclick="clicktodeleteinlist(this);"><i class="fa fa-trash-o"></i></a>';
					html += '<div>';
				html +='</td>';
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
				html += '<div class="label label-default">'+Array_Lang["txt:Page"][actionlang]+' '+page+' '+Array_Lang["txt:Of"][actionlang]+' '+json['noofpage']+'</div>';
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
			"name": "Email","filterable": false,"sortable": true
		},{
			"name": "Contact","filterable": false,"sortable": true
		},{
			"filterable": false,"sortable": true
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
										'url': FullPath+'contactus/index-dataaction.php',
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
								'url': PathURL+"contactus/index-dataaccess.php",
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
function changeListStatus(t){
	var row = $(t).closest('tr');
	var button = row.find('div.btn-group');
	var mydata = $(t).attr('rev');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.ajax({
		'beforeSend': function(){
			row.LoadingOverlay("show");
		},
		'type':'POST',
		'data': {MyData:mydata},
		'url': PathURL+"contactus/index-dataaccess.php",
		'success': function (data) {
			var arr = $.trim(data).split(':');
			if($.trim(arr[0])=='OK'){
				var txtbtn = arr[4]+'<span class="caret ml5"></span>';
				button.find('button').removeClass(arr[2]);
				button.find('button').addClass(arr[3]);
				button.find('button').html(txtbtn);
				button.find("[rel!='" + arr[1] + "']").closest('li').removeClass('active');
				button.find("[rel='" + arr[1] + "']").closest('li').addClass('active');
			}
		},
		complete: function(){
			row.LoadingOverlay("hide");
		}
	});
}
function clicktoexportinfo(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#ajaxFrm input[name=LoginData]').val();
	var url = PathURL+'contactus/printexcelcontact.php?'+LoginData;
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
function exportGroupExcel(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var searchIDs = tb.attr('rev');
	var url = PathURL+'contactus/printexcelcontactgroup.php?'+searchIDs;
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
