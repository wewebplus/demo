<?php
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "ระบบจัดการ Banner";
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["CN"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["JP"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["DE"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["FR"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["ES"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["KR"] = "Manage HTML system";
$Array_Mod_Lang["txt:Detail Head"]["AED"] = "Manage HTML system";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>
