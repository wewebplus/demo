<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
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

$GroupName = (!empty($_POST["inputGroupSubject"])?$_POST["inputGroupSubject"]:'');
$GroupShotname = (!empty($_POST["inputShotGroupSubject"])?$_POST["inputShotGroupSubject"]:'');

$sql = "SELECT MAX("._TABLE_MAIL_GROUP_."_Order) AS MaxO FROM "._TABLE_MAIL_GROUP_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

$insert = array();
$insert[_TABLE_MAIL_GROUP_.'_Folder'] = "'".$mymenuKey."'";
$insert[_TABLE_MAIL_GROUP_.'_CreateDate'] = "NOW()";
$insert[_TABLE_MAIL_GROUP_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_MAIL_GROUP_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_MAIL_GROUP_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_MAIL_GROUP_.'_Status'] = "'On'";
$insert[_TABLE_MAIL_GROUP_.'_GroupName'] = "'".sql_safe($GroupName)."'";
$insert[_TABLE_MAIL_GROUP_.'_GroupShotname'] = "'".sql_safe($GroupShotname)."'";
$insert[_TABLE_MAIL_GROUP_.'_Order'] = sql_safe($MaxOrder,false,true);
$z = new __webctrl;
$z->insert(_TABLE_MAIL_GROUP_,$insert);
$insertid = $z->insertid();
unset($insert);
echo 2;
CloseDB();
?>
