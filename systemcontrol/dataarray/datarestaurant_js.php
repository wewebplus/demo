<?php
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "Manage Contact system";
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Detail Head";

$Array_Mod_Lang["txt:Head 01"]["TH"] = "Contact Date";
$Array_Mod_Lang["txt:Head 01"]["EN"] = "Contact Date";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "Contact Information";
$Array_Mod_Lang["txt:Head 02"]["EN"] = "Contact Information";

$Array_Mod_Lang["txt:Group"]["EN"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["TH"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["CN"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["JP"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["DE"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["FR"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["ES"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["KR"] = "Thai SELECT type";
$Array_Mod_Lang["txt:Group"]["AED"] = "Thai SELECT type";

$Array_Mod_Lang["txt:CreateDate"]["EN"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["TH"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["CN"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["JP"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["DE"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["FR"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["ES"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["KR"] = "CreateDate";
$Array_Mod_Lang["txt:CreateDate"]["AED"] = "CreateDate";

$Array_Mod_Lang["txt:No"]["EN"] = "No.";
$Array_Mod_Lang["txt:No"]["TH"] = "เลขที่";
$Array_Mod_Lang["txt:No"]["CN"] = "No.";
$Array_Mod_Lang["txt:No"]["JP"] = "No.";
$Array_Mod_Lang["txt:No"]["DE"] = "No.";
$Array_Mod_Lang["txt:No"]["FR"] = "No.";
$Array_Mod_Lang["txt:No"]["ES"] = "No.";
$Array_Mod_Lang["txt:No"]["KR"] = "No.";
$Array_Mod_Lang["txt:No"]["AED"] = "No.";
$Array_Mod_Lang["txt:Country"]["EN"] = "Country";
$Array_Mod_Lang["txt:Country"]["TH"] = "Country";
$Array_Mod_Lang["txt:Country"]["CN"] = "Country";
$Array_Mod_Lang["txt:Country"]["JP"] = "Country";
$Array_Mod_Lang["txt:Country"]["DE"] = "Country";
$Array_Mod_Lang["txt:Country"]["FR"] = "Country";
$Array_Mod_Lang["txt:Country"]["ES"] = "Country";
$Array_Mod_Lang["txt:Country"]["KR"] = "Country";
$Array_Mod_Lang["txt:Country"]["AED"] = "Country";
$Array_Mod_Lang["txt:Subject"]["EN"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["TH"] = "ชื่อรายการ";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txt:Subject"]["CN"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["JP"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["DE"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["FR"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["ES"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["KR"] = "Subject";
$Array_Mod_Lang["txt:Branch"]["EN"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["TH"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["CN"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["JP"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["DE"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["FR"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["ES"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["KR"] = "Branch";
$Array_Mod_Lang["txt:Branch"]["AED"] = "Branch";
$Array_Mod_Lang["txt:Member"]["EN"] = "Member";
$Array_Mod_Lang["txt:Member"]["TH"] = "Member";
$Array_Mod_Lang["txt:Member"]["CN"] = "Member";
$Array_Mod_Lang["txt:Member"]["JP"] = "Member";
$Array_Mod_Lang["txt:Member"]["DE"] = "Member";
$Array_Mod_Lang["txt:Member"]["FR"] = "Member";
$Array_Mod_Lang["txt:Member"]["ES"] = "Member";
$Array_Mod_Lang["txt:Member"]["KR"] = "Member";
$Array_Mod_Lang["txt:Member"]["AED"] = "Member";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>
