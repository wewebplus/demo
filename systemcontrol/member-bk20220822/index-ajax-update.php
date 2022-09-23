<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_CONTENT_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }
$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$arrMbrType = array(
  'el' => 'el',
  'preel' => 'Pre el',
  'tdc' => 'tdc',
  'pretdc' => 'Pre tdc',
  'spl' => 'SPL',
  'sel' => 'SEL',
  'isp' => 'ISP',
  'inprog' => 'In progress',
  'other' => 'Other',
);
$arrBsnType = array(
  'anufacturers' => 'Anufacturers',
  'exporter' => 'Exporter',
  'trading' => 'Trading',
  'services' => 'Services',
  'other' => 'Other',
);
$arrTCGroup = array(
  'importer' => 'Importer',
  'prodmft' => 'Product manufacturer',
  'wholesaler' => 'Wholesaler',
  'retailer' => 'Retailer',
  'mall' => 'Mall',
  'distributor' => 'Distributor(Agent/Distributor)',
  'specialstr' => 'Special store',
  'other' => 'Other',
);
$arrAwards = array(
  'awd1' => 'TMARK received year',
  'awd2' => 'DEmark year received',
  'awd3' => 'PM award year received',
  'awd4' => 'Other please specify',
);
$arrEvtMedia = array(
  'newspaper' => 'Newspaper',
  'radiotv' => 'Radio/Television',
  'association' => 'Association',
  'website' => 'DITP website',
  'letter' => 'DITP Invitation letter',
  'other' => 'Other',
);


