function loadpageajax(page){
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
	var groupheader = json['resultgroup'].groupheader;
	var objgroup = json['resultgroup'].groupname;
	var len = json['result'].length;
	var html = '';
	html +='<thead>';
	html +='<tr>';
	html +='<th class="w75 text-center">Select</th>';
	html +='<th class="w75 text-center">No.</th>';
	html +='<th class="w200">Group</th>';
	html +='<th class="">Contact Name</th>';
	html +='<th class="w250">Date</th>';
	html +='<th class="w175 text-left">Contact Action</th>';
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
			html +='<td class="">'+json['result'][i].valueDateshow+'</td>';
			html +='<td class="text-left">';
			html +='<div class="btn-group text-right">';
			html +='<button type="button" class="btn '+json['result'][i].valueStatusCss+' br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> '+json['result'][i].valueStatustxt;
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
	html +='<td colspan="6">';
	html +='<nav>';
	html +='<div id="paging-ui-container"></div>';
	html +='</nav>';
	html +='</td>';
	html +='</tr>';
	html +='</tfoot>';

	$("#datatable > table").html(html);
	//$("#datatable > tbody").append(html);

	$('.footable').footable({
		"columns": [{
			"filterable": false,"sortable": false
		},{
			"name": "Group","filterable": true,"sortable": true
		},{
			"name": "Content","filterable": true,"sortable": true
		},{
			"name": "ContentDate","filterable": true,"sortable": true
		},{
			"filterable": false,"sortable": true
		}],
		"filtering": {
			"enabled": true,
			"container": "#fooFilter",
			"space": "AND"
		},
		"sorting": {
			"enabled": true
		},
		"paging": {
			"enabled": true,
			"container": "#paging-ui-container",
			"position": "right",
			"countFormat": "PAGE {CP} OF {TP}",
			"current": page,
			//"limit": 5,
			"size": 10
		}
	});
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
	$.post(PathURL+"contactus/index-dataaccess.php",{MyData:mydata},
		function(data){
			var arr = $.trim(data).split(':');
			if($.trim(arr[0])=='OK'){
				var txtbtn = arr[4]+'<span class="caret ml5"></span>';
				button.find('button').removeClass(arr[2]);
				button.find('button').addClass(arr[3]);
				button.find('button').html(txtbtn);
				button.find("[rel!='" + arr[1] + "']").closest('li').removeClass('active');
				button.find("[rel='" + arr[1] + "']").closest('li').addClass('active');
			}
		});
}
function clicktoaction(t){
	var mydata = $(t).attr('rev');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var pagenumber = getpagenumber(t);
	var url = getfullUrl()+'?page='+pagenumber+'&'+mydata;
	window.location = url;
}

function clicktodelete(t){
	jqConfirm('Are you sure to delete this record?', function(){
		var mydata = $(t).attr('rev');
		var PathURL = $('#ajaxFrm input[name=PathURL]').val();
		var pagenumber = getpagenumber(t);
		$.post(PathURL+"contactus/index-dataaccess.php",{MyData:mydata},
			function(data){
				if($.trim(data)=='OK'){
					loadpageajax(pagenumber);
				}
			});
	}, function(){
    //alert('yy');
},'Alert Dialog');
}
function checkAll(type){
	var countmnu = $('#countmnu').val();
	for(var i=1;i<=countmnu;i++){
		$('#'+type+'Admin'+i).prop('checked', true);
	}
}
function clicktoexportinfo(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var url = PathURL+'importexport/printexcelcontact.php';
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
