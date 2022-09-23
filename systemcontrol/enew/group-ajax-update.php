<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");

decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenuKey = $menuFolderModule[substr($Login_MenuID,5)];
}else{
  $mymenuinclude = "";
  $mymenuKey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$Lang = "Lang";
$myrand = md5(rand(11111,99999));

if($itemid>0){
  $GroupName = (!empty($_POST["inputGroupSubject"])?$_POST["inputGroupSubject"]:'');
  $GroupShotname = (!empty($_POST["inputShotGroupSubject"])?$_POST["inputShotGroupSubject"]:'');
  $update[_TABLE_MAIL_GROUP_.'_GroupName'] = "'".sql_safe($GroupName)."'";
  $update[_TABLE_MAIL_GROUP_.'_GroupShotname'] = "'".sql_safe($GroupShotname)."'";
	$update[_TABLE_MAIL_GROUP_."_LastUpdate"] = "NOW()";
	$update[_TABLE_MAIL_GROUP_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$z = new __webctrl;
	$z->update(_TABLE_MAIL_GROUP_,$update,array(_TABLE_MAIL_GROUP_."_ID=" => (int)$itemid));
	unset($update);
}
echo 2;
CloseDB();
?>
