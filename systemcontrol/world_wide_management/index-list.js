jQuery(document).ready(function() {
  var actionpage = $('#ajaxFrm input[name=actionpage]').val();
  if($.isNumeric(actionpage)){
    loadpageajax(actionpage);
  }else{
    loadpageajax(1);
  }
  $('.form-search button[name=searchclear]').on('click', function(){
    $( '.form-search' ).each(function(){
      this.reset();
    });
    loadpageajax(1);
  });
});
function submitFrmSearch(t){
  loadpageajax(1);
  return false;
}
