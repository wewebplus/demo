var allidlist=null;
$(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
	var PathFileAtt = $('input[name=PathFileAtt]').val();
	var SessionID = $('input[name=SessionID]').val();
	var UploadToFile = $('input[name=UploadToFile]').val();
	loadpagefileajax(saveData,'#outputuploadFileContent','edit');
	$("#uploadFileContent").setupload({
		'script' : UploadToFile,
		'scriptData' : {myflag:'Content',saveData:saveData},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':'.pdf,.doc,.xls,.ppt,.docx,.xlsx,.pptx,.zip,.jpg,.png',
		'path':PathFileAtt,
		'DataID':0,
		'SessionID':SessionID,
		'result_output':'#outputuploadFileContentError',
		'progress_bar_id':'#progressuploadFileContent',
		'success':function(upresult,data){
			loadpagefileajax(saveData,'#outputuploadFileContent','edit');
		}
	});
	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
});
