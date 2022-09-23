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
if($itemid>0){
  $update = array();
  $update[_TABLE_MAIL_MAILLIST_."_Name"] = "'".sql_safe($inputName)."'";
  $update[_TABLE_MAIL_MAILLIST_."_Email"] = "'".sql_safe($inputEmail)."'";
  $z = new __webctrl;
  $z->update(_TABLE_MAIL_MAILLIST_,$update,array(_TABLE_MAIL_MAILLIST_."_ID=" => $itemid));
  unset($update);
  if(isset($_POST["inputGroupID"])){
    $z->del(_TABLE_MAIL_MAILLISTINGROUP_,array(_TABLE_MAIL_MAILLISTINGROUP_."_MailListID="=>(int)$itemid));
    foreach($_POST["inputGroupID"] as $valGroup){
      $insertGroup[_TABLE_MAIL_MAILLISTINGROUP_."_GroupID"] = sql_safe($valGroup,false,true);
      $insertGroup[_TABLE_MAIL_MAILLISTINGROUP_."_MailListID"] = sql_safe($itemid,false,true);
      $z->insert(_TABLE_MAIL_MAILLISTINGROUP_,$insertGroup);
      unset($insertGroup);
    }
  }
}
echo $itemid;
?>
