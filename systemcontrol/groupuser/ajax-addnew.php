<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$inputGName = $_POST["inputGName"];
$inputShotGName = $_POST["inputShotGName"];
$Detail = encodetxterea($_POST["Detail"]);
$PermissionStr = $_POST["Permission"];

$sql = "SELECT MAX("._TABLE_ADMIN_USERGROUP_."_Order) AS MaxO FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;
$insert[_TABLE_ADMIN_USERGROUP_."_Name"] = "'".sql_safe($inputGName)."'";
$insert[_TABLE_ADMIN_USERGROUP_."_ShotName"] = "'".sql_safe($inputShotGName)."'";
$insert[_TABLE_ADMIN_USERGROUP_."_Title"] = "'".sql_safe($Detail)."'";
$insert[_TABLE_ADMIN_USERGROUP_."_Status"] = "'On'";
$insert[_TABLE_ADMIN_USERGROUP_."_Order"] = "'".sql_safe($MaxOrder)."'";
$z = new __webctrl;
$z->insert(_TABLE_ADMIN_USERGROUP_,$insert);
$NewID = $z->insertid();
unset($insert);
if($NewID>0){
  $pmArr=explode(",",$PermissionStr);
  if(count($pmArr)>0){
    foreach($Array_Lang["txt:Language"] as $LK=>$LV){
      for($i=0;$i<count($pmArr);$i++){
        $pmDivide=explode(":",$pmArr[$i]);
        $IDMenu = str_replace("Admin","",$pmDivide[0]);
        $IDMenu = str_replace("Manage","",$IDMenu);
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_GroupUserID"] = "'".sql_safe($NewID)."'";
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_MenuID"] = "'".sql_safe(intval($IDMenu))."'";
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_Permission"] = "'".sql_safe($pmDivide[1])."'";
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_Language"] = "'".sql_safe($LK)."'";
        $z = new __webctrl;
        $z->insert(_TABLE_ADMIN_USERGROUPPMA_,$insert);
        unset($insert);
      }
    }
  }
  foreach($MenuGroup as $gkey=>$gval){
    if(!empty($_POST["groupchk_".$gval])){
      $groupchk = $_POST["groupchk_".$gval];
    }else{
      $groupchk = "No";
    }
    $insert[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID"] = "'".sql_safe($NewID)."'";
    $insert[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID"] = "'".sql_safe($gval)."'";
    $insert[_TABLE_ADMIN_USERGROUPAPPROVE_."_Permission"] = "'".sql_safe($groupchk)."'";
    $z = new __webctrl;
    $z->insert(_TABLE_ADMIN_USERGROUPAPPROVE_,$insert);
    unset($insert);
  }
}
echo 2;
CloseDB();
?>
