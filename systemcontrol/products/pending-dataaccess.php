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
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;

		$sql = "SELECT "._TABLE_PRODUCTS_."_Key AS myKey,"._TABLE_PRODUCTS_."_ID AS ID,"._TABLE_PRODUCTS_."_Status AS ListStatus FROM "._TABLE_PRODUCTS_." WHERE "._TABLE_PRODUCTS_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
    $myKey = $Row["myKey"];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update = array();
		$update[_TABLE_PRODUCTS_."_Status"] = "'".$StatusTo."'";
		$update[_TABLE_PRODUCTS_."_LastUpdate"] = "NOW()";
		$update[_TABLE_PRODUCTS_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_PRODUCTS_,$update,array(_TABLE_PRODUCTS_."_ID=" => $itemid));
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
    //
		// echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
	break;case 'sort':
	break; default:
}
CloseDB();
?>
