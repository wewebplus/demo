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
			'url': 'http://localhost/disaster2021/upload/frontmenu./resultsmenu-Thai.json',
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

function loadpageajax(page){
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
			'data':{page:page,LoginData:LoginData,loadtype:loadtype},
			'url': 'group-ajax-loadpage-json.php',
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
	html +='<thead>';
		html +='<tr>';
			html +='<th class="w75 text-center">No.</th>';
			html +='<th class="">Menu Name</th>';
			html +='<th class="w175 text-left">Menu Status</th>';
			html +='<th class="w175 text-left">Action</th>';
		html +='</tr>';
	html +='</thead>';
	html +='<tbody>';
	if(len>0){
		$.each(json['result'],function(i, val){
			var numberindex = json['result'][i].ID;
			var countsubgroup = val["CountSubGroup"];
			html +='<tr class="listitem" data-z="'+numberindex+'">';
				html +='<td class="text-center">'+val["ListIndex"]+'</td>';
				html +='<td>';
					html += '<div>';
						html += '<div>'+val["Name"]+'</div>';
						// html += '<div>'+val["GroupFile"]+'</div>';
					html += '</div>';/*('+val["CountContent"]+')*/
					if(countsubgroup>0){
						html += '<ul class="listsubmenu">';
						$.each(val["DataSubGroup"],function(j, valj){
							html += '<li>';
								html += '<div class="relateimg"><img src="'+valj["Picture"]+'" ></div>';
								html += '<div>';
									html += '<div>'+valj["Name"]+' ('+valj["CountContent"]+')</div>';
									html += '<div>'+valj["GroupFile"]+'</div>';
								html += '</div>';
								html += '<div class="relatestatus">'+valj["Btnsubstatus"]+'</div>';
								html += '<div class="relatebtn">';
									html += '<a href="javascript:void(0)" rev="'+valj["dataphone"]+'" class="relateicon" onclick="clicktoaction(this)"><i class="fas fa-phone-square"></i></a>'
									html += '<a href="javascript:void(0)" rev="'+valj["dataedit"]+'" class="relateicon" onclick="clicktoaction(this)"><i class="fas fa-pen-square"></i></a>'
									html += '<a href="javascript:void(0)" rev="'+valj["datadelete"]+'" class="relateicon" onclick="deletesublist(this)"><i class="fas fa-trash-alt"></i></a>';
								html += '</div>';
							html += '</li>';
						});
						html += '</ul>';
					}
					// html += '<div class="linebtnlist">';
					// 	html += '<div><a href="javascript:void(0)" rev="'+val["dataaddsub"]+'" class="relateicon btn btn-sm btn-primary btn-block" onclick="clicktoaction(this)"><i class="fa fa-plus-circle"></i> Add Sub Group</a></div>';
					// 	html += '<div><a href="javascript:void(0)" rev="'+val["datasortsub"]+'" class="relateicon btn btn-sm btn-primary btn-block" onclick="clicktoaction(this)"><i class="fa fa-sort"></i> Move Sub Group</a></div>';
					// html += '</div>';
				html +='</td>';
				html +='<td>'+val["Btnstatus"]+'</td>';
				html +='<td>';
					html += '<div class="divaction">';
						html += '<a href="javascript:void(0)" title="Up" data-dir="up"><i class="fa fa-arrow-up" data-dir="up"></i></a>';
						html += '<a href="javascript:void(0)" title="Down" data-dir="down"><i class="fa fa-arrow-down" data-dir="down"></i></a>';
						html += '<a href="javascript:void(0)" rev="'+val["dataedit"]+'" class="relateicon" onclick="EditMenu(this)"><i class="fas fa-pen-square"></i></a>'
						html += '<a href="javascript:void(0)" rev="'+val["datadelete"]+'" class="relateicon" onclick="DeleteMenu(this)"><i class="fas fa-trash-alt"></i></a>';
					html += '</div>';
				html +='</td>';
			html +='</tr>';
		});
	}
	html +='</tbody>';
	$("#datatable > table").html(html);
	$('[data-z]').click(function(e){
		var jTarget = $(e.target),
			dir = jTarget.data('dir'),
			jItem = $(e.currentTarget),
			jItems = $('tr.listitem'),
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
				var myArray = $("#datatable table tr.listitem").map(function() {
					return $(this).attr('data-z');
				}).get();
				savelistorderContent(myArray);
		}
	  });
}
function savelistorderContent(myval){
	var FullPath = $('#ajaxFrm input[name=PathURL]').val();
	var MyData = $('#ajaxFrm input[name=LoginData]').val();
	$.ajax({
		'beforeSend': function(){
			$('.ajax-loader').css("visibility", "visible");
		},
		type:"POST",
		url:FullPath+'frontmenu/group-dataaction.php',
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
function EditMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var tb = $(t);
	var mydata = tb.attr('rev');
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
			'url': PathURL+"frontmenu/group-ajax-loadinfo.php",
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
			'url': PathURL+"frontmenu/group-ajax-savemenu.php",
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
function changeStatus(t){
	var mydata = $(t).attr('rev');
	var td = $(t).closest('td');
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	$.ajax({
		'beforeSend': function(){
				td.closest('tr').LoadingOverlay("show");
		},
		'type':'POST',
		'data': {MyData:mydata},
		'url': PathURL+"frontmenu/group-dataaccess.php",
		'success': function (data) {
			td.html($.trim(data));
		},
		complete: function(){
			td.closest('tr').LoadingOverlay("hide");
		}
	});
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
					'url': PathURL+"frontmenu/group-dataaccess.php",
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
		'url': PathURL+"frontmenu/group-datagenfrontmenu.php",
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
						'url': PathURL+"frontmenu/group-dataaction.php",
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
			'url': PathURL+"frontmenu/group-ajax-loadinfo-tree.php",
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
			'url': PathURL+"frontmenu/group-ajax-loadinfo-tree.php",
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
function ManageMenuType(t){
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
			'url': PathURL+"frontmenu/group-ajax-loadinfo-tree.php",
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
		$('#FrmManageImport').each(function(){
			this.reset();
		});
		$.magnificPopup.open({
			removalDelay: 500, //delay removal by X to allow out-animation,
			items: {
				src: "#modal-formmenutype"
			},
			// overflowY: 'hidden', //
			callbacks: {
				beforeOpen: function(e) {
					// FrmImport
					$('#FrmManageImport input[name=myaction]').val('managemenu');
					$('#FrmManageImport input[name=inputParentID]').val(res.ID);
					$('#FrmManageImport .MenuName p').html(res.Name);
					$('#FrmManageImport select[name=selectMenuType]').val(res.MenuType);
					$('#FrmManageImport input[name=inputMenuUrl]').val(res.URL);
					$('#FrmManageImport select[name=selectTarget]').val(res.TARGET);
					var Animation = "mfp-zoomIn";
					this.st.mainClass = Animation;
				}
			},
			midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
		});
	}
}
function summitFrmManageMenu(t){
	var PathURL = $('#ajaxFrm input[name=PathURL]').val();
	var form = $(t);
	$.ajax({
		'beforeSend': function(){
			$('.ajax-loader').css("visibility", "visible");
		},
		'type':'POST',
		'data':form.serialize(),
		'url': PathURL+"frontmenu/group-ajax-savemenu.php",
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
	// console.log('xxxx');
	return false;
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
		'url': PathURL+"frontmenu/group-dataaction.php",
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
		'url': PathURL+"frontmenu/group-dataaction.php",
		'success': function (data) {
			// var tree = $('#treegrid').fancytree('getTree').reload();
		},
		complete: function(){
			$('.ajax-loader').css("visibility", "hidden");
		}
	});

}
