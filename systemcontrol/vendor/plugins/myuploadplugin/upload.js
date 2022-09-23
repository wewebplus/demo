(function ($) {

    //สร้างชื่อฟังชั่นไว้ใช้งานเอง
    $.fn.myhightlight = function () {
        return this.each(function(){
            $(this).css('background-color','#aa0000')
        });
    };

    $.fn.mya = function () {
        return this.each(function(){
          $(this).click(function(){
          //this เลเวลนี้จะหมายถึง 1 object element
          //ถึงจะเป็นการกำหนด event click ให้แต่ละ element
            alert("Rel:"+this.rel); //ดึงข้อความใน Attrbute rel ขึ้นมาแสดง
          });
        });
    };

    $.fn.setupload = function( options ) { // กำหนดให้ plugin ของเราสามารถ รับค่าเพิ่มเติมได้ มี options
        //debug(this);
        // ส่วนนี้ สำหรับกำหนดค่าเริ่มต้น
        var defaults={
          'script'  : 'phpupload.php',
          'scriptData'  : {},
          'path'  : '../../upload/temp',
          'fileExt'  : '.jpg',
          'allowed_file_types' : ["image/jpg" , "image/jpeg", "application/jpg" , "image/pjpeg" , "image/vnd.swiftview-jpeg"],
          'max_file_size' : 10485760, //10MB //allowed file size. (1 MB = 1048576)
          'total_files_allowed' : 2,
          'result_output' : '#resultoutput',
          'progress_bar_id' : '#progress-wrp',
          'DataID' : 0,
          'Login_MenuID' : 0,
          'SessionID' : '',
      		success:function(ps){

      		}
        };


        // ส่วนสำหรับ  เป็นต้วแปร รับค่า options หากมี หรือใช้ค่าเริ่มต้น ถ้ากำหนด
        var settings = $.extend( {}, defaults, options );
        var countscriptData = Object.keys(settings.scriptData).length;

        var obj  =  $(this);
        $(obj).change(function(){
          var tbfile = obj.prop('files');
          var tbfrm = obj.closest('form').serialize();
          //debug(tbfrm);
          var proceed = true; //set proceed flag
          var error = [];	//errors
          var total_files_size = 0;
          //reset progressbar
        	$(settings.progress_bar_id +" .progress-bar").css("width", "0%");
        	$(settings.progress_bar_id + " .status").text("0%");

          if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
        		error.push("Your browser does not support new File API! Please upgrade."); //push error text
        	}else{
        		var total_selected_files = tbfile.length; //number of files
        		//limit number of files allowed
            if(settings.total_files_allowed>0){
              if(total_selected_files > settings.total_files_allowed){
          			error.push( "You have selected "+total_selected_files+" file(s), " + settings.total_files_allowed +" is maximum!"); //push error text
          			proceed = false; //set proceed flag to false
          		}
            }
        		 //iterate files in file input field
        		$.each(tbfile,function(i, ifile){
        			if(ifile.value !== ""){ //continue only if file(s) are selected
        				if(settings.allowed_file_types.indexOf(ifile.type) === -1){ //check unsupported file
        					error.push( "<b>"+ ifile.name + "</b> is unsupported file type!"); //push error text
        					proceed = false; //set proceed flag to false
        				}
        				total_files_size = total_files_size + ifile.size; //add file size to total size
        			}
        		});

        		//if total file size is greater than max file size
        		if(total_files_size > settings.max_file_size){
        			error.push( "You have "+total_selected_files+" file(s) with total size "+total_files_size+", Allowed size is " + settings.max_file_size +", Try smaller file!"); //push error text
        			proceed = false; //set proceed flag to false
        		}
            if(proceed){
              $('input[type=submit]').prop( "disabled", true);
              var formData = new FormData();
              $.each($(this).get( 0 ).files, function(i, file) {
                  formData.append(i, file);
              });
              formData.append('id', settings.DataID);
              //formData.append('Login_MenuID', settings.Login_MenuID);
              formData.append('sessionid', settings.SessionID);
              formData.append('mypath', settings.path);

              if(countscriptData>0){
                $.each(settings.scriptData,function(key,value){
                   formData.append(key, value);
                });
              }

              $.ajax({
              	url : settings.script,
              	type: "POST",
              	data : formData,
              	contentType: false,
              	cache: false,
              	processData:false,
              	xhr: function(){
              		//upload Progress
              		var xhr = $.ajaxSettings.xhr();
              		if (xhr.upload) {
              			xhr.upload.addEventListener('progress', function(event) {
              				var percent = 0;
              				var position = event.loaded || event.position;
              				var total = event.total;
              				if (event.lengthComputable) {
              					percent = Math.ceil(position / total * 100);
              				}
              				//update progressbar
        							$(settings.progress_bar_id+"").show();
              				$(settings.progress_bar_id +" .progress-bar").css("width", + percent +"%");
              				$(settings.progress_bar_id + " .status").text(percent +"%");
              			}, true);
              		}
              		return xhr;
              	},
              	mimeType:"multipart/form-data"
              }).done(function(res){ //
                var myJSON = jQuery.parseJSON(res);
                settings.success(myJSON,settings);
                $('input[type=submit]').prop( "disabled", false);

                //reset progressbar
              	$(settings.progress_bar_id +" .progress-bar").css("width", "0%");
              	$(settings.progress_bar_id + " .status").text("0%");
                $(settings.progress_bar_id+"").hide();
              });
            }
          }
          $(settings.result_output).html(""); //reset output
        	$(error).each(function(i){ //output any error to output element
        		$(settings.result_output).append('<div class="error">'+error[i]+"</div>");
        	});
        });
        /// คืนค่ากลับ การทำงานของ plugin
        return this.each(function() {
          var myname = $(this).attr('id')+'[]';
          $(this).attr('name',myname);
          $(this).attr('multiple',true);
          $(this).attr('accept',settings.fileExt);

          //alert(settings.fileExt);
          // โค้ตสำหรับ การทำงานของ plugin
        });

    };
    // Private function for debugging.
    function debug( obj ) {
        if ( window.console && window.console.log ) {
            window.console.log( "hilight selection count: " + obj );//obj.length
        }
    };
})(jQuery)
