<?php
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
$arrf[] = "a."._TABLE_MEMBER_."_MemberType AS MemberType";
$arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
$arrf[] = "a."._TABLE_MEMBER_."_Name AS FullName";
$arrf[] = "a."._TABLE_MEMBER_."_Address AS Address";
$arrf[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '', a."._TABLE_MEMBER_."_Email) as Email";
$arrf[] = "IF(a."._TABLE_MEMBER_."_ContactNo IS NULL or a."._TABLE_MEMBER_."_ContactNo = '', '', a."._TABLE_MEMBER_."_ContactNo) as Tel";
$arrf[] = "a."._TABLE_MEMBER_."_Country AS Country";
$arrf[] = "a."._TABLE_MEMBER_."_Province AS Province";
$arrf[] = "a."._TABLE_MEMBER_."_District AS District";
$arrf[] = "a."._TABLE_MEMBER_."_SubDistrict AS SubDistrict";
$arrf[] = "a."._TABLE_MEMBER_."_ZipCode AS ZipCode";

$arrf[] = "a."._TABLE_MEMBER_."_TaxID AS TaxID";
$arrf[] = "a."._TABLE_MEMBER_."_Register_type AS Register_type";
$arrf[] = "a."._TABLE_MEMBER_."_Company_register_date AS Company_register_date";
$arrf[] = "a."._TABLE_MEMBER_."_Company_NameEN AS CompanyNameEN";
$arrf[] = "a."._TABLE_MEMBER_."_Company_NameTH AS CompanyNameTH";
$arrf[] = "a."._TABLE_MEMBER_."_Company_telephone AS Company_telephone";
$arrf[] = "a."._TABLE_MEMBER_."_Company_fax AS Company_fax";
$arrf[] = "a."._TABLE_MEMBER_."_Company_mobile AS Company_mobile";
$arrf[] = "a."._TABLE_MEMBER_."_Company_email AS Company_email";
$arrf[] = "a."._TABLE_MEMBER_."_Company_website AS Company_website";

$arrf[] = "a."._TABLE_MEMBER_."_Thai_share AS Thai_share";
$arrf[] = "a."._TABLE_MEMBER_."_Foreigner_share AS Foreigner_share";
$arrf[] = "a."._TABLE_MEMBER_."_Registered_capital AS Registered_capital";
$arrf[] = "a."._TABLE_MEMBER_."_Ditp_member_no AS Ditp_member_no";
$arrf[] = "a."._TABLE_MEMBER_."_Currently_applying AS Currently_applying";
$arrf[] = "a."._TABLE_MEMBER_."_Member_type AS Member_type";
$arrf[] = "a."._TABLE_MEMBER_."_Member_type_other AS Member_type_other";
$arrf[] = "a."._TABLE_MEMBER_."_Business_type AS Business_type";
$arrf[] = "a."._TABLE_MEMBER_."_Business_type_other AS Business_type_other";
$arrf[] = "a."._TABLE_MEMBER_."_Contact_person AS Contact_person";
$arrf[] = "a."._TABLE_MEMBER_."_Contact_position AS Contact_position";
$arrf[] = "a."._TABLE_MEMBER_."_Contact_phone AS Contact_phone";
$arrf[] = "a."._TABLE_MEMBER_."_Contact_email AS Contact_email";
$arrf[] = "a."._TABLE_MEMBER_."_Domestic AS Domestic";
$arrf[] = "a."._TABLE_MEMBER_."_Abroad AS Abroad";
$arrf[] = "a."._TABLE_MEMBER_."_Manufacturing_standards AS Manufacturing_standards";
$arrf[] = "a."._TABLE_MEMBER_."_Production_capacity AS Production_capacity";
$arrf[] = "a."._TABLE_MEMBER_."_Export AS Export";
$arrf[] = "a."._TABLE_MEMBER_."_Domestic_sales AS Domestic_sales";
$arrf[] = "a."._TABLE_MEMBER_."_Current_business_export AS Current_business_export";
$arrf[] = "a."._TABLE_MEMBER_."_Market_such_as_country AS Market_such_as_country";
$arrf[] = "a."._TABLE_MEMBER_."_New_product_expand AS New_product_expand";
$arrf[] = "a."._TABLE_MEMBER_."_Market_including_countries AS Market_including_countries";

