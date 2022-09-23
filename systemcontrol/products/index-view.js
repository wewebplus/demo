jQuery(document).ready(function() {
  $( "#EditBtn" ).live( "click", function() {
    var mydata = $('#myFrm input[name=saveData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  var typeUpload = "product";
	var saveDataImg = $('input[name=saveData'+typeUpload+']').val();
	var PathImageAtt = $('input[name=PathAtt'+typeUpload+']').val();
	var SessionID = $('input[name=SessionID]').val();
	var UploadToFile = $('input[name=UploadTo'+typeUpload+']').val();
	loadpagefileajax(saveDataImg,'#outputuploadFile'+typeUpload,'view');

  var typeUpload_1 = "renewal";
	var saveDataFile_1 = $('input[name=saveData'+typeUpload_1+']').val();
	var PathFileAtt_1 = $('input[name=PathAtt'+typeUpload_1+']').val();
	var SessionID_1 = $('input[name=SessionID]').val();
	var UploadToFile_1 = $('input[name=UploadTo'+typeUpload_1+']').val();
	var UploadToExt_1 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_1,'#outputuploadFile'+typeUpload_1,'view');
});
