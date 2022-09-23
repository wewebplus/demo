<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_POST["saveData"]);
if($itemid>0){
  $inputGName = $_POST["inputGName"];
  $inputShotGName = $_POST["inputShotGName"];
  $Detail = encodetxterea($_POST["Detail"]);
  $PermissionStr = $_POST["Permission"];

  $update[_TABLE_ADMIN_USERGROUP_."_Name"] = "'".sql_safe($inputGName)."'";
  $update[_TABLE_ADMIN_USERGROUP_."_ShotName"] = "'".sql_safe($inputShotGName)."'";
  $update[_TABLE_ADMIN_USERGROUP_."_Title"] = "'".sql_safe($Detail)."'";
  $z = new __webctrl;
  $z->update(_TABLE_ADMIN_USERGROUP_,$update,array(_TABLE_ADMIN_USERGROUP_."_ID=" => (int)$itemid));
  unset($update);

  $z = new __webctrl;
  // $z->del(_TABLE_ADMIN_USERGROUPPMA_,array(_TABLE_ADMIN_USERGROUPPMA_."_GroupUserID=" => (int)$itemid,_TABLE_ADMIN_USERGROUPPMA_."_Language=" => $_SESSION['Session_Admin_Language']));
  $z->del(_TABLE_ADMIN_USERGROUPPMA_,array(_TABLE_ADMIN_USERGROUPPMA_."_GroupUserID=" => (int)$itemid));
  $pmArr=explode(",",$PermissionStr);
  if(count($pmArr)>0){
    foreach($Array_Lang["txt:Language"] as $LK=>$LV){
      for($i=0;$i<count($pmArr);$i++){
        $pmDivide=explode(":",$pmArr[$i]);
        $IDMenu = str_replace("Admin","",$pmDivide[0]);
        $IDMenu = str_replace("Manage","",$IDMenu);
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_GroupUserID"] = "'".sql_safe($itemid)."'";
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_MenuID"] = "'".sql_safe(intval($IDMenu))."'";
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_Permission"] = "'".sql_safe($pmDivide[1])."'";
        $insert[_TABLE_ADMIN_USERGROUPPMA_."_Language"] = "'".sql_safe($LK)."'";
        $z = new __webctrl;
        $z->insert(_TABLE_ADMIN_USERGROUPPMA_,$insert);
        unset($insert);
      }
    }
  }

  $z = new __webctrl;
  $z->del(_TABLE_ADMIN_USERGROUPAPPROVE_,array(_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID=" => (int)$itemid));

  foreach($MenuGroup as $gkey=>$gval){
    if(!empty($_POST["groupchk_".$gval])){
      $groupchk = $_POST["groupchk_".$gval];
    }else{
      $groupchk = "No";
    }
    $insert[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID"] = "'".sql_safe($itemid)."'";
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
