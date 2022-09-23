<?php
$Array_Mod_Lang["txt:Detail Head"]["Thai"] = "Manage Contact system";
$Array_Mod_Lang["txt:Detail Head"]["English"] = "Detail Head";

$Array_Mod_Lang["txt:Group Head 01"]["Thai"] = "Group Information";
$Array_Mod_Lang["txt:Group Head 01"]["English"] = "Group Information";

$Array_Mod_Lang["txt:Tab 01"]["Thai"] = "ข้อความภาษาไทย";
$Array_Mod_Lang["txt:Tab 01"]["English"] = "ข้อความภาษาอังกฤษ";

$Array_Mod_Lang["txtinput:inputGroupSubject"]["Thai"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputGroupSubject"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputShotGroupSubject"]["Thai"] = "Shot Subject";
$Array_Mod_Lang["txtinput:inputShotGroupSubject"]["English"] = " Shot Subject";

$Array_Mod_Lang["txtinput:inputDocSubject"]["Thai"] = "ชื่อเอกสาร";
$Array_Mod_Lang["txtinput:inputDocSubject"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputFileSubject"]["Thai"] = "ไฟล์แนบ";
$Array_Mod_Lang["txtinput:inputFileSubject"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputDetail"]["Thai"] = "รายละเอียด";
$Array_Mod_Lang["txtinput:inputDetail"]["English"] = "Subject Group";

$Array_Mod_Lang["txtinput:inputName"]["Thai"] = "ชื่ออีเมล์";
$Array_Mod_Lang["txtinput:inputName"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputEmail"]["Thai"] = "อีเมล์";
$Array_Mod_Lang["txtinput:inputEmail"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputGroupName"]["Thai"] = "ชื่อกลุ่ม";
$Array_Mod_Lang["txtinput:inputGroupName"]["English"] = "Subject Group";

$Array_Mod_Lang["txtinput:inputTaskName"]["Thai"] = "ชื่องาน";
$Array_Mod_Lang["txtinput:inputTaskName"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputTaskNameList"]["Thai"] = "รายการอีเมล์";
$Array_Mod_Lang["txtinput:inputTaskNameList"]["English"] = "Subject Group";
$Array_Mod_Lang["txtinput:inputTaskDate"]["Thai"] = "วันที่ส่ง";
$Array_Mod_Lang["txtinput:inputTaskDate"]["English"] = "Subject Group";

$arrinStatusContactBtnClass["Thai"]["New"] = "btn-info";
$arrinStatusContactBtnClass["Thai"]["Read"] = "btn-alert";
$arrinStatusContactBtnClass["English"]["New"] = "btn-info";
$arrinStatusContactBtnClass["English"]["Read"] = "btn-alert";

$arrinContactStatus["Thai"]["New"] = "มาใหม่";
$arrinContactStatus["Thai"]["Read"] = "อ่านแล้ว";

$arrinContactStatus["English"]["New"] = "Enable";
$arrinContactStatus["English"]["Read"] = "Disable";

$inmodulekey = array_keys($menuFolder, "enew");
$LMModuleKey = $menuFolderModule[22];
$LMId = "Admin31";
$pathupload = _RELATIVE_PATH_UPLOAD_;
$arrinkey = array();
array_push($arrinkey, $LMId, $LMModuleKey);
$pathuploadmodule = $pathupload."/".$LMModuleKey."/";
$pathuploadhtml = $pathuploadmodule."content_htmlfile/";
$pathuploadfile = $pathuploadmodule."file_attach/";

$defaultdata[$LMId]["imghome"] = array("W"=>750,"H"=>270,"aspectRatio"=>16/5);
$defaultdata[$LMId]["img"] = array("W"=>230,"H"=>173,"aspectRatio"=>4/3);
$defaultdata[$LMId]["thumb"] = array("P"=>array("a","b"),"W"=>array(900,230),"H"=>array(677,173));
$defaultdata[$LMId]["gallery"] = array("W"=>900,"H"=>677);
$defaultdata[$LMId]["group"] = array();
$defaultdata[$LMId]["allmodulekey"] = $arrinkey;
$defaultdata[$LMId]["modulekey"] = $LMModuleKey;
$defaultdata[$LMId]["path"] = array("PATH"=>$pathuploadmodule,"HTML"=>$pathuploadhtml,"FILE"=>$pathuploadfile);

// $defaultdata["Admin20"]["group"] = array("menuid"=>"Admin21");

$defaultdata["Admin23"]["group"] = array("menuid"=>"Admin32","menudoc"=>"Admin33");
$defaultdata["Admin23"]["allmodulekey"] = $arrinkey;
$defaultdata["Admin23"]["modulekey"] = $LMModuleKey;
$defaultdata["Admin23"]["path"] = array("PATH"=>$pathuploadmodule,"HTML"=>$pathuploadhtml,"FILE"=>$pathuploadfile);


$LMModuleKey = $menuFolderModule[20];
$LMId = "Admin20";
$sql = "";
$sql .= "SELECT "._TABLE_MAIL_GROUP_."_ID AS ID,"._TABLE_MAIL_GROUP_."_GroupName AS Name FROM "._TABLE_MAIL_GROUP_;
$sql .= " WHERE "._TABLE_MAIL_GROUP_."_Folder = '".$LMModuleKey."'";
$sql .= " AND "._TABLE_MAIL_GROUP_."_Status = 'On'";
$sql .= " ORDER BY "._TABLE_MAIL_GROUP_."_Order DESC";
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$arrGroup = array();
if($RecordCount>0){
  $v = $z->row();
  foreach($v as $Row){
    $arr = array();
    $arr["ID"] = $Row["ID"];
    $arr["Name"] = $Row["Name"];
    $arrGroup[] = $arr;
  }
}
$arrinkey = array();
array_push($arrinkey, $LMId, $LMModuleKey);
$pathuploadmodule = $pathupload."/".$LMModuleKey."/";
$pathuploadhtml = $pathuploadmodule."content_htmlfile/";
$pathuploadfile = $pathuploadmodule."file_attach/";
$defaultdata[$LMId]["group"] = $arrGroup;
$defaultdata[$LMId]["allmodulekey"] = $arrinkey;
$defaultdata[$LMId]["modulekey"] = $LMModuleKey;
$defaultdata[$LMId]["path"] = array("PATH"=>$pathuploadmodule,"HTML"=>$pathuploadhtml,"FILE"=>$pathuploadfile);

// foreach($inmodulekey as $kModuleKey=>$vModuleKey){
//   $LMId = "Admin".$vModuleKey;
//   $LMModuleKey = $menuFolderModule[$vModuleKey];
//   // echo $LMId;
// }

$LangDisable["Thai"] = false;
$LangDisable["English"] = true;

$arrMemberType["Addnew"] = "เพิ่มจากสมุดรายชื่อ";
$arrMemberType["Dealer"] = "Dealer";
$arrMemberType["Member"] = "Member";
$arrMemberType["Sale"] = "Sale";

?>
