<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$inputCountryNameTH = $_POST["inputCountryNameTH"];
$inputCountryNameEN = $_POST["inputCountryNameEN"];
$inputCountryCode = $_POST["inputCountryCode"];
$inputCountryLongCode = $_POST["inputCountryLongCode"];
$inputCountryISD = $_POST["inputCountryISD"];
$inputISONumeric = $_POST["inputISONumeric"];

$sql = "SELECT MAX("._TABLE_ADDRCOUNTRIES_."_CountryID) AS MaxO FROM "._TABLE_ADDRCOUNTRIES_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;
$insert = array();
$insert[_TABLE_ADDRCOUNTRIES_."_CountryNameTH"] = "'".sql_safe($inputCountryNameTH)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_CountryNameEN"] = "'".sql_safe($inputCountryNameEN)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_CountryCode"] = "'".sql_safe($inputCountryCode)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_CountryLongCode"] = "'".sql_safe($inputCountryLongCode)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_CountryISD"] = "'".sql_safe($inputCountryISD)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_ISONumeric"] = "'".sql_safe($inputISONumeric)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_CountryID"] = "'".sql_safe($MaxOrder)."'";
$insert[_TABLE_ADDRCOUNTRIES_."_RunID"] = "'".sql_safe($MaxOrder)."'";
$z = new __webctrl;
$z->insert(_TABLE_ADDRCOUNTRIES_,$insert);
$NewID = $z->insertid();
unset($insert);
echo 2;
CloseDB();
?>
