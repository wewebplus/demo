jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('.checkLang').each(function() {
		var cld = $(this).closest('div.boxlang');
		var mylang = $(this).attr('title');
    if($(this).is(':checked')) {
			cld.find(':text,input[type=url],textarea,select').each(function() {
				$(this).attr('disabled',true);
		  });
    } else {
			cld.find(':text,input[type=url],textarea,select').each(function() {
				$(this).attr('disabled',false);
		  });
    }
	});
	$('.checkLang').click(function() {
		var cld = $(this).closest('div.boxlang');
		var mylang = $(this).attr('title');
    if($(this).is(':checked')) {
			cld.find(':text,input[type=url],textarea,select').each(function() {
				var thisname = $(this).attr('name');
				$(this).attr('disabled',true);
				$(this).closest('label').removeClass('state-error');
				$(this).closest('label').next().remove();
		  });
    } else {
			cld.find(':text,input[type=url],textarea,select').each(function() {
				var thisname = $(this).attr('name');
				$(this).attr('disabled',false);
		  });
    }
	});
  $("#datepickerFrom").datepicker({
    dateFormat: 'dd/mm/yy',
    prevText: '<i class="fa fa-chevron-left"></i>',
    nextText: '<i class="fa fa-chevron-right"></i>',
    showButtonPanel: false,
    onSelect: function(selected) {
      $("#datepickerTo").datepicker("option","minDate", selected)
    }
  });
  $("#datepickerTo").datepicker({
    dateFormat: 'dd/mm/yy',
    prevText: '<i class="fa fa-chevron-left"></i>',
    nextText: '<i class="fa fa-chevron-right"></i>',
    showButtonPanel: false,
    onSelect: function(selected) {
       $("#datepickerFrom").datepicker("option","maxDate", selected)
    }
  });

  $("#myFrm").validate({
		ignore: [],
		errorPlacement: function() {},
		submitHandler: function(form) {
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
			$.ajax({
				'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
				},
				'type':'POST',
				'data':$(form).serialize(),
				'url': PathURL+"weblink/ajax-update.php",
				'success': function (data) {
					//$('#xxxxx').html(data);
					if($.trim(data)>1){
						var PathURL = $('#ajaxFrm input[name=PathURL]').val();
						var mydata = $('#ajaxFrm input[name=LoginData]').val();
						var url = getfullUrl()+'?'+mydata;
						//alert(url);
						window.location = url;
					}else{
						alert('error : '+data);
					}
				},
				error: function () {
					alert("Error");
				},
				'complete': function(){
					$('.ajax-loader').css("visibility", "hidden");
				}
			});
			return false;
		},
		invalidHandler: function() {
        setTimeout(function() {
            $('.nav-tabs a small.required').remove();
						//$('.nav-tabs li').removeClass('active');
						//$('.tab-content > div').removeClass('active');
            var validatePane = $('.tab-content.tab-validate .tab-pane:has(div.has-error)').each(function() {
                var id = $(this).attr('id');
								console.log(id);
                $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">***</small>');
								//$('.nav-tabs').find('a[href^="#' + id + '"]').closest('li').addClass('active');
								//$('#'+id).addClass('active');
								//$('.tab-content > div').not('#'+id).removeClass('active');
            });
        });
    },
    errorClass: "has-error",
		validClass: "has-success",
		errorElement: "em",
		rules: {},
		messages: {},
    highlight: function(element, errorClass, validClass) {
			$(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.form-group').removeClass(errorClass).addClass(validClass);
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

    // Init Bootstrap Maxlength Plugin
    $('input[maxlength]').maxlength({
		threshold: 20,
      	placement: "right"
    });
});
