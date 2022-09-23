<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/mail/class.phpmailer.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);

$xstrnotwww = str_replace("www.","",_HTTP_PATH_UPLOAD_);
$actiontype = $_POST["actiontype"];
$inputSendType = $_POST["inputSendType"];
$inputSendSize = $_POST["inputSendSize"];
if($inputSendType=="Reset") {
	$update[_TABLE_MAIL_TASKPROGRESS_."_Status"] = "'Waiting'";
	$z = new __webctrl;
	$z->update(_TABLE_MAIL_TASKPROGRESS_,$update,array(_TABLE_MAIL_TASKPROGRESS_."_TaskID=" => intval($itemid)));
	unset($update);
}
if($actiontype=="send" || $actiontype=="sending") {
  // Select task information
  $sql="SELECT "._TABLE_MAIL_TASK_."_ID,"._TABLE_MAIL_TASK_."_Name,"._TABLE_MAIL_TASK_."_DocumentID  FROM "._TABLE_MAIL_TASK_." WHERE "._TABLE_MAIL_TASK_."_ID=".intval($itemid);
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $num = $z->num();
  $Row = $v[0];
  $ID = $Row[_TABLE_MAIL_TASK_."_ID"];
  $DocumentID = $Row[_TABLE_MAIL_TASK_."_DocumentID"];
  $KeyDocument = $defaultdata[$Login_MenuID]["group"]["menudoc"];

  $sql = "";
  $sql .= "SELECT * FROM ";
  $sql .= "("	;
    $arrf = array();
    $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
    $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_CreateDate AS CreateDate";
    $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Status AS ListStatus";
    $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Order AS ListOrder";
    $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
    $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_HTMLFileName AS HTMLFileName";
    $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
    $sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$DocumentID;
    unset($arrf);
  $sql .= ") TBmain";
  $sql .= " WHERE 1";
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $DocumentSubject = rechangeQuot($Row["Subject"]);
  $DocumentSubject  =  '=?utf-8?B?'.base64_encode($DocumentSubject).'?=';
  // $Module_Path_File = _RELATIVE_ENEW_UPLOAD_;
  // $Module_Path_FileHTML = $Module_Path_File.$DocumentID."/";
  $html = "";
  $html = $PathUploadHtml.$Row['HTMLFileName'];
  if(is_file($html)){
    $contents = file_get_contents($html);
  }else{
    $contents = "";
  }
  $doc=new DOMDocument();
  $doc->loadHTML($contents);
  $xml=simplexml_import_dom($doc); // just to make xpath more simple
  $images=$xml->xpath('//img');
  $index = 0;
  $imgArr = array();

  foreach ($images as $img) {
    $index++;
    // echo $img['src'] . ' ' . $img['alt'] . ' ' . $img['title'];
    $contents = str_replace($img['src'],"cid:image_".formatStringtoZero($index,4),$contents);
    $filenameArr = explode("/",$img['src']);
    $contentsimg = str_replace(_HTTP_PATH_UPLOAD_,_RELATIVE_PATH_UPLOAD_,$img['src']);
    $contentsimg = str_replace($xstrnotwww,_RELATIVE_PATH_UPLOAD_,$contentsimg);
    $imgArr[$index] = $contentsimg;//$_SERVER["DOCUMENT_ROOT"].$img['src'];//linux
    //$imgArr[$index] = str_replace("\\","/",$_SERVER["DOCUMENT_ROOT"].$Subpath.$img['src']);//iis
    //$imgArr[$index] = $Subpath.$img['src'];
    //$imgArr[$index] = $img['src'];
    $imgFilenameArr[$index] = $filenameArr[count($filenameArr)-1];
    //$imgArr[$index] = strtolower($img['src']);
    //$imgFilenameArr[$index] = strtolower($filenameArr[count($filenameArr)-1]);
  }
  $countImg = count($imgArr);

  $sql = "SELECT "._TABLE_MAIL_TASKPROGRESS_."_ID,"._TABLE_MAIL_TASKPROGRESS_."_MailType,"._TABLE_MAIL_TASKPROGRESS_."_TaskID,"._TABLE_MAIL_TASKPROGRESS_."_MailID,"._TABLE_MAIL_TASKPROGRESS_."_Name,"._TABLE_MAIL_TASKPROGRESS_."_Email FROM "._TABLE_MAIL_TASKPROGRESS_." WHERE "._TABLE_MAIL_TASKPROGRESS_."_Status='Waiting' AND "._TABLE_MAIL_TASKPROGRESS_."_TaskID=".intval($itemid);
  $z = new __webctrl;
  $z->sql($sql,$inputSendSize,1);
  $Query = $z->row();
  $TotalAccount = $z->num();
  if($TotalAccount>0) {
    $index = 0;
    $MailSubject = "E-News "._TITLE_SITENAME_." : ".$DocumentSubject;
    foreach($Query as $Row){
      $ProgressID = $Row[_TABLE_MAIL_TASKPROGRESS_."_ID"];
      $To = $Row[_TABLE_MAIL_TASKPROGRESS_."_Email"];
      $MailType = $Row[_TABLE_MAIL_TASKPROGRESS_."_MailType"];
      $TaskID = $Row[_TABLE_MAIL_TASKPROGRESS_."_TaskID"];
      $MailID = $Row[_TABLE_MAIL_TASKPROGRESS_."_MailID"];
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
              if($countImg>0){
    						foreach ($imgArr as $key=>$value) {
    							// echo formatStringtoZero($key,4);
    							// echo $value;
    							// echo $imgFilenameArr[$key];
    							$mail->AddEmbeddedImage($value,"image_".formatStringtoZero($key,4),$imgFilenameArr[$key]);
    						}
    					}
              $mail->Body = $contents;
              $mail->AltBody =  $contents;

              $sql = "SELECT "._TABLE_MAIL_DOCUMENT_FILE_."_ID,"._TABLE_MAIL_DOCUMENT_FILE_."_CID,"._TABLE_MAIL_DOCUMENT_FILE_."_FileName,"._TABLE_MAIL_DOCUMENT_FILE_."_Subject,"._TABLE_MAIL_DOCUMENT_FILE_."_FileType FROM  "._TABLE_MAIL_DOCUMENT_FILE_."  WHERE  "._TABLE_MAIL_DOCUMENT_FILE_."_CID=".(int)$DocumentID;
              $sql .="  ORDER BY "._TABLE_MAIL_DOCUMENT_FILE_."_ID DESC";
              $zFile = new __webctrl;
              $zFile->sql($sql);
              $Queryfile = $zFile->row();
              $FileAttach = $zFile->num();
              if($FileAttach>0){
                foreach($Queryfile as $RowFile){
                  $ContentID = $RowFile[_TABLE_MAIL_DOCUMENT_FILE_."_CID"];
                  $filedottype = ".".$RowFile[_TABLE_MAIL_DOCUMENT_FILE_."_FileType"];
                  // $FilePathLogoFromDB = _RELATIVE_ENEW_UPLOAD_.$ContentID."/".$RowFile[_TABLE_MAIL_DOCUMENT_FILE_."_FileName"];
                  $FilePathLogoFromDB = $PathUploadFile.$RowFile[_TABLE_MAIL_DOCUMENT_FILE_."_FileName"];
                  $newname = str_replace($filedottype,"",$RowFile[_TABLE_MAIL_DOCUMENT_FILE_."_Subject"]).$filedottype;
                  $mail->AddAttachment($FilePathLogoFromDB,$newname);
                }
              }
    	  			$mail->AddAddress($To);
    	  			if(!empty($To) && strlen($To)>5){
    	  				//$mail->AddReplyTo($To);
    	  			}
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

            $MailType = $Row[_TABLE_MAIL_TASKPROGRESS_."_MailType"];
            $TaskID = $Row[_TABLE_MAIL_TASKPROGRESS_."_TaskID"];
            $MailID = $Row[_TABLE_MAIL_TASKPROGRESS_."_MailID"];

  					// To Report
            $insertreport = array();
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_TaskID"] = sql_safe($TaskID,false,true);
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_MailType"] = "'".$MailType."'";
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_MailID"] = sql_safe($MailID,false,true);
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_SendStatus"] = "'".$sendstatus."'";
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_SendDate"] = "NOW()";
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_Status"] = "'".sql_safe($Err)."'";
  					$insertreport[_TABLE_MAIL_TASKREPORT_."_MSGStatus"] = "'".sql_safe($statusmsg)."'";
  					//$sql="INSERT INTO "._TABLE_MAIL_TASKREPORT_."(".implode(",",array_keys($insertreport)).") VALUES (".implode(",",array_values($insertreport)).")";
  					$z = new __webctrl;
  					$z->insert(_TABLE_MAIL_TASKREPORT_,$insertreport);
  					$MaxID = $z->insertid();
  					unset($insert);
  					// end To report

  					//####################################################################################
  					$update[_TABLE_MAIL_TASKPROGRESS_."_Status"] = "'Send'";
  					$update[_TABLE_MAIL_TASKPROGRESS_."_SendDate"] = "NOW()";
  					$z = new __webctrl;
  					$z->update(_TABLE_MAIL_TASKPROGRESS_,$update,array(_TABLE_MAIL_TASKPROGRESS_."_ID="=>intval($ProgressID)));
  					unset($update);
  					//####################################################################################
  					$index++;
    	}
    }
  }
  //echo $MailSubject;
  //print_r($imgArr);
  // Update task information ----------
  $sql="SELECT "._TABLE_MAIL_TASKPROGRESS_."_ID FROM "._TABLE_MAIL_TASKPROGRESS_."  WHERE "._TABLE_MAIL_TASKPROGRESS_."_Status='Send' AND "._TABLE_MAIL_TASKPROGRESS_."_TaskID=".intval($itemid);
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $SendRecordCount = $z->num();

  $update[_TABLE_MAIL_TASK_."_NoOfSend"] = sql_safe($SendRecordCount,false,true);
  $z = new __webctrl;
  $z->update(_TABLE_MAIL_TASK_,$update,array(_TABLE_MAIL_TASK_."_ID=" => intval($itemid)));
  unset($update);

}

?>
