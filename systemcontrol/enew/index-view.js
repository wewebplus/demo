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
