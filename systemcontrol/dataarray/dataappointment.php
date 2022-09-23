<?php
$Array_Mod_Lang["txt:Detail Head"]["Thai"] = "Manage Article system";
$Array_Mod_Lang["txt:Detail Head"]["English"] = "Detail Head";

$Array_Mod_Lang["txt:Group Head 01"]["Thai"] = "Contact Group Information";
$Array_Mod_Lang["txt:Group Head 01"]["English"] = "Contact Group Information";
$Array_Mod_Lang["txt:Group Head 02"]["Thai"] = "Contact Group Information";
$Array_Mod_Lang["txt:Group Head 02"]["English"] = "Contact Group Information";

$Array_Mod_Lang["txt:Head 01"]["Thai"] = "Calendar Info";
$Array_Mod_Lang["txt:Head 01"]["English"] = "Calendar Info";
$Array_Mod_Lang["txt:Head 02"]["Thai"] = "Content Image Upload & Preview";
$Array_Mod_Lang["txt:Head 02"]["English"] = "Content Image Upload & Preview";
$Array_Mod_Lang["txt:Head 03"]["Thai"] = "Content Setting";
$Array_Mod_Lang["txt:Head 03"]["English"] = "Content Setting";

$Array_Mod_Lang["txt:Tab 01"]["Thai"] = "ข้อความภาษาไทย";
$Array_Mod_Lang["txt:Tab 01"]["English"] = "ข้อความภาษาอังกฤษ";

$Array_Mod_Lang["txtinput:inputGroupSubject"]["Thai"] = "Appointment Group";
$Array_Mod_Lang["txtinput:inputGroupSubject"]["English"] = "Appointment Group";
$Array_Mod_Lang["txtinput:inputGroupTitle"]["Thai"] = "Title Group";
$Array_Mod_Lang["txtinput:inputGroupTitle"]["English"] = "Title Group";
$Array_Mod_Lang["txtinput:inputGroupEmail"]["Thai"] = "Contact Email To";
$Array_Mod_Lang["txtinput:inputGroupEmail"]["English"] = "Contact Email To";
$Array_Mod_Lang["txtinput:inputGroupColor"]["Thai"] = "Color";
$Array_Mod_Lang["txtinput:inputGroupColor"]["English"] = "Color";

$Array_Mod_Lang["txtinput:inputDesDate"]["Thai"] = "วันที่แสดงผล";//Header ( พาดหัวหลัก )
$Array_Mod_Lang["txtinput:inputDesDate"]["English"] = "วันที่แสดงผล";
$Array_Mod_Lang["txtinput:selectGroup"]["Thai"] = "Appointment";
$Array_Mod_Lang["txtinput:selectGroup"]["English"] = "Appointment";
$Array_Mod_Lang["txtinput:inputSubject"]["Thai"] = "ชื่อเรื่อง";
$Array_Mod_Lang["txtinput:inputSubject"]["English"] = "ชื่อเรื่อง";
$Array_Mod_Lang["txtinput:inputLocation"]["Thai"] = "ที่ตั้ง";
$Array_Mod_Lang["txtinput:inputLocation"]["English"] = "ที่ตั้ง";
$Array_Mod_Lang["txtinput:inputDateStart"]["Thai"] = "ตั้งแต่";
$Array_Mod_Lang["txtinput:inputDateStart"]["English"] = "ตั้งแต่";
$Array_Mod_Lang["txtinput:inputDateEnd"]["Thai"] = "ถึง";
$Array_Mod_Lang["txtinput:inputDateEnd"]["English"] = "ถึง";
$Array_Mod_Lang["txtinput:inputTimeStart"]["Thai"] = "เวลา";
$Array_Mod_Lang["txtinput:inputTimeStart"]["English"] = "เวลา";
$Array_Mod_Lang["txtinput:inputTimeEnd"]["Thai"] = "เวลา";
$Array_Mod_Lang["txtinput:inputTimeEnd"]["English"] = "เวลา";
$Array_Mod_Lang["txtinput:inputDetail"]["Thai"] = "รายละเอียด";
$Array_Mod_Lang["txtinput:inputDetail"]["English"] = "รายละเอียด";

