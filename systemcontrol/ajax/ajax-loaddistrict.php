<?php
include("../assets/lib/inc.config.php");
$country = trim($_POST['country']);
if(is_array($_POST['state'])){
	$state = (!empty($_POST['state'])?$_POST['state']:array());
}else{
	$state = array();
	array_push($state,$_POST['state']);
}
$chklang = $_SESSION['Session_Admin_Language'];
$arrf = array();
$arrf[] = _TABLE_ADDRDISTRICT_."_CountryID AS CountryID";
$arrf[] = _TABLE_ADDRDISTRICT_."_StatesID AS StateID";
$arrf[] = _TABLE_ADDRDISTRICT_."_DistrictID AS DistrictID";
$arrf[] = _TABLE_ADDRDISTRICT_."_NameEN AS DistrictName";
$arrf[] = _TABLE_ADDRDISTRICT_."_Code AS DistrictCode";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRDISTRICT_." WHERE 1";
$sql .= " AND "._TABLE_ADDRDISTRICT_."_CountryID = ".(int)$country;
$sql .= " ORDER BY "._TABLE_ADDRDISTRICT_."_NameEN ASC";
if(count($state)>0){
	$sql .= " AND ";
	$sql .= "(";
		foreach($state as $kstate=>$rstate){
			if($kstate>0){
				$sql .= " OR ";
			}
			$sql .= _TABLE_ADDRDISTRICT_."_StatesID = ".(int)$rstate;
		}
	$sql .= ")";
}
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$found = array();
if($chklang=='TH'){
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "เลือก เขต / อำเภอ");
}else{
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "Select District");
}
if($RecordCount>0){
	foreach($v as $Row){
		$arr = array();
		$arr["valueid"] = $Row["DistrictID"];
		$arr["CountryID"] = $Row["CountryID"];
		$arr["StateID"] = $Row["StateID"];
		$arr["Code"] = $Row["DistrictCode"];
		$arr["valuesubject"] = $Row["DistrictName"];
		$found[] = $arr;
	}
}
$output = array(
	"status" => "ok",
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
