//var systemLang = new Array();
//systemLang["Thai"] = "Thai";
//systemLang["English"] = "English";
var gmapkey = 'AIzaSyA2Z6BmbeSedzJmqSjUbz2nO5SZatVTyn0';

$(document).ready(function($){
  $('body').on('keypress', 'input[type=number][maxlength]', function(event){
      var key = event.keyCode || event.charCode;
      var charcodestring = String.fromCharCode(event.which);
      var txtthis = $(this);
      var txtVal = $(this).val();
      var maxlength = $(this).attr('maxlength');
      var regex = new RegExp('^[0-9]+$');
      // 8 = backspace 46 = Del 13 = Enter 39 = Left 37 = right Tab = 9
      if( key == 8 || key == 46 || key == 13 || key == 37 || key == 39 || key == 9 ){
          return true;
      }
      // maxlength allready reached
      if(txtVal.length==maxlength){
          event.preventDefault();
          return false;
      }
      // pressed key have to be a number
      if( !regex.test(charcodestring) ){
        event.preventDefault();
        jqAlert('กรุณากรอกข้อมูลที่เป็นตัวเลขเท่านั้น', 'Alert Dialog',function(){
          txtthis.focus();
        });
        return false;
      }
      return true;
  });
  $('body').on('paste', 'input[type=number][maxlength]', function(event) {
      //catch copy and paste
      var ref = $(this);
      var regex = new RegExp('^[0-9]+$');
      var maxlength = ref.attr('maxlength');
      var clipboardData = event.originalEvent.clipboardData.getData('text');
      var txtVal = ref.val();//current value
      var filteredString = '';
      var combined_input = txtVal + clipboardData;//dont forget old data

      for (var i = 0; i < combined_input.length; i++) {
          if( filteredString.length < maxlength ){
              if( regex.test(combined_input[i]) ){
                  filteredString += combined_input[i];
              }
          }
      }
      setTimeout(function(){
          ref.val('').val(filteredString)
      },100);
  });
});
function frmlogout(){
	/*
	if(confirm('Are you sure to sign out from app')){
		var url = $('#ajaxFrm #PathURL').val();
		$.post( url+"ajax/logout.php", function(datachk){
			var linktomember =  '../loginfrm.php';
			window.location = linktomember;
		});
	}
	*/
	jqConfirm('Are you sure to sign out from app', function(){
		var url = $('#ajaxFrm #PathURL').val();
		$.post( url+"ajax/logout.php", function(datachk){
			var linktomember =  '../loginfrm.php';
			window.location = linktomember;
		});
	}, function(){
		//alert('yy');
	},'Confirmation Dialog');
}
function jqAlert(outputMsg, titleMsg, onCloseCallback) {
    if (!titleMsg)
        titleMsg = 'Alert';

    if (!outputMsg)
        outputMsg = 'No Message to Display.';

    $("<div></div>").html(outputMsg).dialog({
        title: titleMsg,
		dialogClass: "alertclass",
		width:"auto",
        resizable: false,
        modal: true,
		position: {
            my: 'center',
            at: 'center'
        },
        buttons: {
            "ปิด": function () {
                $(this).dialog("close");
            }
        },
        close: onCloseCallback
    });
}
function jqConfirm(dialogText, okFunc, cancelFunc, dialogTitle) {
  $('<div>' + dialogText + '</div>').dialog({
    draggable: false,
    modal: true,
    resizable: false,
	dialogClass: "alertclass",
    width: 'auto',
    title: dialogTitle || 'Confirm',
    minHeight: 75,
	position: {
		my: 'center',
		at: 'center'
	},
    buttons: {
      OK: function () {
        if (typeof (okFunc) == 'function') {
          setTimeout(okFunc, 50);
        }
        $(this).dialog('destroy');
      },
      Cancel: function () {
        if (typeof (cancelFunc) == 'function') {
          setTimeout(cancelFunc, 50);
        }
        $(this).dialog('destroy');
      }
    }
  });
}
function getpagenumber(t){
  var rowIndex = $(t).attr('rel');
	var ft = FooTable.get(".footable");
  var rowCount = ft.rows.all.length;
  var paginationCount = ft.pageSize();
  var pageNumber = Math.ceil((rowIndex) / paginationCount);
  return pageNumber;
}
function getfullUrl(){
	if (!window.location.origin){
    // For IE
    window.location.origin = window.location.protocol + "//" + (window.location.port ? ':' + window.location.port : '');
  }
  var url = window.location.origin + window.location.pathname;
	return url;
}
function clicktorequestaction(type,t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#ajaxFrm input[name=LoginData]').val();
	var pagenumber = getpagenumber(t);
	var json = (function () {
		var json = null;
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{LoginData:LoginData,type:type,pagenumber:pagenumber},
			'url': PathURL+'ajax/ajax-loadaction-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var mydata = json["valuelogindata"];
	var url = getfullUrl()+'?'+mydata;
  window.location = url;
}
function clicktorequestactionnew(type,t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#ajaxFrm input[name=LoginData]').val();
	var footer = $('table.tbjson').find('tfoot');
	var pagination = footer.find('ul.pagination');
	var pagenumber = parseInt(footer.find('li.active a').html());
	var json = (function () {
		var json = null;
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{LoginData:LoginData,type:type,pagenumber:pagenumber},
			'url': PathURL+'ajax/ajax-loadaction-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var mydata = json["valuelogindata"];
	var url = getfullUrl()+'?'+mydata;
  window.location = url;
}
function clicktorequestactiononly(type,t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var LoginData = $('#ajaxFrm input[name=LoginData]').val();
	var footer = $('table.tbjson').find('tfoot');
	var pagination = footer.find('ul.pagination');
	var pagenumber = parseInt(footer.find('li.active a').html());
	var json = (function () {
		var json = null;
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{LoginData:LoginData,type:type,pagenumber:pagenumber},
			'url': PathURL+'ajax/ajax-loadaction-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var mydata = json["valuelogindata"];
	var url = getfullUrl()+'?'+mydata;
  window.location = url;
}
function changeLanguage(lang){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.post( PathURL+"ajax/changelanguage.php", {MyData:lang,MyAction:'setlanguage'},function(datachk){
		location.reload();
	});
}
function getNum(val) {
   if (isNaN(val)) {
     return 0;
   }
   return val;
}

function check_numalertthis(e,t){
   var keyPressed;
   if(window.event){
      keyPressed = window.event.keyCode; // IE
	  if((keyPressed==97 && e.ctrlKey === true) || (e.ctrlKey == true && (keyPressed == '118' || keyPressed == '86')) || (e.ctrlKey == true && (keyPressed == '99' || keyPressed == '67')) || (e.ctrlKey == true && (keyPressed == '120' || keyPressed == '88'))){
		 //alert('TT');
	  }else{
		if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=45) && (keyPressed!=46) && (keyPressed!=8) && (keyPressed!=0) && (keyPressed!=13)) {
		   jqAlert('input number only.', 'Alert Dialog',function(){
				$(t).focus();
			});
			//alert('input number only.');
			window.event.returnValue = false;
		}
	  }
   }else{
      keyPressed = e.which; // Firefox
	  if((keyPressed==97 && e.ctrlKey === true) || (e.ctrlKey == true && (keyPressed == '118' || keyPressed == '86')) || (e.ctrlKey == true && (keyPressed == '99' || keyPressed == '67')) || (e.ctrlKey == true && (keyPressed == '120' || keyPressed == '88'))){
		 //alert('TT');
	  }else{
		if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=45) && (keyPressed!=46) && (keyPressed!=8) && (keyPressed!=0) && (keyPressed!=13)) {
			jqAlert('input number only.', 'Alert Dialog',function(){
				$(t).focus();
			});
			//alert('input number only.');
			keyPressed = e.preventDefault();
		}
	  }
    }
}
function formatNumber(s) {
	var $this = s;
	var num = $this.val().replace(/,/g, '');
	$this.val(num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
(function($){
    $.fn.focusTextToEnd = function(){
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
}(jQuery));
function isEmail(str) {
  var supported = 0;
  if (window.RegExp) {
    var tempStr = "a";
    var tempReg = new RegExp(tempStr);
    if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported)
  return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
  return (!r1.test(str) && r2.test(str));
}
