<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_POST["saveData"]);
if($itemid>0){
  $inputCountryNameTH = $_POST["inputCountryNameTH"];
  $inputCountryNameEN = $_POST["inputCountryNameEN"];
  $inputCountryCode = $_POST["inputCountryCode"];
  $inputCountryLongCode = $_POST["inputCountryLongCode"];
  $inputCountryISD = $_POST["inputCountryISD"];
  $inputISONumeric = $_POST["inputISONumeric"];
  $update[_TABLE_ADDRCOUNTRIES_."_CountryNameTH"] = "'".sql_safe($inputCountryNameTH)."'";
  $update[_TABLE_ADDRCOUNTRIES_."_CountryNameEN"] = "'".sql_safe($inputCountryNameEN)."'";
  $update[_TABLE_ADDRCOUNTRIES_."_CountryCode"] = "'".sql_safe($inputCountryCode)."'";
  $update[_TABLE_ADDRCOUNTRIES_."_CountryLongCode"] = "'".sql_safe($inputCountryLongCode)."'";
  $update[_TABLE_ADDRCOUNTRIES_."_CountryISD"] = "'".sql_safe($inputCountryISD)."'";
  $update[_TABLE_ADDRCOUNTRIES_."_ISONumeric"] = "'".sql_safe($inputISONumeric)."'";
  $z = new __webctrl;
  $z->update(_TABLE_ADDRCOUNTRIES_,$update,array(_TABLE_ADDRCOUNTRIES_."_ID=" => (int)$itemid));
  unset($update);
}
echo 2;
CloseDB();
?>
