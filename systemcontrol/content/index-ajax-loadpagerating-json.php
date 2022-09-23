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
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$found = array();
$sql = "";
$ArrMainField = array();
$ArrMainField[] = "TBmain.ID";
$ArrMainField[] = "TBmain.ContentID";
$ArrMainField[] = "TBmain.MemberID";
$ArrMainField[] = "TBmain.Rating";
$ArrMainField[] = "TBmain.CreateDate";
$sql .= "SELECT ".implode(',',$ArrMainField)." FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = _TABLE_CONTENT_RATING_."_ID AS ID";
  $ArrField[] = _TABLE_CONTENT_RATING_."_ContentID AS ContentID";
  $ArrField[] = _TABLE_CONTENT_RATING_."_MemberID AS MemberID";
  $ArrField[] = _TABLE_CONTENT_RATING_."_CreateDate AS CreateDate";
  $ArrField[] = _TABLE_CONTENT_RATING_."_Rating AS Rating";
  $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_CONTENT_RATING_." WHERE 1 ";
  $sql .=" AND "._TABLE_CONTENT_RATING_."_ContentID = ".(int)$ContentID;
$sql .= ") TBmain";
$sql .= " WHERE 1";
$sql .="  ORDER BY TBmain.ID ASC";
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
    $MemberID = $Row["MemberID"];
    $Rating = $Row["Rating"];
    $arr['ID'] = $ID;
		$arr['Rating'] = $Rating;
    $arr['CreateDate'] = $CreateDate;
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
