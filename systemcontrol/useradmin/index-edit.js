jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
  $( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
  $.validator.methods.smartCaptcha = function(value, element, param) {
    return value == param;
  };
  $(".select2_single").select2();
  $("#myFrm").validate({
		submitHandler: function(form) {
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
			$.ajax({type:"POST", url:PathURL+"useradmin/ajax-update.php", data:$(form).serialize(), cache:false,
				success: function(data) {
					//$('#xxxxx').html(data);
					if($.trim(data)>1){

						var PathURL = $('#ajaxFrm input[name=PathURL]').val();
						var mydata = $('#ajaxFrm input[name=LoginData]').val();
						var url = getfullUrl()+'?'+mydata;
						window.location = url;
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
			inputUsername: {
			  required: true
			},
      SelectUserType: {
        required: true
      },
      SelectEmployee: {
        required: true
      }
		},
      /* @validation error messages
      ---------------------------------------------- */
		messages: {
			inputUsername: {
				required: 'Enter Username'
			},
      SelectUserType: {
        required: 'Select User Type'
      },
      SelectEmployee: {
        required: 'Select Employee'
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
});
