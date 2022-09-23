$(document).ready(function() {
  var actionlang = $('#ajaxFrm input[name=actionlang]').val();
  $('form').attr('autocomplete', 'off');
  $.validator.methods.smartCaptcha = function(value, element, param) {
    return value == param;
  };
	$("#myFrm").validate({
		submitHandler: function(form) {
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
			$.ajax({type:"POST", url:PathURL+"employee/ajax-addnew.php", data:$(form).serialize(), cache:false,
				success: function(data) {
					//$('#ErrorResult').html(data);
					if($.trim(data)>1){
						$(form).find('label').each(function(){
							$(this).removeClass("state-success");
						});
						$(form).each(function(){
							this.reset();
						});
						//loadpageajax(1);
						location.reload();
					}else{
						alert('error : '+data);
					}
				},
				error: function () {
					alert("Error");
				}
			});
			return false;
		},
		errorClass: "state-error",
		validClass: "state-success",
		errorElement: "em",

		rules: {
			firstname: {
			  required: true
			},
			lastname: {
			  required: true
			},
			useremail: {
			  required: true,
			  email: true
			}
		},
      /* @validation error messages
      ---------------------------------------------- */
		messages: {
			firstname: {
				required: Array_Mod_Lang["txtrequired:firstname"][actionlang]
			},
			lastname: {
				required: Array_Mod_Lang["txtrequired:lastname"][actionlang]
			},
			useremail: {
				required: Array_Mod_Lang["txtrequired:email"][actionlang],
				email: Array_Mod_Lang["txtrequired:email VALID"][actionlang]
			}
		},
      /* @validation highlighting + error placement
      ---------------------------------------------------- */
		highlight: function(element, errorClass, validClass) {
			$(element).closest('.field').addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.field').removeClass(errorClass).addClass(validClass);
		},
		errorPlacement: function(error, element) {
			if (element.is(":radio") || element.is(":checkbox")) {
				element.closest('.option-group').after(error);
			} else {
			  	error.insertAfter(element.parent());
			}
		}
	});
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
  $('.form-search select').on('change', function(){
    loadpageajax(1);
  });
});
function submitFrmSearch(t){
  loadpageajax(1);
  return false;
}
