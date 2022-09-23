<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
  $mymenukey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_TEMP_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
if(!is_dir($PathUploadGallery)) { mkdir($PathUploadGallery,0777); }
if(!is_dir($PathUploadVDO)) { mkdir($PathUploadVDO,0777); }
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$DataArrDay = $defaultdata[$Login_MenuID]["day"];
$DataArrService = $defaultdata[$Login_MenuID]["service"];
$mydataTime = array();
if(count($DataArrDay)>0){
  foreach($DataArrDay as $kkd=>$vvd){
    $TimeDataID = (isset($_POST["inputTimeDataID_".$vvd["ID"]])?$_POST["inputTimeDataID_".$vvd["ID"]]:array());
    $DayID = $vvd["ID"];
    if(count($TimeDataID)>0){
      foreach($TimeDataID as $kkt=>$vvt){
        $TimeOpen = $_POST["TIMEOPEN_".$vvd["ID"]][$kkt];
        $TimeClose = $_POST["TIMECLOSE_".$vvd["ID"]][$kkt];
        $arr = array();
        $arr["_ContentID"] = $itemid;
        $arr["_DayID"] = $DayID;
        $arr["_Open"] = (!empty($TimeOpen)?$TimeOpen:'00:00').':00';
        $arr["_Close"] = (!empty($TimeClose)?$TimeClose:'00:00').':00';
        $arr["_LastUpdate"] = "NOW()";
        $arr["_Status"] = 'On';
        $arr["_Order"] = $kkt;
        $mydataTime[] = $arr;
      }
    }
  }
}
// echo '<pre>';
// print_r($mydataTime);
// echo '</pre>';
// echo "xxxxxxxxxx";
// exit();
$stringCheckService = array();
foreach($DataArrService as $ValService){
  $inkey = $ValService["Key"];
  $inChild = $ValService["Child"];
  $dataCheck = (isset($_POST["checkService".$inkey])?$_POST["checkService".$inkey]:'-');
  array_push($stringCheckService,$dataCheck);
  if(count($inChild)>0){
    foreach($inChild as $ChildVal){
      $inkey = $ChildVal["Key"];
      $dataCheck = (isset($_POST["checkService".$inkey])?$_POST["checkService".$inkey]:'-');
      array_push($stringCheckService,$dataCheck);
    }
  }
}
// echo implode(',',$stringCheckService);
// echo '<pre>';
// print_r($stringCheckService);
// echo '</pre>';
// exit();
$selectMember = (!empty($_POST['selectMember'])?$_POST['selectMember']:0);
$selectGroup = (!empty($_POST['selectGroup'])?$_POST['selectGroup']:'');
$inputName = (!empty($_POST['inputName'])?$_POST['inputName']:'');
$inputBranch = (!empty($_POST['inputBranch'])?$_POST['inputBranch']:'');
$inputAddress_1 = (!empty($_POST['inputAddress_1'])?encodetxterea($_POST['inputAddress_1']):'');
$inputAddress_2 = (!empty($_POST['inputAddress_2'])?encodetxterea($_POST['inputAddress_2']):'');
$inputCountry = (!empty($_POST['inputCountry'])?$_POST['inputCountry']:'');
$selectCountry = (!empty($_POST['selectCountry'])?$_POST['selectCountry']:0);
if($selectCountry>0){
  $InfoCountry = getInfoCountry($selectCountry);
  $selectCountryID = $selectCountry;
  $selectCountryName = $InfoCountry->data["CountryName"];
  $selectCountryCode = $InfoCountry->data["CountryCode"];
}else{
  $selectCountryID = $selectCountry;
  $selectCountryName = "";
  $selectCountryCode = "";
}
$inputProvince = (!empty($_POST['inputProvince'])?$_POST['inputProvince']:'');
$selectProvince = (!empty($_POST['selectProvince'])?$_POST['selectProvince']:0);
if($selectProvince>0){
  $InfoProvince = getInfoState($selectProvince);
  $selectProvinceID = $InfoProvince->data["StateID"];
  $selectProvinceName = $InfoProvince->data["StateName"];
}else{
  $selectProvinceID = $selectProvince;
  $selectProvinceName = "";
}
$inputDistrict = (!empty($_POST['inputDistrict'])?$_POST['inputDistrict']:'');
$selectDistrict = (!empty($_POST['selectDistrict'])?$_POST['selectDistrict']:0);
if($selectDistrict>0){
  $InfoDistrict = getInfoCity($selectDistrict);
  $selectDistrictID = $InfoDistrict->data["DistrictID"];
  $selectDistrictName = $InfoDistrict->data["Name"];
}else{
  $selectDistrictID = $selectDistrict;
  $selectDistrictName = "";
}
$inputZipCode = (!empty($_POST['inputZipCode'])?$_POST['inputZipCode']:'');
$inputTimeZone = (!empty($_POST['inputTimeZone'])?$_POST['inputTimeZone']:'');
$selectTimeZone = (!empty($_POST['selectTimeZone'])?$_POST['selectTimeZone']:0);
$sup_search = (!empty($_POST['sup_search'])?$_POST['sup_search']:'');
$sup_lat = (!empty($_POST['sup_lat'])?$_POST['sup_lat']:'');
$sup_lng = (!empty($_POST['sup_lng'])?$_POST['sup_lng']:'');
$inputTelephone = (!empty($_POST['inputTelephone'])?$_POST['inputTelephone']:'');
$inputFax = (!empty($_POST['inputFax'])?$_POST['inputFax']:'');
$inputEmail = (!empty($_POST['inputEmail'])?$_POST['inputEmail']:'');
$inputWebsite = (!empty($_POST['inputWebsite'])?$_POST['inputWebsite']:'');
$inputContact_person = (!empty($_POST['inputContact_person'])?$_POST['inputContact_person']:'');
$inputContact_position = (!empty($_POST['inputContact_position'])?$_POST['inputContact_position']:'');
$inputCurrency = (!empty($_POST['inputCurrency'])?$_POST['inputCurrency']:'');
$inputRegistered_no_of_juristic_person = (!empty($_POST['inputRegistered_no_of_juristic_person'])?$_POST['inputRegistered_no_of_juristic_person']:'');
$inputMonth_year_of_establishment = (!empty($_POST['inputMonth_year_of_establishment'])?$_POST['inputMonth_year_of_establishment']:'');

