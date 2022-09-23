var fileList = new Array;
jQuery(document).ready(function() {
  $('#SaveBtn').prop('disabled', true);
  loadimgGallery();
  var i = 0;
  Dropzone.options.dropZone = {
    paramName: "file",
    maxFilesize: 10, // MB
    acceptedFiles:'.jpg,.jpeg,.png,.mp4,.mp3,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.zip',
    init: function() {
      /* On Success, do whatever you want */
      this.on("success", function(file, serverFileName) {
          fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i };
          //console.log(fileList);
          i++;

      });
      this.on("removedfile", function(file) {
          var rmvFile = "";
          for(f=0;f<fileList.length;f++){
              if(fileList[f].fileName == file.name){
                  rmvFile = fileList[f].serverFileName;
              }
          }
          if (rmvFile){
              $.ajax({
                  url: "imgcarddelfile.php",
                  type: "POST",
                  data: { "fileList" : rmvFile }
              });
          }
          //alert(fileList.length);
      });
      this.on("complete", function (file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
          //doSomething();
          //alert('x');
          $('#SaveBtn').prop('disabled', false);
        }
      });
    },
    addRemoveLinks: true,
	dictDefaultMessage: '<i class="fa fa-cloud-upload"></i> \<span class="main-text"><b>Drop Files</b> to upload (or click)</span> <br /> \<span class="sub-text">(or click)</span>',
    dictResponseError: 'Server not Configured'
  };
});
function saveGallery(){
  //alert(fileList);
  var saveData = $('#myFrmBtn input[name=saveData]').val();
  $.ajax({
    'beforeSend': function(){
        $('.ajax-loader').css("visibility", "visible");
    },
    type: 'POST',
    url: 'imgcardsave.php',
    data: { "fileList" : fileList,saveData:saveData },
    success: function(data) {
      //alert(data);
      //$("#msg").html(data);
      if($.trim(data)=='OK'){
        location.reload();
      }
      /*
      $('.dz-preview').each(function(i, e) {
        this.remove();
      });
      */
    },
    complete: function(){
      $('.ajax-loader').css("visibility", "hidden");
    }
  });
}
function loadimgGallery(){
  var saveData = $('#myFrmBtn input[name=saveData]').val();
  var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{saveData:saveData},
			'url': 'ajax-loadimgcardimages-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();
	var len = json['result'].length;
  var html = '';
  if(len>0){
    html += '<ul id="sortable">';
      for (var i = 0; i< len; i++) {
        html += '<li id="'+json['result'][i].valueid+'" class="ui-state-default">';
        html += '<a class="showimgs" href="javascript:void(0)">'+json['result'][i].valueFile+'</a>';

        html +='<div class="btn-group">';
          html += '<input type="hidden" id="imgurl'+json['result'][i].valueid+'" value="'+json['result'][i].valueFullpath+'" />'
				  html += '<button type="button" class="btn btn-info br2 btn-xs fs12" onclick="copyToClipboard(\'#imgurl'+json['result'][i].valueid+'\')">Copy</button>';
          if(json['result'][i].valueiswebp){
            //html += '<button type="button" class="btn btn-info br2 btn-xs fs12" onclick="genimgtowebp('+json['result'][i].valueid+')">WebP</button>';
          }
				html +='</div>';

        html += '<a class="delimg" href="javascript:void(0)" onclick="deleteimages('+json['result'][i].valueid+')"><span class="fa fa-trash-o"></span></a>';
        html += '</li>';
      }
    html += '</ul>  ';

    $('#showGallery').html(html);
  }else{
    $('#showGallery').html('');
  }

}

function deleteimages(id){
  var saveData = $('#myFrmBtn input[name=saveData]').val();
  var PathURL = $('#ajaxFrm input[name=PathURL]').val();
  jqConfirm('Are you sure to delete this record?', function(){
    $.ajax({
      'beforeSend': function(){
          $('.ajax-loader').css("visibility", "visible");
      },
      type: 'POST',
      url: PathURL+"managefile/imgcarddelfilefromdb.php",
      data: {saveData:saveData,id:id},
      success: function(data) {
        if($.trim(data)=='OK'){
          loadimgGallery();
        }else{
          alert(data);
        }
      },
      complete: function(){
        $('.ajax-loader').css("visibility", "hidden");
      }
    });
  }, function(){
    //alert('yy');
  },'Alert Dialog');
}
function genimgtowebp(id){
  var saveData = $('#myFrmBtn input[name=saveData]').val();
  var PathURL = $('#ajaxFrm input[name=PathURL]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{saveData:saveData,id:id},
			'url': PathURL+'managefile/imgcardgenwebp.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();
	var lenurl = json['result'].path;
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(lenurl).select();
  document.execCommand("copy");
  $temp.remove();
}
