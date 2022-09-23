jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var saveData = $('input[name=saveData]').val();
	var PathFileAtt = $('input[name=PathFileAtt]').val();
	var SessionID = $('input[name=SessionID]').val();
	var UploadToFile = $('input[name=UploadToFile]').val();
	loadpagefileajax(saveData,'#outputuploadFileEnew','edit');
	$("#uploadFileEnew").setupload({
		'script' : UploadToFile,
		'scriptData' : {myflag:'Enew',saveData:saveData},
		'total_files_allowed' : 3,
		'allowed_file_types':arrfileupload,
		'fileExt':'.pdf,.doc,.xls,.ppt,.docx,.xlsx,.pptx,.zip,.jpg,.png',
		'path':PathFileAtt,
		'DataID':0,
		'SessionID':SessionID,
		'result_output':'#outputuploadFileEnewError',
		'progress_bar_id':'#progressuploadFileEnew',
		'success':function(upresult,data){
			loadpagefileajax(saveData,'#outputuploadFileEnew','edit');
		}
	});
	var numchk = $('textarea[name^=inputDetail]').length;
  for(i=0;i<numchk;i++){
    var thisname = $('textarea[name^=inputDetail]:eq('+i+')').attr('name');
    CKEDITOR.replace(thisname, {
			//filebrowserBrowseUrl: '../vendor/plugins/ckfinder/ckfinder.html',
	    //filebrowserImageBrowseUrl: '../vendor/plugins/ckfinder/ckfinder.html?type=Images',
	    //filebrowserUploadUrl: '../vendor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	    //filebrowserImageUploadUrl: '../vendor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			filebrowserBrowseUrl:'../vendor/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
			filebrowserUploadUrl:'../vendor/plugins/responsive_filemanager/filemanager/upload-select.php',
			customConfig: FullPath+'/vendor/plugins/ck/configcustomize.js',
			height: 350,
      on: {
        instanceReady: function(evt) {
          $('.cke').addClass('admin-skin cke-hide-bottom');
        }
      },
    });
  }
	$('#myFrm select').on('change', function(){
    var thisname = $(this).attr('name');
    var thisval = $(this).val();
  	var thistext = $(this).find('option:selected').text();
		$('input[name='+thisname+'Text]').val(thistext);
  });
	$( "#ListBtn" ).on( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
function submitForm(t){
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var nreq = tb.find('.fieldreqs').length;
	var nreqchk = 0;
	for(i=0;i<nreq;i++){
		obj = tb.find('.fieldreqs:eq('+i+')');
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
			obj.closest('div.frmalert').find('.errorText').remove();
			obj.closest('div.frmalert').append('<div class="errorText">'+txtshow+'</div>');
			obj.focus();
			return false;
		}else{
			nreqchk = nreqchk+1;
			obj.closest('div.frmalert').find('.errorText').remove();
		}
	}
	if(nreq==nreqchk){
		for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
		}
		$.ajax({
  		'beforeSend': function(){
  			$("body").LoadingOverlay("show");
  		},
  		type:"POST",
  		url:FullPath+'enew/doc-ajax-addnew.php',
  		data:tb.serialize(),
  		cache:false,
  		success: function(data) {
				// $('#ErrorResult').html(data);
  			//alert(data);
				var mydata = $('#ajaxFrm input[name=LoginData]').val();
				var url = getfullUrl()+'?'+mydata;
  			$.alert({
  				    //title: 'Set Employee!',
  				    title: false,
  				    content: 'Save Data Complete!',
  				    buttons: {
  				    	OK: function () {
  				    		window.location = url;
  				    	}
  				    }
  				});
  		},
  		error: function () {
  			alert("Error");
  		},
  		complete: function(){
  			$("body").LoadingOverlay("hide");
  		}
  	});
	}
	return false;
}