$selectEstimated = (!empty($_POST['selectEstimated'])?$_POST['selectEstimated']:'');
$inputCertificate_of_hygenic = (!empty($_POST['inputCertificate_of_hygenic'])?$_POST['inputCertificate_of_hygenic']:'');
$inputnumber_of_chef_thai = (!empty($_POST['inputnumber_of_chef_thai'])?$_POST['inputnumber_of_chef_thai']:'');
$inputthai_cooking_experience = (!empty($_POST['inputthai_cooking_experience'])?$_POST['inputthai_cooking_experience']:'');
$inputnumber_of_chef_foreign = (!empty($_POST['inputnumber_of_chef_foreign'])?$_POST['inputnumber_of_chef_foreign']:'');
$inputforeign_with_thai_experience = (!empty($_POST['inputforeign_with_thai_experience'])?$_POST['inputforeign_with_thai_experience']:'');
$inputfront_officer = (!empty($_POST['inputfront_officer'])?$_POST['inputfront_officer']:'');
$inputfront_officer_with_thai_experience = (!empty($_POST['inputfront_officer_with_thai_experience'])?$_POST['inputfront_officer_with_thai_experience']:'');
$inputSeat = (!empty($_POST['inputSeat'])?$_POST['inputSeat']:'');
$inputSpace = (!empty($_POST['inputSpace'])?$_POST['inputSpace']:'');
$inputInCountry = (!empty($_POST['inputInCountry'])?$_POST['inputInCountry']:'');
$inputOverseas = (!empty($_POST['inputOverseas'])?$_POST['inputOverseas']:'');
$inputPercentage_of_customer_thai = (!empty($_POST['inputPercentage_of_customer_thai'])?$_POST['inputPercentage_of_customer_thai']:'');
$inputPercentage_of_customer_non_thai = (!empty($_POST['inputPercentage_of_customer_non_thai'])?$_POST['inputPercentage_of_customer_non_thai']:'');
$inputnon_thai_products_please_specify = (!empty($_POST['inputnon_thai_products_please_specify'])?$_POST['inputnon_thai_products_please_specify']:'');

