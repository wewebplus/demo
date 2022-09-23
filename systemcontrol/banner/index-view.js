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
});
