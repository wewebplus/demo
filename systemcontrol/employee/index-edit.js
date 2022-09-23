jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
  $( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
  var actionlang = $('#ajaxFrm input[name=actionlang]').val();
  $.validator.methods.smartCaptcha = function(value, element, param) {
    return value == param;
  };
  var w = $('#myFrm input[name=Gwidth]').val();
  var h = $('#myFrm input[name=Gheight]').val();
  var thumbcrop = $('#myFrm input[name=thumbcrop]').val();
  $('.image-editor').cropit({
    imageState: {
      src: thumbcrop,
    },
    width: w, height: h
  });
  $('.rotate-cw').click(function() {
    $('.image-editor').cropit('rotateCW');
  });
  $('.rotate-ccw').click(function() {
    $('.image-editor').cropit('rotateCCW');
  });
  $('#fileUpload').change(function () {
    var ext = this.value.substr((this.value.lastIndexOf('.') +1));
    ext = ext.toLowerCase();
    switch (ext) {
      case 'jpg':
      case 'png':
      case 'jpeg':
        $('#btAdd').attr('disabled', false);
        break;
      default:
        alert('This is not an allowed file type.');
        this.value = '';
    }
  });

	$("#myFrm").validate({
		submitHandler: function(form) {
      var imageData = $('.image-editor').cropit('export');
  		$('input[name=imageData]').val(imageData);
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
			$.ajax({type:"POST", url:PathURL+"employee/ajax-update.php", data:$(form).serialize(), cache:false,
				success: function(data) {
					//$('#xxxxx').html(data);
					if($.trim(data)>1){
            var PathURL = $('#ajaxFrm input[name=PathURL]').val();
            var mydata = $('#ajaxFrm input[name=LoginData]').val();
            var url = getfullUrl()+'?'+mydata;
            window.location = url;
						//location.reload();
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
});
