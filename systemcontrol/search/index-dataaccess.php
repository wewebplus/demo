<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
//$Login_MenuID;
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
switch($actiontype){
  case 'changeusestatusgroup':
    // $update[_TABLE_SIGN_GROUP_."_Status"] = "'Off'";
    // $z = new __webctrl;
    // $z->update(_TABLE_SIGN_GROUP_,$update,array(_TABLE_SIGN_GROUP_."_ID>" => 0));

    $itemid = $itemid;
    $StatusTo = $statusto;
    $update = array();
		$update[_TABLE_SIGN_GROUP_."_Status"] = "'".$StatusTo."'";
		$update[_TABLE_SIGN_GROUP_."_LastUpdate"] = "NOW()";
		$update[_TABLE_SIGN_GROUP_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_SIGN_GROUP_,$update,array(_TABLE_SIGN_GROUP_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='On'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Off&StatusType=StatusGroup&actiontype=changeusestatusgroup');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=On&StatusType=StatusGroup&actiontype=changeusestatusgroup');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง</a>';
		}
		echo $btnstatus;
  break;case 'changethisstatus':
    $itemid = $itemid;
    $StatusTo = $status;

    $sql = "SELECT "._TABLE_SIGN_."_ID AS ID,"._TABLE_SIGN_."_Status AS ListStatus FROM "._TABLE_SIGN_." WHERE "._TABLE_SIGN_."_ID = ".(int)$itemid;
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];

    $ClassStatusFrom = $arrinStatusContactBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
    $ClassStatusTo = $arrinStatusContactBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

    $update[_TABLE_SIGN_."_Status"] = "'".$StatusTo."'";
    $z = new __webctrl;
    $z->update(_TABLE_SIGN_,$update,array(_TABLE_SIGN_."_ID=" => $itemid));
    unset($update);
    echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinContactStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
  break;case 'delete':
		$itemid = $itemid;
		$z = new __webctrl;
		$z->del(_TABLE_SIGN_,array(_TABLE_SIGN_."_ID=" => (int)$itemid));
		echo "OK";
  break; default:
}


?>
