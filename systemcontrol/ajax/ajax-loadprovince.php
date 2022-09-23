<?php
include("../assets/lib/inc.config.php");
$id = trim($_POST['id']);
$chklang = $_SESSION['Session_Admin_Language'];
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "(";
$sql .= "SELECT "._TABLE_ADDRPROVINCE_."_ID AS ID,"._TABLE_ADDRPROVINCE_."_Code AS Code,"._TABLE_ADDRPROVINCE_."_NameThai AS NameThai,"._TABLE_ADDRPROVINCE_."_NameEnglish AS NameEnglish FROM "._TABLE_ADDRPROVINCE_." WHERE 1 ";
$sql .= ") TB";
$sql .= " ORDER BY TB.Name".$chklang." ASC";
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$found = array();
if($chklang=='Thai'){
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "เลือกจังหวัด");
}else{
	$found[] = array( "valueid" => 0,"valuecode" => "","valuesubject" => "Select Province");
}
if($RecordCount>0){
	foreach($v as $Row){
		$found[] = array( "valueid" => $Row["ID"],"valuecode" => $Row["Code"],"valuesubject" => $Row["Name".$chklang]);
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
