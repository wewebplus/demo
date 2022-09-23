// JavaScript Document
$(document).ready(function($){
	$('form').attr('autocomplete', 'off');
	$('#frmLogin').submit(function(){
		if($('#inputuser').val()==''){
			$('#inputuser').focus();
			return false;
		}
		if($('#inputpass').val()==''){
			$('#inputpass').focus();
			return false;
		}
		$.post( "ajax/login.php", $( "#frmLogin" ).serialize(),function(datachk){

			if($.trim(datachk)=='ok'){
				//location.reload();
				location.href = './home/home.php';
			}else if($.trim(datachk)=='nouser'){
				$('#resultError').html('ไม่มีชื่อผู้ใช้นี้ในระบบ');
				$('#inputuser').val('');
				$('#inputuser').focus();
				/*
				jAlert('ไม่มีชื่อผู้ใช้นี้ในระบบ', 'Alert Dialog',function(){
					$('#inputuser').val('');
					$('#inputuser').focus();
				});
				*/
			}else if($.trim(datachk)=='nopass'){
				$('#resultError').html('รหัสผ่านไม่ถูกต้อง');
				$('#inputpass').val('');
				$('#inputpass').focus();
				/*
				jAlert('รหัสผ่านไม่ถูกต้อง', 'Alert Dialog',function(){
					$('#inputpass').val('');
					$('#inputpass').focus();
				});
				*/
			}
		});
		//alert('xx');
		return false;
	});
});
