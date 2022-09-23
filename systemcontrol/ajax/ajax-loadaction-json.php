<?php
include("../assets/lib/inc.config.php");
$LoginData = decode_URL($_POST["LoginData"]);
$type = (empty($_POST["type"])?"":$_POST["type"]);

$newLoginData = encode_URL('Login_MenuID='.$Login_MenuID.'&actionpage='.$actionpage.'&actiontype='.$type);

$output = array();

$output["valuelogindata"] = $newLoginData;

CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
