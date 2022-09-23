<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
  $mymenukey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$dataModuleKey = $defaultdata[$Login_MenuID]["mainmodulekey"];

$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$inputGroupSubject = (!empty($_POST["inputGroupSubject"])?$_POST["inputGroupSubject"]:'');
$inputGroupFolder = (!empty($_POST["inputGroupFolder"])?$_POST["inputGroupFolder"]:'');
$inputGroupTitle = (!empty($_POST["inputGroupTitle"])?encodetxterea($_POST["inputGroupTitle"]):'');

$sql = "SELECT MAX("._TABLE_SIGN_GROUP_."_Order) AS MaxO FROM "._TABLE_SIGN_GROUP_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

$insert = array();
$insert[_TABLE_SIGN_GROUP_.'_Key'] = "'".$dataModuleKey."'";
$insert[_TABLE_SIGN_GROUP_.'_Name'] = "'".sql_safe($inputGroupSubject)."'";
$insert[_TABLE_SIGN_GROUP_.'_Folder'] = "'".sql_safe($inputGroupFolder)."'";
$insert[_TABLE_SIGN_GROUP_.'_Detail'] = "'".sql_safe($inputGroupTitle)."'";
$insert[_TABLE_SIGN_GROUP_.'_CreateDate'] = "NOW()";
$insert[_TABLE_SIGN_GROUP_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_SIGN_GROUP_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_SIGN_GROUP_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_SIGN_GROUP_.'_Status'] = "'On'";
$insert[_TABLE_SIGN_GROUP_.'_Order'] = sql_safe($MaxOrder,false,true);
$z = new __webctrl;
$z->insert(_TABLE_SIGN_GROUP_,$insert);
$insertid = $z->insertid();
unset($insert);

echo 2;
CloseDB();
?>
