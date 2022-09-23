<?php
include("../systemcontrol/assets/lib/inc.config.php");
// echo _TABLE_ADDRCOUNTRIES_;
$country = (!empty($_GET["country"])?$_GET["country"]:219);
$sql = "SELECT * FROM "._TABLE_ADDRCOUNTRIES_;
$sql .= " WHERE "._TABLE_ADDRCOUNTRIES_."_CountryID = ".intval($country);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$arrCountry = array();
if($RecordCount>0){
  foreach($v as $Row){
    $ID = $Row[_TABLE_ADDRCOUNTRIES_."_ID"];
    $CountryID = $Row[_TABLE_ADDRCOUNTRIES_."_CountryID"];
    $CountryCode = $Row[_TABLE_ADDRCOUNTRIES_."_CountryCode"];
    $state = array();
    $sql = "SELECT "._TABLE_ADDRSTATE_."_StateID AS StateID,"._TABLE_ADDRSTATE_."_NameEN AS StateName,"._TABLE_ADDRSTATE_."_Code AS StateCode FROM "._TABLE_ADDRSTATE_;
    $sql .= " WHERE "._TABLE_ADDRSTATE_."_CountryID = ".intval($CountryID);
    $z->sql($sql);
    $CountState = $z->num();
    if($CountState>0){
      $vState = $z->row();
      foreach($vState as $RowState){
        $district = array();
        $state_id = $RowState["StateID"];
        $sql = "SELECT "._TABLE_ADDRDISTRICT_."_DistrictID AS DistrictID,"._TABLE_ADDRDISTRICT_."_NameEN AS DistrictName,"._TABLE_ADDRDISTRICT_."_Code AS DistrictCode FROM "._TABLE_ADDRDISTRICT_;
        $sql .= " WHERE "._TABLE_ADDRDISTRICT_."_CountryID = ".intval($CountryID);
        $sql .= " AND "._TABLE_ADDRDISTRICT_."_StatesID = ".intval($state_id);
        $z->sql($sql);
        $CountDistrict = $z->num();
        if($CountDistrict>0){
          $vDistrict = $z->row();
          foreach($vDistrict as $RowDistrict){
            $subdistrict = array();
            $district_id = $RowDistrict["DistrictID"];
            $district_name = $RowDistrict["DistrictName"];
            $district_code = $RowDistrict["DistrictCode"];

            $sql = "SELECT "._TABLE_ADDRSUBDISTRICT_."_NameEN AS SubDistrictName,"._TABLE_ADDRSUBDISTRICT_."_Code AS SubDistrictCode,"._TABLE_ADDRSUBDISTRICT_."_Zipcode AS SubDistrictZipcode FROM "._TABLE_ADDRSUBDISTRICT_;
            $sql .= " WHERE "._TABLE_ADDRSUBDISTRICT_."_CountryID = ".intval($CountryID);
            $sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_StatesID = ".intval($state_id);
            $sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_DistrictID = ".intval($district_id);
            $z->sql($sql);
            $CountSubDistrict = $z->num();
            if($CountSubDistrict>0){
              $vSubDistrict = $z->row();
              foreach($vSubDistrict as $RowSubDistrict){
                $subdistrict_name = $RowSubDistrict["SubDistrictName"];
                $subdistrict_code = $RowSubDistrict["SubDistrictCode"];
                $subdistrict_zipcode = $RowSubDistrict["SubDistrictZipcode"];

                $ar = array();
                $ar["_CountryID"] = $CountryID;
                $ar["_CountryCode"] = $CountryCode;
                $ar["_StateID"] = $state_id;
                $ar["_DistrictID"] = $district_id;
                $ar["_SubDistrictName"] = $subdistrict_name;
                $ar["_SubDistrictCode"] = $subdistrict_code;
                $ar["_SubDistrictZipCode"] = $subdistrict_zipcode;
                $subdistrict[] = $ar;
              }
            }
            $ar = array();
            $ar["_CountryID"] = $CountryID;
            $ar["_CountryCode"] = $CountryCode;
            $ar["_StateID"] = $state_id;
            $ar["_DistrictID"] = $district_id;
            $ar["_DistrictName"] = $district_name;
            $ar["_DistrictCode"] = $district_code;
            $ar["subdistrict"] = $subdistrict;
            $district[] = $ar;
          }
        }
        $ar = array();
        $ar["_CountryID"] = $CountryID;
        $ar["_CountryCode"] = $CountryCode;
        $ar["_StateID"] = $state_id;
        $ar["_StateName"] = $RowState["StateName"];
        $ar["_StateCode"] = $RowState["StateCode"];
        $ar["district"] = $district;
        $state[] = $ar;
      }
    }
    $arr = array();
    $arr["ID"] = $ID;
    $arr["CountryID"] = $CountryID;
    $arr["CountryCode"] = $CountryCode;
    $arr["State"] = $state;
    $arrCountry[] = $arr;
    // echo '<div>'.$ID.' '.$CountryCode.' '.$sla_countryID.'</div>';
  }
}
echo '<pre>';
print_r($arrCountry);
echo '</pre>';
?>
