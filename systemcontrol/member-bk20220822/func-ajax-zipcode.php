<?php
include("../assets/lib/inc.config.php");

$cur_subdistid = isset($_GET['cur_subdistid']) ? $_GET['cur_subdistid'] : 0;

$dataSubDistrict = getInfoSubDistrict($cur_subdistid);

$string = '';
if($dataSubDistrict->datacount>0) {
  $string = $dataSubDistrict->data["ZipCode"];
}
echo $string;
exit;
?>
