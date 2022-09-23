<?php
include("../assets/lib/inc.config.php");
$pid = trim($_POST['pid']);
$chklang = $_SESSION['Session_Admin_Language'];

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "(";
$sql .= "SELECT "._TABLE_ADDRAMPHUR_."_ID AS ID,"._TABLE_ADDRAMPHUR_."_Code AS Code,"._TABLE_ADDRAMPHUR_."_NameThai AS NameThai,"._TABLE_ADDRAMPHUR_."_NameEnglish AS NameEnglish FROM "._TABLE_ADDRAMPHUR_." WHERE 1 ";
if(!empty($pid)){
	$sql .= " AND "._TABLE_ADDRAMPHUR_."_ProvinceCode = '".$pid."'";
}
$sql .= ") TB";
$sql .= " ORDER BY TB.Name".$chklang." ASC";
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$found = array();
if($chklang=='Thai'){
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "เลือกอำเภอ / เขต");
}else{
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "Select Amphur");
}
if(!empty($pid)){
	if($RecordCount>0){
		foreach($v as $Row){
			$Name = str_replace("*","",$Row["Name".$chklang]);
			$found[] = array( "valueid" => $Row["ID"],"valuecode" => $Row["Code"],"valuesubject" => $Name);
		}
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
