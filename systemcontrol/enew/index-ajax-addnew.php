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
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$inputName = $_POST["inputName"];
$inputEmail = $_POST["inputEmail"];
$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$insert[_TABLE_MAIL_MAILLIST_."_Folder"] = "'".$FolderKey."'";
$insert[_TABLE_MAIL_MAILLIST_."_Language"] = "'".$_SESSION['Session_Admin_Language']."'";
$insert[_TABLE_MAIL_MAILLIST_."_Name"] = "'".sql_safe($inputName)."'";
$insert[_TABLE_MAIL_MAILLIST_."_Email"] = "'".sql_safe($inputEmail)."'";
$insert[_TABLE_MAIL_MAILLIST_."_CreateByID"] = "'".$_SESSION['Session_Admin_ID']."'";
$insert[_TABLE_MAIL_MAILLIST_."_CreateDate"] = "NOW()";
$insert[_TABLE_MAIL_MAILLIST_."_Status"] = "'On'";
$z = new __webctrl;
$z->insert(_TABLE_MAIL_MAILLIST_,$insert);
$insertid = $z->insertid();
unset($insert);
if($insertid>0){
  if(isset($_POST["inputGroupID"])){
    foreach($_POST["inputGroupID"] as $valGroup){
      $insertGroup[_TABLE_MAIL_MAILLISTINGROUP_."_GroupID"] = sql_safe($valGroup,false,true);
      $insertGroup[_TABLE_MAIL_MAILLISTINGROUP_."_MailListID"] = sql_safe($insertid,false,true);
      $z->insert(_TABLE_MAIL_MAILLISTINGROUP_,$insertGroup);
      unset($insertGroup);
    }
  }
}
echo $insertid;
?>
