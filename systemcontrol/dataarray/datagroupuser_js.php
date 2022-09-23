<?php
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "จัดการกลุ่มผู้ใช้งาน";
$Array_Mod_Lang["txt:Detail Head"]["CN"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["JP"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["DE"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["FR"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["ES"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["KR"] = "Manage Group system";
$Array_Mod_Lang["txt:Detail Head"]["AED"] = "Manage Group system";

$Array_Mod_Lang["txt:Head 01"]["EN"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["TH"] = "รายละเอียดกลุ่ม";
$Array_Mod_Lang["txt:Head 01"]["CN"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["JP"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["DE"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["FR"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["ES"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["KR"] = "Group Information";
$Array_Mod_Lang["txt:Head 01"]["AED"] = "Group Information";
$Array_Mod_Lang["txt:Head 02"]["EN"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "ระดับการเข้าถึงข้อมูล";
$Array_Mod_Lang["txt:Head 02"]["CN"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["JP"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["DE"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["FR"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["ES"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["KR"] = "Group Permission";
$Array_Mod_Lang["txt:Head 02"]["AED"] = "Group Permission";

$Array_Mod_Lang["txt:Group Management Name"]["EN"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["TH"] = "ชื่อกลุ่ม";
$Array_Mod_Lang["txt:Group Management Name"]["CN"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["JP"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["DE"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["FR"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["ES"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["KR"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Name"]["AED"] = "Group Management Name";
$Array_Mod_Lang["txt:Group Management Detail"]["EN"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["TH"] = "รายละเอียดกลุ่ม";
$Array_Mod_Lang["txt:Group Management Detail"]["CN"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["JP"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["DE"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["FR"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["ES"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["KR"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Detail"]["AED"] = "Group Management Detail";
$Array_Mod_Lang["txt:Group Management Status"]["EN"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["TH"] = "สถานะ";
$Array_Mod_Lang["txt:Group Management Status"]["CN"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["JP"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["DE"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["FR"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["ES"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["KR"] = "Status";
$Array_Mod_Lang["txt:Group Management Status"]["AED"] = "Status";
$Array_Mod_Lang["txt:Group Management Action"]["EN"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["TH"] = "จัดการ";
$Array_Mod_Lang["txt:Group Management Action"]["CN"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["JP"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["DE"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["FR"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["ES"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["KR"] = "Action";
$Array_Mod_Lang["txt:Group Management Action"]["AED"] = "Action";

$Array_Mod_Lang["txt:Group View"]["EN"] = "View";
$Array_Mod_Lang["txt:Group View"]["TH"] = "ดู";
$Array_Mod_Lang["txt:Group View"]["CN"] = "View";
$Array_Mod_Lang["txt:Group View"]["JP"] = "View";
$Array_Mod_Lang["txt:Group View"]["DE"] = "View";
$Array_Mod_Lang["txt:Group View"]["FR"] = "View";
$Array_Mod_Lang["txt:Group View"]["ES"] = "View";
$Array_Mod_Lang["txt:Group View"]["KR"] = "View";
$Array_Mod_Lang["txt:Group View"]["AED"] = "View";

$Array_Mod_Lang["txt:Group Edit"]["EN"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["TH"] = "แก้ไข";
$Array_Mod_Lang["txt:Group Edit"]["CN"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["JP"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["DE"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["FR"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["ES"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["KR"] = "Edit";
$Array_Mod_Lang["txt:Group Edit"]["AED"] = "Edit";


header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>