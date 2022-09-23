var allidlist=null;
jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('.number').filter_input({regex:'[0-9]'});
	$('.time').mask('99:99');
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
  var numchk = $('textarea[name^=inputDetail]').length;
  for(i=0;i<numchk;i++){
    var thisname = $('textarea[name^=inputDetail]:eq('+i+')').attr('name');
    CKEDITOR.replace(thisname, {
			//filebrowserBrowseUrl: '../vendor/plugins/ckfinder/ckfinder.html',
	    //filebrowserImageBrowseUrl: '../vendor/plugins/ckfinder/ckfinder.html?type=Images',
	    //filebrowserUploadUrl: '../vendor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	    //filebrowserImageUploadUrl: '../vendor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			filebrowserBrowseUrl:'../vendor/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
			filebrowserUploadUrl:'../vendor/plugins/responsive_filemanager/filemanager/upload-select.php',
			height: 350,
      on: {
        instanceReady: function(evt) {
          $('.cke').addClass('admin-skin cke-hide-bottom');
        }
      },
    });
		// CKEDITOR.on('instanceLoaded', function(e) {e.editor.resize(700, 350)} );
  }
	$("#myFrm").validate({
		ignore: [],
		errorPlacement: function() {},
		submitHandler: function(form) {
			//alert('Successfully saved!');
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
      for(var instanceName in CKEDITOR.instances){
          CKEDITOR.instances[instanceName].updateElement();
      }
			$.ajax({
				'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
				},
				'type':'POST',
				'data':$(form).serialize(),
				'url': PathURL+"products/index-ajax-addnew.php",
				'success': function (data) {
					$('#ErrorResult').html(data);
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
            var validatePane = $('.tab-content.tab-validate .tab-pane:has(label.state-error)').each(function() {
                var id = $(this).attr('id');
                $('.nav-tabs').find('a[href^="#' + id + '"]').append('<small class="required">*</small>');
								//$('.nav-tabs').find('a[href^="#' + id + '"]').closest('li').addClass('active');
								//$('#'+id).addClass('active');
								//$('.tab-content > div').not('#'+id).removeClass('active');
            });
        });
    },
		rules: {},
		messages: {},
		errorClass: "state-error",
		validClass: "state-success",
		errorElement: "em",
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
	// Img file
	var typeUpload = "product";
	var saveDataImg = $('input[name=saveData'+typeUpload+']').val();
	var PathImageAtt = $('input[name=PathAtt'+typeUpload+']').val();
	var SessionID = $('input[name=SessionID]').val();
	var UploadToFile = $('input[name=UploadTo'+typeUpload+']').val();
	loadpagefileajax(saveDataImg,'#outputuploadFile'+typeUpload,'edit');
	$("#uploadFile"+typeUpload).setupload({
		'script' : UploadToFile,
		'scriptData' : {myflag:'Content',saveData:saveDataImg},
		'total_files_allowed' : 0,
		'allowed_file_types':arrimagesupload,
		'fileExt':'image/*',
		'path':PathImageAtt,
		'DataID':0,
		'SessionID':SessionID,
		'result_output':'#outputuploadFile'+typeUpload+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload,
		'success':function(upresult,data){
			loadpagefileajax(saveDataImg,'#outputuploadFile'+typeUpload,'edit');
		}
	});
	// end img
	// File
	var typeUpload_1 = "renewal";
	var saveDataFile_1 = $('input[name=saveData'+typeUpload_1+']').val();
	var PathFileAtt_1 = $('input[name=PathAtt'+typeUpload_1+']').val();
	var SessionID_1 = $('input[name=SessionID]').val();
	var UploadToFile_1 = $('input[name=UploadTo'+typeUpload_1+']').val();
	var UploadToExt_1 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_1,'#outputuploadFile'+typeUpload_1,'edit');
	$("#uploadFile"+typeUpload_1).setupload({
		'script' : UploadToFile_1,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_1},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_1,
		'path':PathFileAtt_1,
		'DataID':0,
		'SessionID':SessionID_1,
		'result_output':'#outputuploadFile'+typeUpload_1+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_1,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_1,'#outputuploadFile'+typeUpload_1,'edit');
		}
	});
	// end File
	$('.frmalert select').on('change', function() {
		var thisname = $(this).attr('name');
		var thisinput = thisname.replace("select","input");
		var thistext = $(this).find("option:selected").text();
		$('input[name='+thisinput+']').val(thistext);
	});
	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
  // Init Bootstrap Maxlength Plugin
  // $('input[maxlength]').maxlength({
	// threshold: 20,
  //   	placement: "right"
  // });
	$(".select2_single").select2();
});
