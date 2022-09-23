<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = trim($_POST['saveData']);
decode_URL($saveData);

$found = array();
$foundselected = array();
$sql = "";
$arrfmain = array();
$arrfmain[] = "TBmain.*";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = _TABLE_ADMIN_USER_."_ID AS ID";
	$arrf[] = _TABLE_ADMIN_USER_."_EmpID AS EmpID";
	$arrf[] = _TABLE_ADMIN_USER_."_Type AS uType";
	$arrf[] = _TABLE_ADMIN_USER_."_Level AS uLevel";
	$arrf[] = _TABLE_ADMIN_USER_."_UserName AS UserName";
	$arrf[] = _TABLE_ADMIN_USER_."_Status AS ListStatus";
	$arrf[] = _TABLE_ADMIN_USER_."_LastLoginDate AS LastLoginDate";
	$arrf[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
	$arrf[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
	$arrf[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
	$arrf[] = "TBType.TypeName";
	$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_USER_;
	$sql .= " LEFT JOIN "._TABLE_ADMIN_STAFF_." ON ("._TABLE_ADMIN_USER_."_EmpID = "._TABLE_ADMIN_STAFF_."_ID)";
	$sql .= " LEFT JOIN (";
		$sql .= "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS ID, "._TABLE_ADMIN_USERGROUP_."_Name AS TypeName FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
	$sql .= ") TBType ON ("._TABLE_ADMIN_USER_."_Type = TBType.ID)";
	$sql .= " WHERE "._TABLE_ADMIN_USER_."_Status = 'On'";
  unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
unset($arrfmain);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
if($RecordCount>0) {
  foreach($v as $Row){
    $ID = $Row["ID"];
    $uType = $Row["uType"];
		$Fullname = $Row["FName"]." ".$Row["LName"];
		$arr["id"] = $ID;
		$arr["value"] = $Fullname;
    if($uType==$itemid){
      $foundselected[] = $arr;
    }else{
      $found[] = $arr;
    }
  }
}
$output = array(
	"Candidate" => $found,
	"Selection" => $foundselected
);
CloseDB();
echo json_encode($output);
exit();
?>
