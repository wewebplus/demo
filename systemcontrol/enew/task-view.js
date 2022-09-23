jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
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
function DownloadDocument(t){
	var data = $(t).attr('rev');
  var url = 'downloadsrc.php?'+data;
  var triggerDownload = $("<a>").attr("href", url).attr('target', '_blank').appendTo("body");
	triggerDownload[0].click();
	triggerDownload.remove();
}
