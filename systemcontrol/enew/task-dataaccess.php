<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;

		$sql = "SELECT "._TABLE_MAIL_TASK_."_ID AS ID,"._TABLE_MAIL_TASK_."_Status AS ListStatus FROM "._TABLE_MAIL_TASK_." WHERE "._TABLE_MAIL_TASK_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_MAIL_TASK_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_MAIL_TASK_,$update,array(_TABLE_MAIL_TASK_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
		$z = new __webctrl;
		$z->del(_TABLE_MAIL_TASK_,array(_TABLE_MAIL_TASK_."_ID=" => (int)$itemid));
		$z->del(_TABLE_MAIL_TASKPROGRESS_,array(_TABLE_MAIL_TASKPROGRESS_."_TaskID=" => (int)$itemid));
		$z->del(_TABLE_MAIL_TASKREPORT_,array(_TABLE_MAIL_TASKREPORT_."_TaskID=" => (int)$itemid));
		echo "OK";
	break;case 'resettask':
		$itemid = $itemid;
		$z = new __webctrl;
		$update[_TABLE_MAIL_TASKPROGRESS_."_Status"] = "'Waiting'";
		$update[_TABLE_MAIL_TASKPROGRESS_."_SendDate"] = "NOW()";
		$z->update(_TABLE_MAIL_TASKPROGRESS_,$update,array(_TABLE_MAIL_TASKPROGRESS_."_TaskID="=>intval($itemid)));
		unset($update);
		$update[_TABLE_MAIL_TASK_."_NoOfSend"] = 0;
	  $z->update(_TABLE_MAIL_TASK_,$update,array(_TABLE_MAIL_TASK_."_ID=" => intval($itemid)));
	  unset($update);
		echo "OK";
	break; default:
}
CloseDB();
?>
