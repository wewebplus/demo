jQuery(document).ready(function() {
  var actionpage = $('#ajaxFrm input[name=actionpage]').val();
  if($.isNumeric(actionpage)){
    loadpageajax(actionpage);
  }else{
    loadpageajax(1);
  }
  loadpageselectgroup(1);
  loadpagelistajax(1);
  $('.form-search button[name=searchclear]').on('click', function(){
    $( '.form-search' ).each(function(){
      this.reset();
    });
    loadpagelistajax(1);
  });
  $('.form-searchGroup button[name=searchGroupclear]').on('click', function(){
    $( '.form-searchGroup' ).each(function(){
      this.reset();
    });
    loadpageajax(1);
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
