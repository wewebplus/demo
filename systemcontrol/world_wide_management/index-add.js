jQuery(document).ready(function() {
  // Cache several DOM elements
  var pageHeader = $('.content-header').find('b');
  var adminForm = $('.admin-form');
  var options = adminForm.find('.option');
  var switches = adminForm.find('.switch');
  var buttons = adminForm.find('.button');
  var Panel = adminForm.find('.panel');

  $("#myFrm").validate({
		submitHandler: function(form) {
      $('button[type=submit]').prop( "disabled", true);
      $('.ajax-loader').css("visibility", "visible");
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
			$.ajax({
        type:"POST",
        url:PathURL+"world_wide_management/index-ajax-addnew.php",
        data:$(form).serialize(),
        cache:false,
				success: function(data) {
					if($.trim(data)>1){
            var PathURL = $('#ajaxFrm input[name=PathURL]').val();
            var mydata = $('#ajaxFrm input[name=LoginData]').val();
            var url = getfullUrl()+'?'+mydata;
            window.location = url;
					}else{
						alert('error : '+data);
					}
				},
				complete: function(){
					$('.ajax-loader').css("visibility", "hidden");
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

		rules: {},
      /* @validation error messages
      ---------------------------------------------- */
		messages: {},
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
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  $('input[maxlength]').maxlength({
  threshold: 20,
      placement: "right"
  });
});
