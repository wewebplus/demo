<?php
$Array_Mod_Lang["txt:Select User Type"]["EN"] = "Select User Type";
$Array_Mod_Lang["txt:Select User Type"]["TH"] = "เลือกประเภทผู้ใช้งาน";

$Array_Mod_Lang["txt:Select User Level"]["EN"] = "Select User Level";
$Array_Mod_Lang["txt:Select User Level"]["TH"] = "เลือกระดับผู้ใช้งาน";

$Array_Mod_Lang["txt:Select Employee"]["EN"] = "Select Employee";
$Array_Mod_Lang["txt:Select Employee"]["TH"] = "เลือกผู้ใช้งาน";

$Array_Mod_Lang["txt:Note"]["EN"] = "Note";
$Array_Mod_Lang["txt:Note"]["TH"] = "Note";

$Array_Mod_Lang["txt:UserName"]["EN"] = "User Name";
$Array_Mod_Lang["txt:UserName"]["TH"] = "ชื่อผู้ใช้งาน";
$Array_Mod_Lang["txt:fullname"]["EN"] = "Fullname";
$Array_Mod_Lang["txt:fullname"]["TH"] = "ชื่อ - นามสกุล";
$Array_Mod_Lang["txt:User Type"]["EN"] = "User Type";
$Array_Mod_Lang["txt:User Type"]["TH"] = "ประเภทผู้ใช้งาน";
$Array_Mod_Lang["txt:User Level"]["EN"] = "User Level";
$Array_Mod_Lang["txt:User Level"]["TH"] = "ระดับผู้ใช้งาน";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";

?>
