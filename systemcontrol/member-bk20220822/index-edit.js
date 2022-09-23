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