if(isset($_POST['checkIngredients'])){
  // print_r($_POST['checkIngredients']);
  $checkIngredients = implode(',',$_POST['checkIngredients']);
}else{
  $checkIngredients = "";
}
if(isset($_POST['checkPurchaseofraw'])){
  // print_r($_POST['checkPurchaseofraw']);
  $checkPurchaseofraw = implode(',',$_POST['checkPurchaseofraw']);
  $purchase_of_raw_materials_other = (!empty($_POST['purchase_of_raw_materials_other'])?$_POST['purchase_of_raw_materials_other']:'');
}else{
  $checkPurchaseofraw = "";
  $purchase_of_raw_materials_other = "";
}
if(isset($_POST['checkPrmarketing'])){
  // print_r($_POST['checkPrmarketing']);
  $checkPrmarketing = implode(',',$_POST['checkPrmarketing']);
  $pr_marketing_promotion_activities_other = (!empty($_POST['pr_marketing_promotion_activities_other'])?$_POST['pr_marketing_promotion_activities_other']:'');
}else{
  $checkPrmarketing = "";
  $pr_marketing_promotion_activities_other = "";
}

// $putDataFile = $_POST["putDataFile"];
// $putDataFile = str_replace(_HTTP_PATH_UPLOAD_,_RELATIVE_PATH_UPLOAD_,$putDataFile);
// $putData = $_POST["putData"];

