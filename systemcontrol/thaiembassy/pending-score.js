jQuery(document).ready(function() {
  $('form').attr('autocomplete', 'off');
  $('.inputnumber').filter_input({regex:'[0-9.,]'});
  $('.date').mask('99/99/9999');
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  $("#InspectionDate").datepicker({
    dateFormat: 'dd/mm/yy',
    prevText: '<i class="fa fa-chevron-left"></i>',
    nextText: '<i class="fa fa-chevron-right"></i>',
    showButtonPanel: false,
    onSelect: function(selected) {

    }
  });
  $(".inputnumber").blur(function(e){
     calscore();
  });
});
function calscore(){
  var totalall = 0;
	var totalset2 = 0;
	var totalset3 = 0;
  $('.inputnumber').each(function(index,key) {
    // console.log(index);
    // console.log($(this).attr('name'));
    var FullScore = $(this).closest('tr').find('.FullScore');
    var InputScore = $(this).closest('tr').find('.Score');
    var maxData = parseFloat(FullScore.find('input[type=text]').val());
    var inputmyscore = parseFloat($(this).val().replace(/,/g , ""));
    inputmyscore = getNum(inputmyscore);
    if(maxData>=inputmyscore){
      // console.log('Y');
      if(index>=9){
        totalset3 = totalset3+inputmyscore;
      }else{
        totalset2 = totalset2+inputmyscore;
      }
      totalall = totalall+inputmyscore;
    }else{
      $.alert({
          title: false,
          content: 'การให้คะแนนไม่ถูกต้อง คะแนนต้องไม่เกิน '+maxData+' คะแนน',
          buttons: {
          	OK: function () {
              InputScore.find('input[type=text]').focusTextToEnd();
          	}
          }
      });
      return false;
    }
  });
  $('input[name=Section2Total]').val(totalset2);
  $('input[name=Section3Total]').val(totalset3);
  $('input[name=SectionTotalAll]').val(totalall);
  // console.log(totalall,totalset2,totalset3);
}
function SubmitFrm(t){
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
      url:FullPath+'thaiembassy/pending-score-save.php',
      data:tb.serialize(),
      cache:false,
      success: function(data) {
        // $('#ErrorResult').html(data);
				var mydata = $('#ajaxFrm input[name=LoginData]').val();
				var url = getfullUrl()+'?'+mydata;
				$.alert({
				    //title: 'Set Score!',
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
