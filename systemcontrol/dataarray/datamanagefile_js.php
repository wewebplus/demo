<?php
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "จัดการเอกสาร";
$Array_Mod_Lang["txt:Detail Head"]["CN"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["JP"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["DE"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["FR"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["ES"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["KR"] = "Manage Stock Files";
$Array_Mod_Lang["txt:Detail Head"]["AED"] = "Manage Stock Files";

$Array_Mod_Lang["txt:Head 01"]["EN"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["TH"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["CN"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["JP"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["DE"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["FR"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["ES"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["KR"] = "List Images";
$Array_Mod_Lang["txt:Head 01"]["AED"] = "List Images";

$Array_Mod_Lang["txt:Head 02"]["EN"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["CN"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["JP"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["DE"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["FR"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["ES"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["KR"] = "Uploader";
$Array_Mod_Lang["txt:Head 02"]["AED"] = "Uploader";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";

?>
