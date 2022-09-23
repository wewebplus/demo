function loadpageajax(page){
	var LoginData = $('#ajaxFrm #LoginData').val();
	var actionlang = $('#ajaxFrm input[name=actionlang]').val();
	var json = (function () {
		var json = null;
		var dataKeyword = $('.form-search input[id=fooFilter]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword},
			'url': 'ajax-loadpageuser-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var len = json['result'].length;
	var html = '';
  html +='<thead>';
    html +='<tr>';
			html +='<th class="w40 text-center">';
				html +='<label class="option block mn">';
					html +='<input type="checkbox" name="CheckOrderAll" value="Yes" onclick="CheckOrderAll(this)">';
					html +='<span class="checkbox mn"></span>';
				html +='</label>';
			html += '</th>';
      html +='<th class="w250">'+Array_Mod_Lang["txt:UserName"][actionlang]+'</th>';
      html +='<th class="">'+Array_Mod_Lang["txt:fullname"][actionlang]+'</th>';
      html +='<th class="w150">'+Array_Mod_Lang["txt:User Type"][actionlang]+'</th>';
      html +='<th class="w175 text-left">'+Array_Lang["txt:Status"][actionlang]+'</th>';
			html +='<th class="w150 text-left">'+Array_Lang["txt:Action"][actionlang]+'</th>';
    html +='</tr>';
  html +='</thead>';
  html +='<tbody>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			var numberindex = json['result'][i].valueid;
			var FixListItem = json['result'][i].FixListItem;
			html +='<tr>';
				html +='<td class="text-center">';
					html +='<input type="hidden" name="MyDataList[]" value="'+numberindex+'" />';
					html +='<label class="option block mn">';
						html +='<input type="checkbox" name="CheckOrder[]" value="Yes">';
						html +='<span class="checkbox mn"></span>';
					html +='</label>';
				html +='</td>';
				html +='<td class="">'+json['result'][i].valueUserName+'</td>';
			  html +='<td>';
				html +='<img class="img-responsive mw20 ib mr10" title="user" src="'+json['result'][i].valueImages+'">';
				html +='<span>'+json['result'][i].valueSubject+'</span>';
			  html +='</td>';
			  html +='<td class="">'+json['result'][i].valueUserType+'</td>';
			  html +='<td class="text-left">';
				html +='<div class="btn-group text-right">';
				  html +='<button type="button" class="btn '+json['result'][i].valueStatusCss+' br2 fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> '+json['result'][i].valueStatustxt;
					html +='<span class="caret ml5"></span>';
				  html +='</button>';
				  html += json['result'][i].valueBtn;
				html +='</div>';
			  html +='</td>';
				html +='<td>';
					html += '<div class="btn-group">';
						html += '<a href="javascript:void(0)" rev="'+json['result'][i].LinkView+'" class="btn btn-primary dark" onclick="clicktoaction(this);"><i class="far fa-eye"></i></a>';
						html += '<a href="javascript:void(0)" rev="'+json['result'][i].LinkEdit+'" class="btn btn-primary dark" onclick="clicktoaction(this);"><i class="far fa-edit"></i></a>';
						if(FixListItem){
							html += '<a href="javascript:void(0)" rev="'+json['result'][i].LinkDelete+'" class="btn btn-danger disabled"><i class="fa fa-trash-o"></i></a>';
						}else{
							html += '<a href="javascript:void(0)" rev="'+json['result'][i].LinkDelete+'" class="btn btn-danger" onclick="clicktodelete(this);"><i class="fa fa-trash-o"></i></a>';
						}
					html +='</div>';
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
				html += '<div class="label label-default">PAGE '+page+' OF '+json['noofpage']+'</div>';
			html +='</td>';
		html +='</tr>';
	html +='</tfoot>';
	$("#datatable > table").html(html);
	//$("#datatable > tbody").append(html);
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
function clicktodeletelist(t){
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
										'url': FullPath+'useradmin/index-dataaction.php',
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
									loadpageajax(1);
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
		'url': PathURL+"useradmin/index-dataaccess.php",
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
function getfullUrl(){
	if (!window.location.origin){
    // For IE
    window.location.origin = window.location.protocol + "//" + (window.location.port ? ':' + window.location.port : '');
  }
  var url = window.location.origin + window.location.pathname;
	return url;
}
function clicktodelete(t){
  /* //-- normal
  if(confirm('Are you sure to delete this record?')){
    var mydata = $(t).attr('rev');
    var PathURL = $('#ajaxFrm input[name=PathURL]').val();
    var pagenumber = getpagenumber(t);
    $.post(PathURL+"employee/index-dataaccess.php",{MyData:mydata},
  		   function(data){
          if($.trim(data)=='OK'){
            loadpageajax(pagenumber);
          }
  	});
  }
  */
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
								'url': PathURL+"useradmin/index-dataaccess.php",
								'success': function (data) {
									if($.trim(data)=='OK'){
										loadpageajax(pagenumber);
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
function CheckOrderAll(t){
	var tb = $(t);
	var Checkboxes = $('#datatable tbody input:checkbox');
	if(tb.is(":checked")){
		Checkboxes.each(function () {
			$(this).prop( "checked", true );
		});
	}else{
		Checkboxes.each(function () {
			$(this).prop( "checked", false );
		});
	}
}
