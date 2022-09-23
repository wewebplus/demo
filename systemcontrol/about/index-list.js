jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('.checkLang').each(function() {
		var cld = $(this).closest('div.boxlang');
		var mylang = $(this).attr('title');
    if($(this).is(':checked')) {
			cld.find(':text,textarea').each(function() {
				$(this).attr('disabled',true);
		  });
    } else {
			cld.find(':text,textarea').each(function() {
				$(this).attr('disabled',false);
		  });
    }
	});
	$('.checkLang').click(function() {
		var cld = $(this).closest('div.boxlang');
		var mylang = $(this).attr('title');
    if($(this).is(':checked')) {
			cld.find(':text,textarea').each(function() {
				var thisname = $(this).attr('name');
				$(this).attr('disabled',true);
				$(this).closest('label').removeClass('state-error');
				$(this).closest('label').next().remove();
				if(thisname=='inputDetail'+mylang){
					CKEDITOR.instances[thisname].setReadOnly(true);
				}
		  });
    } else {
			cld.find(':text,textarea').each(function() {
				var thisname = $(this).attr('name');
				$(this).attr('disabled',false);
				if(thisname=='inputDetail'+mylang){
					CKEDITOR.instances[thisname].setReadOnly(false);
				}
		  });
    }
	});
  //CKEDITOR.disableAutoInline = true;
  // Init Ckeditor
  var numchk = $('textarea[name^=inputDetail]').length;
  for(i=0;i<numchk;i++){
    var thisname = $('textarea[name^=inputDetail]:eq('+i+')').attr('name');
    CKEDITOR.replace(thisname, {
      height: 600,
      on: {
        instanceReady: function(evt) {
          $('.cke').addClass('admin-skin cke-hide-bottom');
        }
      },
    });
  }
});
function saveDataHtml(t){
  var PathURL = $('#ajaxFrm input[name=PathURL]').val();
  var frm = $('#myFrm');
  for(var instanceName in CKEDITOR.instances){
      CKEDITOR.instances[instanceName].updateElement();
  }
  $.ajax({
    'beforeSend': function(){
      $('.ajax-loader').css("visibility", "visible");
    },
    'type':'POST',
    'data':frm.serialize(),
    'url': PathURL+"about/ajax-updatedata.php",
    'success': function (data) {
      // $('#errorresult').html(data);
      if($.trim(data)>1){
        location.reload();
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
}
