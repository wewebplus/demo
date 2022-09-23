<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;

		$sql = "SELECT "._TABLE_ADMIN_USER_."_ID AS ID,"._TABLE_ADMIN_USER_."_Status AS ListStatus FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_ADMIN_USER_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_ADMIN_USER_,$update,array(_TABLE_ADMIN_USER_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
		$z = new __webctrl;
		$z->del(_TABLE_ADMIN_USER_,array(_TABLE_ADMIN_USER_."_ID=" => (int)$itemid));
		$z->del(_TABLE_ADMIN_USERHISTORYPASS_,array(_TABLE_ADMIN_USERHISTORYPASS_."_UserID=" => (int)$itemid));
		$z->del(_TABLE_ADMIN_USERTOKEN_,array(_TABLE_ADMIN_USERTOKEN_."_UserID=" => (int)$itemid));
		echo "OK";
	break; default:
}
CloseDB();
?>
