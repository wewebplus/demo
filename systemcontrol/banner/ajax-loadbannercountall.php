<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

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

$dataArrGroup = $defaultdata[$Login_MenuID]["group"];

$sql = "SELECT GROUP_CONCAT("._TABLE_BANNER_."_ID) AS AllID FROM "._TABLE_BANNER_." WHERE "._TABLE_BANNER_."_Key = '".$Login_MenuID."'";
$z = new __webctrl;
$z->sql($sql);
$vBanner = $z->row();
$AllID = (!empty($vBanner[0]["AllID"])?$vBanner[0]["AllID"]:'0');

$sql = "SELECT "._TABLE_BANNER_."_GroupBanner AS GroupBanner,GROUP_CONCAT("._TABLE_BANNER_."_ID) AS AllID FROM "._TABLE_BANNER_." WHERE "._TABLE_BANNER_."_Key = '".$Login_MenuID."'";
$sql .= " GROUP BY "._TABLE_BANNER_."_GroupBanner";
$z = new __webctrl;
$z->sql($sql);
$vBanner = $z->row();

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
if(count($vBanner)>0){
  foreach($vBanner as $gk=>$gv){
		$arrfmain[] = "TB.Sum".$gv["GroupBanner"];
		$arrfmain[] = "TB.SumFix".$gv["GroupBanner"];
	}
}
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= "(";
	$sql .= "SELECT ";
	$sql .= " COUNT(*) AS CountData";
	$sql .= " ,SUM(IF(DATE("._TABLE_BANNER_LOGS_."_CreateDate) BETWEEN '".$DMStart."' AND '".$DMEnd."', 1, 0)) AS CountDataAll";
	$sql .= " ,SUM(IF(DATE("._TABLE_BANNER_LOGS_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS CountDataFix";
	if(count($dateranginweek)>0){
		foreach($dateranginweek as $kldate=>$vldate){
			$sql .= " ,SUM(IF(DATE("._TABLE_BANNER_LOGS_."_CreateDate) BETWEEN '".$vldate["monday"]."' AND '".$vldate["sunday"]."', 1, 0)) AS DW0".$kldate;
		}
	}
	if(count($vBanner)>0){
		foreach($vBanner as $gk=>$gv){
			$sql .= " ,SUM(IF("._TABLE_BANNER_LOGS_."_BannerID IN (".$gv["AllID"]."), 1, 0)) AS Sum".$gv["GroupBanner"];
			$sql .= " ,SUM(IF("._TABLE_BANNER_LOGS_."_BannerID IN (".$gv["AllID"].") AND DATE("._TABLE_BANNER_LOGS_."_CreateDate) BETWEEN '".$DRStart."' AND '".$DREnd."', 1, 0)) AS SumFix".$gv["GroupBanner"];
		}
	}
	$sql .= " FROM "._TABLE_BANNER_LOGS_." AS p";
	$sql .= " WHERE DATE(p."._TABLE_BANNER_LOGS_."_CreateDate) BETWEEN '".$DMStart."' AND '".$DMEnd."'";
  $sql .= " AND p."._TABLE_BANNER_LOGS_."_BannerID IN (".$AllID.")";
$sql .= ") TB";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$Register = array();
$ar = array();
$ar["visible"] = true;
$ar["name"] = 'Click';
$ar["incolor"] = $GroupSetColor[0];
$ar["incount"] = count($dateranginweek);
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

$foundpie = array();
$index = 0;
if(count($vBanner)>0){
  foreach($vBanner as $gk=>$gv){
		$index++;
		$GID = $gv["GroupBanner"];
    $query = "Key='".$GID."'";
    $mydata = @ArraySearch($dataArrGroup,$query,1);
    $GroupName = $dataArrGroup[array_key_first($mydata)]["Name"];

		$arrpie = array();
		$arrpie["dataName"] = $GroupName;
		$arrpie["dataColor"] = $GroupSetColor[$index];
		$arrpie["dataSum"] = intval($Row["Sum".$GID]);
		$arrpie["dataSumFormat"] = number_format($Row["Sum".$GID]);
		$arrpie["dataSumFix"] = intval($Row["SumFix".$GID]);
		$arrpie["dataSumFixFormat"] = number_format($Row["SumFix".$GID]);
		$foundpie[] = $arrpie;
	}
}
$output = array(
	"status" => "ok",
	"resultline" => $found,
	"resultpie" => $foundpie
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
