jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
  $('.checkLang').each(function() {
    var cld = $(this).closest('div.boxlang');
    var mylang = $(this).attr('title');
    if($(this).is(':checked')) {
      cld.find(':text,input[type="email"],textarea').each(function() {
        $(this).attr('disabled',true);
      });
    } else {
      cld.find(':text,input[type="email"],textarea').each(function() {
        $(this).attr('disabled',false);
      });
    }
  });
  $('.checkLang').click(function() {
    var cld = $(this).closest('div.boxlang');
    var mylang = $(this).attr('title');
    if($(this).is(':checked')) {
      cld.find(':text,input[type="email"],textarea').each(function() {
        var thisname = $(this).attr('name');
        $(this).attr('disabled',true);
      });
    } else {
      cld.find(':text,input[type="email"],textarea').each(function() {
        var thisname = $(this).attr('name');
        $(this).attr('disabled',false);
      });
    }
  });

  $("#myFrm").validate({
    ignore: [],
		errorPlacement: function() {},
		submitHandler: function(form) {
      /*
			var PathURL = $('#ajaxFrm input[name=PathURL]').val();
			$.ajax({type:"POST", url:PathURL+"contactus/ajax-group-addnew.php", data:$(form).serialize(), cache:false,
				success: function(data) {
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
				}
			});
      */
			return false;
		},
    invalidHandler: function() {
        setTimeout(function() {
            $('.nav-tabs a small.required').remove();
						//$('.nav-tabs li').removeClass('active');
						//$('.tab-content > div').removeClass('active');
            var validatePane = $('.tab-content.tab-validate .tab-pane:has(label.state-error)').each(function() {
                var id = $(this).attr('id');
                $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">***</small>');
								//$('.nav-tabs').find('a[href^="#' + id + '"]').closest('li').addClass('active');
								//$('#'+id).addClass('active');
								//$('.tab-content > div').not('#'+id).removeClass('active');
            });
        });
    },
		errorClass: "state-error",
		validClass: "state-success",
		errorElement: "em",

		rules: {},
		messages: {},
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

  // Cropper
  (function() {
    var $image = $('.img-container01 > img'),
      $dataX = $('#dataX'),
      $dataY = $('#dataY'),
      $dataHeight = $('#dataHeight'),
      $dataWidth = $('#dataWidth'),
      $dataRotate = $('#dataRotate'),
      options = {
        aspectRatio: 1/1,
        preview: '.img-preview',
        crop: function(data) {
          $dataX.val(Math.round(data.x));
          $dataY.val(Math.round(data.y));
          $dataHeight.val(Math.round(data.height));
          $dataWidth.val(Math.round(data.width));
          $dataRotate.val(Math.round(data.rotate));
        }
      };

    $image.on({
      'build.cropper': function(e) {
        console.log(e.type);
      },
      'built.cropper': function(e) {
        console.log(e.type);
      },
      'dragstart.cropper': function(e) {
        console.log(e.type, e.dragType);
      },
      'dragmove.cropper': function(e) {
        console.log(e.type, e.dragType);
      },
      'dragend.cropper': function(e) {
        console.log(e.type, e.dragType);
      },
      'zoomin.cropper': function(e) {
        console.log(e.type);
      },
      'zoomout.cropper': function(e) {
        console.log(e.type);
      }
    }).cropper(options);

    // Methods
    $(document.body).on('click', '[data-method]', function() {
      var data = $(this).data(),$target,result;

      if (data.method) {
        data = $.extend({}, data); // Clone a new one

        if (typeof data.target !== 'undefined') {
          $target = $(data.target);

          if (typeof data.option === 'undefined') {
            try {
              data.option = JSON.parse($target.val());
            } catch (e) {
              console.log(e.message);
            }
          }
        }

        result = $image.cropper(data.method, data.option);

        if (data.method === 'getCroppedCanvas') {
          //$('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
          var croppng = result.toDataURL("image/png");//result.toDataURL()
          $.ajax({
              type: 'POST',
              url: 'savecropimage.php',
              data: {
                pngimageData: croppng,
                filename: 'imgfile.png'
              },
              success: function(output) {
                $('#putDataFile').val($.trim(output));
                var htmlimgpw = '<img src="'+$.trim(output)+'" alt="" />';
                $('#boxcroppreview').html(htmlimgpw);
              }
          });
        }

        if ($.isPlainObject(result) && $target) {
          try {
            $target.val(JSON.stringify(result));
          } catch (e) {
            console.log(e.message);
          }
        }

      }
    }).on('keydown', function(e) {

      switch (e.which) {
        case 37:
          e.preventDefault();
          $image.cropper('move', -1, 0);
          break;

        case 38:
          e.preventDefault();
          $image.cropper('move', 0, -1);
          break;

        case 39:
          e.preventDefault();
          $image.cropper('move', 1, 0);
          break;

        case 40:
          e.preventDefault();
          $image.cropper('move', 0, 1);
          break;
      }

    });

    // Import image
    var $inputImage = $('#inputImage'),
      URL = window.URL || window.webkitURL,
      blobURL;

    if (URL) {
      $inputImage.change(function() {
        var files = this.files,
          file;

        if (files && files.length) {
          file = files[0];

          if (/^image\/\w+$/.test(file.type)) {
            blobURL = URL.createObjectURL(file);
            $image.one('built.cropper', function() {
              URL.revokeObjectURL(blobURL); // Revoke when load complete
            }).cropper('reset', true).cropper('replace', blobURL);
            $inputImage.val('');
          } else {
            showMessage('Please choose an image file.');
          }
        }
      });
    } else {
      $inputImage.parent().remove();
    }

    // Options
    $('.docs-options :checkbox').on('change', function() {
      var $this = $(this);
      options[$this.val()] = $this.prop('checked');
      $image.cropper('destroy').cropper(options);
    });
    // Tooltips
    //$('[data-toggle="tooltip"]').tooltip();
  }());

  $('#multiselectLifestyle').multiselect({
    includeSelectAllOption: true
  });

  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
