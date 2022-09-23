jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('select[name=SelectMenu]').on('change', function(){
		var thisindex = $(this).val();
		loadpageajaxlistgroup(thisindex);
	});
	loadpageajaxlistgroup($('select[name=SelectMenu]').val());
});
function submitFrm(t){
  var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var inMenu = $('#myFrm select[name=SelectMenu]').val();
	var boxcontentinput = $('.forminput');
	var form = $(document.createElement('form'));
  $(form).attr("action", "?");
  $(form).attr("method", "POST");
	var inMenuInput = $("<input>").attr("type", "hidden").attr("name", "inMenu").val(inMenu);
	$(form).append($(inMenuInput));
	var inputmyaction = $("<input>").attr("type", "hidden").attr("name", "myaction").val('addnew');
	$(form).append($(inputmyaction));
	var insubmit = false;
	boxcontentinput.find('input:text,input:hidden, select, textarea').not('.gui-input').each(function() {
    if($.trim($(this).val())==''){
      insubmit = false;
      $(this).focusTextToEnd();
      return false;
    }else{
      insubmit = true;
      var input = $("<input>").attr("type", "hidden").attr("name", $(this).attr('name')).val($(this).val());
      $(form).append($(input));
    }
  });
	if(insubmit){
		$.ajax({
      'beforeSend': function(){
        $('.ajax-loader').css("visibility", "visible");
      },
      'async': false,
      'global': false,
      'type':'POST',
      'data':$(form).serialize(),
      'url': PathURL+'groupweblink/index-dataaction.php',
      'success': function (data) {
				console.log(data);
				if(data>0){
					$('#myFrm input[name^=inputGroup]').val('');
					loadpageajaxlistgroup(inMenu);
				}
      },
      complete: function(){
        $('.ajax-loader').css("visibility", "hidden");
      }
    });
	}
  return false;
}
