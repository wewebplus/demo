<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$InLang = $_SESSION['Session_Admin_Language'];
$myaction = (!empty($_POST["myaction"])?$_POST["myaction"]:'');
$inputParentID = (!empty($_POST["inputParentID"])?$_POST["inputParentID"]:0);
$inputMenuName = (!empty($_POST["inputMenuName"])?$_POST["inputMenuName"]:'');
$inputMenuShotName = (!empty($_POST["inputMenuShotName"])?$_POST["inputMenuShotName"]:$inputMenuName);
$SelectMenu = (!empty($_POST["SelectMenu"])?intval($_POST["SelectMenu"]):0);
if($SelectMenu>0){
  $mySelectMenuKey = @$menuModuleKey[$SelectMenu];
}else{
  $mySelectMenuKey = "";
}
$inputMenuUrl = (!empty($_POST["inputMenuUrl"])?$_POST["inputMenuUrl"]:'');
$selectTarget = (!empty($_POST["selectTarget"])?$_POST["selectTarget"]:'_self');
if($myaction=='addnew'){
  $sql = "SELECT MAX("._TABLE_FRONTMENUCONTENT_."_Order) AS MaxO FROM "._TABLE_FRONTMENUCONTENT_." WHERE "._TABLE_FRONTMENUCONTENT_."_ParentID = ".intval($inputParentID);
  $sql .= " AND "._TABLE_FRONTMENUCONTENT_."_Language = '".$InLang."'";
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $MaxOrder = $Row["MaxO"]+1;

  $insert[_TABLE_FRONTMENUCONTENT_.'_ParentID'] = sql_safe($inputParentID,false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_Language'] = "'".$InLang."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Folder'] = "'".$FolderKey."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_CreateDate'] = "NOW()";
  $insert[_TABLE_FRONTMENUCONTENT_.'_LastUpdate'] = "NOW()";
  $insert[_TABLE_FRONTMENUCONTENT_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_Status'] = "'On'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Order'] = sql_safe($MaxOrder,false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_KeyID'] = "'".sql_safe($SelectMenu)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Key'] = "'".sql_safe($mySelectMenuKey)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Name'] = "'".sql_safe($inputMenuName)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_ShotName'] = "'".sql_safe($inputMenuShotName)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Path'] = "'".sql_safe($inputMenuUrl)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Target'] = "'".sql_safe($selectTarget)."'";
  $z = new __webctrl;
  $z->insert(_TABLE_FRONTMENUCONTENT_,$insert);
  $insertid = $z->insertid();
  unset($insert);
}else if($myaction=='addsubmenu'){
  $sql = "SELECT MAX("._TABLE_FRONTMENUCONTENT_."_Order) AS MaxO FROM "._TABLE_FRONTMENUCONTENT_." WHERE "._TABLE_FRONTMENUCONTENT_."_ParentID = ".intval($inputParentID);
  $sql .= " AND "._TABLE_FRONTMENUCONTENT_."_Language = '".$InLang."'";
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $MaxOrder = $Row["MaxO"]+1;

  $insert[_TABLE_FRONTMENUCONTENT_.'_ParentID'] = sql_safe($inputParentID,false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_Language'] = "'".$InLang."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Folder'] = "'".$FolderKey."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_CreateDate'] = "NOW()";
  $insert[_TABLE_FRONTMENUCONTENT_.'_LastUpdate'] = "NOW()";
  $insert[_TABLE_FRONTMENUCONTENT_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_Status'] = "'On'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Order'] = sql_safe($MaxOrder,false,true);
  $insert[_TABLE_FRONTMENUCONTENT_.'_KeyID'] = "'".sql_safe($SelectMenu)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Key'] = "'".sql_safe($mySelectMenuKey)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Name'] = "'".sql_safe($inputMenuName)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_ShotName'] = "'".sql_safe($inputMenuShotName)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Path'] = "'".sql_safe($inputMenuUrl)."'";
  $insert[_TABLE_FRONTMENUCONTENT_.'_Target'] = "'".sql_safe($selectTarget)."'";
  $z = new __webctrl;
  $z->insert(_TABLE_FRONTMENUCONTENT_,$insert);
  $insertid = $z->insertid();
  unset($insert);
}else if($myaction=='editmenu'){
  $update[_TABLE_FRONTMENUCONTENT_."_LastUpdate"] = "NOW()";
	$update[_TABLE_FRONTMENUCONTENT_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $update[_TABLE_FRONTMENUCONTENT_.'_KeyID'] = "'".sql_safe($SelectMenu)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_Key'] = "'".sql_safe($mySelectMenuKey)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_Name'] = "'".sql_safe($inputMenuName)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_ShotName'] = "'".sql_safe($inputMenuShotName)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_Path'] = "'".sql_safe($inputMenuUrl)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_Target'] = "'".sql_safe($selectTarget)."'";
	$z = new __webctrl;
	$z->update(_TABLE_FRONTMENUCONTENT_,$update,array(_TABLE_FRONTMENUCONTENT_."_ID=" => (int)$inputParentID));
	unset($update);
}else if($myaction=='managemenu'){
  $sql = "SELECT "._TABLE_FRONTMENUCONTENT_."_Name AS MenuName FROM "._TABLE_FRONTMENUCONTENT_." WHERE "._TABLE_FRONTMENUCONTENT_."_ID = ".intval($inputParentID);
  $sql .= " AND "._TABLE_FRONTMENUCONTENT_."_Language = '".$InLang."'";
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $selectMenuType = (!empty($_POST["selectMenuType"])?$_POST["selectMenuType"]:'Link');
  $inputMenuUrl = (!empty($_POST["inputMenuUrl"])?$_POST["inputMenuUrl"]:'');
  $selectTarget = (!empty($_POST["selectTarget"])?$_POST["selectTarget"]:'_self');
  if($selectMenuType!="Link"){
    $inputMenuUrl = "/menu/".strtolower($selectMenuType)."/".$inputParentID."/".$Row["MenuName"]."/";
  }
  $update[_TABLE_FRONTMENUCONTENT_."_LastUpdate"] = "NOW()";
	$update[_TABLE_FRONTMENUCONTENT_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $update[_TABLE_FRONTMENUCONTENT_.'_MenuType'] = "'".sql_safe($selectMenuType)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_Path'] = "'".sql_safe($inputMenuUrl)."'";
  $update[_TABLE_FRONTMENUCONTENT_.'_Target'] = "'".sql_safe($selectTarget)."'";
	$z = new __webctrl;
	$z->update(_TABLE_FRONTMENUCONTENT_,$update,array(_TABLE_FRONTMENUCONTENT_."_ID=" => (int)$inputParentID));
	unset($update);
}
// genFileJson($FolderKey,$InLang);
?>
