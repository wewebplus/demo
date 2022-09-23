jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
	var PathFileAtt = $('input[name=PathFileAtt]').val();
	var SessionID = $('input[name=SessionID]').val();
	var UploadToFile = $('input[name=UploadToFile]').val();
	loadpagefileajax(saveData,'#outputuploadFileEnew','view');  
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
});
function submitForm(t){
  return false;
}
