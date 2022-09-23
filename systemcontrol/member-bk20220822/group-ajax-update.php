<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$sql = "TRUNCATE TABLE "._TABLE_MEMBER_USAGE_;
$z = new __webctrl;
$z->query($sql);
foreach($arrMemberType as $K=>$V){
  $checkboxUsage = (isset($_POST["checkboxUsage".$K])?$_POST["checkboxUsage".$K]:array());
  $strdata = implode(',',$checkboxUsage);
  // print_r($_POST["checkboxUsage".$K]);
  $insert = array();
  $insert[_TABLE_MEMBER_USAGE_."_Index"] = "'".sql_safe($K)."'";
  $insert[_TABLE_MEMBER_USAGE_."_Name"] = "'".sql_safe($V)."'";
  $insert[_TABLE_MEMBER_USAGE_."_Seting"] = "'".sql_safe($strdata)."'";
  $z = new __webctrl;
  $z->insert(_TABLE_MEMBER_USAGE_,$insert);
  unset($insert);
}
echo "OK";
// _TABLE_MEMBER_USAGE_
// echo $Login_MenuID;
?>
