<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;

		$sql = "SELECT "._TABLE_ADMIN_STAFF_."_ID AS ID,"._TABLE_ADMIN_STAFF_."_Status AS ListStatus FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_ADMIN_STAFF_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_ADMIN_STAFF_,$update,array(_TABLE_ADMIN_STAFF_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;

		$sql="SELECT "._TABLE_ADMIN_STAFF_."_PictureFileSrc AS PictureFileSrc,"._TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
	  $z = new __webctrl;
	  $z->sql($sql);
	  $v = $z->row();
	  $oldSrcFile = _RELATIVE_EMPLOYEE_UPLOAD_.$v[0]["PictureFileSrc"];
	  $oldPictureFile = _RELATIVE_EMPLOYEE_UPLOAD_.$v[0]["PictureFile"];

		if(is_file($oldSrcFile)) {
      unlink($oldSrcFile);
    }
    if(is_file($oldPictureFile)) {
      unlink($oldPictureFile);
    }

		$z = new __webctrl;
		$z->del(_TABLE_ADMIN_STAFF_,array(_TABLE_ADMIN_STAFF_."_ID=" => (int)$itemid));
		echo "OK";
	break; default:
}
CloseDB();
?>
