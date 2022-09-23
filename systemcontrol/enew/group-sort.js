jQuery(document).ready(function() {
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  $( "#sortablecontent" ).sortable({
		placeholder: 'ui-state-highlight',
		update:function(){
			var items = $(".ui-state-default");
			var photos = [];
			allidlist=null;
			for(var x=0; x<items.length; x++){
				var photo = {}
				photo.id = items[x].id;
				allidlist= allidlist+'|x|'+photo.id;
			}
      changeSortable(allidlist);
		}
	});
	$( "#sortablecontent" ).disableSelection();
});
