<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = trim($_POST['saveData']);
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
$UserPermission = userPmaInfo();
$osmnupma = $UserPermission->osmnupma;

if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$found = array();
$sql = "";
$ArrMainField = array();
$ArrMainField[] = "TBmain.ID";
$ArrMainField[] = "TBmain.ContentID";
$ArrMainField[] = "TBmain.MemberID";
$ArrMainField[] = "TBmain.CreateDate";
$ArrMainField[] = "TBmain._Comment";
$ArrMainField[] = "TBmain.ListStatus";
$ArrMainField[] = "TBmain._StartDate";
$ArrMainField[] = "TBmain._ExpireDate";
$sql .= "SELECT ".implode(',',$ArrMainField)." FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_ID AS ID";
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_ContentID AS ContentID";
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_MemberID AS MemberID";
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_CreateDate AS CreateDate";
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_StartDate AS _StartDate";
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_ExpireDate AS _ExpireDate";
  $ArrField[] = "IF("._TABLE_RESTAURANT_STATUSLOGS_."_Remark IS NULL or "._TABLE_RESTAURANT_STATUSLOGS_."_Remark = '', '-', "._TABLE_RESTAURANT_STATUSLOGS_."_Remark) as _Comment";
  $ArrField[] = _TABLE_RESTAURANT_STATUSLOGS_."_Status AS ListStatus";
  $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_RESTAURANT_STATUSLOGS_." WHERE 1 ";
  $sql .=" AND "._TABLE_RESTAURANT_STATUSLOGS_."_ContentID = ".(int)$ContentID;
$sql .= ") TBmain";
$sql .= " WHERE 1";
$sql .="  ORDER BY TBmain.CreateDate DESC";
unset($ArrMainField);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
if($RecordCount>0) {
  foreach($v as $Row){
    $ID = $Row["ID"];
    $ContentID = $Row["ContentID"];
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($CreateDate,'j M Y H:i');
    $_StartDate = $Row["_StartDate"];
    $_ExpireDate = $Row["_ExpireDate"];
    if($_StartDate!='0000-00-00 00:00:00'){
      $DateshowExpire = "( ".dateformat($_StartDate,'j M Y')." - ".dateformat($_ExpireDate,'j M Y')." )";
    }else{
      $DateshowExpire = "";
    }
    $MemberID = $Row["MemberID"];
    $_Comment = $Row["_Comment"];
    $ListStatus = $Row["ListStatus"];
    $statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
    $listmnubtn = '';
    $arr['ID'] = $ID;
    $arr['CreateDate'] = $CreateDate;
    $arr['Comment'] = echoDetailToediter($_Comment);
    $arr["StatusCss"] = strtolower($statuscss);
    $arr["Status"] = strtolower($ListStatus);
		$arr["Statustxt"] = $ListStatus;
    $arr["StatusBtn"] = $listmnubtn;
    $arr["DateshowExpire"] = $DateshowExpire;
    $found[] = $arr;
  }
}
$output = array(
	"status" => "ok",
	"reccount" => number_format($RecordCount),
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