// echo "xxxxxxxxxxxxxxxxxx";
// echo $sup_search;
// echo "<br />";
// echo $selectDistrictName;
if($itemid>0){
  $update[_TABLE_RESTAURANT_."_MemberID"] = sql_safe($selectMember,false,true);
	$update[_TABLE_RESTAURANT_."_LastUpdate"] = "NOW()";
	$update[_TABLE_RESTAURANT_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_RESTAURANT_.'_Ignore'] = "'".sql_safe($Lang)."'";
  $update[_TABLE_RESTAURANT_.'_Name'] = "'".sql_safe($inputName)."'";
  $update[_TABLE_RESTAURANT_.'_Branch'] = "'".sql_safe($inputBranch)."'";
  $update[_TABLE_RESTAURANT_.'_Type'] = "'".sql_safe($selectGroup)."'";
  $update[_TABLE_RESTAURANT_.'_Address1'] = "'".sql_safe($inputAddress_1)."'";
  $update[_TABLE_RESTAURANT_.'_Address2'] = "'".sql_safe($inputAddress_2)."'";
  $update[_TABLE_RESTAURANT_."_Country"] = "'".sql_safe($selectCountryID)."'";
  $update[_TABLE_RESTAURANT_.'_CountryCode'] = "'".sql_safe($selectCountryCode)."'";
  $update[_TABLE_RESTAURANT_.'_CountryName'] = "'".sql_safe($selectCountryName)."'";
  $update[_TABLE_RESTAURANT_."_Province"] = "'".sql_safe($selectProvinceID)."'";
  $update[_TABLE_RESTAURANT_.'_ProvinceName'] = "'".sql_safe($selectProvinceName)."'";
  $update[_TABLE_RESTAURANT_."_District"] = "'".sql_safe($selectDistrictID)."'";
  $update[_TABLE_RESTAURANT_.'_DistrictName'] = "'".sql_safe($selectDistrictName)."'";
  $update[_TABLE_RESTAURANT_.'_Zipcode'] = "'".sql_safe($inputZipCode)."'";
  $update[_TABLE_RESTAURANT_.'_Mapsearch'] = "'".sql_safe($sup_search)."'";
  $update[_TABLE_RESTAURANT_.'_Lat'] = "'".sql_safe($sup_lat)."'";
  $update[_TABLE_RESTAURANT_.'_Long'] = "'".sql_safe($sup_lng)."'";
  $update[_TABLE_RESTAURANT_.'_Phone'] = "'".sql_safe($inputTelephone)."'";
  $update[_TABLE_RESTAURANT_.'_Fax'] = "'".sql_safe($inputFax)."'";
  $update[_TABLE_RESTAURANT_.'_Email'] = "'".sql_safe($inputEmail)."'";
  $update[_TABLE_RESTAURANT_.'_Website'] = "'".sql_safe($inputWebsite)."'";
  $update[_TABLE_RESTAURANT_.'_Contact_person'] = "'".sql_safe($inputContact_person)."'";
  $update[_TABLE_RESTAURANT_.'_Contact_position'] = "'".sql_safe($inputContact_position)."'";
  $update[_TABLE_RESTAURANT_.'_Currency'] = "'".sql_safe($inputCurrency)."'";
  $update[_TABLE_RESTAURANT_.'_Registered_no_of_juristic_person'] = "'".sql_safe($inputRegistered_no_of_juristic_person)."'";
  $update[_TABLE_RESTAURANT_.'_Month_year_of_establishment'] = "'".sql_safe($inputMonth_year_of_establishment)."'";
  $update[_TABLE_RESTAURANT_.'_Restaurant_services'] = "'".sql_safe(implode(',',$stringCheckService))."'";
  $update[_TABLE_RESTAURANT_.'_Time_zone'] = "'".sql_safe($selectTimeZone)."'";
  $update[_TABLE_RESTAURANT_.'_Estimated_price'] = "'".sql_safe($selectEstimated)."'";
  $update[_TABLE_RESTAURANT_.'_Certificate_of_hygenic'] = "'".sql_safe($inputCertificate_of_hygenic)."'";
  $update[_TABLE_RESTAURANT_.'_Number_of_chef_thai'] = "'".sql_safe($inputnumber_of_chef_thai)."'";
  $update[_TABLE_RESTAURANT_.'_Thai_cooking_experience'] = "'".sql_safe($inputthai_cooking_experience)."'";
  $update[_TABLE_RESTAURANT_.'_Number_of_chef_foreign'] = "'".sql_safe($inputnumber_of_chef_foreign)."'";
  $update[_TABLE_RESTAURANT_.'_Foreign_with_thai_experience'] = "'".sql_safe($inputforeign_with_thai_experience)."'";
  $update[_TABLE_RESTAURANT_.'_Front_officer'] = "'".sql_safe($inputfront_officer)."'";
  $update[_TABLE_RESTAURANT_.'_Front_officer_with_thai_experience'] = "'".sql_safe($inputfront_officer_with_thai_experience)."'";
  $update[_TABLE_RESTAURANT_.'_Seat'] = "'".sql_safe($inputSeat)."'";
  $update[_TABLE_RESTAURANT_.'_Space'] = "'".sql_safe($inputSpace)."'";
  $update[_TABLE_RESTAURANT_.'_Branch_in_country'] = "'".sql_safe($inputInCountry)."'";
  $update[_TABLE_RESTAURANT_.'_Branch_in_overseas'] = "'".sql_safe($inputOverseas)."'";
  $update[_TABLE_RESTAURANT_.'_Percentage_of_customer_thai'] = "'".sql_safe($inputPercentage_of_customer_thai)."'";
  $update[_TABLE_RESTAURANT_.'_Percentage_of_customer_non_thai'] = "'".sql_safe($inputPercentage_of_customer_non_thai)."'";
  $update[_TABLE_RESTAURANT_.'_Non_thai_product'] = "'".sql_safe($inputnon_thai_products_please_specify)."'";
  $update[_TABLE_RESTAURANT_.'_Ingredients_used'] = "'".sql_safe($checkIngredients)."'";
  $update[_TABLE_RESTAURANT_.'_Purchase_of_raw_materials'] = "'".sql_safe($checkPurchaseofraw)."'";
  $update[_TABLE_RESTAURANT_.'_Purchase_of_raw_materials_other'] = "'".sql_safe($purchase_of_raw_materials_other)."'";
  $update[_TABLE_RESTAURANT_.'_Pr_marketing_promotion_activities'] = "'".sql_safe($checkPrmarketing)."'";
  $update[_TABLE_RESTAURANT_.'_Pr_marketing_promotion_activities_other'] = "'".sql_safe($pr_marketing_promotion_activities_other)."'";
	$z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => (int)$itemid));
	unset($update);
  // echo '<pre>';
  // print_r($update);
  // echo '</pre>';
  // exit();
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputDetail = (!empty($_POST["inputDetail".$lkey])?$_POST["inputDetail".$lkey]:'');
  	if($detailid>0){
  		$update[_TABLE_RESTAURANT_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
  		$update[_TABLE_RESTAURANT_DETAIL_.'_Detail'] = "'".sql_safe($inputDetail)."'";
  		$update[_TABLE_RESTAURANT_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$update[_TABLE_RESTAURANT_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$update[_TABLE_RESTAURANT_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z->update(_TABLE_RESTAURANT_DETAIL_,$update,array(_TABLE_RESTAURANT_DETAIL_."_ID=" => (int)$detailid));
  		unset($update);
  	}else{
  		$insert[_TABLE_RESTAURANT_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
  		$insert[_TABLE_RESTAURANT_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  		$insert[_TABLE_RESTAURANT_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
      $insert[_TABLE_RESTAURANT_DETAIL_.'_Detail'] = "'".sql_safe($inputDetail)."'";
  		$insert[_TABLE_RESTAURANT_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$insert[_TABLE_RESTAURANT_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$insert[_TABLE_RESTAURANT_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z->insert(_TABLE_RESTAURANT_DETAIL_,$insert);
  		unset($insert);
  	}
  }
  // $mydataTime.
  if(count($mydataTime)>0){
    $z->del(_TABLE_RESTAURANT_WORK_,array(_TABLE_RESTAURANT_WORK_."_ContentID=" => (int)$itemid));
    foreach($mydataTime as $list){
      $insert = array();
      $insert[_TABLE_RESTAURANT_WORK_.'_ContentID'] = sql_safe($list["_ContentID"],false,true);
      $insert[_TABLE_RESTAURANT_WORK_.'_Open'] = "'".$list["_Open"]."'";
      $insert[_TABLE_RESTAURANT_WORK_.'_Close'] = "'".$list["_Close"]."'";
      $insert[_TABLE_RESTAURANT_WORK_.'_Day'] = sql_safe($list["_DayID"],false,true);
      $insert[_TABLE_RESTAURANT_WORK_.'_LastUpdate'] = $list["_LastUpdate"];
      $insert[_TABLE_RESTAURANT_WORK_.'_Status'] = "'".$list["_Status"]."'";
      $insert[_TABLE_RESTAURANT_WORK_.'_Order'] = sql_safe($list["_Order"],false,true);
      $z->insert(_TABLE_RESTAURANT_WORK_,$insert);
      unset($insert);
      // print_r($insert);
    }
  }
  // echo "xxxxxxxxxx";
}
echo 2;
CloseDB();
?>
