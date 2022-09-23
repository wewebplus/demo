<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$Lang = "Lang";
$myrand = md5(rand(11111,99999));

if($itemid>0){
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputGroupSubject = (!empty($_POST["inputGroupSubject".$lkey])?$_POST["inputGroupSubject".$lkey]:'');
    $inputGroupTitle = (!empty($_POST["inputGroupTitle".$lkey])?encodetxterea($_POST["inputGroupTitle".$lkey]):'');
    if($detailid>0){
      $update[_TABLE_RECIPES_GROUP_DETAIL_.'_Subject'] = "'".sql_safe($inputGroupSubject)."'";
      $update[_TABLE_RECIPES_GROUP_DETAIL_.'_Title'] = "'".sql_safe($inputGroupTitle)."'";
      $update[_TABLE_RECIPES_GROUP_DETAIL_.'_UpdateDate'] = "NOW()";
      if(!empty($Ignore)){
        $update[_TABLE_RECIPES_GROUP_DETAIL_.'_Status'] = "'Off'";
        $Lang .= "|".$lkey.":Off";
      }else{
        $update[_TABLE_RECIPES_GROUP_DETAIL_.'_Status'] = "'On'";
        $Lang .= "|".$lkey.":On";
      }
      $z = new __webctrl;
      $z->update(_TABLE_RECIPES_GROUP_DETAIL_,$update,array(_TABLE_RECIPES_GROUP_DETAIL_."_ID=" => (int)$detailid));
      unset($update);
    }else{
      $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
      $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
      $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_Subject'] = "'".sql_safe($inputGroupSubject)."'";
      $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_Title'] = "'".sql_safe($inputGroupTitle)."'";
      $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_UpdateDate'] = "NOW()";
      if(!empty($Ignore)){
        $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_Status'] = "'Off'";
        $Lang .= "|".$lkey.":Off";
      }else{
        $insert[_TABLE_RECIPES_GROUP_DETAIL_.'_Status'] = "'On'";
        $Lang .= "|".$lkey.":On";
      }
      $z = new __webctrl;
      $z->insert(_TABLE_RECIPES_GROUP_DETAIL_,$insert);
      unset($insert);
    }
  }
	$update[_TABLE_RECIPES_GROUP_."_LastUpdate"] = "NOW()";
	$update[_TABLE_RECIPES_GROUP_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_RECIPES_GROUP_.'_Ignore'] = "'".sql_safe($Lang)."'";
	$update[_TABLE_RECIPES_GROUP_.'_IP'] = "'".get_real_ip()."'";
	$z = new __webctrl;
	$z->update(_TABLE_RECIPES_GROUP_,$update,array(_TABLE_RECIPES_GROUP_."_ID=" => (int)$itemid));
	unset($update);
}
echo 2;
CloseDB();
?>
