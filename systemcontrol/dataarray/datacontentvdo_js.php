<?php
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "Manage Content system";
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Detail Head";

$Array_Mod_Lang["txt:Head 01"]["TH"] = "Content Date";
$Array_Mod_Lang["txt:Head 01"]["EN"] = "Content Date";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "Content Information";
$Array_Mod_Lang["txt:Head 02"]["EN"] = "Content Information";
$Array_Mod_Lang["txt:Head 03"]["TH"] = "Content Image Upload & Preview";
$Array_Mod_Lang["txt:Head 03"]["EN"] = "Content Image Upload & Preview";
$Array_Mod_Lang["txt:Head 04"]["TH"] = "Content Image Upload & Preview";
$Array_Mod_Lang["txt:Head 04"]["EN"] = "Content Image Upload & Preview";

$Array_Mod_Lang["txtinput:inputDateTime"]["TH"] = "ระยะเวลาการแสดงผล";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txtinput:inputDateTime"]["EN"] = "ระยะเวลาการแสดงผล";

$Array_Mod_Lang["txtinput:inputSubject"]["TH"] = "พาดหัว";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txtinput:inputSubject"]["EN"] = "Header";
$Array_Mod_Lang["txtinput:inputTitle"]["TH"] = "Title";
$Array_Mod_Lang["txtinput:inputTitle"]["EN"] = "Title";
$Array_Mod_Lang["txtinput:inputDetail"]["TH"] = "รายละเอียด Activity";
$Array_Mod_Lang["txtinput:inputDetail"]["EN"] = "Detail";

$Array_Mod_Lang["txtinput:inputVDOType"]["TH"] = "รูปแบบวีดีโอ";
$Array_Mod_Lang["txtinput:inputVDOType"]["EN"] = "VDOType";

$Array_Mod_Lang["txtinput:VDOTypeE"]["TH"] = "Embed Video";
$Array_Mod_Lang["txtinput:VDOTypeE"]["EN"] = "Embed Video";
$Array_Mod_Lang["txtinput:VDOTypeL"]["TH"] = "Link Video";
$Array_Mod_Lang["txtinput:VDOTypeL"]["EN"] = "Link Video";
$Array_Mod_Lang["txtinput:VDOTypeF"]["TH"] = "File Video";
$Array_Mod_Lang["txtinput:VDOTypeF"]["EN"] = "File Video";

$Array_Mod_Lang["txt:Group"]["EN"] = "Group";
$Array_Mod_Lang["txt:Group"]["TH"] = "กลุ่ม";
$Array_Mod_Lang["txt:Group"]["CN"] = "Group";
$Array_Mod_Lang["txt:Group"]["JP"] = "Group";
$Array_Mod_Lang["txt:Group"]["DE"] = "Group";
$Array_Mod_Lang["txt:Group"]["FR"] = "Group";
$Array_Mod_Lang["txt:Group"]["ES"] = "Group";
$Array_Mod_Lang["txt:Group"]["KR"] = "Group";
$Array_Mod_Lang["txt:Group"]["AED"] = "Group";
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
$Array_Mod_Lang["txt:Count"]["EN"] = "Count";
$Array_Mod_Lang["txt:Count"]["TH"] = "จำนวน";
$Array_Mod_Lang["txt:Count"]["CN"] = "Count";
$Array_Mod_Lang["txt:Count"]["JP"] = "Count";
$Array_Mod_Lang["txt:Count"]["DE"] = "Count";
$Array_Mod_Lang["txt:Count"]["FR"] = "Count";
$Array_Mod_Lang["txt:Count"]["ES"] = "Count";
$Array_Mod_Lang["txt:Count"]["KR"] = "Count";
$Array_Mod_Lang["txt:Count"]["AED"] = "Count";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>
