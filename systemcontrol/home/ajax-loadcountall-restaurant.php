<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$daterange = $_POST["homerang"];
$ardate = explode("-",$daterange);
$ardateFrom = trim($ardate[0]);
$ardateTo = trim($ardate[1]);
$DRStart = convertdatetodb($ardateFrom,'English');
$DREnd = convertdatetodb($ardateTo,'English');
$dateranginweek = getDateRangeForAllWeeks($DRStart, $DREnd);
$found = array();
$foundinner = array();

$DMStart = date('Y-m-d',mktime(0,0,0,1,1,2000));
$DMEnd = date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));

$sql = "";
$arrfmain = array();
$arrfmain[] = "TB.CountData";
$arrfmain[] = "TB.CountDataAll";
$arrfmain[] = "TB.CountDataFix";
if(count($dateranginweek)>0){
	foreach($dateranginweek as $kldate=>$vldate){
		$arrfmain[] = "TB.DW0".$kldate;
	}
}
$arrfmain[] = "TB.Sum01";
$arrfmain[] = "TB.Sum02";
$arrfmain[] = "TB.Sum03";
$arrfmain[] = "TB.Sum04";
$arrfmain[] = "TB.Sum01Fix";
$arrfmain[] = "TB.Sum02Fix";
$arrfmain[] = "TB.Sum03Fix";
$arrfmain[] = "TB.Sum04Fix";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= "(";
	$sql .= "SELECT ";
	$sql .= " COUNT(*) AS CountData";
	$sql .= " ,SUM(IF(DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DMStart."' AND '".$DMEnd."', 1, 0)) AS CountDataAll";
	$sql .= " ,SUM(IF(DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS CountDataFix";
	if(count($dateranginweek)>0){
		foreach($dateranginweek as $kldate=>$vldate){
			$sql .= " ,SUM(IF(DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$vldate["monday"]."' AND '".$vldate["sunday"]."', 1, 0)) AS DW0".$kldate;
		}
	}
  $sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Casual', 1, 0)) AS Sum01";
	$sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Classic', 1, 0)) AS Sum02";
	$sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Signature', 1, 0)) AS Sum03";
	$sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Unique', 1, 0)) AS Sum04";
	$sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Casual' AND DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum01Fix";
  $sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Classic' AND DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum02Fix";
	$sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Signature' AND DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum03Fix";
	$sql .= " ,SUM(IF("._TABLE_RESTAURANT_."_Type = 'Unique' AND DATE("._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum04Fix";
	$sql .= " FROM "._TABLE_RESTAURANT_." AS p";
	$sql .= " WHERE DATE(p."._TABLE_RESTAURANT_."_CreateDate) BETWEEN '".$DMStart."' AND '".$DMEnd."'";
$sql .= ") TB";
// echo $sql;
// exit();
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$Register = array();
$ar = array();
$ar["visible"] = true;
$ar["name"] = 'Restaurant';
$ar["incount"] = 12;
$arrdata = array();
if(count($dateranginweek)>0){
	foreach($dateranginweek as $kldate=>$vldate){
		$arrx = array();
		$arrx["name"] = dateformat($vldate["monday"]." 00:00:00",'j/m/Y')." - ".dateformat($vldate["sunday"]." 00:00:00",'j/m/Y');
		$arrx["y"] = intval($Row["DW0".$kldate]);
		$arrdata[] = $arrx;
		$datef = new DateTime($vldate["monday"]);
		$weekf = $datef->format("W");
		$RegisterCat[] = "Week ".($weekf);
	}
}
$ar["data"] = $arrdata;
$Register[] = $ar;
$found["dataRestaurant"] = $Register;
$found["dataCat"] = $RegisterCat;
$found["dataSelect"] = dateformat($DRStart." 00:00:00",'j F Y','Thai')." ถึง ".dateformat($DREnd." 00:00:00",'j F Y','Thai');
$AllCountData = intval($Row["CountData"]);
$found["dataRestaurantcountformat"] = number_format($AllCountData);
$found["dataRestauranttext"] = dateformat($DMStart." 00:00:00",'j F Y','Thai')." ถึงปัจจุบัน";
$found["dataRestaurantcount"] = $AllCountData;

$found["dataSum01"] = intval($Row["Sum01"]);
$found["dataSum01Format"] = number_format($Row["Sum01"]);
$found["dataSum02"] = intval($Row["Sum02"]);
$found["dataSum02Format"] = number_format($Row["Sum02"]);
$found["dataSum03"] = intval($Row["Sum03"]);
$found["dataSum03Format"] = number_format($Row["Sum03"]);
$found["dataSum04"] = intval($Row["Sum04"]);
$found["dataSum04Format"] = number_format($Row["Sum04"]);

$found["dataSum01Fix"] = intval($Row["Sum01Fix"]);
$found["dataSum01FixFormat"] = number_format($Row["Sum01Fix"]);
$found["dataSum02Fix"] = intval($Row["Sum02Fix"]);
$found["dataSum02FixFormat"] = number_format($Row["Sum02Fix"]);
$found["dataSum03Fix"] = intval($Row["Sum03Fix"]);
$found["dataSum03FixFormat"] = number_format($Row["Sum03Fix"]);
$found["dataSum04Fix"] = intval($Row["Sum04Fix"]);
$found["dataSum04FixFormat"] = number_format($Row["Sum04Fix"]);

$output = $found;
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
