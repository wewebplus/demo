function loadpageajax(page){
	var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
		var dataKeyword = $('.form-search input[id=fooFilter]').val();
		var dataGroup = $('.form-search select[name=selectGroup]').val();
		var selectLevel = $('.form-search select[name=selectLevel]').val();
		var loadtype = "loadpage";
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword,dataGroup:dataGroup,selectLevel:selectLevel,loadtype:loadtype},
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
	var pagesize = json['pagesize'];
	var html = '';
	html +='<thead>';
	html +='<tr>';
		html +='<th class="w75 text-center">Select</th>';
		html +='<th class="w75">No.</th>';
		html +='<th class="">Content Name</th>';
		html +='<th class="">Content Email</th>';
		html +='<th class="w250">Create Date</th>';
		html +='<th class="w125 text-left">Action</th>';
	html +='</tr>';
	html +='</thead>';
	html +='<tbody>';
	if(len>0){
		for (var i = 0; i< len; i++) {
      //var numberindex = json['result'][i].ListIndex;
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
				html += '<td><span>'+json['result'][i].valueName+'</span></td>';
				html += '<td><span>'+json['result'][i].valueEmail+'</span></td>';
				html += '<td class="">'+json['result'][i].valueDateshow+'</td>';
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
	$('.footable').footable({
		"columns": [{
			"filterable": false,"sortable": false
		},{
			"name": "Content","filterable": true,"sortable": true
		},{
			"name": "ContentDate","filterable": true,"sortable": true
		},{
			"filterable": false,"sortable": true
		}],
		"filtering": {
			"enabled": false,
			"container": "#fooFilter",
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
										'url': FullPath+'enew/index-dataaction.php',
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
									var footer = $('table.footable').find('tfoot');
									var pagination = footer.find('ul.pagination');
									var ActivePage = parseInt(footer.find('li.active a').html());
									loadpageajax(ActivePage);
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
		'url': PathURL+"enew/index-dataaccess.php",
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
  jqConfirm('Are you sure to delete this record?', function(){
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
			'url': PathURL+"enew/index-dataaccess.php",
			'success': function (data) {
				if($.trim(data)=='OK'){
					loadpageajax(pagenumber);
				}
			},
			complete: function(){
				$('.ajax-loader').css("visibility", "hidden");
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
function changeSortable(tsort){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var MyData = $('#myFrm input[name=saveData]').val();
	$.ajax({
		'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
		},
		'type':'POST',
		'data':{MyData:MyData,tsort:tsort},
		'url': PathURL+"content/index-dataaccess.php",
		'success': function (data) {

		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});
}
function ajaxuFileUploadProgressImg(t){
	var tb = $(t);
	var pg = tb.attr('name').replace("fileToUpload", "progress");
	var po = tb.attr('name').replace("fileToUpload", "output");
	var uploadshow = tb.attr('name').replace("fileToUpload", "showoption");
	var lang = tb.attr('name').replace("fileToUpload", "");
  var tbfile = tb.prop('files');
  var result_output 			= '#'+po; //ID of an element for response output
  var progress_bar_id 		= '#'+pg; //ID of an element for response output
  var proceed = true; //set proceed flag
  var error = [];	//errors
  var total_files_size = 0;
  var max_file_size 			= 10485760; //62914560 60MB //allowed file size. (1 MB = 1048576) //
  var allowed_file_types 		= ['image/png', 'image/jpeg', 'image/pjpeg'];
  if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
		error.push("Your browser does not support new File API! Please upgrade."); //push error text
	}else{
    $.each(tbfile,function(i, ifile){
			if(ifile.value !== ""){ //continue only if file(s) are selected
				if(allowed_file_types.indexOf(ifile.type) === -1){ //check unsupported file
					error.push( "<b>"+ ifile.name + "</b> is unsupported file type!"); //push error text
					proceed = false; //set proceed flag to false
				}
				total_files_size = total_files_size + ifile.size; //add file size to total size
			}
		});
    //if total file size is greater than max file size
		if(total_files_size > max_file_size){
			error.push( "You have 1 file(s) with total size "+total_files_size+", Allowed size is " + max_file_size +", Try smaller file!"); //push error text
			proceed = false; //set proceed flag to false
		}
    if(proceed){
      var file = $(t).get( 0 ).files[0],
          formData = new FormData();
          formData.append( 'file', file );
      console.log( file );
      $('button[type=submit]').prop( "disabled", true);
      $.ajax( {
          url        : 'save-img-upload-progress.php',
          type       : 'POST',
          contentType: false,
          cache      : false,
          processData: false,
          data       : formData,
          xhr        : function ()
          {
              var jqXHR = null;
              if ( window.ActiveXObject ){
                  jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
              }else{
                  jqXHR = new window.XMLHttpRequest();
              }

              //Upload progress
              jqXHR.upload.addEventListener( "progress", function ( evt )
              {
                  if ( evt.lengthComputable ){
                      var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                      //Do something with upload progress
                      var percentVal = percentComplete + '%';
											$(progress_bar_id+"").show();
                      $(progress_bar_id+" .progress-bar").css("width", + percentComplete +"%");
              				$(progress_bar_id+" .status").text(percentVal);

                      //$('#showfile').html(percentVal);
                      console.log( 'Uploaded percent', percentComplete );
                  }
              }, false );

              //Download progress
              jqXHR.addEventListener( "progress", function ( evt )
              {
                  if ( evt.lengthComputable ){
                      var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                      //Do something with download progress
                      console.log( 'Downloaded percent', percentComplete );
                  }
              }, false );

              return jqXHR;
          },
          success    : function ( data )
          {
						//reset progressbar
						$(progress_bar_id +" .progress-bar").css("width", "0%");
						$(progress_bar_id + " .status").text("0%");
						$(progress_bar_id+"").hide();

            var myJSON = jQuery.parseJSON(data);
            //alert(myJSON.filename);
						var htmlinput = '';
						var randNum = 1 + Math.floor(Math.random() * 6);
            var pathfileshow = myJSON.pathfile;
            var fileshow = myJSON.filename;
            var phyfileshow = myJSON.phyfilename+'.'+myJSON.filetype;
						var viwefile = pathfileshow+phyfileshow;
						htmlinput += '<div><img src="'+viwefile+'" /></div>';
						htmlinput += '<input type="hidden" name="filewallshow'+lang+'" value="'+phyfileshow+'" />';
						htmlinput += '<input type="hidden" name="filewallurl'+lang+'" value="'+pathfileshow+'" />';
						htmlinput += '<input type="hidden" name="filewallname'+lang+'" value="'+fileshow+'" />';
						$('#'+uploadshow).html(htmlinput);
            //Do something success-ish
						$('button[type=submit]').prop( "disabled", false);
            console.log( 'Completed.' );
          }
      } );
    }
  }
  $(result_output).html(""); //reset output
	$(error).each(function(i){ //output any error to output element
		$(result_output).append('<div class="error">'+error[i]+"</div>");
	});
}
function clicktoexportlist(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#ajaxFrm input[name=LoginData]').val();
	var selectLevel = $('.form-search select[name=selectLevel]').val();
	var selectGroup = $('.form-search select[name=selectGroup]').val();
	var url = PathURL+'enew/printexcelmail.php?selectLevel='+selectLevel+'&selectGroup='+selectGroup+'&'+LoginData;
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
