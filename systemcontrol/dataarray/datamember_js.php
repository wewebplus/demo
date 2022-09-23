<?php
$Array_Mod_Lang["txt:Detail Head"]["Thai"] = "Manage Member system";
$Array_Mod_Lang["txt:Detail Head"]["English"] = "Detail Head";

$Array_Mod_Lang["txt:Head 01"]["Thai"] = "Member Info";
$Array_Mod_Lang["txt:Head 01"]["English"] = "Member Info";
$Array_Mod_Lang["txt:Head 02"]["Thai"] = "Member Address";
$Array_Mod_Lang["txt:Head 02"]["English"] = "Member Address";
$Array_Mod_Lang["txt:Head 03"]["Thai"] = "Member Map";
$Array_Mod_Lang["txt:Head 03"]["English"] = "Member Map";
$Array_Mod_Lang["txt:Head 04"]["Thai"] = "Member Picture";
$Array_Mod_Lang["txt:Head 04"]["English"] = "Member Picture";
$Array_Mod_Lang["txt:Head 05"]["Thai"] = "รายการ เงินเดือน";
$Array_Mod_Lang["txt:Head 05"]["English"] = "Member Salary";
$Array_Mod_Lang["txt:Head 06"]["Thai"] = "รายการ slip เงินเดือน";
$Array_Mod_Lang["txt:Head 06"]["English"] = "Member Salary";
$Array_Mod_Lang["txt:Head 07"]["Thai"] = "รายการ เครื่องราชอิสริยาภรณ์";
$Array_Mod_Lang["txt:Head 07"]["English"] = "Member Salary";

$Array_Mod_Lang["txtinput:inputName"]["Thai"] = "ชื่อสมาชิก";
$Array_Mod_Lang["txtinput:inputName"]["English"] = "ชื่อสมาชิก";
$Array_Mod_Lang["txtinput:inputAName"]["Thai"] = "คำนำหน้า";
$Array_Mod_Lang["txtinput:inputAName"]["English"] = "คำนำหน้า";
$Array_Mod_Lang["txtinput:inputFName"]["Thai"] = "ชื่อสมาชิก";
$Array_Mod_Lang["txtinput:inputFName"]["English"] = "ชื่อสมาชิก";
$Array_Mod_Lang["txtinput:inputLName"]["Thai"] = "นามสกุล";
$Array_Mod_Lang["txtinput:inputLName"]["English"] = "นามสกุล";
$Array_Mod_Lang["txtinput:inputRefNo"]["Thai"] = "หมายเลขบัตรประชาชน";
$Array_Mod_Lang["txtinput:inputRefNo"]["English"] = "หมายเลขบัตรประชาชน";
$Array_Mod_Lang["txtinput:inputEmail"]["Thai"] = "Email";
$Array_Mod_Lang["txtinput:inputEmail"]["English"] = "Email";
$Array_Mod_Lang["txtinput:inputUsername"]["Thai"] = "Username";
$Array_Mod_Lang["txtinput:inputUsername"]["English"] = "Username";
$Array_Mod_Lang["txtinput:inputPassword"]["Thai"] = "รหัสผ่าน";
$Array_Mod_Lang["txtinput:inputPassword"]["English"] = "รหัสผ่าน";
$Array_Mod_Lang["txtinput:inputConfirmPassword"]["Thai"] = "ยืนยันรหัสผ่าน";
$Array_Mod_Lang["txtinput:inputConfirmPassword"]["English"] = "ยืนยันรหัสผ่าน";
$Array_Mod_Lang["txtinput:inputTelephone"]["Thai"] = "Tel";
$Array_Mod_Lang["txtinput:inputTelephone"]["English"] = "Tel";
$Array_Mod_Lang["txtinput:inputTelephone2"]["Thai"] = "Tel";
$Array_Mod_Lang["txtinput:inputTelephone2"]["English"] = "Tel";
$Array_Mod_Lang["txtinput:inputFax"]["Thai"] = "Fax";
$Array_Mod_Lang["txtinput:inputFax"]["English"] = "Fax";
$Array_Mod_Lang["txtinput:inputPosition"]["Thai"] = "ตำแหน่ง";
$Array_Mod_Lang["txtinput:inputPosition"]["English"] = "Position";
$Array_Mod_Lang["txtinput:inputGender"]["Thai"] = "เพศ";
$Array_Mod_Lang["txtinput:inputGender"]["English"] = "Gender";
$Array_Mod_Lang["txtinput:inputBirthday"]["Thai"] = "วันเกิด";
$Array_Mod_Lang["txtinput:inputBirthday"]["English"] = "วันเกิด";

$Array_Mod_Lang["txtinput:inputCompany"]["Thai"] = "บริษัท / ร้าน";
$Array_Mod_Lang["txtinput:inputCompany"]["English"] = "บริษัท / ร้าน";
$Array_Mod_Lang["txtinput:inputBuildingCode"]["Thai"] = "เลขที่";
$Array_Mod_Lang["txtinput:inputBuildingCode"]["English"] = "เลขที่";
$Array_Mod_Lang["txtinput:inputRoad"]["Thai"] = "ถนน";
$Array_Mod_Lang["txtinput:inputRoad"]["English"] = "ถนน";
$Array_Mod_Lang["txtinput:inputSubDistrict"]["Thai"] = "แขวง / ตำบล";
$Array_Mod_Lang["txtinput:inputSubDistrict"]["English"] = "แขวง / ตำบล";
$Array_Mod_Lang["txtinput:inputDistrict"]["Thai"] = "เขต / อำเภอ";
$Array_Mod_Lang["txtinput:inputDistrict"]["English"] = "เขต / อำเภอ";
$Array_Mod_Lang["txtinput:inputProvince"]["Thai"] = "จังหวัด";
$Array_Mod_Lang["txtinput:inputProvince"]["English"] = "จังหวัด";
$Array_Mod_Lang["txtinput:inputZipCode"]["Thai"] = "รหัสไปรษณีย์";
$Array_Mod_Lang["txtinput:inputZipCode"]["English"] = "รหัสไปรษณีย์";

$Array_Mod_Lang["txtinput:inputLatLng"]["Thai"] = "Lat,Lng";
$Array_Mod_Lang["txtinput:inputLatLng"]["English"] = "Lat,Lng";
$Array_Mod_Lang["txtinput:inputmyMap"]["Thai"] = "Google Map";
$Array_Mod_Lang["txtinput:inputmyMap"]["English"] = "Google Map";

$Array_Mod_Lang["txtinput:inputLevel"]["Thai"] = "ระดับสมาชิก";
$Array_Mod_Lang["txtinput:inputLevel"]["English"] = "ระดับสมาชิก";

$Array_Mod_Lang["txtinput:inputMainType"]["Thai"] = "ประเภทผู้ใช้งาน";
$Array_Mod_Lang["txtinput:inputMainType"]["English"] = "ประเภทผู้ใช้งาน";
$Array_Mod_Lang["txtinput:inputSalarySlip"]["Thai"] = "สลิปเงินเดือน";
$Array_Mod_Lang["txtinput:inputSalarySlip"]["English"] = "สลิปเงินเดือน";

header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";

?>
