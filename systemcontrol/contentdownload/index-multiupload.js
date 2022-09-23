function loadpagefileajax(saveData,to,type){
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
			'url': './index-ajax-loadpagefilelist.php',
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
		html += '<div class="boxrelatefile">';
		for (var i = 0; i< len; i++) {
      html += '<div class="boxinnerrelate" id="'+json['result'][i].ID+'">';
        html += '<div class="relatelineimg"><a href="javascript:void(0)" rev="'+json['result'][i].DataDWN+'" onclick="DownloadDocument(this)"><img src="'+json['result'][i].FileTypeShow+'" border="0" class="thumbgallery" /></a></div>';
        html += '<div class="relatelineinfo">';
          html += '<div class="relatelinedetail"><p>'+json['result'][i].Detail+'</p><p>Doenload : '+json['result'][i].CountDWN+'</p></div>';
					if(type=='edit'){
						html += '<div class="relatelinebtn">';
							html += '<a href="javascript:void(0)" rev="'+json['result'][i].DataDWN+'" class="relateicon" onclick="DownloadDocument(this)"><i class="fa fa-download"></i></a>'
	            html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="relateicon" onclick="editlistfile(this)"><i class="fas fa-pen-square"></i></a>'
	            html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" rev="'+type+'" class="relateicon" onclick="deletelistfile(this)"><i class="fas fa-trash-alt"></i></a>';
	          html += '</div>';
					}else{
						html += '<div class="relatelinebtn">';
							html += '<a href="javascript:void(0)" rev="'+json['result'][i].DataDWN+'" class="relateicon" onclick="DownloadDocument(this)"><i class="fa fa-download"></i></a>'
	          html += '</div>';
					}
        html += '</div>';
      html += '</div>';
		}
		html += '</div>';
	}
	$(to).html(html);
	if(type=='edit'){
		$('.boxrelatefile').sortable({
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
}
function editlistfile(t){
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
			'data':{dataitemid:itemid,saveData:saveData,action: 'selecttxt'},
			'url': 'index-index-ajax-action-file.php',
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
	$('input[name=relateedit_'+itemid+']').focusTextToEnd();
	tb.html('<i class="fas fa-save"></i>');
	tb.attr('onclick','savelistfile(this)')
}
function savelistfile(t){
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
			'data':{dataitemid:itemid,saveData:saveData,datadetail:datadetail,action: 'savetxt'},
			'url': 'index-ajax-action-file.php',
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
			'url': 'index-ajax-action-file.php',
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
function deletelistfile(t){
	var tb = $(t);
	var itemid = tb.attr('rel');
	var saveData = $('input[name=saveData]').val();
	if(confirm('ข้อมูลนี้กำลังจะถูกลบ คุณแน่ใจหรือไม่ ?')){
		$.post("index-ajax-action-file.php", { dataitemid: itemid,saveData:saveData, action: 'delete'},
		function(data){
			if(data == 1){
				loadpagefileajax(saveData,'#outputuploadFileContent','edit');
			}else{
				alert('ไม่สามารถทำตามคำสั่งได้ เกิดความผิดพลาดดังนี้ >> '+data);
			}
		});
	}
}
function DownloadDocument(t){
	var data = $(t).attr('rev');
  var url = 'downloadsrc.php?'+data;
  var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
