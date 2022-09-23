var dslCourse = [];
jQuery(document).ready(function() {
  $( "#ListBtn" ).live( "click", function() {
    var mydata = $('#ajaxFrm input[name=LoginData]').val();
    var url = getfullUrl()+'?'+mydata;
    window.location = url;
	});
  CreateSelect();
});
function submitFrm(t){
  var saveData = $('#myFrm input[name=saveData]').val();
  var res = dslCourse.getSelection(false);
  var person = {};
	person["InAction"] = 'savemanage';
	person["saveData"] = saveData;
	person["data"] = res;
  $.ajax({
		'beforeSend': function(){
				$("body").LoadingOverlay("show");
		},
		type:"POST",
		contentType: 'application/json',
		url:'./ajax-action-json.php',
		data:JSON.stringify(person),
		cache:false,
		success: function(data) {
			// console.log(data);
      if($.trim(data)=='OK'){
        var PathURL = $('#ajaxFrm input[name=PathURL]').val();
        var mydata = $('#ajaxFrm input[name=LoginData]').val();
        var url = getfullUrl()+'?'+mydata;
        window.location = url;
      }else{
        alert('error : '+data);
      }
		},
		error: function () {
			alert("Error");
		},
		complete: function(){
			$("body").LoadingOverlay("hide");
		}
	});
  console.log(person);
  // alert('xxx');
  return false;
}
function CreateSelect(){
  var saveData = $('#myFrm input[name=saveData]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{saveData:saveData},
			'url': './ajax-loadpageuserlist.php',
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
  dslCourse = $('#dualSelectCourse').DualSelectList({
    'colors' : {
      'itemText' : 'white',
      'itemBackground' : 'rgb(0, 51, 204)',
      'itemHoverBackground' : '#0066ff'
    }
  });
  dslCourse.setCandidate(json.Candidate);
  dslCourse.setSelection(json.Selection);
  // console.log(json);
}
