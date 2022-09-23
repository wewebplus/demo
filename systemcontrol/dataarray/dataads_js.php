<?php
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Detail Head";

$Array_Mod_Lang["txt:Head 01"]["TH"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["EN"] = "Intro Date";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["EN"] = "Intro Information";
$Array_Mod_Lang["txt:Head 03"]["TH"] = "Intro Image Upload & Preview";
$Array_Mod_Lang["txt:Head 03"]["EN"] = "Intro Image Upload & Preview";
$Array_Mod_Lang["txt:Head 04"]["TH"] = "Intro Comment";
$Array_Mod_Lang["txt:Head 04"]["EN"] = "Intro Comment";
$Array_Mod_Lang["txt:Head 05"]["TH"] = "Intro Gallery";
$Array_Mod_Lang["txt:Head 05"]["EN"] = "Intro Gallery";
$Array_Mod_Lang["txt:Head 06"]["TH"] = "Intro Config";
$Array_Mod_Lang["txt:Head 06"]["EN"] = "Intro Config";
$Array_Mod_Lang["txt:Head 07"]["TH"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 07"]["EN"] = "Intro Sorting";

$Array_Mod_Lang["txt:Tab 01"]["TH"] = "ข้อความภาษาไทย";
$Array_Mod_Lang["txt:Tab 01"]["EN"] = "ข้อความภาษาอังกฤษ";

$Array_Mod_Lang["txtinput:inputSubject"]["TH"] = "ชื่อรายการ";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txtinput:inputSubject"]["EN"] = "Header";
$Array_Mod_Lang["txtinput:inputTitle"]["TH"] = "Title";
$Array_Mod_Lang["txtinput:inputTitle"]["EN"] = "Title";
$Array_Mod_Lang["txtinput:inputDetail"]["TH"] = "รายละเอียด Intro";
$Array_Mod_Lang["txtinput:inputDetail"]["EN"] = "Detail";
$Array_Mod_Lang["txtinput:inputURL"]["TH"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["EN"] = "URL";

$Array_Mod_Lang["txtinput:inputPosition"]["TH"] = "ตำแหน่ง";
$Array_Mod_Lang["txtinput:inputPosition"]["EN"] = "ตำแหน่ง";
$Array_Mod_Lang["txtinput:inputDimension"]["TH"] = "Dimension";
$Array_Mod_Lang["txtinput:inputDimension"]["EN"] = "Dimension";

$Array_Mod_Lang["txtinput:inputType"]["TH"] = "ประเภท";
$Array_Mod_Lang["txtinput:inputType"]["EN"] = "ประเภท";

$Array_Mod_Lang["txt:Subject"]["EN"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["TH"] = "ชื่อรายการ";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txt:Subject"]["CN"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["JP"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["DE"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["FR"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["ES"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["KR"] = "Subject";
$Array_Mod_Lang["txt:Subject"]["AED"] = "Subject";
$Array_Mod_Lang["txt:Date"]["EN"] = "Date";
$Array_Mod_Lang["txt:Date"]["TH"] = "วันที่";
$Array_Mod_Lang["txt:Date"]["CN"] = "Date";
$Array_Mod_Lang["txt:Date"]["JP"] = "Date";
$Array_Mod_Lang["txt:Date"]["DE"] = "Date";
$Array_Mod_Lang["txt:Date"]["FR"] = "Date";
$Array_Mod_Lang["txt:Date"]["ES"] = "Date";
$Array_Mod_Lang["txt:Date"]["KR"] = "Date";
$Array_Mod_Lang["txt:Date"]["AED"] = "Date";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>
