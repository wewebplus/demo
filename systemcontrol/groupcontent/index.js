function loadpageajaxlistgroup(gid){
  var json = (function () {
    var json = null;
    var saveData = $('#ajaxFrm #LoginData').val();
    $.ajax({
      'beforeSend': function(){
        $('.ajax-loader').css("visibility", "visible");
      },
      'async': false,
      'global': false,
      'type':'POST',
      'data':{saveData:saveData,dataGroup:gid},
      'url': 'index-ajax-loadlistgroup-json.php',
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
    for (var i = 0; i< len; i++) {
      var countlogs = json['result'][i].CountLogs;
      var numberindex = json['result'][i].ID;
      html += '<li class="listitem" data-z="'+numberindex+'">';
        html += '<div class="relateline">';
          html += json['result'][i].Name;
        html += '</div>';
        html += '<div class="relatelinebtn">';
          html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="status'+json['result'][i].ListStatus+'" onclick="changestatus(this)">'+json['result'][i].StatusIcon+'</a>';
          html += '<a href="javascript:void(0)" title="Up" data-dir="up"><i class="fa fa-arrow-up" data-dir="up"></i></a>';
          html += '<a href="javascript:void(0)" title="Down" data-dir="down"><i class="fa fa-arrow-down" data-dir="down"></i></a>';
          html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="relateicon" onclick="editlistgroup(this)"><i class="fas fa-pen-square"></i></a>'
          if(countlogs==0){
            html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="relateicon" onclick="deletelistgroup(this)"><i class="fas fa-trash-alt"></i></a>';
          }else{
            html += '<a href="javascript:void(0)" rel="'+json['result'][i].ID+'" class="relateicon icondisable"><i class="fas fa-trash-alt"></i></a>';
          }
        html += '</div>';
      html += '</li>';
    }
  }
  $('#ShowResult').html(html);
  $('[data-z]').click(function(e){
	  var jTarget = $(e.target),
	      dir = jTarget.data('dir'),
	      jItem = $(e.currentTarget),
	      jItems = $('li.listitem'),
	      index = jItems.index(jItem);
        //alert(dir);
	  switch (dir) {
	    case 'up':
	      if (index != 0) {
	        var item = $(this).detach().insertBefore(jItems[index - 1]);
	      }
	      break;
	    case 'down':
	      if (index != jItems.length - 1) {
	        var item = $(this).detach().insertAfter(jItems[index + 1]);
	      }
	      break;
	  }
    if(dir=='up' || dir=='down'){
			var myArray = $("#ShowResult li.listitem").map(function() {
			    return $(this).attr('data-z');
			}).get();
			savelistorderContent(myArray);
    }
	});
}
function editlistgroup(t){
  var tb = $(t);
  var mydata = tb.attr('rel');
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	$.magnificPopup.open({
		removalDelay: 500, //delay removal by X to allow out-animation,
		items: {
			src: "#modal-formedit"
		},
		// overflowY: 'hidden', //
		callbacks: {
			beforeOpen: function(e) {
        var json = (function () {
          var json = null;
          $.ajax({
            'beforeSend': function(){
              $('.ajax-loader').css("visibility", "visible");
            },
            'async': false,
            'global': false,
            'type':'POST',
            'data':{ mydata: mydata ,myaction:'edit'},
            'url': FullPath+'groupcontent/index-dataaction.php',
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
        var len = json['result'].inputGroup.length;
        if(len>0){
          $('#FrmEdit input[name=editData]').val(json['result'].ID);
          $.each(json['result'].inputGroup, function( index, value ) {
            // console.log(value['Name']);
            $('#FrmEdit input[name='+value['Name']+']').val(value['Val']);
          });
        }
				var Animation = "mfp-zoomIn";
				this.st.mainClass = Animation;
			}
		},
		midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
	});
}
function summitFrmEdit(t){
  var tb = $(t);
  var PathURL = $('#ajaxFrm input[name=PathURL]').val();
  var inMenu = $('#myFrm select[name=SelectMenu]').val();
  var inID = tb.find('input[name=editData]').val();
  var form = $(document.createElement('form'));
  $(form).attr("action", "?");
  $(form).attr("method", "POST");
  var inMenuInput = $("<input>").attr("type", "hidden").attr("name", "inMenu").val(inMenu);
	$(form).append($(inMenuInput));
	var inID = $("<input>").attr("type", "hidden").attr("name", "inID").val(inID);
	$(form).append($(inID));
	var inputmyaction = $("<input>").attr("type", "hidden").attr("name", "myaction").val('update');
	$(form).append($(inputmyaction));
  var insubmit = false;
	tb.find('input:text,input:hidden, select, textarea').not('.gui-input').each(function() {
    if($.trim($(this).val())==''){
      insubmit = false;
      $(this).focusTextToEnd();
      return false;
    }else{
      insubmit = true;
      var input = $("<input>").attr("type", "hidden").attr("name", $(this).attr('name')).val($(this).val());
      $(form).append($(input));
    }
  });
  if(insubmit){
		$.ajax({
      'beforeSend': function(){
        $('.ajax-loader').css("visibility", "visible");
      },
      'async': false,
      'global': false,
      'type':'POST',
      'data':$(form).serialize(),
      'url': PathURL+'groupcontent/index-dataaction.php',
      'success': function (data) {
				console.log(data);
				if(data>0){
					$('#myFrm input[name^=inputEditGroup]').val('');
					loadpageajaxlistgroup(inMenu);
          $.magnificPopup.close();
				}
      },
      complete: function(){
        $('.ajax-loader').css("visibility", "hidden");
      }
    });
	}
  return false;
}
function deletelistgroup(t){
  // alert('D');
  var tb = $(t);
  var mydata = tb.attr('rel');
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  var inMenu = $('#myFrm select[name=SelectMenu]').val();
  $.confirm({
      title: 'Confirm!',
      content: 'Are you sure to delete this record?',
      buttons: {
        Submit: {
            text: 'Confirm',
            btnClass: 'btn-blue',
            action: function () {
              console.log(mydata);
              var json = (function () {
                var json = null;
                $.ajax({
                  'beforeSend': function(){
                    $('.ajax-loader').css("visibility", "visible");
                  },
                  'async': false,
                  'global': false,
                  'type':'POST',
                  'data':{ mydata: mydata ,myaction:'deleteitem'},
                  'url': FullPath+'groupcontent/index-dataaction.php',
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
              var status = json['status'];
              if(status=='ok'){
                loadpageajaxlistgroup(inMenu);
              }
              // console.log (json);
            }
        },
        cancel: function () {
            //$.alert('Canceled!');
        }
      }
  });
}
function savelistorderContent(myval){
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var MyData = $('#ajaxFrm input[name=LoginData]').val();
  // var inMenu = $('#myFrm select[name=SelectMenu]').val();
  // console.log(inMenu);
	$.ajax({
    'beforeSend': function(){
      $('.ajax-loader').css("visibility", "visible");
    },
    type:"POST",
    url:FullPath+'groupcontent/index-dataaction.php',
    data:{myval:myval,MyData:MyData,myaction:'sortlist'},
    cache:false,
    success: function(data) {
      // console.log(data);
      // if($.trim(data)=='OK'){
      //   loadpageajaxlistgroup(inMenu);
      // }else{
      //   //alert('xxxx '+myval);
			// 	console.log(myval);
      // }
    },
    error: function () {
      alert("Error");
    },
    complete: function(){
      $('.ajax-loader').css("visibility", "hidden");
    }
  });
}
function changestatus(t){
  var tb = $(t);
  var mydata = tb.attr('rel');
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  var inMenu = $('#myFrm select[name=SelectMenu]').val();
  var json = (function () {
    var json = null;
    $.ajax({
      'beforeSend': function(){
        $('.ajax-loader').css("visibility", "visible");
      },
      'async': false,
      'global': false,
      'type':'POST',
      'data':{ mydata: mydata ,myaction:'changestatus'},
      'url': FullPath+'groupcontent/index-dataaction.php',
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
  var status = json['status'];
  if(status=='ok'){
    loadpageajaxlistgroup(inMenu);
  }
}
