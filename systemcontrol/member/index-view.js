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
  var typeUpload_1 = "certificate_of_registration";
	var saveDataFile_1 = $('input[name=saveData'+typeUpload_1+']').val();
	var PathFileAtt_1 = $('input[name=PathAtt'+typeUpload_1+']').val();
	var SessionID_1 = $('input[name=SessionID]').val();
	var UploadToFile_1 = $('input[name=UploadTo'+typeUpload_1+']').val();
	var UploadToExt_1 = arrfileupload;
	loadpagefileajax(saveDataFile_1,'#outputuploadFile'+typeUpload_1,'view');

  var typeUpload_2 = "tax_identification";
	var saveDataFile_2 = $('input[name=saveData'+typeUpload_2+']').val();
	var PathFileAtt_2 = $('input[name=PathAtt'+typeUpload_2+']').val();
	var SessionID_2 = $('input[name=SessionID]').val();
	var UploadToFile_2 = $('input[name=UploadTo'+typeUpload_2+']').val();
	var UploadToExt_2 = arrfileupload;
	loadpagefileajax(saveDataFile_2,'#outputuploadFile'+typeUpload_2,'view');

  var typeUpload_3 = "product_certificate";
	var saveDataFile_3 = $('input[name=saveData'+typeUpload_3+']').val();
	var PathFileAtt_3 = $('input[name=PathAtt'+typeUpload_3+']').val();
	var SessionID_3 = $('input[name=SessionID]').val();
	var UploadToFile_3 = $('input[name=UploadTo'+typeUpload_3+']').val();
	var UploadToExt_3 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_3,'#outputuploadFile'+typeUpload_3,'view');

  var typeUpload_4 = "product_quality";
	var saveDataFile_4 = $('input[name=saveData'+typeUpload_4+']').val();
	var PathFileAtt_4 = $('input[name=PathAtt'+typeUpload_4+']').val();
	var SessionID_4 = $('input[name=SessionID]').val();
	var UploadToFile_4 = $('input[name=UploadTo'+typeUpload_4+']').val();
	var UploadToExt_4 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_4,'#outputuploadFile'+typeUpload_4,'view');

  var typeUpload_5 = "copyright_origin";
	var saveDataFile_5 = $('input[name=saveData'+typeUpload_5+']').val();
	var PathFileAtt_5 = $('input[name=PathAtt'+typeUpload_5+']').val();
	var SessionID_5 = $('input[name=SessionID]').val();
	var UploadToFile_5 = $('input[name=UploadTo'+typeUpload_5+']').val();
	var UploadToExt_5 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_5,'#outputuploadFile'+typeUpload_5,'view');

  var typeUpload_6 = "company_location";
	var saveDataFile_6 = $('input[name=saveData'+typeUpload_6+']').val();
	var PathFileAtt_6 = $('input[name=PathAtt'+typeUpload_6+']').val();
	var SessionID_6 = $('input[name=SessionID]').val();
	var UploadToFile_6 = $('input[name=UploadTo'+typeUpload_6+']').val();
	var UploadToExt_6 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_6,'#outputuploadFile'+typeUpload_6,'view');

  var typeUpload_7 = "other_file";
	var saveDataFile_7 = $('input[name=saveData'+typeUpload_7+']').val();
	var PathFileAtt_7 = $('input[name=PathAtt'+typeUpload_7+']').val();
	var SessionID_7 = $('input[name=SessionID]').val();
	var UploadToFile_7 = $('input[name=UploadTo'+typeUpload_7+']').val();
	var UploadToExt_7 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_7,'#outputuploadFile'+typeUpload_7,'view');

});
