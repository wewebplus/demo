jQuery(document).ready(function() {
  var actionpage = $('#ajaxFrm input[name=actionpage]').val();
  if($.isNumeric(actionpage)){
    loadpageajax(actionpage);
  }else{
    loadpageajax(1);
  }
  $('.form-searchGroup button[name=searchGroupclear]').on('click', function(){
    $( '.form-searchGroup' ).each(function(){
      this.reset();
    });
    loadpageajax(1);
  });
});
function submitFrmSearch(t){
  loadpageajax(1);
  return false;
}
