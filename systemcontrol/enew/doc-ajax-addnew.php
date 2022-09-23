<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }

$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$sql = "SELECT MAX("._TABLE_MAIL_DOCUMENT_."_Order) AS MaxO FROM "._TABLE_MAIL_DOCUMENT_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

// $PathFile = _RELATIVE_ENEW_UPLOAD_;
$inputDocSubject = $_POST["inputDocSubject"];
$HTMLToolContent = $_POST["inputDetail"];
$SessionID = $_POST["SessionID"];
$insert[_TABLE_MAIL_DOCUMENT_."_Folder"] = "'".$Login_MenuID."'";
$insert[_TABLE_MAIL_DOCUMENT_."_Language"] = "'".$_SESSION['Session_Admin_Language']."'";
$insert[_TABLE_MAIL_DOCUMENT_."_Subject"] = "'".sql_safe($inputDocSubject)."'";
$insert[_TABLE_MAIL_DOCUMENT_."_CreateByID"] = "'".$_SESSION['Session_Admin_ID']."'";
$insert[_TABLE_MAIL_DOCUMENT_."_CreateBy"] = "'".$_SESSION['Session_Admin_UserName']."'";
$insert[_TABLE_MAIL_DOCUMENT_."_HTMLFileName"] = "''";
$insert[_TABLE_MAIL_DOCUMENT_."_CreateDate"] = "NOW()";
$insert[_TABLE_MAIL_DOCUMENT_."_LastUpdate"] = "NOW()";
$insert[_TABLE_MAIL_DOCUMENT_."_Status"] = "'On'";
$insert[_TABLE_MAIL_DOCUMENT_."_Order"] = sql_safe($MaxOrder,false,true);
$z = new __webctrl;
$z->insert(_TABLE_MAIL_DOCUMENT_,$insert);
$insertid = $z->insertid();
unset($insert);
if($insertid>0){
  // $oldname = $PathFile.$SessionID."/";
  // $newPathFileName = $PathFile.$insertid."/";
  // if(is_dir($oldname)) {
  //   rename($oldname, $newPathFileName);
  // }
  $update = array();
  $update[_TABLE_MAIL_DOCUMENT_FILE_."_CID"] = sql_safe($insertid,false,true);
  $z = new __webctrl;
  $z->update(_TABLE_MAIL_DOCUMENT_FILE_,$update,array(_TABLE_MAIL_DOCUMENT_FILE_."_Session=" => "'".$SessionID."'",_TABLE_MAIL_DOCUMENT_FILE_."_CID=" => 0));
  unset($update);

  // if(!is_dir($newPathFileName)) { mkdir($newPathFileName,0777);}
  $HTMLFileName = "html-$myrand.html";
  $HTMLToolContent=stripslashes($HTMLToolContent);
  $fp = fopen ($PathUploadHtml."/".$HTMLFileName, "w+");
  fwrite($fp,$HTMLToolContent);
  fclose($fp);

  $update = array();
  $update[_TABLE_MAIL_DOCUMENT_."_HTMLFileName"] = "'".sql_safe($HTMLFileName)."'";
  $z = new __webctrl;
  $z->update(_TABLE_MAIL_DOCUMENT_,$update,array(_TABLE_MAIL_DOCUMENT_."_ID=" => $insertid));
  unset($update);
}
echo $insertid;
?>
