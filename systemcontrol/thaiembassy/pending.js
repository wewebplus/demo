function loadpageajax(page){
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
	var len = json['result'].length;
	var pmaalllist = json['pmaalllist'];
	var html = '';
  html +='<thead>';
    html +='<tr>';
		html +='<th class="w75 text-left"> </th>';
		html +='<th class="w125 text-left">สมัครเมื่อ</th>';
		html +='<th class="w125 text-left">Type</th>';
		html +='<th class="">Name</th>';
		// html +='<th class="w400 text-left">score</th>';
		html +='<th class="w125 text-left">ให้คะแนน</th>';
		html +='<th class="w150 text-left">Action</th>';
    html +='</tr>';
  html +='</thead>';
  html +='<tbody>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			var numberindex = json['result'][i].valueid;
			var ResScore = json['result'][i].valueResScore;
			html +='<tr>';
				html += '<td class="">';
					html += '<div class="img">'+json['result'][i].valuePicture+'</div>';
				html += '</td>';
				html +='<td class="">'+json['result'][i].valueCreateDate+'</td>';
				html +='<td class="">'+json['result'][i].valueResType+'</td>';
			  html +='<td class="linetd">';
					html += '<p>'+json['result'][i].valueName+'</p>';
					html += '<div class="barprograss" title="'+json['result'][i].valuePercentProgressTitle+'"><div class="pg01 inbarprograss'+json['result'][i].valuePercentProgress+'"></div></div>';
					if(ResScore.length>0){
						html += '<br />';
						html += '<table class="table table-striped table-hover">';
							html +='<tr>';
								html +='<th class="text-left"> </th>';
								html +='<th class="w100 text-left">สถานะ</th>';
								html +='<th class="w75 text-left"> </th>';
								html +='<th class="w75 text-left"> </th>';
								html +='<th class="w75 text-left">คะแนน</th>';
								html +='<th class="w100 text-left">Action</th>';
					    html +='</tr>';
							$.each(ResScore, function( index, value ) {
									html += '<tr>';
										html += '<td>'+value['Member']+'</td>';
										html += '<td>'+value['PassTheCriteria']+'</td>';
										html += '<td>'+value['Section2Total']+'</td>';
										html += '<td>'+value['Section3Total']+'</td>';
										html += '<td>'+value['SectionTotalAll']+'</td>';
										html += '<td><a rev="'+value['LinkScore']+'" rel="" href="javascript:void(0);" onclick="clicktoaction(this);">ดูคะแนน</a></td>';
									html += '</tr>';
								// html += '<div class="viewscore">';
								//   html +='<span>'+value['Member']+' => '+value['PassTheCriteria']+' ('+value['Section2Total']+'+'+value['Section3Total']+' = '+value['SectionTotalAll']+')</span>';
								// 	html += '<a rev="'+value['LinkScore']+'" rel="" href="javascript:void(0);" onclick="clicktoaction(this);">ดูคะแนน</a>';
								// html += '</div>';
							});
						html += '</table>';
					}

			  html +='</td>';
				// html +='<td class="linetd">';
				// 	// html +='<p>score : '+json['result'][i].valueScore+'</p>';
				// 	// html += ResScore.length;
				// 	if(ResScore.length>0){
				// 		html += '<table class="table table-striped table-hover">';
				// 		$.each(ResScore, function( index, value ) {
				// 				html += '<tr>';
				// 					html += '<td>'+value['Member']+'</td>';
				// 					html += '<td>'+value['PassTheCriteria']+'</td>';
				// 					html += '<td>'+value['Section2Total']+'</td>';
				// 					html += '<td>'+value['Section3Total']+'</td>';
				// 					html += '<td>'+value['SectionTotalAll']+'</td>';
				// 					html += '<td><a rev="'+value['LinkScore']+'" rel="" href="javascript:void(0);" onclick="clicktoaction(this);">ดูคะแนน</a></td>';
				// 				html += '</tr>';
				// 			// html += '<div class="viewscore">';
				// 			//   html +='<span>'+value['Member']+' => '+value['PassTheCriteria']+' ('+value['Section2Total']+'+'+value['Section3Total']+' = '+value['SectionTotalAll']+')</span>';
				// 			// 	html += '<a rev="'+value['LinkScore']+'" rel="" href="javascript:void(0);" onclick="clicktoaction(this);">ดูคะแนน</a>';
				// 			// html += '</div>';
				// 		});
				// 		html += '</table>';
				// 	}
			  // html +='</td>';
				html +='<td class="">';
					html += '<a rev="'+json['result'][i].LinkScore+'" class="btn btn-hover btn-success btn-block" rel="" href="javascript:void(0);" onclick="clicktoaction(this);">ให้คะแนน</a>';
				html += '</td>';
			  html +='<td class="text-left">';
				html +='<div class="btn-group text-right">';
				  html +='<button type="button" class="btn '+json['result'][i].valueStatusCss+' btn-block br2 fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> '+json['result'][i].valueStatustxt;
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
		'url': PathURL+"thaiembassy/pending-dataaccess.php",
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
function clicktodelete(t){
	var mydata = $(t).attr('rev');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var footer = $(t).closest('table').find('tfoot');
	var pagination = footer.find('ul.pagination');
	var pagenumber = parseInt(footer.find('li.active a').html());
	$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this record?',
			buttons: {
				Submit: {
						text: 'Confirm',
						btnClass: 'btn-blue',
						action: function () {
							$.ajax({
								'beforeSend': function(){
										$('.ajax-loader').css("visibility", "visible");
								},
								'type':'POST',
								'data':{MyData:mydata},
								'url': PathURL+"thaiembassy/index-dataaccess.php",
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
          url        : 'save-upload-progress.php',
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

						$('input[name='+thisname+'ushowfile]').val(phyfileshow);
						$('input[name='+thisname+'ushowfilename]').val(fileshow);
						$('input[name='+thisname+'ushowpathfile]').val(pathfileshow);
						$('#'+thisname+'showfile').val(fileshow);
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
function selectThisGroiup(t){
  var tb = $(t);
  var data = tb.val();
	var to = $('select[name=selectSubGroup]');
  var saveData = $('#myFrm input[name=saveData]').val();
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
			data:{data:data,saveData:saveData,MyDataAction:'selectsubgroup'},
			'url': 'index-dataaction.php',
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
	html += '<option value=""> - - Select Sub Group - - </option>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			html += '<option value="'+json['result'][i].id+'">'+json['result'][i].value+'</option>';
		}
	}
	to.html(html);
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
		'url': PathURL+"thaiembassy/index-dataaccess.php",
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

						//reset progressbar
						$(progress_bar_id+" .progress-bar").css("width", "0%");
						$(progress_bar_id+ " .status").text("0%");
						$(progress_bar_id+"").hide();
          }
      } );
    }
  }
  $(result_output).html(""); //reset output
	$(error).each(function(i){ //output any error to output element
		$(result_output).append('<div class="error">'+error[i]+"</div>");
	});
}
function chkPassKey(data){
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');
	var xsp = new RegExp('[!@#$%^&*()_+-,/?<>.:;]');
	if(data.match(upperCase) && data.match(lowerCase) && data.match(numbers)) {
		if(data.match(xsp)){
			return false;
		}else{
			return true;
		}
		//return true;
	}else{
		return false;
	}
}
function isEmail(str) {
  var supported = 0;
  if (window.RegExp) {
    var tempStr = "a";
    var tempReg = new RegExp(tempStr);
    if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported)
  return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
  return (!r1.test(str) && r2.test(str));
}
function clicktoexportexcel(t){
	var selectLevel = $('.form-search select[name=selectLevel]').val();
	var dwnfile = "printexcelmember.php?selectLevel="+selectLevel;
	var triggerDownload = $("<a>").attr("href", dwnfile).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
function exportpdf(t){
	var tb = $(t);
	var searchIDs = tb.attr('rev');
	var url = 'member-loadexportdatapdf.php?'+searchIDs;
	var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
function loadajaxstate(data){
	var tb = $(data);
	var selectto = $('#selectProvince');
	// console.log(data);
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	// console.log(FullPath);
	var LoginData = $('#ajaxFrm #LoginData').val();
	var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{indata:tb.val(),LoginData:LoginData},
			'url': FullPath+'ajax/ajax-loadstate.php',
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
			html += '<option value="'+json['result'][i].valueid+'">'+json['result'][i].valuesubject+'</option>';
		}
	}
	selectto.html(html);
	selectto.select2();
}
function loadajaxdistrict(data){
	var country = $('select[name=selectCountry]').val();
	var selectto = $('#selectDistrict');
	// console.log(data);
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	// console.log(FullPath);
	var LoginData = $('#ajaxFrm #LoginData').val();
	var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{country:country,state:data,LoginData:LoginData},
			'url': FullPath+'ajax/ajax-loaddistrict.php',
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
			html += '<option value="'+json['result'][i].valueid+'">'+json['result'][i].valuesubject+'</option>';
		}
	}
	selectto.html(html);
	selectto.select2({
		placeholder: "Select a state",
		allowClear: true
	});
}
function changeDialogStatus(t){
	var mydata = $(t).attr('rev');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();

	$.magnificPopup.open({
		removalDelay: 500, //delay removal by X to allow out-animation,
		items: {
			src: "#modal-formmanualupdatestatus"
		},
		// overflowY: 'hidden', //
		callbacks: {
			beforeOpen: function(e) {
				$('#FrmManualUpdateStatus input[name=MyData]').val(mydata);
				var Animation = "mfp-zoomIn";
				this.st.mainClass = Animation;
			}
		},
		midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
	});
}
function summitFrmUpdateStatus(t){
	var form = $(t);
	var nreq = form.find('.fieldreqs').length;
	var row = $('body');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var footer = $('table.tbpending').find('tfoot');
	var pagination = footer.find('ul.pagination');
	var pagenumber = parseInt(footer.find('li.active a').html());
	var mydata = form.find('input[name=MyData]').val();
	var myremark = form.find('textarea[name=textRemark]').val();
	var nreqchk = 0;
	for(i=0;i<nreq;i++){
		obj = form.find('.fieldreqs:eq('+i+')');
		objType = obj.attr('type');
		tagName = obj.get(0).tagName;
		title = obj.attr('dataalert');
		if(objType=='hidden'){
			var pre = '';
		}else{
			if(tagName=='SELECT'){
        var pre = '';//กรถณาเลือก
    	}else{
        var pre = '';//กรุณากรอก
    	}
		}
		var txtshow = pre+title;
		if(obj.val()==''){
			// obj.closest('div.frmalert').find('.errorText').remove();
			// obj.closest('div.frmalert').append('<div class="errorText">'+txtshow+'</div>');
			obj.focus();
			return false;
		}else{
			nreqchk = nreqchk+1;
			// obj.closest('div.frmalert').find('.errorText').remove();
		}
	}
	if(nreq==nreqchk){
		$.ajax({
			'beforeSend': function(){
				row.LoadingOverlay("show");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data': {MyData:mydata,myremark:myremark},
			'url': PathURL+"thaiembassy/pending-dataaccess.php",
			'dataType': "json",
			'success': function (data) {
				if(data.status=='OK'){
					form.each(function(){
						this.reset();
					});
					loadpageajax(pagenumber);
					$.magnificPopup.close();
				}
			},
			complete: function(){
				row.LoadingOverlay("hide");
			}
		});
	}
	return false;
}
