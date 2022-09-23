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
      var countmnu = $('#countmnu').val();
  		var genStr="";
      // $("#myFrm input[type=radio]").each(function() {
      //   console.log($(this).val(), $(this).attr('name'));
      //           //whatever you need
      // });
      var rgroups = [];
      $('input:radio').each(function (index, el) {
          var i;
          for (i = 0; i < rgroups.length; i++)
          if (rgroups[i] == $(el).attr('name')) return true;
          rgroups.push($(el).attr('name'));
      });
      // rgroups = rgroups.length;
      // console.log(rgroups);
  		for(var i=1;i<=countmnu;i++){
  			// var ii = $('input[name=Admin'+i+']:checked', '#myFrm').val();
        var ii = $('input[name='+rgroups[i]+']:checked', '#myFrm').val();
  			if(i>1){
  				genStr += ',';
  			}
  			if(ii!=undefined){
  				// genStr += i+':'+ii;
          genStr += rgroups[i]+':'+ii;
  			}else{
  				// genStr += i+':NA';
          genStr += rgroups[i]+':NA';
  			}
  		}
      // console.log(genStr);
  		$('#Permission').val(genStr);
			$.ajax({type:"POST",
      url:PathURL+"groupuser/ajax-update.php",
      data:$(form).serialize(),
      cache:false,
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

		rules: {
			inputGName: {
			  required: true
			}
		},
      /* @validation error messages
      ---------------------------------------------- */
		messages: {
			inputGName: {
				required: 'Enter Group name'
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
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
