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

$DMStart = date('Y-m-d',mktime(0,0,0,1,1,2011));
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
$arrfmain[] = "TB.Sum05";
$arrfmain[] = "TB.SumOther";
$arrfmain[] = "TB.Sum01Fix";
$arrfmain[] = "TB.Sum02Fix";
$arrfmain[] = "TB.Sum03Fix";
$arrfmain[] = "TB.Sum04Fix";
$arrfmain[] = "TB.Sum05Fix";
$arrfmain[] = "TB.SumOtherFix";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= "(";
	$sql .= "SELECT ";
	$sql .= " COUNT(*) AS CountData";
	$sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DMStart."' AND '".$DMEnd."', 1, 0)) AS CountDataAll";
	$sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS CountDataFix";
	if(count($dateranginweek)>0){
		foreach($dateranginweek as $kldate=>$vldate){
			$sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$vldate["monday"]."' AND '".$vldate["sunday"]."', 1, 0)) AS DW0".$kldate;
		}
	}
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '0', 1, 0)) AS SumOther";
  $sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '1', 1, 0)) AS Sum01";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '2', 1, 0)) AS Sum02";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '3', 1, 0)) AS Sum03";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '4', 1, 0)) AS Sum04";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '5', 1, 0)) AS Sum05";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '0' AND DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS SumOtherFix";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '1' AND DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum01Fix";
  $sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '2' AND DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum02Fix";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '3' AND DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum03Fix";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '4' AND DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum04Fix";
	$sql .= " ,SUM(IF("._TABLE_MEMBER_."_Member = '5' AND DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS Sum05Fix";
	$sql .= " FROM "._TABLE_MEMBER_." AS p";
	$sql .= " WHERE DATE(p."._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DMStart."' AND '".$DMEnd."'";
$sql .= ") TB";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$Register = array();
$ar = array();
$ar["visible"] = true;
$ar["name"] = 'Register';
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
$found["dataRegister"] = $Register;
$found["dataRegisterCat"] = $RegisterCat;
$found["dataRegisterSelect"] = dateformat($DRStart." 00:00:00",'j F Y','Thai')." ถึง ".dateformat($DREnd." 00:00:00",'j F Y','Thai');

$AllCountData = intval($Row["CountData"]);

$found["dataregistercountformat"] = number_format($AllCountData);
$found["dataregistertext"] = dateformat($DMStart." 00:00:00",'j F Y','Thai')." ถึงปัจจุบัน";
$found["dataregistercount"] = $AllCountData;
$found["dataregister"] = $foundinner;

$found["dataSum01"] = intval($Row["Sum01"]);
$found["dataSum01Format"] = number_format($Row["Sum01"]);
$found["dataSum02"] = intval($Row["Sum02"]);
$found["dataSum02Format"] = number_format($Row["Sum02"]);
$found["dataSum03"] = intval($Row["Sum03"]);
$found["dataSum03Format"] = number_format($Row["Sum03"]);
$found["dataSum04"] = intval($Row["Sum04"]);
$found["dataSum04Format"] = number_format($Row["Sum04"]);
$found["dataSum05"] = intval($Row["Sum05"]);
$found["dataSum05Format"] = number_format($Row["Sum05"]);
// $indataSumOther = intval($Row["CountData"])-(intval($Row["Sum01"])+intval($Row["Sum02"])+intval($Row["Sum03"])+intval($Row["Sum04"])+intval($Row["Sum05"]));
$found["dataSumOther"] = intval($Row["SumOther"]);
$found["dataSumOtherFormat"] = number_format($Row["SumOther"]);

$found["dataSum01Fix"] = intval($Row["Sum01Fix"]);
$found["dataSum01FixFormat"] = number_format($Row["Sum01Fix"]);
$found["dataSum02Fix"] = intval($Row["Sum02Fix"]);
$found["dataSum02FixFormat"] = number_format($Row["Sum02Fix"]);
$found["dataSum03Fix"] = intval($Row["Sum03Fix"]);
$found["dataSum03FixFormat"] = number_format($Row["Sum03Fix"]);
$found["dataSum04Fix"] = intval($Row["Sum04Fix"]);
$found["dataSum04FixFormat"] = number_format($Row["Sum04Fix"]);
$found["dataSum05Fix"] = intval($Row["Sum05Fix"]);
$found["dataSum05FixFormat"] = number_format($Row["Sum05Fix"]);
$found["dataSumOtherFix"] = intval($Row["SumOtherFix"]);
$found["dataSumOtherFixFormat"] = number_format($Row["SumOtherFix"]);
$output = $found;
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
