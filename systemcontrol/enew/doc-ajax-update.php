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
if($itemid>0){
  // $PathFile = _RELATIVE_ENEW_UPLOAD_;
  // $realPathFileName = $PathFile.$itemid."/";
  $inputDocSubject = $_POST["inputDocSubject"];
  $HTMLToolContent = $_POST["inputDetail"];
  $arrf = array();
  $sql = "";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
  $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_CreateDate AS CreateDate";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Order AS ListOrder";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
  $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_HTMLFileName AS HTMLFileName";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
	$sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_Folder='".$Login_MenuID."'";
  $sql .= " AND "._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$itemid;
	unset($arrf);
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $oldhtml01 = $PathUploadHtml.$Row['HTMLFileName'];
  if(is_file($oldhtml01)){unlink($oldhtml01);}

  $HTMLFileName = "html-$myrand.html";
  $HTMLToolContent=stripslashes($HTMLToolContent);
  $fp = fopen ($PathUploadHtml."/".$HTMLFileName, "w+");
  fwrite($fp,$HTMLToolContent);
  fclose($fp);

  $update = array();
  $update[_TABLE_MAIL_DOCUMENT_."_Subject"] = "'".sql_safe($inputDocSubject)."'";
  $update[_TABLE_MAIL_DOCUMENT_."_HTMLFileName"] = "'".sql_safe($HTMLFileName)."'";
  $update[_TABLE_MAIL_DOCUMENT_."_LastUpdate"] = "NOW()";
  $z = new __webctrl;
  $z->update(_TABLE_MAIL_DOCUMENT_,$update,array(_TABLE_MAIL_DOCUMENT_."_ID=" => $itemid));
  unset($update);
}
echo $itemid;

?>
