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

$inmodulekey = array_keys($menuFolder, "about");
$pathupload = _RELATIVE_PATH_UPLOAD_."/";
foreach($inmodulekey as $kModuleKey=>$vModuleKey){
  $LMId = "Admin".$vModuleKey;
  $LMModuleKey = $menuModuleKey[$vModuleKey];
  $dataGroupMathching[$LMId] = $LMModuleKey;
  $arrinkey = array();
  array_push($arrinkey, $LMId, $LMModuleKey);
  $arrOption = $menuOption[$vModuleKey];
  $pathuploadmodule = $pathupload.$LMModuleKey."/";
  $pathuploadhtml = $pathuploadmodule."content_htmlfile/";
  $defaultdata[$LMId]["modulekey"] = $arrinkey;
  $defaultdata[$LMId]["option"] = $arrOption;
  $defaultdata[$LMId]["path"] = array("PATH"=>$pathuploadmodule,"HTML"=>$pathuploadhtml);
}
?>
