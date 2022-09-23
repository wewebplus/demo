<?php
include("../assets/lib/inc.config.php");
$did = trim($_POST['did']);

$sql = "SELECT "._TABLE_ADDRDISTRICTS_."_Zipcode AS Zipcode FROM "._TABLE_ADDRDISTRICTS_." WHERE 1 ";
$sql .= " AND "._TABLE_ADDRDISTRICTS_."_Code = '".$did."'";
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$Row = $v[0];

$output = array(
	"status" => "ok",
	"resultZipcode" => $Row["Zipcode"]
);
CloseDB();
echo json_encode($output);
exit();
?>
