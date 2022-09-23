function loadpageajaxtest(){
	var json = (function () {
		var json = null;
		var LoginData = $('#ajaxFrm #LoginData').val();
		var loadtype = "loadpage";
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{},
			'url': 'http://localhost/disaster2021/upload/frontmenu/resultscontent-Thai.json',
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
	console.log(len);
}
function savelistorderContent(myval){
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var MyData = $('#ajaxFrm input[name=LoginData]').val();
	$.ajax({
		'beforeSend': function(){
			$('.ajax-loader').css("visibility", "visible");
		},
		type:"POST",
		url:FullPath+'fronthomecontent/group-dataaction.php',
		data:{myval:myval,MyData:MyData,mypage:1,mypagesize:0,myaction:'sortlist'},
		cache:false,
		success: function(data) {
			if($.trim(data)=='OK'){
				loadpageajax(1);
			}else{
				console.log(myval);
			}
		},
		error: function () {
			alert("Error");
		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
  	});
}
function myselectMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var thisval = tb.val();
	var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data': {MyData:thisval},
			'url': PathURL+"fronthomecontent/group-ajax-loadinfo-menu.php",
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
	var res = json['result'];
	if(status=='ok'){
		var myurl = '/content/'+res.Name;
		$('#FrmImport input[name=inputMenuKey]').val(res.Key);
		$('#FrmImport input[name=inputMenuName]').val(res.Name);
		$('#FrmImport input[name=inputMenuUrl]').val(myurl);
	}
	// $('#FrmImport input[name=inputParentID]').val(res.ID);
	// /content/รอบรั้วปภ
}
function AddnewMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.magnificPopup.open({
		removalDelay: 500, //delay removal by X to allow out-animation,
		items: {
			src: "#modal-formmenu"
		},
		// overflowY: 'hidden', //
		callbacks: {
			beforeOpen: function(e) {
				$('#FrmImport input[name=inputParentID]').val(0);
				$('#FrmImport input[name=myaction]').val('addnew');
				var Animation = "mfp-zoomIn";
				this.st.mainClass = Animation;
			}
		},
		midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
	});
}
function summitFrmMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var form = $(t);
	var nreq = form.find('.reqs').length;
	var nreqchk = 0;
	for(i=0;i<nreq;i++){
		obj = form.find('.reqs:eq('+i+')');
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
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'type':'POST',
			'data':form.serialize(),
			'url': PathURL+"fronthomecontent/group-ajax-savemenu.php",
			'success': function (data) {
				$('#ErrorOtherResult').html(data);
				form.each(function(){
					this.reset();
				});
				$.alert({
						//title: 'Set Employee!',
						title: false,
						content: 'บันทึกข้อมูลสำเร็จ',
						buttons: {
							OK: function () {
								$.magnificPopup.close();
								var tree = $('#treegrid').fancytree('getTree').reload();
								// loadpageajax(1);
							}
						}
				});
			},
			error: function () {
				alert("Error");
			},
			'complete': function(){
				$('.ajax-loader').css("visibility", "hidden");
			}
		});
	}
	return false;
}
function DeleteMenu(t){
	$.confirm({
	    title: 'Confirm!',
	    content: 'Are you sure to delete this record?',
	    buttons: {
	        confirm: function () {
				var mydata = $(t).attr('rev');
				var PathURL = $('#ajaxFrm input[name=PathURL]').val();
				$.ajax({
					'beforeSend': function(){
							$('.ajax-loader').css("visibility", "visible");
					},
					'type':'POST',
					'data':{MyData:mydata},
					'url': PathURL+"fronthomecontent/group-dataaccess.php",
					'success': function (data) {
						if($.trim(data)=='OK'){
							loadpageajax(1);
						}
					},
					complete: function(){
						$('.ajax-loader').css("visibility", "hidden");
					}
				});
	        },
	        cancel: function () {
	            //$.alert('Canceled!');
	        }
	    }
	});
}
function GenFrontendMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var mydata = $('#ajaxFrm input[name=LoginData]').val();
	$.ajax({
		'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
		},
		'type':'POST',
		'data':{MyData:mydata},
		'url': PathURL+"fronthomecontent/group-datagenfrontmenu.php",
		'success': function (data) {

		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});
}
function DeleteTreeMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var node = $.ui.fancytree.getNode(tb);
	mydata = node.key;
	// console.log(node.title,node.key);
	$.confirm({
	    title: 'Confirm!',
	    content: 'Are you sure to delete this record?',
	    buttons: {
			confirm: {
				text: 'Confirm',
				btnClass: 'btn-blue',
				keys: ['enter', 'shift'],
				action: function(){
					$.ajax({
						'beforeSend': function(){
								$('.ajax-loader').css("visibility", "visible");
						},
						'type':'POST',
						'data':{MyData:mydata,myaction:'delete'},
						'url': PathURL+"fronthomecontent/group-dataaction.php",
						'success': function (data) {
							if($.trim(data)=='OK'){
								// loadpageajax(1);
								var tree = $('#treegrid').fancytree('getTree').reload();
							}
						},
						complete: function(){
							$('.ajax-loader').css("visibility", "hidden");
						}
					});
				}
			},
	        cancel: function () {
	            //$.alert('Canceled!');
	        }
	    }
	});
}
function AddTreeMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var node = $.ui.fancytree.getNode(tb);
	var parentid = node.key;
	// console.log(node.title,node.key);
	var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data': {MyData:parentid},
			'url': PathURL+"fronthomecontent/group-ajax-loadinfo-tree.php",
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
	var res = json['result'];
	if(status=='ok'){
		$('#FrmImport').each(function(){
			this.reset();
		});
		$.magnificPopup.open({
			removalDelay: 500, //delay removal by X to allow out-animation,
			items: {
				src: "#modal-formmenu"
			},
			// overflowY: 'hidden', //
			callbacks: {
				beforeOpen: function(e) {
					// FrmImport
					$('#FrmImport .panel-title').html('<i class="fa fa-rocket"></i>Add Sub Menu');
					$('#FrmImport #mydataParentID').show();
					$('#FrmImport #mydataParentID p').html(res.Name);
					$('#FrmImport input[name=myaction]').val('addsubmenu');
					$('#FrmImport input[name=inputParentID]').val(res.ID);
					var Animation = "mfp-zoomIn";
					this.st.mainClass = Animation;
				}
			},
			midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
		});
	}
}
function EditTreeMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var node = $.ui.fancytree.getNode(tb);
	// console.log(node.title,node.key);
	var mydata = node.key;
	var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data': {MyData:mydata},
			'url': PathURL+"fronthomecontent/group-ajax-loadinfo-tree.php",
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
	var res = json['result'];

	$.magnificPopup.open({
		removalDelay: 500, //delay removal by X to allow out-animation,
		items: {
			src: "#modal-formmenu"
		},
		// overflowY: 'hidden', //
		callbacks: {
			beforeOpen: function(e) {
				// FrmImport
				$('#FrmImport .panel-title').html('<i class="fa fa-rocket"></i>Edit Menu');
				$('#FrmImport input[name=myaction]').val('editmenu');
				$('#FrmImport input[name=inputMenuKey]').val(res.MenuKey);
				$('#FrmImport select[name=SelectMenu]').val(res.MenuKeyID);
				$('#FrmImport input[name=inputParentID]').val(res.ID);
				$('#FrmImport input[name=inputMenuName]').val(res.Name);
				$('#FrmImport input[name=inputMenuUrl]').val(res.URL);
				$('#FrmImport select[name=selectTarget]').val(res.TARGET);
				var Animation = "mfp-zoomIn";
				this.st.mainClass = Animation;
			}
		},
		midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
	});
}
function myselectMenuType(t){
	var tb = $(t);
	var thisval = tb.val();
	var frm = tb.closest('form');
	var inputURL = frm.find('input[name=inputMenuUrl]')
	if(thisval=='Link'){
		inputURL.attr("readonly", false);
		inputURL.focusTextToEnd();
	}else{
		inputURL.attr("readonly", true);
	}
	// console.log(frm);
}
function UpdatePositionParent(thisid,data){
	// console.log(hit.node.data.ID);
	// console.log(thisid,data);
	// console.log(data);
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var hitMode = data.hitMode;
	var ToData = data.node.data.ID;
	$.ajax({
		'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
		},
		'type':'POST',
		'data':{thisid:thisid,hitMode:hitMode,ToData:ToData,myaction:'allposition'},
		'url': PathURL+"fronthomecontent/group-dataaction.php",
		'success': function (data) {

		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});
	// console.log(ToData,hitMode);
}
function UpdateOrder(dataorder){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	// console.log(dataorder);
	$.ajax({
		'beforeSend': function(){
				$('.ajax-loader').css("visibility", "visible");
		},
		'type':'POST',
		'data':{MyData:dataorder,myaction:'allorder'},
		'url': PathURL+"fronthomecontent/group-dataaction.php",
		'success': function (data) {
			// var tree = $('#treegrid').fancytree('getTree').reload();
		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});

}
