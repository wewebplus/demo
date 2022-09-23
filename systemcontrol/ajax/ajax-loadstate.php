<?php
include("../assets/lib/inc.config.php");
$country = trim($_POST['indata']);
$chklang = $_SESSION['Session_Admin_Language'];
$arrf = array();
$arrf[] = _TABLE_ADDRSTATE_."_CountryID AS CountryID";
$arrf[] = _TABLE_ADDRSTATE_."_StateID AS StateID";
$arrf[] = _TABLE_ADDRSTATE_."_NameEN AS StateName";
$arrf[] = _TABLE_ADDRSTATE_."_Code AS StateCode";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSTATE_." WHERE 1";
$sql .= " AND "._TABLE_ADDRSTATE_."_CountryID = ".(int)$country;
$sql .= " ORDER BY "._TABLE_ADDRSTATE_."_NameEN ASC";
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$found = array();
if($chklang=='TH'){
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "เลือกจังหวัด");
}else{
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "Select State/Province");
}
if($RecordCount>0){
	foreach($v as $Row){
		$arr = array();
		$arr["valueid"] = $Row["StateID"];
		$arr["valuecode"] = $Row["StateCode"];
		$arr["valuesubject"] = $Row["StateName"];
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
