function loadpageajax(page){
	var LoginData = $('#ajaxFrm #LoginData').val();
	var actionlang = $('#ajaxFrm input[name=actionlang]').val();
	var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
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
		html +='<th class="w40 text-center">';
			html +='<label class="option block mn">';
				html +='<input type="checkbox" name="CheckOrderAll" value="Yes" onclick="CheckOrderAll(this)">';
				html +='<span class="checkbox mn"></span>';
			html +='</label>';
		html += '</th>';
		html +='<th class="w75"> </th>';
		html +='<th class="">'+Array_Mod_Lang["txt:Subject"][actionlang]+'</th>';
		html +='<th class="w300">'+Array_Mod_Lang["txt:Date"][actionlang]+'</th>';
		html +='<th class="w100 text-left"> </th>';
		html +='<th class="w175 text-left">'+Array_Lang["txt:Action"][actionlang]+'</th>';
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
			  html +='<td class="">'+json['result'][i].valuePicture+'</td>';
			  html +='<td>';
				html +='<span>'+json['result'][i].valueSubject+'</span>';
			  html +='</td>';
			  html +='<td class="">'+json['result'][i].valueDateshow+'</td>';
				html += '<td>';
					html += '<div class="divaction">';
						html += '<a href="javascript:void(0)" title="Up" data-dir="up"><i class="fa fa-arrow-up" data-dir="up"></i></a>';
						html += '<a href="javascript:void(0)" title="Down" data-dir="down"><i class="fa fa-arrow-down" data-dir="down"></i></a>';
					html += '</div>';
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
	$('[data-z]').click(function(e){
	  var jTarget = $(e.target),
	      dir = jTarget.data('dir'),
	      jItem = $(e.currentTarget),
	      jItems = $('tr.listitem'),
	      index = jItems.index(jItem);
        //alert(dir);
	  switch (dir) {
	    case 'up':
	      if (index != 0) {
	        var item = $(this).detach().insertBefore(jItems[index - 1]);
	      }
	      break;
	    case 'down':
	      if (index != jItems.length - 1) {
	        var item = $(this).detach().insertAfter(jItems[index + 1]);
	      }
	      break;
	  }
    if(dir=='up' || dir=='down'){
			var myArray = $("#datatable table tr.listitem").map(function() {
			    return $(this).attr('data-z');
			}).get();
			savelistorderContent(myArray,pagesize);
    }
	});
}
function savelistorderContent(myval,pagesize){
	var footer = $('#datatable > table.table').find('tfoot');
	var pagination = footer.find('ul.pagination');
	var ActivePage = parseInt(footer.find('li.active a').html());
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var MyData = $('#ajaxFrm input[name=LoginData]').val();
	$.ajax({
    'beforeSend': function(){
      $('.ajax-loader').css("visibility", "visible");
    },
    type:"POST",
    url:FullPath+'floating/index-dataaction.php',
    data:{myval:myval,MyData:MyData,mypage:ActivePage,mypagesize:pagesize,myaction:'sortlist'},
    cache:false,
    success: function(data) {
      if($.trim(data)=='OK'){
        loadpageajax(ActivePage);
      }else{
        //alert('xxxx '+myval);
				console.log(myval);
      }
    },
    error: function () {
      alert("Error");
    },
    complete: function(){
      $('.ajax-loader').css("visibility", "hidden");
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
										'url': FullPath+'floating/index-dataaction.php',
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
		'url': PathURL+"floating/index-dataaccess.php",
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
								'url': PathURL+"floating/index-dataaccess.php",
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
		'url': PathURL+"floating/index-dataaccess.php",
		'success': function (data) {

		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});
}
function ajaxuFileUploadProgress00(t){
  var tb = $(t);
  var tbfile = tb.prop('files');
	var thisname = tb.attr('name');
  var result_output 			= '#'+thisname+'popupoutput'; //ID of an element for response output
  var progress_bar_id 		= '#'+thisname+'progress-wrp'; //ID of an element for response output
  var proceed = true; //set proceed flag
  var error = [];	//errors
  var total_files_size = 0;
  var max_file_size 			= 62914560; //62914560 60MB //allowed file size. (1 MB = 1048576) //
  var allowed_file_types 		= arrfileupload; //allowed file types

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
          url        : 'index-upload.php',
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
            var pathfileshow = myJSON.pathfile;
            var fileshow = myJSON.filename;
            var phyfileshow = myJSON.phyfilename+'.'+myJSON.filetype;
						var viwefile = pathfileshow+phyfileshow;

						$('input[name='+thisname+'ushowfile]').val(phyfileshow);
						$('input[name='+thisname+'ushowfilename]').val(fileshow);
						$('input[name='+thisname+'ushowpathfile]').val(pathfileshow);
						$('#'+thisname+'showfile').val(fileshow);
						$('#'+thisname+'popupoutput').html('<div><img src="'+viwefile+'" /></div>');
            $('button[type=submit]').prop( "disabled", false);
            //Do something success-ish
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
function selectgroupbanner(t){
	var tb = $(t);
	var thisval = tb.val();
	var json = (function () {
		var json = null;
    var LoginData = $('input[name=saveData]').val();
    var activepage = 'home';
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
      'data':{thisval:thisval,LoginData:LoginData},
			'url': './ajax-loadbannergroupwidth-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var lenw = json['W'];
	var lenh = json['H'];
	var html = 'min size '+lenw+' * '+lenh+' px.';
	var tohtml = $('.postuploadicon');
	tohtml.find('span').html(html);
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
