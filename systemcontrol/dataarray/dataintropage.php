<?php
$Array_Mod_Lang["txt:Detail Head"]["TH"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["EN"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["CN"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["JP"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["DE"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["FR"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["ES"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["KR"] = "Manage Intro system";
$Array_Mod_Lang["txt:Detail Head"]["AED"] = "Manage Intro system";

$Array_Mod_Lang["txt:Head 01"]["TH"] = "วันที่แสดงผล";
$Array_Mod_Lang["txt:Head 01"]["EN"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["CN"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["JP"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["DE"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["FR"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["ES"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["KR"] = "Intro Date";
$Array_Mod_Lang["txt:Head 01"]["AED"] = "Intro Date";
$Array_Mod_Lang["txt:Head 02"]["TH"] = "รายละเอียด";
$Array_Mod_Lang["txt:Head 02"]["EN"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["CN"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["JP"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["DE"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["FR"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["ES"] = "Intro Information";
$Array_Mod_Lang["txt:Head 02"]["KR"] = "Intro Information";
$Array_Mod_Lang["txt:Head 03"]["TH"] = "เรียงลำดับ";
$Array_Mod_Lang["txt:Head 03"]["EN"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 03"]["CN"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 03"]["JP"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 03"]["DE"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 03"]["FR"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 03"]["ES"] = "Intro Sorting";
$Array_Mod_Lang["txt:Head 03"]["KR"] = "Intro Sorting";

$Array_Mod_Lang["txtinput:inputDesDate"]["TH"] = "วันที่แสดงผล";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txtinput:inputDesDate"]["EN"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["CN"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["JP"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["DE"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["FR"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["ES"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["KR"] = "Show Date";
$Array_Mod_Lang["txtinput:inputDesDate"]["AED"] = "Show Date";
$Array_Mod_Lang["txtinput:inputSubject"]["TH"] = "พาดหัว";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txtinput:inputSubject"]["EN"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["CN"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["JP"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["DE"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["FR"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["ES"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["KR"] = "Header";
$Array_Mod_Lang["txtinput:inputSubject"]["AED"] = "Header";
$Array_Mod_Lang["txtinput:inputURL"]["TH"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["EN"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["CN"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["JP"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["DE"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["FR"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["ES"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["KR"] = "URL";
$Array_Mod_Lang["txtinput:inputURL"]["AED"] = "URL";
$Array_Mod_Lang["txtinput:selectTarget"]["TH"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["EN"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["CN"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["JP"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["DE"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["FR"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["ES"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["KR"] = "Select Target";
$Array_Mod_Lang["txtinput:selectTarget"]["AED"] = "Select Target";
$Array_Mod_Lang["txtinput:inputType"]["TH"] = "ประเภท";
$Array_Mod_Lang["txtinput:inputType"]["EN"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["CN"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["JP"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["DE"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["FR"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["ES"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["KR"] = "Type";
$Array_Mod_Lang["txtinput:inputType"]["AED"] = "Type";

$arrIntroType["P"] = "Picture";
$arrIntroType["E"] = "Embed";
$arrIntroType["L"] = "LinkVideo";
$arrIntroType["H"] = "HTML";


$inmodulekey = array_keys($menuFolder, "intropage");
$pathupload = _RELATIVE_PATH_UPLOAD_;
foreach($inmodulekey as $kModuleKey=>$vModuleKey){
  $LMId = "Admin".$vModuleKey;
  $LMModuleKey = $menuModuleKey[$vModuleKey];
  $arrinkey = array();
  array_push($arrinkey, $LMId, $LMModuleKey);
  $pathuploadmodule = $pathupload."/".$LMModuleKey."/";
  $pathuploadpicture = $pathuploadmodule."intro/";
  $defaultdata[$LMId]["thumb"] = array("P"=>array("thum-120","thum-1024"),"W"=>array(120,1024),"H"=>array(68,580));
  $defaultdata[$LMId]["Dimension"] = array("W"=>1920,"H"=>1080);
  $defaultdata[$LMId]["Type"] = array("F"=>"Images","H"=>"HTML");
  $defaultdata[$LMId]["modulekey"] = $arrinkey;
  $defaultdata[$LMId]["path"] = array("PATH"=>$pathuploadmodule,"PICTURE"=>$pathuploadpicture);
}

?>