$arrf[] = "a."._TABLE_MEMBER_."_Target_customer_group AS Target_customer_group";
$arrf[] = "a."._TABLE_MEMBER_."_Target_customer_group_other AS Target_customer_group_other";
$arrf[] = "a."._TABLE_MEMBER_."_Awards AS Awards";
$arrf[] = "a."._TABLE_MEMBER_."_Awards_txt_1 AS Awards_txt_1";
$arrf[] = "a."._TABLE_MEMBER_."_Awards_txt_2 AS Awards_txt_2";
$arrf[] = "a."._TABLE_MEMBER_."_Awards_txt_3 AS Awards_txt_3";
$arrf[] = "a."._TABLE_MEMBER_."_Awards_txt_4 AS Awards_txt_4";
$arrf[] = "a."._TABLE_MEMBER_."_Event_media AS Event_media";
$arrf[] = "a."._TABLE_MEMBER_."_Event_media_other AS Event_media_other";


$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
$sql .= " WHERE "._TABLE_MEMBER_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
// $Birthday = dateformat($Row["Birthday"]." 00:00:00",'j M Y',$_SESSION['Session_Admin_Language']);
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$DataCheckMemtype = "";
$MemberLevel = $Row["MemberLevel"];
$MemberLevelText = $arrMemberLevel[$MemberLevel];

$lang = ($_SESSION['Session_Admin_Language'] == 'TH') ? $_SESSION['Session_Admin_Language'] : 'EN';

$Country = $Row["Country"];
$arrf = array();
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_ID AS ID";
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_CountryID AS CountryID";
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_CountryCode AS CountryCode";
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_ISONumeric AS ISONumeric";
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_CountryLongCode AS CountryLongCode";
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_CountryNameTH AS CountryNameTH";
$arrf[] = "a."._TABLE_ADDRCOUNTRIES_."_CountryNameEN AS CountryNameEN";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRCOUNTRIES_." a";
$sql .= " WHERE "._TABLE_ADDRCOUNTRIES_."_CountryID = ".(int)$Country;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$RowC = $v[0];
$Country = $RowC["CountryName".$lang];

$Province = $Row["Province"];
$arrf = array();
$arrf[] = "a."._TABLE_ADDRSTATE_.'_ID AS ID';
$arrf[] = "a."._TABLE_ADDRSTATE_.'_CountryID AS CountryID';
$arrf[] = "a."._TABLE_ADDRSTATE_.'_CountryCode AS CountryCode';
$arrf[] = "a."._TABLE_ADDRSTATE_.'_StateID AS StateID';
$arrf[] = "a."._TABLE_ADDRSTATE_.'_NameTH AS NameTH';
$arrf[] = "a."._TABLE_ADDRSTATE_.'_NameEN AS NameEN';
$arrf[] = "a."._TABLE_ADDRSTATE_.'_Code AS Code';
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSTATE_." a";
$sql .= " WHERE "._TABLE_ADDRSTATE_."_StateID = ".(int)$Province;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$RowP = $v[0];
$Province = $RowP["Name".$lang];

$District = $Row["District"];
$arrf = array();
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_ID AS ID';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_CountryID AS CountryID';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_CountryCode AS CountryCode';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_StatesID AS StatesID';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_DistrictID AS DistrictID';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_NameTH AS NameTH';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_NameEN AS NameEN';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_Code AS Code';
$arrf[] = "a."._TABLE_ADDRDISTRICT_.'_ProvinceCode AS ProvinceCode';
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRDISTRICT_." a";
$sql .= " WHERE "._TABLE_ADDRDISTRICT_."_DistrictID = ".(int)$District;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$RowD = $v[0];
$District = $RowD["Name".$lang];

