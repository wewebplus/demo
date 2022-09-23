jQuery(document).ready(function() {
  $(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});  
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
