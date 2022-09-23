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

$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$sql = "SELECT MAX("._TABLE_CONTACT_GROUP_."_Order) AS MaxO FROM "._TABLE_CONTACT_GROUP_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

$insert = array();
$insert[_TABLE_CONTACT_GROUP_.'_Key'] = "'".$mymenukey."'";
$insert[_TABLE_CONTACT_GROUP_.'_CreateDate'] = "NOW()";
$insert[_TABLE_CONTACT_GROUP_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_CONTACT_GROUP_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_CONTACT_GROUP_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_CONTACT_GROUP_.'_Status'] = "'On'";
$insert[_TABLE_CONTACT_GROUP_.'_Ignore'] = "'".sql_safe($Lang)."'";
$insert[_TABLE_CONTACT_GROUP_.'_IP'] = "'".get_real_ip()."'";
$insert[_TABLE_CONTACT_GROUP_.'_Order'] = sql_safe($MaxOrder,false,true);
$z = new __webctrl;
$z->insert(_TABLE_CONTACT_GROUP_,$insert);
$insertid = $z->insertid();
unset($insert);
foreach($systemLang as $lkey=>$lval){
  $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
  $inputGroupSubject = (!empty($_POST["inputGroupSubject".$lkey])?$_POST["inputGroupSubject".$lkey]:'');
  $inputGroupTitle = (!empty($_POST["inputGroupTitle".$lkey])?encodetxterea($_POST["inputGroupTitle".$lkey]):'');
  $inputGroupEmail = (!empty($_POST["inputGroupEmail".$lkey])?$_POST["inputGroupEmail".$lkey]:'');

  $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
  $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_Subject'] = "'".sql_safe($inputGroupSubject)."'";
  $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_Email'] = "'".sql_safe($inputGroupEmail)."'";
  $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_Title'] = "'".sql_safe($inputGroupTitle)."'";
  $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_UpdateDate'] = "NOW()";
  if(!empty($Ignore)){
    $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_Status'] = "'Off'";
    $Lang .= "|".$lkey.":Off";
  }else{
    $insert[_TABLE_CONTACT_GROUP_DETAIL_.'_Status'] = "'On'";
    $Lang .= "|".$lkey.":On";
  }
  $z = new __webctrl;
  $z->insert(_TABLE_CONTACT_GROUP_DETAIL_,$insert);
  unset($insert);
}
$sql = "UPDATE "._TABLE_CONTACT_GROUP_." SET "._TABLE_CONTACT_GROUP_."_Ignore='".sql_safe($Lang)."' WHERE "._TABLE_CONTACT_GROUP_."_ID = ".(int)$insertid;
$z = new __webctrl;
$z->query($sql);

echo 2;
CloseDB();
?>
