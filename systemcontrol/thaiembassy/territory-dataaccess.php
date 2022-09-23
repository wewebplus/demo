<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;
		if(!empty($Login_MenuID)){
		  $indexLogin_MenuID = substr($Login_MenuID,5);
		  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
		  $mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$sql = "SELECT "._TABLE_ADMIN_TERRITORY_."_ID AS ID,"._TABLE_ADMIN_TERRITORY_."_Status AS ListStatus FROM "._TABLE_ADMIN_TERRITORY_." WHERE "._TABLE_ADMIN_TERRITORY_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];
		$update[_TABLE_ADMIN_TERRITORY_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_ADMIN_TERRITORY_,$update,array(_TABLE_ADMIN_TERRITORY_."_ID=" => $itemid));
		unset($update);
		$output = array(
			"status" => "OK",
		  "statusto" => strtolower($StatusTo),
			"ClassStatusFrom" => $ClassStatusFrom,
			"ClassStatusTo" => $ClassStatusTo,
			"StatusText" => $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo]
		);
		CloseDB();
		header('Content-Type: application/json');
		echo json_encode($output);
		exit();
		// echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
		if(!empty($Login_MenuID)){
		  $indexLogin_MenuID = substr($Login_MenuID,5);
		  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
		  $mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$z = new __webctrl;
		$z->del(_TABLE_ADMIN_TERRITORY_,array(_TABLE_ADMIN_TERRITORY_."_ID=" => (int)$itemid));
		$z->del(_TABLE_ADMIN_TERRITORY_.'_internal',array(_TABLE_ADMIN_TERRITORY_."_internal_TerritoryID=" => (int)$itemid));
		$z->del(_TABLE_ADMIN_TERRITORY_.'_external',array(_TABLE_ADMIN_TERRITORY_."_external_TerritoryID=" => (int)$itemid));
		echo "OK";
	break; default:
}
CloseDB();
?>