$SubDistrict = $Row["SubDistrict"];
$arrf = array();
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_ID AS ID';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_CountryID AS CountryID';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_CountryCode AS CountryCode';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_StatesID AS StatesID';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_DistrictID AS DistrictID';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_NameTH AS NameTH';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_NameEN AS NameEN';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_Code AS Code';
$arrf[] = "a."._TABLE_ADDRSUBDISTRICT_.'_ZipCode AS ZipCode';
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSUBDISTRICT_." a";
$sql .= " WHERE "._TABLE_ADDRSUBDISTRICT_."_ID = ".(int)$SubDistrict;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$RowS = $v[0];
$SubDistrict = $RowS["Name".$lang];
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:View"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 05"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTypeMember"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['MemberType']; ?>
                &nbsp;&nbsp;
                <?php
                $flag_color = "#fff";
                if($Row['MemberType'] == 'User') {
                  $flag_color = "#F9003E";
                }
                else if($Row['MemberType'] == 'Restaurant') {
                  $flag_color = "#B1844B";
                }
                else if($Row['MemberType'] == 'Company') {
                  $flag_color = "#586D33";
                }
                ?>
                <i class="fas fa-circle" style="color: <?php echo $flag_color; ?>;"></i>
              </p>
            </div>
					</div>
				</div>

    <?php if($Row['MemberType'] == 'User' || $Row['MemberType'] == 'Restaurant') { ?>

        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['FullName']; ?></p>
            </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputUsername"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Username']; ?></p>
            </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPassword"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted">******</p>
            </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Email']; ?></p>
            </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Tel']; ?></p>
            </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Address']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Country; //$Row['Country']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvinceState"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Province; //$Row['Province']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $District; //$Row['District']; ?></p>
            </div>
					</div>
				</div>
        <!--
        <div class="section-divider mb40" id="spy2">
            <span><?php //echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label">Images</label>
          <div class="col-lg-8">
            <div class="bs-component">
              <?php
              // $lkeyindex = "Home";
              ?>
              <div class="showoption" id="showoption<?php echo $lkeyindex?>">
                <?php
                // $PictureFileHome = $PathUploadPicture.$Row["PictureFile"];
                // if(is_file($PictureFileHome)){
                //   echo '<div><img src="'.$PictureFileHome.'" alt="" /></div>';
                // }
                ?>
              </div>
            </div>
          </div>
        </div>
        -->

    <?php }else if($Row['MemberType'] == 'Company') { ?>

        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 06"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-12 control-label text-left"><strong><?php echo $Array_Mod_Lang["txt:Head 07"][$_SESSION['Session_Admin_Language']]?></strong></label>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaxID"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['TaxID']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputRegisterType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Register_type']; ?></p>
            </div>
					</div>
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCompanyRegisterDate"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Company_register_date']; ?></p>
            </div>
					</div>
				</div>
       
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCompanyNameEN"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['CompanyNameEN']; ?></p>
            </div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCompanyNameTH"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['CompanyNameTH']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Address']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Country; //$Row['Country']; ?></p>
            </div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvinceState"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Province; //$Row['Province']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $District; //$Row['District']; ?></p>
            </div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubDistrict"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $SubDistrict; //$Row['SubDistrict']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['ZipCode']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Company_telephone']; ?></p>
            </div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Company_fax']; ?></p>
            </div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMobile"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Company_mobile']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Company_email']; ?></p>
            </div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Company_website']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtShareholder"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-9">
            <div class="bs-component">
              
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputThaiShare"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Thai_share']!='') ? $Row['Thai_share'].'%':''; ?></p>
            </div>
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputForeigner"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Foreigner_share']!='') ? $Row['Foreigner_share'].'%':''; ?></p>
            </div>
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputRegisteredCapital"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Registered_capital']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtDitpMemberNo"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Ditp_member_no']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCurrentlyApplying"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Currently_applying']==2)?'[Yes]':'[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]'; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtMemberType"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-9">
            <div class="bs-component">
              
            </div>
					</div>
				</div>

        <div class="form-group">
          <?php
          $rowMtype = ($Row['Member_type']!='')?$Row['Member_type']:'||||||||'; // '|||||||inprog|';
          $rowMtype = explode('|',$rowMtype);
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
          ?>
          <?php
          $i=0;
          foreach($arrMbrType as $k=>$v) {
          ?>
          <div class="col-md-2 control-label text-right"><?php echo $v; ?></div>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($rowMtype[$i]==$k?'[Yes]':'[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]')?></p>
            </div>
          </div>
          <?php
            $i++;
          }
          ?>
        </div>

        <div class="form-group">
          <label class="col-md-2 control-label">OtherTxt:</label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Member_type_other']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtBusinessType"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-9">
            <div class="bs-component">
              
            </div>
					</div>
				</div>

        <div class="form-group">
        <?php
          $rowBtype = ($Row['Business_type']!='')?$Row['Business_type']:'||||';
          $rowBtype = explode('|',$rowBtype);
          $arrBsnType = array(
            'anufacturers' => 'Anufacturers',
            'exporter' => 'Exporter',
            'trading' => 'Trading',
            'services' => 'Services',
            'other' => 'Other',
          );
        ?>
        <?php
          $j=0;
          foreach($arrBsnType as $k=>$v) {
        ?>
          <div class="col-md-2 control-label text-right"><?php echo $v; ?></div>
          <div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($rowBtype[$j]==$k?'[Yes]':'[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]')?></p>
            </div>
          </div>
        <?php
            $j++;
          }
        ?>
        </div>

        <div class="form-group">
          <label class="col-md-2 control-label">OtherTxt:</label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Business_type_other']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactPerson"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Contact_person']; ?></p>
            </div>
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Contact_position']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Contact_phone']; ?></p>
            </div>
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Contact_email']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-12 control-label text-left"><strong><?php echo $Array_Mod_Lang["txt:Head 08"][$_SESSION['Session_Admin_Language']]?></strong></label>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtRowMaterial"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-9">
            <div class="bs-component">
              
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDomestic"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Domestic']!='') ? $Row['Domestic'].'%':''; ?></p>
            </div>
					</div>
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAbroad"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Abroad']!='') ? $Row['Abroad'].'%':''; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputManufacturing"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Manufacturing_standards']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProduction"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Production_capacity']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-8 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtBusinessGuidelines"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-4">
            <div class="bs-component">
              
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputExport"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Export']!='') ? $Row['Export'].'%':''; ?></p>
            </div>
					</div>
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDomesticSales"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($Row['Domestic_sales']!='') ? $Row['Domestic_sales'].'%':''; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCurrentBusiness"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Current_business_export']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMarketsSuch"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Market_such_as_country']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputListNewProducts"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['New_product_expand']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWhichMarkets"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Market_including_countries']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-3 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtTargetCustomerGroup"][$_SESSION['Session_Admin_Language']]?></u></label>
          <div class="col-md-9">
            <div class="bs-component">
             
            </div>
					</div>
				</div>

        <div class="form-group">
        <?php
          $rowTCGroup = ($Row['Target_customer_group']!='')?$Row['Target_customer_group']:'|||||||'; 
          $rowTCGroup = explode('|',$rowTCGroup);
          
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
        ?>
        <?php
          $j=0;
          foreach($arrTCGroup as $k=>$v) {
        ?>
          <div class="col-md-3 control-label text-right"><?php echo $v; ?></div>
          <div class="col-md-1">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($rowTCGroup[$j]==$k?'[Yes]':'[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]')?></p>
            </div>
          </div>
        <?php
            $j++;
          }
        ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">OtherTxt:</label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Target_customer_group_other']; ?></p>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-3 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtAwards"][$_SESSION['Session_Admin_Language']]?></u></label>
          <div class="col-md-9">
            <div class="bs-component">
             
            </div>
					</div>
				</div>

        
        <?php
          $rowAwards = ($Row['Awards']!='')?$Row['Awards']:'||'; 
          $rowAwards = explode('|',$rowAwards);
          
          $arrAwards = array(
            'awd1' => 'TMARK received year',
            'awd2' => 'DEmark year received',
            'awd3' => 'PM award year received',
            'awd4' => 'Other please specify',
          );
        ?>
        <?php
          $j=0;$jj=0;
          foreach($arrAwards as $k=>$v) {
            $jj++;
        ?>
        <div class="form-group">
          <div class="col-md-3 control-label text-right"><?php echo $v; ?></div>
          <div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($rowAwards[$j]==$k?'[Yes]':'[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]')?></p>
            </div>
          </div>
          <div class="col-md-6 control-label text-left">
            Text: <?php echo $Row['Awards_txt_'.$jj]; ?>
          </div>
        </div>
        <?php
            $j++;
          }
        ?>


        <div class="form-group">
					<label class="col-md-12 control-label text-left"><strong><?php echo $Array_Mod_Lang["txt:Head 09"][$_SESSION['Session_Admin_Language']]?></strong></label>
				</div>

        <div class="form-group">
					<label class="col-md-12 control-label text-left"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3H1"][$_SESSION['Session_Admin_Language']]?></u></label>
				</div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P1"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P2"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P3"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P4"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>

        <div class="form-group">
					<label class="col-md-12 control-label text-left"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3H2"][$_SESSION['Session_Admin_Language']]?></u></label>
				</div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P5"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P6"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>
        <div class="form-group">
					<label class="col-md-6 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P7"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
        </div>
        <div class="form-group">
					<label class="col-md-12 control-label text-left"><?php echo $Array_Mod_Lang["txtinput:inputTxtStep3P8"][$_SESSION['Session_Admin_Language']]?></label>
        </div>


        <div class="form-group">
					<label class="col-md-12 control-label text-left"><strong><?php echo $Array_Mod_Lang["txt:Head 10"][$_SESSION['Session_Admin_Language']]?></strong></label>
				</div>

        <div class="form-group">
        <?php
          $rowEvtMedia = ($Row['Event_media']!='')?$Row['Event_media']:'|||||'; 
          $rowEvtMedia = explode('|',$rowEvtMedia);
          
          $arrEvtMedia = array(
            'newspaper' => 'Newspaper',
            'radiotv' => 'Radio/Television',
            'association' => 'Association',
            'website' => 'DITP website',
            'letter' => 'DITP Invitation letter',
            'other' => 'Other',
          );
        ?>
        <?php
          $j=0;
          foreach($arrEvtMedia as $k=>$v) {
        ?>
          <div class="col-md-3 control-label text-right"><?php echo $v; ?></div>
          <div class="col-md-1">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo ($rowEvtMedia[$j]==$k?'[Yes]':'[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]')?></p>
            </div>
          </div>
        <?php
            $j++;
          }
        ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">OtherTxt:</label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Event_media_other']; ?></p>
            </div>
					</div>
				</div>



    <?php } ?>


				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
