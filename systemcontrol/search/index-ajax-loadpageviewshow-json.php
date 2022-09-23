<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datamemberslip.php");
$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['saveData']);
decode_URL($LoginData);
// $itemid = trim($_POST['itemid']);
$PageShow = (empty($selectPage)?1:$selectPage);
$PageSize = 50;

$arrf = array();
$arrf[] = _TABLE_SEARCH_LOGS_."_ID AS ID";
$arrf[] = _TABLE_SEARCH_LOGS_."_Keyword AS Keyword";
$arrf[] = _TABLE_SEARCH_LOGS_."_SearchDate AS CreateDate";
$sql = "SELECT  ".implode(',',$arrf)." FROM "._TABLE_SEARCH_LOGS_." a";
$sql .= " WHERE "._TABLE_SEARCH_LOGS_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$Keyword = $Row["Keyword"];


$found = array();
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= " (";
  $arrf = array();
	$arrf[] = _TABLE_SEARCH_LOGS_.'_ID AS ID';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_Keyword AS ListKeyword';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_IP AS ListIP';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_ID AS ListOrder';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_SearchDate AS CreateDate';
	$arrf[] = _TABLE_SEARCH_LOGS_."_Browser AS Browser";
	$arrf[] = _TABLE_SEARCH_LOGS_."_Platform AS Platform";
	$arrf[] = _TABLE_SEARCH_LOGS_."_userAgent AS userAgent";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_SEARCH_LOGS_;
	$sql .= " WHERE "._TABLE_SEARCH_LOGS_."_Keyword = '".$Keyword."'";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
unset($arrf);
$z = new __webctrl;
$z->sql($sql,$PageSize,$PageShow);
$RecordCount = $z->num();
$v = $z->row();
$NoOfPage = $z->totalpage();
$RecordCountInpage = $z->numinpage();
$RecordStart = ($PageSize*($PageShow-1));
if($RecordCount>0) {
	foreach($v as $Row){
		$arr["valueid"] = $Row["ID"];
		$arr["ListKeyword"] = $Row["ListKeyword"];
		$arr["ListIP"] = $Row["ListIP"];
		$arr["CreateDate"] = $Row["CreateDate"];
		$arr["Browser"] = $Row["Browser"];
		$arr["Platform"] = $Row["Platform"];
		$arr["userAgent"] = $Row["userAgent"];
		$found[] = $arr;
	}
}

$output = array(
	"status" => "ok",
	"reccount" => number_format($RecordCount),
	"pagesize" => $PageSize,
	"noofpage" => $NoOfPage,
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
