//var DataselectIDs = [];
//var DataselectIDs = $('input[name=myselect]').val().split(',');
jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	var saveData = $('input[name=saveData]').val();
	$('#dateinputStart').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		showButtonPanel: false
  });
	$('#myFrm select').on('change', function(){
    var thisname = $(this).attr('name');
    var thisval = $(this).val();
  	var thistext = $(this).find('option:selected').text();
		$('input[name='+thisname+'Text]').val(thistext);
  });
	$( "#ListBtn" ).on( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
});
function submitForm(t){
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var nreq = tb.find('.fieldreqs').length;
	var nreqchk = 0;
	for(i=0;i<nreq;i++){
		obj = tb.find('.fieldreqs:eq('+i+')');
		objType = obj.attr('type');
		tagName = obj.get(0).tagName;
		title = obj.attr('dataalert');
		if(objType=='hidden'){
			var pre = '';
		}else{
			if(tagName=='SELECT'){
        var pre = '';//กรถณาเลือก
    	}else{
        var pre = '';//กรุณากรอก
    	}
		}
		var txtshow = pre+title;
		if(obj.val()==''){
			obj.closest('div.frmalert').find('.errorText').remove();
			obj.closest('div.frmalert').append('<div class="errorText">'+txtshow+'</div>');
			obj.focus();
			return false;
		}else{
			nreqchk = nreqchk+1;
			obj.closest('div.frmalert').find('.errorText').remove();
		}
	}
	if(nreq==nreqchk){
		var insend = false;
		var datamyselect = tb.find('input[name=myselect]').val();
		var datamygroupselect = tb.find('input[name=mygroupselect]').val();
		var datamyothselect = tb.find('input[name=myothselect]').val();
		var datamyselectdoc = tb.find('input[name=myselectdoc]').val();
		if(datamyselectdoc=='0'){
			$.alert({
			    title: 'Alert!',
			    content: 'Please select Document!',
			});
			insend = false;
			return false;
		}else{
			insend = true;
		}
		if(datamyselect=='0' && datamygroupselect=='0' && datamyothselect=='0'){
			$.alert({
			    title: 'Alert!',
			    content: 'Please select Email!',
			});
			insend = false;
			return false;
		}else{
			insend = true;
		}
		if(insend){
			$.ajax({
	  		'beforeSend': function(){
	  			$("body").LoadingOverlay("show");
	  		},
	  		type:"POST",
	  		url:FullPath+'enew/task-ajax-addnew.php',
	  		data:tb.serialize(),
	  		cache:false,
	  		success: function(data) {
					$('#ErrorResult').html(data);
	  			//alert(data);
					var mydata = $('#ajaxFrm input[name=LoginData]').val();
					var url = getfullUrl()+'?'+mydata;
	  			$.alert({
	  				    //title: 'Set Employee!',
	  				    title: false,
	  				    content: 'Save Data Complete!',
	  				    buttons: {
	  				    	OK: function () {
	  				    		window.location = url;
	  				    	}
	  				    }
	  				});
	  		},
	  		error: function () {
	  			alert("Error");
	  		},
	  		complete: function(){
	  			$("body").LoadingOverlay("hide");
	  		}
	  	});			
		}
	}
	return false;
}
function PopupListEmail(t){
	var tb = $(t);
	var inname = tb.attr('id');
	var type = inname.replace("btn", "");
	var mydata = $('#myFrm input[name=saveData]').val();
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.magnificPopup.open({
    removalDelay: 500, //delay removal by X to allow out-animation,
    items: {
      src: "#modal-formsearchEmail"
    },
    // overflowY: 'hidden', //
    callbacks: {
      beforeOpen: function(e) {
				console.log(type);
				$('#frmselectdataemail input[name=MyData]').val(mydata);
				$('#frmselectdataemail #showResultPopup').empty();
				if(type=='SelectMain'){
					loadpageajaxemail(1);
				}else if(type=='SelectGroupMain'){
					loadpageajaxgroupemail(1);
				}else if(type=='Select_Oth'){
					loadpageajaxothemail(1);
				}else{

				}
        var Animation = "mfp-zoomIn";
        this.st.mainClass = Animation;
      },
			close: function(){
				loadlistselectemail(1);
			}
    },
    midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
  });
}
function summitfrmselectdataemail(t){
	loadpageajaxemail(1);
	return false;
}
function popupBtnSearch(t){
	loadpageajaxemail(1);
	return false;
}
function popupBtnClear(t){
	var dataKeyword = $('#frmselectdataemail input[name=popupSearch]').val('');
	loadpageajaxemail(1);
	return false;
}