if($itemid>0){
  $inputFullName = $_POST["inputFullName"];

// echo '<pre>'; print_r($_POST); exit;

  $inputTelephone = (isset($_POST["inputTelephone"]) && $_POST["inputTelephone"] !='') ? $_POST["inputTelephone"] : '';
  $inputAddress = (isset($_POST["inputAddress"]) && $_POST["inputAddress"] !='') ? $_POST["inputAddress"] : '';
  $selectCountry = (isset($_POST["selectCountry"]) && $_POST["selectCountry"] !='') ? $_POST["selectCountry"] : 0;
  $selectProvinceState = (isset($_POST["selectProvinceState"]) && $_POST["selectProvinceState"] !='') ? $_POST["selectProvinceState"] : 0;
  $selectDistrict = (isset($_POST["selectDistrict"]) && $_POST["selectDistrict"] !='') ? $_POST["selectDistrict"] : 0;

  if(isset($_POST["MemberType"]) && $_POST["MemberType"] =='Company') {

  $inputTaxID = (isset($_POST["inputTaxID"]) && $_POST["inputTaxID"] !='') ? $_POST["inputTaxID"] : '';
  $inputRegisterType = (isset($_POST["inputRegisterType"]) && $_POST["inputRegisterType"] !='') ? $_POST["inputRegisterType"] : '';
  $inputCompanyRegisterDate = (isset($_POST["inputCompanyRegisterDate"]) && $_POST["inputCompanyRegisterDate"] !='') ? $_POST["inputCompanyRegisterDate"] : '0000-00-00';
  $inputCompanyNameEN = (isset($_POST["inputCompanyNameEN"]) && $_POST["inputCompanyNameEN"] !='') ? $_POST["inputCompanyNameEN"] : '';
  $inputCompanyNameTH = (isset($_POST["inputCompanyNameTH"]) && $_POST["inputCompanyNameTH"] !='') ? $_POST["inputCompanyNameTH"] : '';

  $selectSubDistrict = (isset($_POST["selectSubDistrict"]) && $_POST["selectSubDistrict"] !='') ? $_POST["selectSubDistrict"] : 0;
  $inputZipCode = (isset($_POST["inputZipCode"]) && $_POST["inputZipCode"] !='') ? $_POST["inputZipCode"] : '';
  $inputFax = (isset($_POST["inputFax"]) && $_POST["inputFax"] !='') ? $_POST["inputFax"] : '';
  $inputMobile = (isset($_POST["inputMobile"]) && $_POST["inputMobile"] !='') ? $_POST["inputMobile"] : '';
  $inputEmail = (isset($_POST["inputEmail"]) && $_POST["inputEmail"] !='') ? $_POST["inputEmail"] : '';
  $inputWebsite = (isset($_POST["inputWebsite"]) && $_POST["inputWebsite"] !='') ? $_POST["inputWebsite"] : '';

  $inputThaiShare = (isset($_POST["inputThaiShare"]) && $_POST["inputThaiShare"] !='') ? $_POST["inputThaiShare"] : 0;
  $inputForeigner = (isset($_POST["inputForeigner"]) && $_POST["inputForeigner"] !='') ? $_POST["inputForeigner"] : 0;
  $inputRegisteredCapital = (isset($_POST["inputRegisteredCapital"]) && $_POST["inputRegisteredCapital"] !='') ? $_POST["inputRegisteredCapital"] : 0;
  $inputDitpMemberNo = (isset($_POST["inputDitpMemberNo"]) && $_POST["inputDitpMemberNo"] !='') ? $_POST["inputDitpMemberNo"] : 0;
  $inputCurrentlyApplying = (isset($_POST["inputCurrentlyApplying"]) && $_POST["inputCurrentlyApplying"] !='') ? $_POST["inputCurrentlyApplying"] : 0;
  
  $inputListMemberType = '';
  if(isset($_POST["inputListMemberType"]) && $_POST["inputListMemberType"] !=''){
    $strMbrType = '';
    foreach($arrMbrType as $k=>$v) {
      $strMbrType .= (in_array($k,$_POST["inputListMemberType"])) ? $k.'|' : '|';
    }
    $strMbrType = substr($strMbrType, 0, -1);
    $inputListMemberType = $strMbrType;
  }
  $inputMemberTypeOther = (isset($_POST["inputMemberTypeOther"]) && $_POST["inputMemberTypeOther"] !='') ? $_POST["inputMemberTypeOther"] : '';
  $inputListBusinessType = '';
  if(isset($_POST["inputListBusinessType"]) && $_POST["inputListBusinessType"] !=''){
    $strBsnType = '';
    foreach($arrBsnType as $k=>$v) {
      $strBsnType .= (in_array($k,$_POST["inputListBusinessType"])) ? $k.'|' : '|';
    }
    $strBsnType = substr($strBsnType, 0, -1);
    $inputListBusinessType = $strBsnType;
  }
  $inputBusinessTypeOther = (isset($_POST["inputBusinessTypeOther"]) && $_POST["inputBusinessTypeOther"] !='') ? $_POST["inputBusinessTypeOther"] : '';
  $inputContactPerson = (isset($_POST["inputContactPerson"]) && $_POST["inputContactPerson"] !='') ? $_POST["inputContactPerson"] : '';
  $inputContactPosition = (isset($_POST["inputContactPosition"]) && $_POST["inputContactPosition"] !='') ? $_POST["inputContactPosition"] : '';
  $inputContactTelephone = (isset($_POST["inputContactTelephone"]) && $_POST["inputContactTelephone"] !='') ? $_POST["inputContactTelephone"] : '';
  $inputContactEmail = (isset($_POST["inputContactEmail"]) && $_POST["inputContactEmail"] !='') ? $_POST["inputContactEmail"] : '';
  $inputDomestic = (isset($_POST["inputDomestic"]) && $_POST["inputDomestic"] !='') ? $_POST["inputDomestic"] : 0;
  $inputAbroad = (isset($_POST["inputAbroad"]) && $_POST["inputAbroad"] !='') ? $_POST["inputAbroad"] : 0;
  $inputManufacturing = (isset($_POST["inputManufacturing"]) && $_POST["inputManufacturing"] !='') ? $_POST["inputManufacturing"] : '';
  $inputProduction = (isset($_POST["inputProduction"]) && $_POST["inputProduction"] !='') ? $_POST["inputProduction"] : '';
  $inputExport = (isset($_POST["inputExport"]) && $_POST["inputExport"] !='') ? $_POST["inputExport"] : 0;
  $inputDomesticSales = (isset($_POST["inputDomesticSales"]) && $_POST["inputDomesticSales"] !='') ? $_POST["inputDomesticSales"] : 0;
  $inputCurrentBusiness = (isset($_POST["inputCurrentBusiness"]) && $_POST["inputCurrentBusiness"] !='') ? $_POST["inputCurrentBusiness"] : '';
  $inputMarketsSuch = (isset($_POST["inputMarketsSuch"]) && $_POST["inputMarketsSuch"] !='') ? $_POST["inputMarketsSuch"] : '';
  $inputListNewProducts = (isset($_POST["inputListNewProducts"]) && $_POST["inputListNewProducts"] !='') ? $_POST["inputListNewProducts"] : '';
  $inputWhichMarkets = (isset($_POST["inputWhichMarkets"]) && $_POST["inputWhichMarkets"] !='') ? $_POST["inputWhichMarkets"] : '';

  $inputListTargetCustomerGroup = '';
  if(isset($_POST["inputListTargetCustomerGroup"]) && $_POST["inputListTargetCustomerGroup"] !=''){
    $strTCGroup = '';
    foreach($arrTCGroup as $k=>$v) {
      $strTCGroup .= (in_array($k,$_POST["inputListTargetCustomerGroup"])) ? $k.'|' : '|';
    }
    $strTCGroup = substr($strTCGroup, 0, -1);
    $inputListTargetCustomerGroup = $strTCGroup;
  }
  $inputTargetCustomerGroupeOther = (isset($_POST["inputTargetCustomerGroupeOther"]) && $_POST["inputTargetCustomerGroupeOther"] !='') ? $_POST["inputTargetCustomerGroupeOther"] : '';
  $inputListAwards = '';
  if(isset($_POST["inputListAwards"]) && $_POST["inputListAwards"] !=''){
    $strAwards = '';
    foreach($arrAwards as $k=>$v) {
      $strAwards .= (in_array($k,$_POST["inputListAwards"])) ? $k.'|' : '|';
    }
    $strAwards = substr($strAwards, 0, -1);
    $inputListAwards = $strAwards;
  }
  $inputAwards_1 = (isset($_POST["inputAwards_1"]) && $_POST["inputAwards_1"] !='') ? $_POST["inputAwards_1"] : '';
  $inputAwards_2 = (isset($_POST["inputAwards_2"]) && $_POST["inputAwards_2"] !='') ? $_POST["inputAwards_2"] : '';
  $inputAwards_3 = (isset($_POST["inputAwards_3"]) && $_POST["inputAwards_3"] !='') ? $_POST["inputAwards_3"] : '';
  $inputAwards_4 = (isset($_POST["inputAwards_4"]) && $_POST["inputAwards_4"] !='') ? $_POST["inputAwards_4"] : '';

  $inputListEventMedia = '';
  if(isset($_POST["inputListEventMedia"]) && $_POST["inputListEventMedia"] !=''){
    $strEvtMedia = '';
    foreach($arrEvtMedia as $k=>$v) {
      $strEvtMedia .= (in_array($k,$_POST["inputListEventMedia"])) ? $k.'|' : '|';
    }
    $strEvtMedia = substr($strEvtMedia, 0, -1);
    $inputListEventMedia = $strEvtMedia;
  }
  $inputEventMediaOther = (isset($_POST["inputEventMediaOther"]) && $_POST["inputEventMediaOther"] !='') ? $_POST["inputEventMediaOther"] : '';

  }

/*
Array
(
    [saveData] => valueID=oGSaG3FDnou44UPwoou34RkyoJqaLKEjnJ54o3OcoKE3L0kuoFMaMKE0nJS4MUOjoKI3G0lDooua4UFwnou44UOyoKO3rHk0oJ5ao3EcnKE4L3OuoFM3ZRj0oGSaG3FDnou44UPwoou34RkxoJyaoKEynKE4nKNzoGy3ZxkhoJyaoKExnHS4G3PDoou34Rlwooua4UERnHy4qKOhoJI3GHksoJ5anKEanJ94GNo7o3Qo7o3Q
    [DataCheckMemtype] => 
    [MemberType] => Company
    [inputTaxID] => 0123562004698
    [inputRegisterType] => Person
    [inputCompanyRegisterDate] => 2019-10-10
    [inputCompanyNameEN] => cmpnyEN
    [inputCompanyNameTH] => cmpnyTH
    [inputAddress] => 88/159 Moo 2 Tambol Wat Chalor
    [inputCountryID] => 219
    [inputCountry] => Thailand
    [selectCountry] => 219
    [inputProvinceStateID] => 3510
    [inputProvinceState] => Roi Et
    [selectProvinceState] => 3510
    [inputDistrictID] => 106226
    [inputDistrict] => Amphoe Si Somdet
    [selectDistrict] => 106226
    [inputSubDistrictID] => 3669
    [inputSubDistrict] => Si Somdet
    [selectSubDistrict] => 3669
    [inputZipCode] => 45000
    [inputTelephone] => 0922826153
    [inputFax] => 020233370
    [inputMobile] => 0922826153
    [inputEmail] => dreamangkanaporn@gmail.com
    [inputWebsite] => www.thaiddchef.com
    [inputThaiShare] => 90
    [inputForeigner] => 80
    [inputRegisteredCapital] => 100000
    [inputDitpMemberNo] => 1234
    [inputCurrentlyApplying] => 2
    [inputListMemberType] => Array
        (
            [0] => el
            [1] => tdc
            [2] => inprog
            [3] => other
        )
    [inputMemberTypeOther] => m type other
    [inputListBusinessType] => Array
        (
            [0] => anufacturers
            [1] => trading
        )
    [inputBusinessTypeOther] => b type other
    [inputContactPerson] => อังคณาภรณ์1
    [inputContactPosition] => กรรมการผู้จัดการ2
    [inputContactTelephone] => 09228261533
    [inputContactEmail] => thaiddchef@gmail.com4
    [inputDomestic] => 90
    [inputAbroad] => 80
    [inputManufacturing] => THAIFDA, HALAN, BRC, IFS, USFDA Aa
    [inputProduction] => 300,000 กล่อง / ปี Bb
    [inputExport] => 70
    [inputDomesticSales] => 60
    [inputCurrentBusiness] => เครื่องผัดสำเร็จรูป DD CHEF Cc
    [inputMarketsSuch] => เครื่องผัดสำเร็จรูป DD CHEF Dd
    [inputListNewProducts] => เครื่องผัดสำเร็จรูป DD CHEF Ff
    [inputWhichMarkets] => Gg
    [inputListTargetCustomerGroup] => Array
        (
            [0] => importer
            [1] => mall
            [2] => other
        )

    [inputTargetCustomerGroupeOther] => อื่นๆ 1
    [inputListAwards] => Array
        (
            [0] => awd1
            [1] => awd2
            [2] => awd4
        )

    [inputAwards_1] => A
    [inputAwards_2] => B
    [inputAwards_3] => 
    [inputAwards_4] => C
    [inputListEventMedia] => Array
        (
            [0] => newspaper
            [1] => association
            [2] => letter
            [3] => other
        )

    [inputEventMediaOther] => other AAA
)
*/

  // $inputGender = (!empty($_POST["inputGender"])?$_POST["inputGender"]:'M');
  // $BirthdaySelectDay = $_POST["BirthdaySelectDay"];
  // $BirthdaySelectMonth = $_POST["BirthdaySelectMonth"];
  // $BirthdaySelectYear = $_POST["BirthdaySelectYear"];
  // $Birthday = $BirthdaySelectYear."-".$BirthdaySelectMonth."-".$BirthdaySelectDay;

  if(isset($_POST["MemberType"]) && ($_POST["MemberType"] == 'User' || $_POST["MemberType"] == 'Restaurant')) {

  $update[_TABLE_MEMBER_."_Name"] = "'".sql_safe($inputFullName)."'";
  // $update[_TABLE_MEMBER_."_Username"] = "'".sql_safe($inputUsername)."'";
  // $update[_TABLE_MEMBER_."_Email"] = "'".sql_safe($inputEmail)."'";
  $update[_TABLE_MEMBER_."_ContactNo"] = "'".sql_safe($inputTelephone)."'";
  $update[_TABLE_MEMBER_."_Address"] = "'".sql_safe($inputAddress)."'";
  $update[_TABLE_MEMBER_."_Country"] = "'".sql_safe($selectCountry)."'";
  $update[_TABLE_MEMBER_."_Province"] = "'".sql_safe($selectProvinceState)."'";
  $update[_TABLE_MEMBER_."_District"] = "'".sql_safe($selectDistrict)."'";

  } 
  else if(isset($_POST["MemberType"]) && $_POST["MemberType"] == 'Company') {

  $update[_TABLE_MEMBER_."_TaxID"] = "'".sql_safe($inputTaxID)."'";
  $update[_TABLE_MEMBER_."_Register_type"] = "'".sql_safe($inputRegisterType)."'";
  $update[_TABLE_MEMBER_."_Company_register_date"] = "'".sql_safe($inputCompanyRegisterDate)."'";
  $update[_TABLE_MEMBER_."_Company_NameEN"] = "'".sql_safe($inputCompanyNameEN)."'";
  $update[_TABLE_MEMBER_."_Company_NameTH"] = "'".sql_safe($inputCompanyNameTH)."'";
  $update[_TABLE_MEMBER_."_Company_telephone"] = "'".sql_safe($inputTelephone)."'";
  $update[_TABLE_MEMBER_."_Company_fax"] = "'".sql_safe($inputFax)."'";
  $update[_TABLE_MEMBER_."_Company_mobile"] = "'".sql_safe($inputMobile)."'";
  $update[_TABLE_MEMBER_."_Company_email"] = "'".sql_safe($inputEmail)."'";
  $update[_TABLE_MEMBER_."_Company_website"] = "'".sql_safe($inputWebsite)."'";
  $update[_TABLE_MEMBER_."_Address"] = "'".sql_safe($inputAddress)."'";
  $update[_TABLE_MEMBER_."_Country"] = "'".sql_safe($selectCountry)."'";
  $update[_TABLE_MEMBER_."_Province"] = "'".sql_safe($selectProvinceState)."'";
  $update[_TABLE_MEMBER_."_District"] = "'".sql_safe($selectDistrict)."'";
  $update[_TABLE_MEMBER_."_SubDistrict"] = "'".sql_safe($selectSubDistrict)."'";
  $update[_TABLE_MEMBER_."_ZipCode"] = "'".sql_safe($inputZipCode)."'";

  $update[_TABLE_MEMBER_."_Thai_share"] = "'".sql_safe($inputThaiShare)."'";
  $update[_TABLE_MEMBER_."_Foreigner_share"] = "'".sql_safe($inputForeigner)."'";
  $update[_TABLE_MEMBER_."_Registered_capital"] = "'".sql_safe($inputRegisteredCapital)."'";
  $update[_TABLE_MEMBER_."_Ditp_member_no"] = "'".sql_safe($inputDitpMemberNo)."'";
  $update[_TABLE_MEMBER_."_Currently_applying"] = "'".sql_safe($inputCurrentlyApplying)."'";
  $update[_TABLE_MEMBER_."_Member_type"] = "'".sql_safe($inputListMemberType)."'";
  $update[_TABLE_MEMBER_."_Member_type_other"] = "'".sql_safe($inputMemberTypeOther)."'";
  $update[_TABLE_MEMBER_."_Business_type"] = "'".sql_safe($inputListBusinessType)."'";
  $update[_TABLE_MEMBER_."_Business_type_other"] = "'".sql_safe($inputBusinessTypeOther)."'";
  $update[_TABLE_MEMBER_."_Contact_person"] = "'".sql_safe($inputContactPerson)."'";
  $update[_TABLE_MEMBER_."_Contact_position"] = "'".sql_safe($inputContactPosition)."'";
  $update[_TABLE_MEMBER_."_Contact_phone"] = "'".sql_safe($inputContactTelephone)."'";
  $update[_TABLE_MEMBER_."_Contact_email"] = "'".sql_safe($inputContactEmail)."'";
  $update[_TABLE_MEMBER_."_Domestic"] = "'".sql_safe($inputDomestic)."'";
  $update[_TABLE_MEMBER_."_Abroad"] = "'".sql_safe($inputAbroad)."'";
  $update[_TABLE_MEMBER_."_Manufacturing_standards"] = "'".sql_safe($inputManufacturing)."'";
  $update[_TABLE_MEMBER_."_Production_capacity"] = "'".sql_safe($inputProduction)."'";
  $update[_TABLE_MEMBER_."_Export"] = "'".sql_safe($inputExport)."'";
  $update[_TABLE_MEMBER_."_Domestic_sales"] = "'".sql_safe($inputDomesticSales)."'";
  $update[_TABLE_MEMBER_."_Current_business_export"] = "'".sql_safe($inputCurrentBusiness)."'";
  $update[_TABLE_MEMBER_."_Market_such_as_country"] = "'".sql_safe($inputMarketsSuch)."'";
  $update[_TABLE_MEMBER_."_New_product_expand"] = "'".sql_safe($inputListNewProducts)."'";
  $update[_TABLE_MEMBER_."_Market_including_countries"] = "'".sql_safe($inputWhichMarkets)."'";

  $update[_TABLE_MEMBER_."_Target_customer_group"] = "'".sql_safe($inputListTargetCustomerGroup)."'";
  $update[_TABLE_MEMBER_."_Target_customer_group_other"] = "'".sql_safe($inputTargetCustomerGroupeOther)."'";
  $update[_TABLE_MEMBER_."_Awards"] = "'".sql_safe($inputListAwards)."'";
  $update[_TABLE_MEMBER_."_Awards_txt_1"] = "'".sql_safe($inputAwards_1)."'";
  $update[_TABLE_MEMBER_."_Awards_txt_2"] = "'".sql_safe($inputAwards_2)."'";
  $update[_TABLE_MEMBER_."_Awards_txt_3"] = "'".sql_safe($inputAwards_3)."'";
  $update[_TABLE_MEMBER_."_Awards_txt_4"] = "'".sql_safe($inputAwards_4)."'";

  $update[_TABLE_MEMBER_."_Event_media"] = "'".sql_safe($inputListEventMedia)."'";
  $update[_TABLE_MEMBER_."_Event_media_other"] = "'".sql_safe($inputEventMediaOther)."'";



  }

	$update[_TABLE_MEMBER_."_LastUpdate"] = "NOW()";
	$update[_TABLE_MEMBER_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  // echo '<pre>';print_r($update);exit;
	$z = new __webctrl;
	$z->update(_TABLE_MEMBER_,$update,array(_TABLE_MEMBER_."_ID=" => (int)$itemid));
	unset($update);
}

echo 2;
CloseDB();
?>
