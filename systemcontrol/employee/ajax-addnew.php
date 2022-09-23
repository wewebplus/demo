<?php
include("../assets/lib/inc.config.php");
$inputFName = $_POST["firstname"];
$inputLName = $_POST["lastname"];
$inputEmail = $_POST["useremail"];
$inputTelephone = $_POST["telephone"];
$inputRemark = encodetxterea($_POST["Emp_note"]);
$selectInType = $_POST["selectInType"];
$myrand = md5(rand(11111,99999));
$PathUpload = _RELATIVE_EMPLOYEE_UPLOAD_;
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$txtfilesrcname = "";
$outputtempimg = "";
$phyFilePicture = "";
switch($selectInType){
  case 'Thaiselect':
    $InPreFix = "EMP";
  break;case 'Embassy':
    $InPreFix = "EMB";
  break;case 'Other':
    $InPreFix = "OTH";
  break; default:
    $InPreFix = "EMP";
}
$option = array("prefix"=>$InPreFix,"table"=>_TABLE_ADMIN_STAFF_,"field"=>"EmpCode","flag"=>"NoEdit","numberlength"=>3,"where"=>array(_TABLE_ADMIN_STAFF_."_Status=" => "'On'",_TABLE_ADMIN_STAFF_."_InType=" => "'".$selectInType."'"));
$autonumber = generate_code($option);
$insert[_TABLE_ADMIN_STAFF_."_EmpCode"] = "'".sql_safe($autonumber)."'";
$insert[_TABLE_ADMIN_STAFF_."_FName"] = "'".sql_safe($inputFName)."'";
$insert[_TABLE_ADMIN_STAFF_."_LName"] = "'".sql_safe($inputLName)."'";
$insert[_TABLE_ADMIN_STAFF_."_Email"] = "'".sql_safe($inputEmail)."'";
$insert[_TABLE_ADMIN_STAFF_."_Tel"] = "'".sql_safe($inputTelephone)."'";
$insert[_TABLE_ADMIN_STAFF_."_PictureFileSrc"] = "'".sql_safe($txtfilesrcname)."'";
$insert[_TABLE_ADMIN_STAFF_."_PictureFile"] = "'".sql_safe($phyFilePicture)."'";
$insert[_TABLE_ADMIN_STAFF_."_Remark"] = "'".sql_safe($inputRemark)."'";
$insert[_TABLE_ADMIN_STAFF_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_ADMIN_STAFF_."_CreateDate"] = "NOW()";
$insert[_TABLE_ADMIN_STAFF_."_LastUpdate"] = "NOW()";
$insert[_TABLE_ADMIN_STAFF_."_Status"] = "'On'";
$insert[_TABLE_ADMIN_STAFF_."_InType"] = "'".sql_safe($selectInType)."'";
$z = new __webctrl;
$z->insert(_TABLE_ADMIN_STAFF_,$insert);
$MaxID = $z->insertid();
unset($insert);
echo 2;
CloseDB();
?>