function PopupListDoc(t){
	var tb = $(t);
	var inname = tb.attr('id');
	var type = inname.replace("btn", "");
	var mydata = $('#myFrm input[name=saveData]').val();
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.magnificPopup.open({
    removalDelay: 500, //delay removal by X to allow out-animation,
    items: {
      src: "#modal-formsearchDoc"
    },
    // overflowY: 'hidden', //
    callbacks: {
      beforeOpen: function(e) {
				console.log(type);
				$('#frmselectdatadoc input[name=MyData]').val(mydata);
				$('#frmselectdatadoc #showResultPopup').empty();
				if(type=='SelectDoc'){
					loadpageajaxdoc(1);
				}else{

				}
        var Animation = "mfp-zoomIn";
        this.st.mainClass = Animation;
      },
			close: function(){
				loadlistselectdoc(1);
			}
    },
    midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
  });
}
function summitfrmselectdatadoc(t){
	return false;
}
function popupBtnDocSearch(t){
	loadpageajaxdoc(1);
	return false;
}
function popupBtnDocClear(t){
	var dataKeyword = $('#frmselectdatadoc input[name=popupDocSearch]').val('');
	loadpageajaxdoc(1);
	return false;
}
function loadpageajaxdoc(page){
	var inputselect = $('input[name=myselectdoc]');
	var DataselectIDs = inputselect.val().split(',');
	var json = (function () {
		var json = null;
		var LoginData = $('#myFrm input[name=saveData]').val();
		var dataKeyword = $('#frmselectdatadoc input[name=popupDocSearch]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword},
			'url': 'ajax-loadpagepopupdoc.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var len = json['result'].length;
	var myindex = 0;
	var tmp = 0;
	var totalcount = json['reccount'];
	var html = '';
	html += '<table class="TablelistContentPopup" data-filtering="true" data-sorting="true" data-filter-connectors="false" data-filter="#popupSearch">';
	html +='<thead>';
	html += '<tr class="theader">';
		html +='<th> </th>';
		html +='<th>No.</th>';
		html +='<th>Name</th>';
	html += '</tr>';
	html +='</thead>';
	html +='<tbody>';
	for (var i = 0; i< len; i++) {
		myindex = myindex+1;
		tmp = myindex%2;
		html += '<tr class="trrow trrow0'+tmp+'">';
			html += '<td class="tdcolpopupchkbox">';
				html += '<label class="option option-primary">';
					if ($.inArray(json['result'][i].valueid,DataselectIDs)==-1){
						html += '<input type="checkbox" name="CheckBoxID[]" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxDocarr(this)">';
					}else{
						html += '<input type="checkbox" name="CheckBoxID[]" checked="checked" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxDocarr(this)">';
					}
					html += '<span class="checkbox"></span>';
				html += '</label>';
			html += '</td>';
			html += '<td class="tdcolpopupindex">'+json['result'][i].ListIndex+'</td>';
			html += '<td class="tdcolpopupname"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueName+'</label></p></td>';
		html += '</tr>';
	}
	html +='</tbody>';
  html +='<tfoot class="footer-menu">';
    html +='<tr>';
      html +='<td colspan="4">';
        html +='<nav>';
          html +='<div id="paging-ui-container"></div>';
        html +='</nav>';
      html +='</td>';
    html +='</tr>';
  html +='</tfoot>';
	html += '</table>';
	html += '<div class="navpopuptxt">';
		html += '<span>หน้า</span>';
		html += '<span>';
		html += '<select name="selectpage" class="" onchange="loadpageajaxemail($(this).val())">';
		for(var j = 1; j<= json['noofpage']; j++){
			if(j==page){
				html += '<option value="'+j+'" selected="selected">'+j+'</option>';
			}else{
				html += '<option value="'+j+'">'+j+'</option>';
			}
		}
		html += '</select>';
		html += '</span>';
		html += '<span>จาก '+json['noofpage']+'</span>';
	html += '</div>';
	$('#showResultDocPopup').html(html);
}
function loadlistselectdoc(page){
	var saveData = $('input[name=saveData]').val();
	var inputselect = $('input[name=myselectdoc]');
	var form = $(document.createElement('form'));
  $(form).attr("action", "?");
  $(form).attr("method", "POST");
	var pageval = $("<input>").attr("type", "hidden").attr("name", "page").val(page);
	$(form).append($(pageval));
	var myselectdoc = $("<input>").attr("type", "hidden").attr("name", "myselectdoc").val(inputselect.val());
	$(form).append($(myselectdoc));
	var saveData = $("<input>").attr("type", "hidden").attr("name", "saveData").val(saveData);
	$(form).append($(saveData));
	var json = (function () {
		var json = null;
		var LoginData = $('#myFrm input[name=saveData]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':$(form).serialize(),
			'url': 'ajax-loadpageselectdoc.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var html = '';
	var len = json['resultselect'].length;
	if(len>0){
		$.each(json['resultselect'], function( index, value ) {
			html += '<div>'+value["datahtml"]+'</div>';
		});
	}
	$('#showResultListDoc').html(html);
}
function inCheckboxDocarr(t){
	var tb = $(t);
	var inputselect = $('input[name=myselectdoc]');
	var DataselectIDs = [];
	$('.TablelistContentPopup input[type="checkbox"]').not(t).prop('checked', false);
	if ($.inArray(tb.val(),DataselectIDs)==-1) DataselectIDs.push(tb.val());
	console.log(DataselectIDs);
	inputselect.val(DataselectIDs.join(','));
}
function loadpageajaxemail(page){
	var inputselect = $('input[name=myselect]');
	var DataselectIDs = inputselect.val().split(',');
	var json = (function () {
		var json = null;
		var LoginData = $('#myFrm input[name=saveData]').val();
		var dataKeyword = $('#frmselectdataemail input[name=popupSearch]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword},
			'url': 'ajax-loadpagepopupemail.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var len = json['result'].length;
	var myindex = 0;
	var tmp = 0;
	var totalcount = json['reccount'];
	var html = '';
	html += '<table class="TablelistContentPopup" data-filtering="true" data-sorting="true" data-filter-connectors="false" data-filter="#popupSearch">';
	html +='<thead>';
	html += '<tr class="theader">';
		html +='<th> </th>';
		html +='<th>No.</th>';
		html +='<th>Name</th>';
		html +='<th>Email</th>';
	html += '</tr>';
	html +='</thead>';
	html +='<tbody>';
	for (var i = 0; i< len; i++) {
		myindex = myindex+1;
		tmp = myindex%2;
		html += '<tr class="trrow trrow0'+tmp+'">';
			html += '<td class="tdcolpopupchkbox">';
				html += '<label class="option option-primary">';
					if ($.inArray(json['result'][i].valueid,DataselectIDs)==-1){
						html += '<input type="checkbox" name="CheckBoxID[]" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxToarr(this)">';
					}else{
						html += '<input type="checkbox" name="CheckBoxID[]" checked="checked" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxToarr(this)">';
					}
					html += '<span class="checkbox"></span>';
				html += '</label>';
			html += '</td>';
			html += '<td class="tdcolpopupindex">'+json['result'][i].ListIndex+'</td>';
			html += '<td class="tdcolpopupname"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueName+'</label></p></td>';
			html += '<td class="tdcolpopupemail"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueEmail+'</label></p></td>';
		html += '</tr>';
	}
	html +='</tbody>';
  html +='<tfoot class="footer-menu">';
    html +='<tr>';
      html +='<td colspan="4">';
        html +='<nav>';
          html +='<div id="paging-ui-container"></div>';
        html +='</nav>';
      html +='</td>';
    html +='</tr>';
  html +='</tfoot>';
	html += '</table>';
	html += '<div class="navpopuptxt">';
		html += '<span>หน้า</span>';
		html += '<span>';
		html += '<select name="selectpage" class="" onchange="loadpageajaxemail($(this).val())">';
		for(var j = 1; j<= json['noofpage']; j++){
			if(j==page){
				html += '<option value="'+j+'" selected="selected">'+j+'</option>';
			}else{
				html += '<option value="'+j+'">'+j+'</option>';
			}
		}
		html += '</select>';
		html += '</span>';
		html += '<span>จาก '+json['noofpage']+'</span>';
	html += '</div>';
	$('#showResultPopup').html(html);
}
function loadpageajaxgroupemail(page){
	var inputselect = $('input[name=mygroupselect]');
	var DataselectIDs = inputselect.val().split(',');
	var json = (function () {
		var json = null;
		var LoginData = $('#myFrm input[name=saveData]').val();
		var dataKeyword = $('#frmselectdataemail input[name=popupSearch]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword},
			'url': 'ajax-loadpagepopupgroupemail.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var len = json['result'].length;
	var myindex = 0;
	var tmp = 0;
	var totalcount = json['reccount'];
	var html = '';
	html += '<table class="TablelistContentPopup" data-filtering="true" data-sorting="true" data-filter-connectors="false" data-filter="#popupSearch">';
	html +='<thead>';
	html += '<tr class="theader">';
		html +='<th> </th>';
		html +='<th>No.</th>';
		html +='<th>Name</th>';
		html +='<th>Email (Count)</th>';
	html += '</tr>';
	html +='</thead>';
	html +='<tbody>';
	for (var i = 0; i< len; i++) {
		myindex = myindex+1;
		tmp = myindex%2;
		html += '<tr class="trrow trrow0'+tmp+'">';
			html += '<td class="tdcolpopupchkbox">';
				html += '<label class="option option-primary">';
					if ($.inArray(json['result'][i].valueid,DataselectIDs)==-1){
						html += '<input type="checkbox" name="CheckBoxID[]" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxGroupToarr(this)">';
					}else{
						html += '<input type="checkbox" name="CheckBoxID[]" checked="checked" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxGroupToarr(this)">';
					}
					html += '<span class="checkbox"></span>';
				html += '</label>';
			html += '</td>';
			html += '<td class="tdcolpopupindex">'+json['result'][i].ListIndex+'</td>';
			html += '<td class="tdcolpopupname"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueName+'</label></p></td>';
			html += '<td class="tdcolpopupcount"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueCount+'</label></p></td>';
		html += '</tr>';
	}
	html +='</tbody>';
  html +='<tfoot class="footer-menu">';
    html +='<tr>';
      html +='<td colspan="4">';
        html +='<nav>';
          html +='<div id="paging-ui-container"></div>';
        html +='</nav>';
      html +='</td>';
    html +='</tr>';
  html +='</tfoot>';
	html += '</table>';
	html += '<div class="navpopuptxt">';
		html += '<span>หน้า</span>';
		html += '<span>';
		html += '<select name="selectpage" class="" onchange="loadpageajaxgroupemail($(this).val())">';
		for(var j = 1; j<= json['noofpage']; j++){
			if(j==page){
				html += '<option value="'+j+'" selected="selected">'+j+'</option>';
			}else{
				html += '<option value="'+j+'">'+j+'</option>';
			}
		}
		html += '</select>';
		html += '</span>';
		html += '<span>จาก '+json['noofpage']+'</span>';
	html += '</div>';
	$('#showResultPopup').html(html);
}
function loadpageajaxothemail(page){
	var inputselect = $('input[name=myothselect]');
	var DataselectIDs = inputselect.val().split(',');
	var json = (function () {
		var json = null;
		var LoginData = $('#myFrm input[name=saveData]').val();
		var dataKeyword = $('#frmselectdataemail input[name=popupSearch]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData,dataKeyword:dataKeyword},
			'url': 'ajax-loadpagepopupothemail.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var len = json['result'].length;
	var myindex = 0;
	var tmp = 0;
	var totalcount = json['reccount'];
	var html = '';
	html += '<table class="TablelistContentPopup" data-filtering="true" data-sorting="true" data-filter-connectors="false" data-filter="#popupSearch">';
	html +='<thead>';
	html += '<tr class="theader">';
		html +='<th> </th>';
		html +='<th>No.</th>';
		html +='<th>Name</th>';
		html +='<th>Email</th>';
	html += '</tr>';
	html +='</thead>';
	html +='<tbody>';
	for (var i = 0; i< len; i++) {
		myindex = myindex+1;
		tmp = myindex%2;
		html += '<tr class="trrow trrow0'+tmp+'">';
			html += '<td class="tdcolpopupchkbox">';
				html += '<label class="option option-primary">';
					if ($.inArray(json['result'][i].valueid,DataselectIDs)==-1){
						html += '<input type="checkbox" name="CheckBoxID[]" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxOthToarr(this)">';
					}else{
						html += '<input type="checkbox" name="CheckBoxID[]" checked="checked" id="CheckBoxID'+myindex+'" value="'+json['result'][i].valueid+'" onclick="inCheckboxOthToarr(this)">';
					}
					html += '<span class="checkbox"></span>';
				html += '</label>';
			html += '</td>';
			html += '<td class="tdcolpopupindex">'+json['result'][i].ListIndex+'</td>';
			html += '<td class="tdcolpopupname"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueName+'</label></p></td>';
			html += '<td class="tdcolpopupemail"><p><label for="CheckBoxID'+myindex+'">'+json['result'][i].valueEmail+'</label></p></td>';
		html += '</tr>';
	}
	html +='</tbody>';
  html +='<tfoot class="footer-menu">';
    html +='<tr>';
      html +='<td colspan="4">';
        html +='<nav>';
          html +='<div id="paging-ui-container"></div>';
        html +='</nav>';
      html +='</td>';
    html +='</tr>';
  html +='</tfoot>';
	html += '</table>';
	html += '<div class="navpopuptxt">';
		html += '<span>หน้า</span>';
		html += '<span>';
		html += '<select name="selectpage" class="" onchange="loadpageajaxemail($(this).val())">';
		for(var j = 1; j<= json['noofpage']; j++){
			if(j==page){
				html += '<option value="'+j+'" selected="selected">'+j+'</option>';
			}else{
				html += '<option value="'+j+'">'+j+'</option>';
			}
		}
		html += '</select>';
		html += '</span>';
		html += '<span>จาก '+json['noofpage']+'</span>';
	html += '</div>';
	$('#showResultPopup').html(html);
}
function loadlistselectemail(page){
	var frm = $('#myFrm');
	var pageval = $("<input>").attr("type", "hidden").attr("name", "page").val(page);
	frm.append($(pageval));
	var json = (function () {
		var json = null;
		var LoginData = $('#myFrm input[name=saveData]').val();
		$.ajax({
			'async': false,
			'global': false,
			'type':'POST',
			'data':frm.serialize(),
			'url': 'ajax-loadpageselectemail.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();
	var html = '';
	var myindex = 0;
	var tmp = 0;
	var len = json['resultselect'].length;
	var lengroup = json['resultgroupselect'].length;
	var lenoth = json['resultothselect'].length;
	if(len>0){
		var countselect = json['resultselectcount'];
		html += '<div class="TablelistEmailCount">รายการอีเมล์จำนวน '+countselect+' รายการ</div>';
		html += '<table class="TablelistEmail">';
			html +='<tbody>';
					$.each(json['resultselect'], function( index, value ) {
						html += '<tr>';
							//html += '<td></td>';
							html += '<td>'+value["name"]+'<input type="hidden" name="selectmailid[]" value="'+value["id"]+'" /><input type="hidden" name="selectmailtype[]" value="enew" /></td>';
							html += '<td>'+value["email"]+'</td>';
							html += '<td class="action">';
								html += '<a href="javascript:void(0)" rel="'+value["id"]+'" class="relateicon" onclick="dellistemail(this)"><i class="fas fa-trash-alt"></i></a>';
							html += '</td>';
						html += '</tr>';
					});
			html +='</tbody>';
		html += '</table>';
	}
	if(lengroup>0){
		var countselect = json['resultgroupselectcount'];
		html += '<div class="TablelistEmailCount">รายการกลุ่มจำนวน '+countselect+' รายการ</div>';
		html += '<table class="TablelistEmail">';
			html +='<tbody>';
					$.each(json['resultgroupselect'], function( index, value ) {
						html += '<tr>';
							//html += '<td></td>';
							html += '<td>'+value["name"]+'<input type="hidden" name="selectgroupid[]" value="'+value["id"]+'" /></td>';
							html += '<td>';
								var lenemail = value["email"].length;
								if(lenemail>0){
									html += '<table class="TablelistEmailInner">';
										html +='<tbody>';
										$.each(value["email"], function( index, value ) {
											html += '<tr>';
												html += '<td>'+value["Name"]+'<input type="hidden" name="selectmailid[]" value="'+value["MailListID"]+'" /><input type="hidden" name="selectmailtype[]" value="enew" /></td>';
												html += '<td class="email">'+value["Email"]+'</td>';
												html += '<td class="action">';
													html += '<a href="javascript:void(0)" rel="'+value["id"]+'" class="relateicon" onclick="dellistemailongroup(this)"><i class="fas fa-trash-alt"></i></a>';
												html += '</td>';
											html += '</tr>';
										});
										html +='</tbody>';
									html += '</table>';
								}
							html += '</td>';
							html += '<td class="action">';
								html += '<a href="javascript:void(0)" rel="'+value["id"]+'" class="relateicon" onclick="dellistgroup(this)"><i class="fas fa-trash-alt"></i></a>';
							html += '</td>';
						html += '</tr>';
					});
			html +='</tbody>';
		html += '</table>';
	}
	if(lenoth>0){
		var countselect = json['resultothselectcount'];
		html += '<div class="TablelistEmailCount">รายการอีเมล์จำนวน '+countselect+' รายการ</div>';
		html += '<table class="TablelistEmail">';
			html +='<tbody>';
					$.each(json['resultothselect'], function( index, value ) {
						html += '<tr>';
							//html += '<td></td>';
							html += '<td>'+value["name"]+'<input type="hidden" name="selectmailid[]" value="'+value["id"]+'" /><input type="hidden" name="selectmailtype[]" value="member" /></td>';
							html += '<td>'+value["email"]+'</td>';
							html += '<td class="action">';
								html += '<a href="javascript:void(0)" rel="'+value["id"]+'" class="relateicon" onclick="dellistoth(this)"><i class="fas fa-trash-alt"></i></a>';
							html += '</td>';
						html += '</tr>';
					});
			html +='</tbody>';
		html += '</table>';
	}
	$('#showResultListMail').html(html);
}
function dellistemail(t){
	var inputselect = $('input[name=myselect]');
	var DataselectIDs = inputselect.val().split(',');
	var tb = $(t);
	var tr = tb.closest('tr');
	var dataselect = tr.find('input[name^=selectmailid]').val();
	console.log (DataselectIDs);
	$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this record?',
			buttons: {
				Submit: {
						text: 'Confirm',
						btnClass: 'btn-blue',
						action: function () {
							DataselectIDs.splice( $.inArray(dataselect, DataselectIDs), 1 );
							tr.remove();
							inputselect.val(DataselectIDs.join(','));
							console.log (DataselectIDs);
						}
				},
				cancel: function () {
						//$.alert('Canceled!');
				}
			}
	});
}
function dellistgroup(t){
	var inputselect = $('input[name=mygroupselect]');
	var DataselectIDs = inputselect.val().split(',');
	var tb = $(t);
	var tr = tb.closest('tr');
	var dataselect = tr.find('input[name^=selectgroupid]').val();
	console.log (DataselectIDs);
	$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this record?',
			buttons: {
				Submit: {
						text: 'Confirm',
						btnClass: 'btn-blue',
						action: function () {
							DataselectIDs.splice( $.inArray(dataselect, DataselectIDs), 1 );
							tr.remove();
							inputselect.val(DataselectIDs.join(','));
							console.log (DataselectIDs);
							loadlistselectemail(1);
						}
				},
				cancel: function () {
						//$.alert('Canceled!');
				}
			}
	});
}
function dellistoth(t){
	var inputselect = $('input[name=myothselect]');
	var DataselectIDs = inputselect.val().split(',');
	var tb = $(t);
	var tr = tb.closest('tr');
	var dataselect = tr.find('input[name^=selectmailid]').val();
	console.log (DataselectIDs);
	$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this record?',
			buttons: {
				Submit: {
						text: 'Confirm',
						btnClass: 'btn-blue',
						action: function () {
							DataselectIDs.splice( $.inArray(dataselect, DataselectIDs), 1 );
							tr.remove();
							inputselect.val(DataselectIDs.join(','));
							console.log (DataselectIDs);
						}
				},
				cancel: function () {
						//$.alert('Canceled!');
				}
			}
	});
}
function dellistemailongroup(t){
	var tb = $(t);
	var tr = tb.closest('tr');
	tr.remove();
}
function inCheckboxToarr(t){
	var tb = $(t);
	var inputselect = $('input[name=myselect]');
	var DataselectIDs = inputselect.val().split(',');
	if(tb.prop("checked") == true){
			if ($.inArray(tb.val(),DataselectIDs)==-1) DataselectIDs.push(tb.val());
			console.log(DataselectIDs);
	}else if(tb.prop("checked") == false){
			DataselectIDs.splice( $.inArray(tb.val(), DataselectIDs), 1 );
			console.log(DataselectIDs);
	}
	inputselect.val(DataselectIDs.join(','));
}
function inCheckboxGroupToarr(t){
	var tb = $(t);
	var inputselect = $('input[name=mygroupselect]');
	var DataselectIDs = inputselect.val().split(',');
	if(tb.prop("checked") == true){
			if ($.inArray(tb.val(),DataselectIDs)==-1) DataselectIDs.push(tb.val());
			console.log(DataselectIDs);
	}else if(tb.prop("checked") == false){
			DataselectIDs.splice( $.inArray(tb.val(), DataselectIDs), 1 );
			console.log(DataselectIDs);
	}
	inputselect.val(DataselectIDs.join(','));
}
function inCheckboxOthToarr(t){
	var tb = $(t);
	var inputselect = $('input[name=myothselect]');
	var DataselectIDs = inputselect.val().split(',');
	if(tb.prop("checked") == true){
			if ($.inArray(tb.val(),DataselectIDs)==-1) DataselectIDs.push(tb.val());
			console.log(DataselectIDs);
	}else if(tb.prop("checked") == false){
			DataselectIDs.splice( $.inArray(tb.val(), DataselectIDs), 1 );
			console.log(DataselectIDs);
	}
	inputselect.val(DataselectIDs.join(','));
}
function popupBtnSelectClose(t){
	$.magnificPopup.close();
	//loadlistselectemail(1);
}
function popupBtnSelect(t){
	var tb = $(t);
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var searchIDs = $("#showResultPopup input:checkbox:checked").map(function(){
		if ($.inArray($(this).val(),DataselectIDs)==-1) DataselectIDs.push($(this).val());
	}); // <----
	console.log(DataselectIDs);

	//var searchIDs = [];
	//var searchIDs = $('input[name=myselect]').val().split(',');
	/*
	var searchIDs = $("#showResultPopup input:checkbox:checked").map(function(){
		var tbc = $(this).closest('tr').find('input[name^=CheckBoxID]').val();
		return tbc;
	}).toArray();
	DataselectIDs.push(searchIDs);
	console.log (DataselectIDs);
	*/
	/*
  var searchIDs = $("#showResultPopup input:checkbox:checked").map(function(){
    return $(this).val();
		DataselectIDs.push($(this).val());
  }).get(); // <----
	//DataselectIDs.push(searchIDs);
  console.log(DataselectIDs);
	*/
	/*
	searchIDs = $('#showResultPopup input[type="checkbox"]:checked').map(function() {
			return $(this).val();
	}).get().join(',');
	console.log(searchIDs);
	$('input[name=myselect]').val(searchIDs);
	*/
}
