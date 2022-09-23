<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/mail/class.phpmailer.php");
$MyData = trim($_POST['saveData']);
decode_URL($MyData);
$useradminid = intval($_SESSION['Session_Admin_ID']);
if($useradminid>0){
  if(intval($itemid)>0){
    $z = new __webctrl;
    $inputTextReply = (!empty($_POST["inputTextReply"])?encodetxterea($_POST["inputTextReply"]):'');

    // load contact
    $sql = "";
    $arrfield = array();
    $arrfield[] = "TBmain.*";
    $arrfield[] = "TBJoin.GSubject".$_SESSION['Session_Admin_Language']." AS GroupSubject";
    $sql .= "SELECT ".implode(',',$arrfield)." FROM ";
    $sql .= " (";
      $arrf = array();
      $arrf[] = "a."._TABLE_CONTACT_.'_ID AS ID';
      $arrf[] = "a."._TABLE_CONTACT_.'_GroupID AS GroupID';
      $arrf[] = "a."._TABLE_CONTACT_.'_Key AS ModKey';
      $arrf[] = "a."._TABLE_CONTACT_.'_Status AS status';
      $arrf[] = "a."._TABLE_CONTACT_.'_CreateDate AS CreateDate';
      $arrf[] = "a."._TABLE_CONTACT_.'_Name AS ContactName';
      $arrf[] = "a."._TABLE_CONTACT_.'_Email AS ContactEmail';
      $arrf[] = "a."._TABLE_CONTACT_.'_Tel AS ContactTel';
      $arrf[] = "a."._TABLE_CONTACT_.'_Message AS ContactMessage';
      $sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTACT_." a";
      $sql .= " WHERE "._TABLE_CONTACT_."_ID = ".(int)$itemid;
      unset($arrf);
    $sql .= ") TBmain";
    $sql .= " LEFT JOIN (";
    	$sqlsub = "";
    	foreach($systemLang as $lkey=>$lval){
    		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS GSubject".$lkey;
    		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS GStatus".$lkey;
    	}
    	$sql .= "SELECT b."._TABLE_CONTACT_GROUP_."_ID as groupid".$sqlsub." FROM "._TABLE_CONTACT_GROUP_." b";
    	foreach($systemLang as $lkey=>$lval){
    		$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (b."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
    	}
    	$sql .= " WHERE b."._TABLE_CONTACT_GROUP_."_Key = '".$Login_MenuID."'";
    $sql .= ") TBJoin ON (TBmain.GroupID = TBJoin.groupid)";
    $sql .= " WHERE 1";
    unset($arrfield);
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];
    $ID = $Row["ID"];
    $GroupSubject = $Row["GroupSubject"];
    $ContactName = $Row["ContactName"];
    $ContactEmail = $Row["ContactEmail"];
    $ContactMessage = $Row["ContactMessage"];
    $ContactTel = $Row["ContactTel"];
    $CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');

    $DocumentSubject = rechangeQuot($Row["GroupSubject"]);
    $DocumentSubject  =  '=?utf-8?B?'.base64_encode($DocumentSubject).'?=';

    $contactStr="";
    $readUrlFile="../template-mail/template-contactus.html";
    $fp = @fopen($readUrlFile,"r");
    if ($fp) { while (!feof($fp)) $contactStr .= fgetc($fp); fclose($fp); }
    $contactStr = str_replace('[--@INPUTNAME@--]',$ContactName,$contactStr);
    $contactStr = str_replace('[--@GROUP@--]',$GroupSubject,$contactStr);
    $contactStr = str_replace('[--@PHONE@--]',$ContactTel,$contactStr);
    $contactStr = str_replace('[--@EMAIL@--]',$ContactEmail,$contactStr);
    $contactStr = str_replace('[--@DETAIL@--]',echoDetailToediter($ContactMessage),$contactStr);
    $contactStr = str_replace('[--@DATETIME@--]',$CreateDate,$contactStr);
    $contactStr = str_replace('[--@REPLY MESSAGE@--]',echoDetailToediter($inputTextReply),$contactStr);

    if(_ENABLE_SEND_MAIL_){
      if(!empty($ContactEmail)){
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
            $mail->Subject = $DocumentSubject;
            $mail->Body = $contactStr;
            $mail->AltBody =  $contactStr;
            $mail->AddAddress($ContactEmail);
            $mail->AddReplyTo(_DEFAULE_ADMIN_EMAIL_);
            if(!$mail->Send()) {
              $nogood = true;
              $sendstatus = 0;
              $statusmsg = "Message was not sent Mailer Error: " . $mail->ErrorInfo;
              $Err = $mail->ErrorInfo;
            } else {
              $sendstatus = 1;
              $statusmsg = "Thank you! Your message has been sent";
              $Err = "Email successful";
            }
          } catch (phpmailerException $e) {
            $nogood = true;
            $sendstatus = 0;
            $statusmsg = "Message was not sent Mailer Error: " . $e->errorMessage();
            $Err = $e->errorMessage();
            //echo $e->errorMessage(); //Pretty error messages from PHPMailer
          } catch (Exception $e) {
            $nogood = true;
            $sendstatus = 0;
            $statusmsg = "Message was not sent Mailer Error: " . $e->getMessage();
            $Err = $e->getMessage();
            //echo $e->getMessage(); //Boring error messages from anything else!
          }
      }else{
        $sendstatus = 0;
        $statusmsg = "Message was not sent Mailer Error";
        $Err = "No Email";
      }
    }else{
      $sendstatus = 0;
      $statusmsg = "Message was not sent Mailer Error";
      $Err = "No Open Send Email";
    }
    $insert = array();
    $insert[_TABLE_CONTACT_REPLY_."_ContactID"] = sql_safe($itemid,false,true);
    $insert[_TABLE_CONTACT_REPLY_."_StaffID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
    $insert[_TABLE_CONTACT_REPLY_."_StaffName"] = "'".sql_safe($_SESSION['Session_Admin_Name'])."'";
    $insert[_TABLE_CONTACT_REPLY_."_StaffType"] = "'Admin'";
    $insert[_TABLE_CONTACT_REPLY_."_Detail"] = "'".sql_safe($inputTextReply)."'";
    $insert[_TABLE_CONTACT_REPLY_.'_CreateDate'] = "NOW()";
    $insert[_TABLE_CONTACT_REPLY_."_SendStatus"] = sql_safe($sendstatus,false,true);
    $insert[_TABLE_CONTACT_REPLY_."_SendDate"] = "NOW()";
    $insert[_TABLE_CONTACT_REPLY_."_MSGStatus"] = "'".sql_safe($statusmsg)."'";
    $insert[_TABLE_CONTACT_REPLY_."_Err"] = "'".sql_safe($Err)."'";
    $z->insert(_TABLE_CONTACT_REPLY_,$insert);
    $ReplyDataID = $z->insertid();
    unset($insert);

    echo "OK";
  }
}
// echo $useradminid;
// // _TABLE_CONTACT_REPLY_
?>
