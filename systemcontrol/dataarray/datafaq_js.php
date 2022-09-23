<?php
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "Manage Contact system";
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Detail Head";

$Array_Mod_Lang["txt:Head 01"]["TH"] = "Contact Date";
$Array_Mod_Lang["txt:Head 01"]["EN"] = "Contact Date";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "Contact Information";
$Array_Mod_Lang["txt:Head 02"]["EN"] = "Contact Information";

$Array_Mod_Lang["txt:Group Head 01"]["TH"] = "Contact Group Information";
$Array_Mod_Lang["txt:Group Head 01"]["EN"] = "Contact Group Information";

$Array_Mod_Lang["txtinput:inputGroupSubject"]["TH"] = "Subject Contact Group";
$Array_Mod_Lang["txtinput:inputGroupSubject"]["EN"] = "Subject Contact Group";
$Array_Mod_Lang["txtinput:inputGroupTitle"]["TH"] = "Title Contact Group";
$Array_Mod_Lang["txtinput:inputGroupTitle"]["EN"] = "Title Contact Group";
$Array_Mod_Lang["txtinput:inputGroupEmail"]["TH"] = "Contact Email To";
$Array_Mod_Lang["txtinput:inputGroupEmail"]["EN"] = "Contact Email To";

$Array_Mod_Lang["txtinput:inputContactDate"]["TH"] = "Contact Date";
$Array_Mod_Lang["txtinput:inputContactDate"]["EN"] = "Contact Date";
$Array_Mod_Lang["txtinput:inputContactName"]["TH"] = "Contact Name";
$Array_Mod_Lang["txtinput:inputContactName"]["EN"] = "Contact Name";
$Array_Mod_Lang["txtinput:inputContactEmail"]["TH"] = "Contact Email";
$Array_Mod_Lang["txtinput:inputContactEmail"]["EN"] = "Contact Email";
$Array_Mod_Lang["txtinput:inputContactTel"]["TH"] = "Contact Tel";
$Array_Mod_Lang["txtinput:inputContactTel"]["EN"] = "Contact Tel";
$Array_Mod_Lang["txtinput:inputContactMessage"]["TH"] = "Contact Message";
$Array_Mod_Lang["txtinput:inputContactMessage"]["EN"] = "Contact Message";
$Array_Mod_Lang["txtinput:inputContactMessageReply"]["TH"] = "Contact Message Reply";
$Array_Mod_Lang["txtinput:inputContactMessageReply"]["EN"] = "Contact Message Reply";

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


header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>
