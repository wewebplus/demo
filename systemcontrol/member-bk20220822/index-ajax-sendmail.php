<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/mail/class.phpmailer.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$LoginData = trim($_POST['saveData']);
decode_URL($LoginData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a.id AS ID";
  $arrf[] = "a.email AS Email";
  $arrf[] = "a.name AS Name";
  $arrf[] = "a.birthday AS Birthday";
  $arrf[] = "a.gender AS Gender";
  $arrf[] = "a.phone_number AS Tel";
  $arrf[] = "a.id AS ListOrder";
  $arrf[] = "(SELECT 'On') AS ListStatus";
	$arrf[] = "a.user_id AS User_id";
  $arrf[] = "a.create_date AS CreateDate";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
	$sql .= " WHERE 1";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE TBmain.ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$Name = $Row["Name"];
$Email = (!empty($Row["Email"])?$Row["Email"]:'');
$Tel = $Row["Tel"];
$User_id = $Row["User_id"];
$mail_attach = "";

$contactStr="";
$readUrlFile="../template-mail/1.html";
$fp = @fopen($readUrlFile,"r");
if ($fp) { while (!feof($fp)) $contactStr .= fgetc($fp); fclose($fp); }
$contactStr = str_replace('[--@USERCODE@--]',$User_id,$contactStr);
$contactStr = str_replace('[--@USERNAME@--]',$Name,$contactStr);
	$MailSubject = "คุณได้ทำการเข้าร่วม โครงการ เที่ยวไทยอะเมสซิ่งยิ่งกว่าเดิม เป็นที่เรียบร้อย";
	$MemberEmail = "gritcomdev@gmail.com";
	$MemberEmail = (!empty($Email)?$Email:$MemberEmail);
	if(_ENABLE_SEND_MAIL_){
	    $mail = new PHPMailer();
	  		try {
	  			$mail->CharSet = "utf-8";
	  			$mail->IsHTML();
	  			$mail->SMTPDebug = 1;
	  			$mail->SMTPAuth = _DEFAULE_SMTPAUTH_;
	  			if(_DEFAULE_SMTPENABLE_){
	  				$mail->IsSMTP();
	  				$mail->Host = _DEFAULE_SMTP_;
	  				$mail->Port = _DEFAULE_SMTP_PORT_;
	  				$mail->SMTPSecure = _DEFAULE_SMTPAUTH_SECURE_;
	  			}
	  			if(_DEFAULE_SMTPAUTH_){
	  				$mail->Username = _DEFAULE_SMTPAUTH_USER_; // gmail  username
	  				$mail->Password = _DEFAULE_SMTPAUTH_PASS_; // gmail password
	  			}
	  			$mail->From = _DEFAULE_ADMIN_EMAIL_;
	  			$mail->FromName = _DEFAULE_ADMIN_NAME_;
	  			$mail->Subject = $MailSubject;
	  			$mail->Body = $contactStr;
	  			$mail->AltBody =  $contactStr;
          /*
	  			if(is_file($mail_attach)){
	  				$mail->AddAttachment($mail_attach,"file.jpg");
	  			}
          */
	  			$mail->AddAddress($MemberEmail);
	  			if(!empty($MemberEmail) && strlen($MemberEmail)>5){
	  				$mail->AddReplyTo($MemberEmail);
	  			}
	  			$mail->Send();
	  		  //echo "Message Sent OK\n";
          $Message = "Message Sent OK";
          $MessageStatus = "C";
	  		} catch (phpmailerException $e) {
	  		  $Message =  $e->errorMessage(); //Pretty error messages from PHPMailer
          $MessageStatus = "E";
	  		} catch (Exception $e) {
	  		  $Message = $e->getMessage(); //Boring error messages from anything else!
          $MessageStatus = "W";
	  		}
	}
if($MessageStatus=='C'){
  $update["flagmail"] = "'".$MessageStatus."'";
  $z = new __webctrl;
  $z->update(_TABLE_MEMBER_,$update,array("id=" => intval($ID)));
  unset($update);
  echo " Email : ".$MemberEmail;
}else{
  echo $Message;
}
?>