$Array_Mod_Lang["txtinput:OnOffPin"]["Thai"] = "ปิด / เปิด ปักหมุดของเนื้อหา";
$Array_Mod_Lang["txtinput:OnOffPin"]["English"] = "ปิด / เปิด ปักหมุดของเนื้อหา";
$Array_Mod_Lang["txtinput:OnOffPassword"]["Thai"] = "ปิด / เปิด รหัสผ่าน";
$Array_Mod_Lang["txtinput:OnOffPassword"]["English"] = "ปิด / เปิด รหัสผ่าน";

$Array_Mod_Lang["txt:Pin"]["Thai"] = "ปักหมุดของเนื้อหา";
$Array_Mod_Lang["txt:Pin"]["English"] = "ปักหมุดของเนื้อหา";
$Array_Mod_Lang["txt:Password"]["Thai"] = "รหัสผ่าน";
$Array_Mod_Lang["txt:Password"]["English"] = "รหัสผ่าน";

$Array_Mod_Lang["status:On"]["Thai"] = "รอการอนุมัติ";
$Array_Mod_Lang["status:On"]["English"] = "รอการอนุมัติ";
$Array_Mod_Lang["status:Cancel"]["Thai"] = "ยกเลิก";
$Array_Mod_Lang["status:Cancel"]["English"] = "ยกเลิก";
$Array_Mod_Lang["status:Confirm"]["Thai"] = "อนุมัติ";
$Array_Mod_Lang["status:Confirm"]["English"] = "อนุมัติ";

$LangDisable["Thai"] = false;
$LangDisable["English"] = true;

$z = new __webctrl;

$LMId = "Admin27";
$sql = "";
$sqlsub = "";
$arrfmain = array();
$arrfmain[] = "TB.ID";
$arrfmain[] = "TB.Subject".$_SESSION['Session_Admin_Language']." AS Name";
$arrfmain[] = "TB.Color AS Color";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_APPOINTMENT_GROUP_.'_ID AS ID';
	$arrf[] = "a."._TABLE_APPOINTMENT_GROUP_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_APPOINTMENT_GROUP_.'_Order AS ListOrder';
	$arrf[] = "a."._TABLE_APPOINTMENT_GROUP_.'_Color AS Color';
	$sqlsub .= "a.*";
	foreach($systemLang as $lkey=>$lval){
		$arrf[] = $lkey."."._TABLE_APPOINTMENT_GROUP_DETAIL_."_ID AS SubjectID".$lkey;
		$arrf[] = $lkey."."._TABLE_APPOINTMENT_GROUP_DETAIL_."_Subject AS Subject".$lkey;
		$arrf[] = $lkey."."._TABLE_APPOINTMENT_GROUP_DETAIL_."_Email AS Email".$lkey;
		$arrf[] = $lkey."."._TABLE_APPOINTMENT_GROUP_DETAIL_."_Status AS Status".$lkey;
	}
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_APPOINTMENT_GROUP_." a";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_APPOINTMENT_GROUP_DETAIL_." ".$lkey." ON (a."._TABLE_APPOINTMENT_GROUP_."_ID = ".$lkey."."._TABLE_APPOINTMENT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_APPOINTMENT_GROUP_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE a."._TABLE_APPOINTMENT_GROUP_."_Key='".$LMId."'";
	unset($arrf);
$sql .= ") TB";
$sql .= " WHERE 1";
$sql .= " ORDER BY TB.ListOrder DESC";
$z->sql($sql);
$RecordCount = $z->num();
$arrGroup = array();
if($RecordCount>0){
  $v = $z->row();
  foreach($v as $Row){
    $arr = array();
    $arr["ID"] = $Row["ID"];
    $arr["Name"] = $Row["Name"];
		$arr["Color"] = $Row["Color"];
    $arrGroup[] = $arr;
  }
}
$defaultdata[$LMId]["group"] = $arrGroup;//array('A'=>'กิจกรรม','B'=>'กองทุน');
$defaultdata[$LMId]["filetype"] = ".pdf,.doc,.xls,.ppt,.docx,.xlsx,.pptx,.zip,.jpg,.png";
$defaultdata[$LMId]["fileupload"] = "index-uploaddocument.php";
$defaultdata[$LMId]["thumb"] = array("P"=>array("a","b"),"W"=>array(800,400),"H"=>array(600,300),"aspectRatio"=>4/3);
?>
