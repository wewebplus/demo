jQuery(document).ready(function() {
  var actionpage = $('#ajaxFrm input[name=actionpage]').val();
  if($.isNumeric(actionpage)){
    loadpageajax(actionpage);
  }else{
    loadpageajax(1);
  }
  //mobilehotdeal
  $( ".mobilehotdeal" ).live( "click", function() {
		var pageval=$(this).val();
    changeHotdeal(pageval,this);
	});
  $('.form-search button[name=searchclear]').on('click', function(){
    $( '.form-search' ).each(function(){
      this.reset();
    });
    var filtering = FooTable.get('.footable').use(FooTable.Filtering);
    filtering.removeFilter('status');
    filtering.filter();
  });
  $('.form-search select').on('change', function(){
    var selectGroup = $('select[name=selectGroup] option:selected').text();
    if($.trim(selectGroup)=='- - Select Group - -'){
      selectGroup = '';
    }
    var fooFilter = $('input[id=fooFilter]').val();
    var filter = '';
    var filtering = FooTable.get('.footable').use(FooTable.Filtering);
    if($.trim(selectGroup)!=''){
      filter += selectGroup;
      filtering.addFilter('status', selectGroup, ['Group']);
      filtering.filter();
    }else{
      filtering.removeFilter('status');
      filtering.filter();
    }
    if($.trim(fooFilter)!=''){
      filter += ' '+fooFilter;
    }else{
      filtering.removeFilter('status');
      filtering.filter();
    }
    filtering.addFilter('status', filter, ['Group']);
    filtering.filter();
  });
  $('#fooFilter').on('keyup', function(){
		var filtering = FooTable.get('.footable').use(FooTable.Filtering); // get the filtering component for the table
		var thistxtfilter = $(this).val(); // get the value to filter by
    var selectGroup = $('select[name=selectGroup] option:selected').text();
    if($.trim(selectGroup)=='- - Select Group - -'){
      selectGroup = '';
    }
    var filter = $.trim(thistxtfilter+' '+selectGroup);
    filtering.addFilter('status', filter, ['Group','Content','ContentDate']);
		filtering.filter();
	});
  
});
