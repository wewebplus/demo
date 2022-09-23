var allidlist=null;
$(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
	loadpagegalleryajax(saveData,'#outputuploadImages');
	$("#uploadImages").setupload({
		'script' : 'index-uploadifyphoto.php',
		'scriptData' : {saveData:saveData},
		'total_files_allowed' : 0,
		'allowed_file_types':arrimagesupload,
		'fileExt':'.jpg,.jpeg',
		'path':'',
		'DataID':0,
		'result_output':'#outputuploadImagesError',
		'progress_bar_id':'#progressuploadImages',
		'success':function(upresult,data){
			loadpagegalleryajax(saveData,'#outputuploadImages');
		}
	});

	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
});

function loadpagegalleryajax(saveData,to){
	//alert(cmsid+' '+to);
	var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
				$(to).LoadingOverlay("show");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{saveData:saveData},
			'url': './index-ajax-loadpagephoto.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $(to).LoadingOverlay("hide");
		  }
		});
		return json;
	})();
	var len = json['result'].length;
	var html = '';
	if(len>0){
		html += '<div class="boxrelate">';
		for (var i = 0; i< len; i++) {
			html += '<div class="boxinnerrelate" id="'+json['result'][i].ID+'">';
				html += '<div class="relatelineimg"><img src="'+json['result'][i].ThumbPic+'" border="0" class="thumbgallery" /></div>';
				html += '<div class="relatelineinfo">';
					html += '<div class="relatelinedetail">'+json['result'][i].Detail+'</div>';
					html += '<div class="relatelinebtn">';
						html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="relateicon" onclick="editlistimg(this)"><i class="fas fa-pen-square"></i></a>'
						html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="relateicon" onclick="deletelistimg(this)"><i class="fas fa-trash-alt"></i></a>';
					html += '</div>';
				html += '</div>';
			html += '</div>';
		}
		html += '</div>';
	}
	$(to).html(html);
	$('.boxrelate').sortable({
			items: '.boxinnerrelate',
			placeholder: "ui-state-highlight",
			update:function(){
				var items = $(".boxinnerrelate");
				var photos = [];
				allidlist=null;
				for(var x=0; x<items.length; x++){
					var photo = {}
					photo.id = items[x].id;
					allidlist= allidlist+'|x|'+photo.id;
				}
				savesortable(allidlist);
			}
	}).disableSelection();
}
function savesortable(data){
	var json = (function () {
		var json = null;
		var saveData = $('input[name=saveData]').val();
		$.ajax({
			'beforeSend': function(){
				//tbd.LoadingOverlay("show");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{dataorder:data,saveData:saveData,action: 'sortcontent'},
			'url': 'index-ajax-action_photo.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    //tbd.LoadingOverlay("hide");
		  }
		});
		return json;
	})();
	var detail = json['Detail'];
	//alert(detail);
}
function editlistimg(t){
	var tb = $(t);
	var itemid = tb.attr('rel');
	var tbd = tb.closest('.relatelineinfo');
	var tbinput = tbd.find('.relatelinedetail');
	var json = (function () {
		var json = null;
		var saveData = $('input[name=saveData]').val();
		$.ajax({
			'beforeSend': function(){
				tbd.LoadingOverlay("show");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{dataitemid:itemid,saveData:saveData,action: 'selecttxtphoto'},
			'url': 'index-ajax-action_photo.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    tbd.LoadingOverlay("hide");
		  }
		});
		return json;
	})();
	var detail = json['Detail'];
	var html = '<input type="text" name="relateedit_'+itemid+'" value="'+detail+'">';
	tbinput.html(html);
	$('input[name=relateedit_'+itemid+']').focus();
	tb.html('<i class="fas fa-save"></i>');
	tb.attr('onclick','savelistimg(this)')
}
function savelistimg(t){
	var tb = $(t);
	var itemid = tb.attr('rel');
	var tbd = tb.closest('.relatelineinfo');
	var tbinput = tbd.find('.relatelinedetail');
	var datadetail = $('input[name=relateedit_'+itemid+']').val();
	var json = (function () {
		var json = null;
		var saveData = $('input[name=saveData]').val();
		$.ajax({
			'beforeSend': function(){
				tbd.LoadingOverlay("show");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{dataitemid:itemid,saveData:saveData,datadetail:datadetail,action: 'savetxtphoto'},
			'url': 'index-ajax-action_photo.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    tbd.LoadingOverlay("hide");
		  }
		});
		return json;
	})();
	var detail = json['Detail'];
	tbinput.html(detail);
	tb.html('<i class="fas fa-pen-square"></i>');
	tb.attr('onclick','editlistimg(this)')
}
function deletelistimg(t){
	var tb = $(t);
	var itemid = tb.attr('rel');
	var saveData = $('input[name=saveData]').val();
	$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this record?',
			buttons: {
				Submit: {
						text: 'Confirm',
						btnClass: 'btn-blue',
						action: function () {
							$.post("index-ajax-action_photo.php", { dataitemid: itemid,saveData:saveData, action: 'deletephoto'},
							function(data){
								if(data == 1){
									loadpagegalleryajax(saveData,'#outputuploadImages');
								}else{
									alert('ไม่สามารถทำตามคำสั่งได้ เกิดความผิดพลาดดังนี้ >> '+data);
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
