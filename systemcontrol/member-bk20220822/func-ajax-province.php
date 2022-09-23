<?php
include("../assets/lib/inc.config.php");

$country = isset($_GET['country']) ? $_GET['country'] : 0;
$cur_provid = isset($_GET['cur_provid']) ? $_GET['cur_provid'] : 0;

$dataProvince = getListProvince($country);

$option = '';
if($dataProvince->datacount>0) {
  $option = '<option value=""> - - Select Province/State - - </option>';
  foreach($dataProvince->data as $gk=>$gv){
    $option .= '<option value="'.$gv["id"].'" '.($cur_provid==$gv["id"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
  }
}
echo $option;
exit;
?>
