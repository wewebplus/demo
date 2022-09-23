<?php
include("../assets/lib/inc.config.php");

$country = isset($_GET['country']) ? $_GET['country'] : 0;
$province = isset($_GET['province']) ? $_GET['province'] : 0;
$cur_distid = isset($_GET['cur_distid']) ? $_GET['cur_distid'] : 0;

$dataDistrict = getListCity($province,$country);

$option = '';
if($dataDistrict->datacount>0) {
  $option = '<option value=""> - - Select District - - </option>';
  foreach($dataDistrict->data as $gk=>$gv){
    $option .= '<option value="'.$gv["DistrictID"].'" '.($cur_distid==$gv["DistrictID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
  }
}
echo $option;
exit;
?>
