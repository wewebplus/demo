<?php
include("../assets/lib/inc.config.php");

$country = isset($_GET['country']) ? $_GET['country'] : 0;
$province = isset($_GET['province']) ? $_GET['province'] : 0;
$district = isset($_GET['district']) ? $_GET['district'] : 0;
$cur_subdistid = isset($_GET['cur_subdistid']) ? $_GET['cur_subdistid'] : 0;

$dataSubDistrict = getListSubDistrict($district,$province,$country);

$option = '';
if($dataSubDistrict->datacount>0) {
  $option = '<option value=""> - - Select SubDistrict - - </option>';
  foreach($dataSubDistrict->data as $gk=>$gv){
    $option .= '<option value="'.$gv["Code"].'" '.($cur_subdistid==$gv["Code"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
  }
}
echo $option;
exit;
?>
