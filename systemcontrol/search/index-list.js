jQuery(document).ready(function() {
  var actionpage = $('#ajaxFrm input[name=actionpage]').val();
  loadpagelistajax(actionpage);
  $('.form-search button[name=searchclear]').on('click', function(){
    $( '.form-search' ).each(function(){
      this.reset();
    });
    loadpagelistajax(1);
  });
  $('.form-search select').on('change', function(){
    loadpagelistajax(1);
  });
});
function submitFrmSearch(t){
  loadpageajax(1);
  return false;
}
function submitListFrmSearch(t){
	loadpagelistajax(1);
	return false;
}
