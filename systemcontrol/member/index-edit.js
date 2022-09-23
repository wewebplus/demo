jQuery(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$('input[name=inputZipCode]').filter_input({regex:'[0-9]'});
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
	$('.bs-component select').on('change', function() {
		var thisname = $(this).attr('name');
		var thisinput = thisname.replace("select","input");
		var thistext = $(this).find("option:selected").text();
		$('input[name='+thisinput+']').val(thistext);
	});
	$('.frmalert select').on('change', function() {
		var thisname = $(this).attr('name');
		var thisinput = thisname.replace("select","input");
		var thistext = $(this).find("option:selected").text();
		$('input[name='+thisinput+']').val(thistext);
	});
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	$('.inputCountry').change(function(){
		var countryid = $(this).val();
		var cur_provid = $('input[name=inputProvinceStateID]').val();
		$.ajax({
			'beforeSend': function(){
			  $("body").LoadingOverlay("show");
			},
			type:"GET",
			url:FullPath+'member/func-ajax-province.php',
			data:{country: countryid, cur_provid: cur_provid},
			cache:false,
			success: function(data) {
			  $(".inputProvinceState").html(data).fadeIn('fast');
			  $('.inputDistrict').empty();
			  $('.inputSubDistrict').empty();
			},
			error: function () {
			  alert("Error");
			},
			complete: function(){
			  $("body").LoadingOverlay("hide");
			}
		});
	});
	$('.inputProvinceState').change(function(){
		var countryid = $('.inputCountry').val();
		var provinceid = $(this).val();
		var cur_distid = $('input[name=inputDistrictID]').val();
		$.ajax({
			'beforeSend': function(){
			  $("body").LoadingOverlay("show");
			},
			type:"GET",
			url:FullPath+'member/func-ajax-district.php',
			data:{country: countryid, province: provinceid, cur_distid: cur_distid},
			cache:false,
			success: function(data) {
			  $(".inputDistrict").html(data).fadeIn('fast');
			  $('.inputSubDistrict').empty();
			},
			error: function () {
			  alert("Error");
			},
			complete: function(){
			  $("body").LoadingOverlay("hide");
			}
		});
	});
	$('.inputDistrict').change(function(){
		var countryid = $('.inputCountry').val();
		var provinceid = $('.inputProvinceState').val();
		var districtid = $(this).val();
		var cur_subdistid = $('input[name=inputSubDistrictID]').val();
		$.ajax({
			'beforeSend': function(){
			  $("body").LoadingOverlay("show");
			},
			type:"GET",
			url:FullPath+'member/func-ajax-subdistrict.php',
			data:{country: countryid, province: provinceid, district: districtid, cur_subdistid: cur_subdistid},
			cache:false,
			success: function(data) {
			  $(".inputSubDistrict").html(data).fadeIn('fast');
			},
			error: function () {
			  alert("Error");
			},
			complete: function(){
			  $("body").LoadingOverlay("hide");
			}
		});
	});
	$('.inputSubDistrict').change(function(){
		var cur_subdistid = $(this).val();
		$.ajax({
			'beforeSend': function(){
			  $("body").LoadingOverlay("show");
			},
			type:"GET",
			url:FullPath+'member/func-ajax-zipcode.php',
			data:{cur_subdistid: cur_subdistid},
			cache:false,
			success: function(data) {
			  $(".inputZipCode").val(data);
			},
			error: function () {
			  alert("Error");
			},
			complete: function(){
			  $("body").LoadingOverlay("hide");
			}
		});
	});
	$("#inputCompanyRegisterDate").datepicker({
		// dateFormat: 'dd/mm/yy',
		dateFormat: 'yy-mm-dd',
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		showButtonPanel: false,
	});

	// File
	var typeUpload_1 = "certificate_of_registration";
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

	var typeUpload_2 = "tax_identification";
	var saveDataFile_2 = $('input[name=saveData'+typeUpload_2+']').val();
	var PathFileAtt_2 = $('input[name=PathAtt'+typeUpload_2+']').val();
	var SessionID_2 = $('input[name=SessionID]').val();
	var UploadToFile_2 = $('input[name=UploadTo'+typeUpload_2+']').val();
	var UploadToExt_2 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_2,'#outputuploadFile'+typeUpload_2,'edit');
	$("#uploadFile"+typeUpload_2).setupload({
		'script' : UploadToFile_2,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_2},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_2,
		'path':PathFileAtt_2,
		'DataID':0,
		'SessionID':SessionID_2,
		'result_output':'#outputuploadFile'+typeUpload_2+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_2,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_2,'#outputuploadFile'+typeUpload_2,'edit');
		}
	});

	var typeUpload_3 = "product_certificate";
	var saveDataFile_3 = $('input[name=saveData'+typeUpload_3+']').val();
	var PathFileAtt_3 = $('input[name=PathAtt'+typeUpload_3+']').val();
	var SessionID_3 = $('input[name=SessionID]').val();
	var UploadToFile_3 = $('input[name=UploadTo'+typeUpload_3+']').val();
	var UploadToExt_3 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_3,'#outputuploadFile'+typeUpload_3,'edit');
	$("#uploadFile"+typeUpload_3).setupload({
		'script' : UploadToFile_3,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_3},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_3,
		'path':PathFileAtt_3,
		'DataID':0,
		'SessionID':SessionID_3,
		'result_output':'#outputuploadFile'+typeUpload_3+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_3,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_3,'#outputuploadFile'+typeUpload_3,'edit');
		}
	});

	var typeUpload_4 = "product_quality";
	var saveDataFile_4 = $('input[name=saveData'+typeUpload_4+']').val();
	var PathFileAtt_4 = $('input[name=PathAtt'+typeUpload_4+']').val();
	var SessionID_4 = $('input[name=SessionID]').val();
	var UploadToFile_4 = $('input[name=UploadTo'+typeUpload_4+']').val();
	var UploadToExt_4 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_4,'#outputuploadFile'+typeUpload_4,'edit');
	$("#uploadFile"+typeUpload_4).setupload({
		'script' : UploadToFile_4,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_4},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_4,
		'path':PathFileAtt_4,
		'DataID':0,
		'SessionID':SessionID_4,
		'result_output':'#outputuploadFile'+typeUpload_4+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_4,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_4,'#outputuploadFile'+typeUpload_4,'edit');
		}
	});

	var typeUpload_5 = "copyright_origin";
	var saveDataFile_5 = $('input[name=saveData'+typeUpload_5+']').val();
	var PathFileAtt_5 = $('input[name=PathAtt'+typeUpload_5+']').val();
	var SessionID_5 = $('input[name=SessionID]').val();
	var UploadToFile_5 = $('input[name=UploadTo'+typeUpload_5+']').val();
	var UploadToExt_5 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_5,'#outputuploadFile'+typeUpload_5,'edit');
	$("#uploadFile"+typeUpload_5).setupload({
		'script' : UploadToFile_5,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_5},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_5,
		'path':PathFileAtt_5,
		'DataID':0,
		'SessionID':SessionID_5,
		'result_output':'#outputuploadFile'+typeUpload_5+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_5,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_5,'#outputuploadFile'+typeUpload_5,'edit');
		}
	});

	var typeUpload_6 = "company_location";
	var saveDataFile_6 = $('input[name=saveData'+typeUpload_6+']').val();
	var PathFileAtt_6 = $('input[name=PathAtt'+typeUpload_6+']').val();
	var SessionID_6 = $('input[name=SessionID]').val();
	var UploadToFile_6 = $('input[name=UploadTo'+typeUpload_6+']').val();
	var UploadToExt_6 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_6,'#outputuploadFile'+typeUpload_6,'edit');
	$("#uploadFile"+typeUpload_6).setupload({
		'script' : UploadToFile_6,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_6},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_6,
		'path':PathFileAtt_6,
		'DataID':0,
		'SessionID':SessionID_6,
		'result_output':'#outputuploadFile'+typeUpload_6+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_6,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_6,'#outputuploadFile'+typeUpload_6,'edit');
		}
	});

	var typeUpload_7 = "other_file";
	var saveDataFile_7 = $('input[name=saveData'+typeUpload_7+']').val();
	var PathFileAtt_7 = $('input[name=PathAtt'+typeUpload_7+']').val();
	var SessionID_7 = $('input[name=SessionID]').val();
	var UploadToFile_7 = $('input[name=UploadTo'+typeUpload_7+']').val();
	var UploadToExt_7 = arrfileupload;//$('input[name=UploadFileType'+typeUpload_1+']').val();
	loadpagefileajax(saveDataFile_7,'#outputuploadFile'+typeUpload_7,'edit');
	$("#uploadFile"+typeUpload_7).setupload({
		'script' : UploadToFile_7,
		'scriptData' : {myflag:'Content',saveData:saveDataFile_7},
		'total_files_allowed' : 0,
		'allowed_file_types':arrfileupload,
		'fileExt':UploadToExt_7,
		'path':PathFileAtt_7,
		'DataID':0,
		'SessionID':SessionID_7,
		'result_output':'#outputuploadFile'+typeUpload_7+'Error',
		'progress_bar_id':'#progressuploadFile'+typeUpload_7,
		'success':function(upresult,data){
			loadpagefileajax(saveDataFile_7,'#outputuploadFile'+typeUpload_7,'edit');
		}
	});

	// end File

});
function submitFrm(t){
  var tb = $(t);
  var nreq = tb.find('.reqs').length;
  var nreqchk = 0;
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  for(i=0;i<nreq;i++){
		obj = tb.find('.reqs:eq('+i+')');
		objType = obj.attr('type');
		tagName = obj.get(0).tagName;
		title = obj.attr('placeholder');
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
		$.ajax({
      'beforeSend': function(){
        $("body").LoadingOverlay("show");
      },
      type:"POST",
      url:FullPath+'member/index-ajax-update.php',
      data:tb.serialize(),
      cache:false,
      success: function(data) {
        //$('#ErrorOtherResult').html(data);
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
	return false;
}
