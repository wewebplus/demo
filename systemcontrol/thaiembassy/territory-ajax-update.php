<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$ListStatus = (!empty($_POST["ListStatus"])?$_POST["ListStatus"]:'Off');
$inputRegion = $_POST["inputRegion"];
$selectRegion = $_POST["selectRegion"];
$inputTerritoryName = $_POST["inputTerritoryName"];
$inputCountry = $_POST["inputCountry"];
$selectCountry = $_POST["selectCountry"];
if($selectCountry>0){
  $InfoCountry = getInfoCountry($selectCountry);
  $selectCountryName = $InfoCountry->data["CountryName"];
  $selectCountryCode = $InfoCountry->data["CountryCode"];
}else{
  $selectCountryName = "";
  $selectCountryCode = "";
}
if($itemid>0){
  $update[_TABLE_ADMIN_TERRITORY_.'_LastUpdate'] = "NOW()";
  $update[_TABLE_ADMIN_TERRITORY_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $update[_TABLE_ADMIN_TERRITORY_.'_RegionID'] = sql_safe($selectRegion,false,true);
  $update[_TABLE_ADMIN_TERRITORY_.'_RegionName'] = "'".sql_safe($inputRegion)."'";
  $update[_TABLE_ADMIN_TERRITORY_.'_Name'] = "'".sql_safe($inputTerritoryName)."'";
  $update[_TABLE_ADMIN_TERRITORY_.'_CountryID'] = sql_safe($selectCountry,false,true);
  $update[_TABLE_ADMIN_TERRITORY_.'_CountryCode'] = "'".sql_safe($selectCountryCode)."'";
  $update[_TABLE_ADMIN_TERRITORY_.'_CountryName'] = "'".sql_safe($selectCountryName)."'";
  $z = new __webctrl;
	$z->update(_TABLE_ADMIN_TERRITORY_,$update,array(_TABLE_ADMIN_TERRITORY_."_ID=" => (int)$itemid));
	unset($update);

  // Internal
  $selectCountry_I = $_POST["selectCountry_I"];
  if($selectCountry_I>0){
    $InfoCountry = getInfoCountry($selectCountry_I);
    $selectCountry_IName = $InfoCountry->data["CountryName"];
    $selectCountry_ICode = $InfoCountry->data["CountryCode"];
  }else{
    $selectCountry_IName = "";
    $selectCountry_ICode = "";
  }
  $arrProvince = array();
  $OrderIndex = 0;
  $OrderIndex++;
  $arr = array();
  $arr["_TerritoryID"] = $itemid;
  $arr["_CountryID"] = $selectCountry_I;
  $arr["_CountryCode"] = $selectCountry_ICode;
  $arr["_CountryName"] = $selectCountry_IName;
  $arr["_StateID"] = 0;
  $arr["_StateName"] = '';
  $arr["_Order"] = $OrderIndex;
  $arrProvince[] = $arr;
  if(isset($_POST["selectProvince_I"])){
    foreach($_POST["selectProvince_I"] as $kProvince=>$vProvince){
      $OrderIndex++;
      $InfoProvince = getInfoState($vProvince);
      $arr = array();
      $arr["_TerritoryID"] = $itemid;
      $arr["_CountryID"] = $selectCountry_I;
      $arr["_CountryCode"] = $selectCountry_ICode;
      $arr["_CountryName"] = $selectCountry_IName;
      $arr["_StateID"] = $InfoProvince->data["StateID"];
      $arr["_StateName"] = $InfoProvince->data["StateName"];
      $arr["_Order"] = $OrderIndex;
      $arrProvince[] = $arr;
    }
  }
  if(count($arrProvince)>0){
    $z->del(_TABLE_ADMIN_TERRITORY_.'_internal',array(_TABLE_ADMIN_TERRITORY_."_internal_TerritoryID=" => (int)$itemid));
    foreach($arrProvince as $RowI){
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_TerritoryID'] = sql_safe($RowI["_TerritoryID"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_CountryID'] = sql_safe($RowI["_CountryID"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_CountryCode'] = sql_safe($RowI["_CountryCode"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_CountryName'] = sql_safe($RowI["_CountryName"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_StateID'] = sql_safe($RowI["_StateID"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_StateName'] = sql_safe($RowI["_StateName"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_internal_Order'] = sql_safe($RowI["_Order"],false,true);
      $z->insert(_TABLE_ADMIN_TERRITORY_.'_internal',$insert);
      unset($insert);
    }
  }
  // End Internal
  // External
  $OrderIndex = 0;
  $OrderIndex++;
  $arrCountry = array();
  if(isset($_POST["selectCountry_E"])){
    foreach($_POST["selectCountry_E"] as $kcountry=>$vcountry){
      $InfoCountry = getInfoCountry($vcountry);
      $selectCountry_EName = $InfoCountry->data["CountryName"];
      $selectCountry_ECode = $InfoCountry->data["CountryCode"];
      $arr = array();
      $arr["_TerritoryID"] = $itemid;
      $arr["_CountryID"] = $vcountry;
      $arr["_CountryCode"] = $selectCountry_ECode;
      $arr["_CountryName"] = $selectCountry_EName;
      $arr["_StateID"] = 0;
      $arr["_StateName"] = '';
      $arr["_Order"] = $OrderIndex;
      $arrCountry[] = $arr;
    }
  }
  if(count($arrCountry)>0){
    $z->del(_TABLE_ADMIN_TERRITORY_.'_external',array(_TABLE_ADMIN_TERRITORY_."_external_TerritoryID=" => (int)$itemid));
    foreach($arrCountry as $RowE){
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_TerritoryID'] = sql_safe($RowE["_TerritoryID"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_CountryID'] = sql_safe($RowE["_CountryID"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_CountryCode'] = sql_safe($RowE["_CountryCode"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_CountryName'] = sql_safe($RowE["_CountryName"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_StateID'] = sql_safe($RowE["_StateID"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_StateName'] = sql_safe($RowE["_StateName"],false,true);
      $insert[_TABLE_ADMIN_TERRITORY_.'_external_Order'] = sql_safe($RowE["_Order"],false,true);
      $z->insert(_TABLE_ADMIN_TERRITORY_.'_external',$insert);
      unset($insert);
    }
  }
  // end external
}
echo 'OK';
?>
