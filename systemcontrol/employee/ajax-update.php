<?php
include("../assets/lib/inc.config.php");
decode_URL($_POST["saveData"]);

if($itemid>0){
  $inputFName = $_POST["firstname"];
  $inputLName = $_POST["lastname"];
  $inputEmail = $_POST["useremail"];
  $inputTelephone = $_POST["telephone"];
  $inputRemark = encodetxterea($_POST["Emp_note"]);
  $base64_string = $_POST["imageData"];
  $selectInType = $_POST["selectInType"];

  $myrand = md5(rand(11111,99999));
  $PathUpload = _RELATIVE_EMPLOYEE_UPLOAD_;
  if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }

  $sql="SELECT "._TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $oldPictureFile = $PathUpload.$v[0]["PictureFile"];

  if(!empty($base64_string)){
    if(is_file($oldPictureFile)) {
      unlink($oldPictureFile);
    }
    $filename = "img-".$myrand;
    $output_file = $PathUpload.$filename;
    $outputtempimg = save_base64_image($base64_string, $output_file);
    $phyFilePicture = str_replace($PathUpload,"",$outputtempimg);
    $update[_TABLE_ADMIN_STAFF_."_PictureFile"] = "'".sql_safe($phyFilePicture)."'";
  }

  $update[_TABLE_ADMIN_STAFF_."_FName"] = "'".sql_safe($inputFName)."'";
  $update[_TABLE_ADMIN_STAFF_."_LName"] = "'".sql_safe($inputLName)."'";
  $update[_TABLE_ADMIN_STAFF_."_Email"] = "'".sql_safe($inputEmail)."'";
  $update[_TABLE_ADMIN_STAFF_."_Tel"] = "'".sql_safe($inputTelephone)."'";
  $update[_TABLE_ADMIN_STAFF_."_Remark"] = "'".sql_safe($inputRemark)."'";
  $update[_TABLE_ADMIN_STAFF_."_LastUpdate"] = "NOW()";
  $update[_TABLE_ADMIN_STAFF_."_InType"] = "'".sql_safe($selectInType)."'";
  $z = new __webctrl;
  $z->update(_TABLE_ADMIN_STAFF_,$update,array(_TABLE_ADMIN_STAFF_."_ID=" => (int)$itemid));
  unset($update);
}

echo 2;
CloseDB();
?>
