<?php
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$arrf = array();
$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
$arrf[] = "a."._TABLE_MEMBER_."_MemberType AS MemberType";
$arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
$arrf[] = "a."._TABLE_MEMBER_."_Name AS FullName";
$arrf[] = "a."._TABLE_MEMBER_."_Email AS Email";
$arrf[] = "a."._TABLE_MEMBER_."_ContactNo AS Telephone";
$arrf[] = "a."._TABLE_MEMBER_."_Address AS Address";
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

$arrf[] = "a."._TABLE_MEMBER_."_Target_customer_group  AS Target_customer_group ";
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
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$DataCheckMemtype = "";

$Country = $Row["Country"];
$Province = $Row["Province"];
$District = $Row["District"];
$SubDistrict = $Row["SubDistrict"];

$countryInfo = getInfoCountry($Country);
$CountryName = $countryInfo->data['CountryName'];
/*
stdClass Object
(
    [datacount] => 1
    [data] => Array
        (
            [CountryID] => 219
            [CountryCode] => TH
            [CountryLongCode] => THA
            [CountryName] => Thailand
        )
)
*/
$provinceInfo = getInfoState($Province);
$ProvinceName = $provinceInfo->data['StateName'];
$districtInfo = getInfoCity($District);
$DistrictName = $districtInfo->data['Name'];
$subdistrictInfo = getInfoSubDistrict($SubDistrict);
$SubDistrictName = $subdistrictInfo->data['Name'];
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitFrm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTypeMember"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <input type="hidden" name="MemberType" class="gui-input" value="<?php echo $Row['MemberType']; ?>">
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

    <?php if($Row['MemberType'] == 'User' || $Row['MemberType'] == 'Restaurant') { ?>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputUsername"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <p class="form-control-static text-muted"><?php echo $Row['Username']; ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputFullName"?>" class="gui-input reqs" value="<?php echo $Row['FullName']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<!-- <input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="<?php echo $Row['Email']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>"> -->
            <p class="form-control-static text-muted"><?php echo $Row['Email']; ?></p>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="<?php echo $Row['Telephone']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputAddress"?>" class="gui-input" value="<?php echo $Row['Address']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label for="inputSelect" class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4 frmalert">
            <?php
              $dataCountry = getListCountry();
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputCountryID" class="gui-input" value="'.$Country.'">';
                echo '<input type="hidden" name="inputCountry" class="gui-input" value="'.$CountryName.'">';
                echo '<select name="selectCountry" class="inputCountry" data-rule-required="true" data-msg-required="Select Country">';
                echo '<option value=""> - - Select Country - - </option>';
                if($dataCountry->datacount>0){
                  foreach($dataCountry->data as $gk=>$gv){
                    echo '<option value="'.$gv["countryid"].'" '.($Country==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
				</div>
        <div class="form-group">
					<label for="inputSelect" class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvinceState"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4 frmalert">
            <?php
              $dataProvince = getListProvince($Country);
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputProvinceStateID" class="gui-input" value="'.$Province.'">';
                echo '<input type="hidden" name="inputProvinceState" class="gui-input" value="'.$ProvinceName.'">';
                echo '<select name="selectProvinceState" class="inputProvinceState" data-rule-required="true" data-msg-required="Select Province">';
                echo '<option value=""> - - Select Province/State - - </option>';
                if($dataProvince->datacount>0){
                  foreach($dataProvince->data as $gk=>$gv){
                    echo '<option value="'.$gv["id"].'" '.($Province==$gv["id"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
				</div>
        <div class="form-group">
					<label for="inputSelect" class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4 frmalert">
            <?php
              $dataDistrict = getListCity($Province,$Country);
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputDistrictID" class="gui-input" value="'.$District.'">';
                echo '<input type="hidden" name="inputDistrict" class="gui-input" value="'.$DistrictName.'">';
                echo '<select name="selectDistrict" class="inputDistrict" data-rule-required="true" data-msg-required="Select District">';
                echo '<option value=""> - - Select District - - </option>';
                if($dataDistrict->datacount>0){
                  foreach($dataDistrict->data as $gk=>$gv){
                    echo '<option value="'.$gv["DistrictID"].'" '.($District==$gv["DistrictID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
				</div>


        
        <!-- <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label">Images</label>
          <div class="col-lg-8">
            <div class="bs-component">
              <?php
              $lkeyindex = "Home";
              ?>
              <div id="progress<?php echo $lkeyindex?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
              <div id="output<?php echo $lkeyindex?>"><! -- error or success results -- ></div>
              <div class="showoption" id="showoption<?php echo $lkeyindex?>">
                <?php
                $PictureFileHome = $PathUploadPicture.$Row["PictureFile"];
                if(is_file($PictureFileHome)){
                  echo '<div><img src="'.$PictureFileHome.'" alt="" /></div>';
                }
                ?>
              </div>
              <div class="postuploadicon">
                <label for="fileToUpload<?php echo $lkeyindex?>" class="labeluploadfile">
                  <img src="./images/uploadnow.jpg" />
                </label> <span><?php echo "min size ".$defaultdata[$Login_MenuID]["imghome"]["W"]." * ".$defaultdata[$Login_MenuID]["imghome"]["H"]." px."?></span>
                <input name="fileToUpload<?php echo $lkeyindex?>" class="uploadFile" type="file" id="fileToUpload<?php echo $lkeyindex?>" accept="image/*" onChange="return ajaxuFileUploadProgressImg(this);" />
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
            <input type="text" name="<?php echo "inputTaxID"?>" class="gui-input" value="<?php echo $Row['TaxID']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTaxID"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputRegisterType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <input type="text" name="<?php echo "inputRegisterType"?>" class="gui-input" value="<?php echo $Row['Register_type']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputRegisterType"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCompanyRegisterDate"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <div class="section">
              <label for="datepickerFrom" class="field prepend-icon">
                <input type="text" id="inputCompanyRegisterDate" name="inputCompanyRegisterDate" readonly="readonly" class="gui-input" value="<?php echo $Row['Company_register_date']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputCompanyRegisterDate"][$_SESSION['Session_Admin_Language']]?>">
                <label class="field-icon"><i class="fa fa-calendar-o"></i></label>
              </label>
            </div>
					</div>
				</div>
       
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCompanyNameEN"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <input type="text" name="<?php echo "inputCompanyNameEN"?>" class="gui-input" value="<?php echo $Row['CompanyNameEN']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputCompanyNameEN"][$_SESSION['Session_Admin_Language']]?>">
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCompanyNameTH"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <input type="text" name="<?php echo "inputCompanyNameTH"?>" class="gui-input" value="<?php echo $Row['CompanyNameTH']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputCompanyNameTH"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <textarea name="<?php echo "inputAddress"?>" class="form-control" id="<?php echo "inputAddress"?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?>" rows="3"><?php echo $Row['Address']; ?></textarea>
            </div>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 frmalert">
            <?php
              $dataCountry = getListCountry();
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputCountryID" class="gui-input" value="'.$Country.'">';
                echo '<input type="hidden" name="inputCountry" class="gui-input" value="'.$CountryName.'">';
                echo '<select name="selectCountry" class="inputCountry" data-rule-required="true" data-msg-required="Select Country">';
                echo '<option value=""> - - Select Country - - </option>';
                if($dataCountry->datacount>0){
                  foreach($dataCountry->data as $gk=>$gv){
                    echo '<option value="'.$gv["countryid"].'" '.($Country==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvinceState"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4 frmalert">
            <?php
              $dataProvince = getListProvince($Country);
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputProvinceStateID" class="gui-input" value="'.$Province.'">';
                echo '<input type="hidden" name="inputProvinceState" class="gui-input" value="'.$ProvinceName.'">';
                echo '<select name="selectProvinceState" class="inputProvinceState" data-rule-required="true" data-msg-required="Select Province">';
                echo '<option value=""> - - Select Province/State - - </option>';
                if($dataProvince->datacount>0){
                  foreach($dataProvince->data as $gk=>$gv){
                    echo '<option value="'.$gv["id"].'" '.($Province==$gv["id"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 frmalert">
            <?php
              $dataDistrict = getListCity($Province,$Country);
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputDistrictID" class="gui-input" value="'.$District.'">';
                echo '<input type="hidden" name="inputDistrict" class="gui-input" value="'.$DistrictName.'">';
                echo '<select name="selectDistrict" class="inputDistrict" data-rule-required="true" data-msg-required="Select District">';
                echo '<option value=""> - - Select District - - </option>';
                if($dataDistrict->datacount>0){
                  foreach($dataDistrict->data as $gk=>$gv){
                    echo '<option value="'.$gv["DistrictID"].'" '.($District==$gv["DistrictID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubDistrict"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4 frmalert">
            <?php
              $dataDistrict = getListSubDistrict($District,$Province,$Country);
              echo '<label class="field select">';
                echo '<input type="hidden" name="inputSubDistrictID" class="gui-input" value="'.$SubDistrict.'">';
                echo '<input type="hidden" name="inputSubDistrict" class="gui-input" value="'.$SubDistrictName.'">';
                echo '<select name="selectSubDistrict" class="inputSubDistrict" data-rule-required="true" data-msg-required="Select District">';
                echo '<option value=""> - - Select SubDistrict - - </option>';
                if($dataDistrict->datacount>0){
                  foreach($dataDistrict->data as $gk=>$gv){
                    echo '<option value="'.$gv["SubDistrictID"].'" '.($SubDistrict==$gv["SubDistrictID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
                  }
                }
                echo '</select>';
                echo '<i class="arrow"></i>';
              echo '</label>';
            ?>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <input type="text" name="<?php echo "inputZipCode"?>" class="gui-input <?php echo "inputZipCode"?>" value="<?php echo $Row['ZipCode']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="<?php echo $Row['Company_telephone']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <input type="text" name="<?php echo "inputFax"?>" class="gui-input" value="<?php echo $Row['Company_fax']; ?>" placeholder="<?php echo $Array_Mod_Lang["inputFax:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMobile"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <input type="text" name="<?php echo "inputMobile"?>" class="gui-input" value="<?php echo $Row['Company_mobile']; ?>" placeholder="<?php echo $Array_Mod_Lang["inputFax:inputMobile"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="<?php echo $Row['Company_email']; ?>" placeholder="<?php echo $Array_Mod_Lang["inputFax:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <input type="text" name="<?php echo "inputWebsite"?>" class="gui-input" value="<?php echo $Row['Company_website']; ?>" placeholder="<?php echo $Array_Mod_Lang["inputFax:inputWebsite"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-3 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtShareholder"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-9">
            <div class="bs-component">
              
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputThaiShare"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <input type="text" name="<?php echo "inputThaiShare"?>" class="gui-input" value="<?php echo $Row['Thai_share']; ?>" placeholder="%" style="width: 75px;">
            <label class="control-label">%</label>
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputForeigner"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-2">
            <input type="text" name="<?php echo "inputForeigner"?>" class="gui-input" value="<?php echo $Row['Foreigner_share']; ?>" placeholder="%" style="width: 75px;">
            <label class="control-label">%</label>
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputRegisteredCapital"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-2">
            <input type="text" name="<?php echo "inputRegisteredCapital"?>" class="gui-input" value="<?php echo $Row['Registered_capital']; ?>" placeholder="<?php echo $Array_Mod_Lang["inputFax:inputRegisteredCapital"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTxtDitpMemberNo"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-1 control-label">
            <input name="inputCurrentlyApplying" type="radio" title="<?php echo $Array_Mod_Lang["txtinput:inputTxtDitpMemberNo"][$_SESSION['Session_Admin_Language']]?>" class="text checkLang" <?php echo ($Row['Currently_applying']!='2'?'checked="checked"':'') ?> value="1" />
          </div>
          <div class="col-md-6">
            <input type="text" name="<?php echo "inputDitpMemberNo"?>" class="gui-input" value="<?php echo $Row['Ditp_member_no']; ?>" placeholder="<?php echo $Array_Mod_Lang["inputFax:inputTxtDitpMemberNo"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCurrentlyApplying"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-1 control-label">
            <input name="inputCurrentlyApplying" type="radio" title="<?php echo $Array_Mod_Lang["txtinput:inputCurrentlyApplying"][$_SESSION['Session_Admin_Language']]?>" class="text checkLang" <?php echo ($Row['Currently_applying']=='2'?'checked="checked"':'') ?> value="2" />
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
          <div class="col-md-1 control-label text-right">
            <input type="checkbox" name="inputListMemberType[]" id="<?php echo ($k=='other') ? $k.'3' : $k; ?>" value="<?php echo $k; ?>" <?php echo ($rowMtype[$i]==$k?'checked="checked"':'')?> > <!--  onclick="CheckRowInput(this)" -->
          </div>
					<label class="col-md-2 control-label text-left" for="<?php echo ($k=='other') ? $k.'3' : $k; ?>"><?php echo $v; ?></label>
          <?php
            $i++;
          }
          ?>
				</div>
        <div class="form-group">
          <label class="col-md-2 control-label">Other:</label>
					<div class="col-md-6">
            <input type="text" name="<?php echo "inputMemberTypeOther"?>" class="gui-input" value="<?php echo $Row['Member_type_other']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTxtOther2"][$_SESSION['Session_Admin_Language']]?>">
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
          <div class="col-md-1 control-label text-right">
            <input type="checkbox" name="inputListBusinessType[]" id="<?php echo ($k=='other') ? $k.'1' : $k; ?>" value="<?php echo $k; ?>" <?php echo ($rowBtype[$j]==$k?'checked="checked"':'')?> > <!--  onclick="CheckRowInput(this)" -->
          </div>
					<label class="col-md-2 control-label text-left" for="<?php echo ($k=='other') ? $k.'1' : $k; ?>"><?php echo $v; ?></label>
        <?php
            $j++;
          }
        ?>
        </div>

        <div class="form-group">
          <label class="col-md-2 control-label">Other:</label>
					<div class="col-md-6">
            <input type="text" name="<?php echo "inputBusinessTypeOther"?>" class="gui-input" value="<?php echo $Row['Business_type_other']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTxtOther2"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactPerson"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <input type="text" name="<?php echo "inputContactPerson"?>" class="gui-input" value="<?php echo $Row['Contact_person']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputContactPerson"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-4">
            <input type="text" name="<?php echo "inputContactPosition"?>" class="gui-input" value="<?php echo $Row['Contact_position']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
            <input type="text" name="<?php echo "inputContactTelephone"?>" class="gui-input" value="<?php echo $Row['Contact_phone']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-4">
            <input type="text" name="<?php echo "inputContactEmail"?>" class="gui-input" value="<?php echo $Row['Contact_email']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-12 control-label text-left"><strong><?php echo $Array_Mod_Lang["txt:Head 08"][$_SESSION['Session_Admin_Language']]?></strong></label>
				</div>
        <div class="form-group">
					<label class="col-md-4 control-label"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtRowMaterial"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-9">
            <div class="bs-component">
              
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDomestic"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <input type="text" name="<?php echo "inputDomestic"?>" class="gui-input" value="<?php echo $Row['Domestic']; ?>" placeholder="%" style="width: 80px;">
            <label class="control-label">%</label>
					</div>
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAbroad"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-3">
            <input type="text" name="<?php echo "inputAbroad"?>" class="gui-input" value="<?php echo $Row['Abroad']; ?>" placeholder="%" style="width: 80px;">
            <label class="control-label">%</label>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputManufacturing"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <input type="text" name="<?php echo "inputManufacturing"?>" class="gui-input" value="<?php echo $Row['Manufacturing_standards']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputManufacturing"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProduction"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <input type="text" name="<?php echo "inputProduction"?>" class="gui-input" value="<?php echo $Row['Production_capacity']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputProduction"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-12 control-label text-left"><u><?php echo $Array_Mod_Lang["txtinput:inputTxtBusinessGuidelines"][$_SESSION['Session_Admin_Language']]?></u></label>
					<div class="col-md-4">
            <div class="bs-component">
              
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputExport"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <input type="text" name="<?php echo "inputExport"?>" class="gui-input" value="<?php echo $Row['Export']; ?>" placeholder="%" style="width: 80px;">
            <label class="control-label">%</label>
					</div>
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDomesticSales"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-3">
            <input type="text" name="<?php echo "inputDomesticSales"?>" class="gui-input" value="<?php echo $Row['Domestic_sales']; ?>" placeholder="%" style="width: 80px;">
            <label class="control-label">%</label>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCurrentBusiness"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <textarea name="<?php echo "inputCurrentBusiness"?>" class="form-control" id="<?php echo "inputCurrentBusiness"?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputCurrentBusiness"][$_SESSION['Session_Admin_Language']]?>" rows="3"><?php echo $Row['Current_business_export']; ?></textarea>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMarketsSuch"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <textarea name="<?php echo "inputMarketsSuch"?>" class="form-control" id="<?php echo "inputMarketsSuch"?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputMarketsSuch"][$_SESSION['Session_Admin_Language']]?>" rows="3"><?php echo $Row['Market_such_as_country']; ?></textarea>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputListNewProducts"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <textarea name="<?php echo "inputListNewProducts"?>" class="form-control" id="<?php echo "inputListNewProducts"?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputListNewProducts"][$_SESSION['Session_Admin_Language']]?>" rows="3"><?php echo $Row['New_product_expand']; ?></textarea>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWhichMarkets"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <textarea name="<?php echo "inputWhichMarkets"?>" class="form-control" id="<?php echo "inputWhichMarkets"?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputWhichMarkets"][$_SESSION['Session_Admin_Language']]?>" rows="3"><?php echo $Row['Market_including_countries']; ?></textarea>
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
          <div class="col-md-1 control-label text-right">
            <input type="checkbox" name="inputListTargetCustomerGroup[]" id="<?php echo ($k=='other') ? $k.'2' : $k; ?>" value="<?php echo $k; ?>" <?php echo ($rowTCGroup[$j]==$k?'checked="checked"':'')?> > <!--  onclick="CheckRowInput(this)" -->
          </div>
					<label class="col-md-3 control-label text-left" for="<?php echo ($k=='other') ? $k.'2' : $k; ?>"><?php echo $v; ?></label>
        <?php
            $j++;
          }
        ?>
        </div>

        <div class="form-group">
          <label class="col-md-2 control-label">Other:</label>
					<div class="col-md-6">
            <input type="text" name="<?php echo "inputTargetCustomerGroupeOther"?>" class="gui-input" value="<?php echo $Row['Target_customer_group_other']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTxtOther2"][$_SESSION['Session_Admin_Language']]?>">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
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

        <div class="form-group">
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
          <div class="col-md-2 control-label text-right">
            <input type="checkbox" name="inputListAwards[]" id="<?php echo $k; ?>" value="<?php echo $k; ?>" <?php echo ($rowAwards[$j]==$k?'checked="checked"':'')?> > <!--  onclick="CheckRowInput(this)" -->
          </div>
					<label class="col-md-3 control-label text-left" for="<?php echo $k; ?>"><?php echo $v; ?></label>
          <div class="col-md-6">
            <input type="text" name="<?php echo "inputAwards_".$jj;?>" class="gui-input" value="<?php echo $Row['Awards_txt_'.$jj]; ?>" placeholder="">
          </div>
        <?php
            $j++;
          }
        ?>
        </div>

        <div class="form-group">
					<label class="col-md-12 control-label text-left"><strong><?php echo $Array_Mod_Lang["txt:Head 09"][$_SESSION['Session_Admin_Language']]?></strong></label>
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
          <div class="col-md-1 control-label text-right">
            <input type="checkbox" name="inputListEventMedia[]" id="<?php echo ($k=='other') ? $k.'4' : $k; ?>" value="<?php echo $k; ?>" <?php echo ($rowEvtMedia[$j]==$k?'checked="checked"':'')?> > <!--  onclick="CheckRowInput(this)" -->
          </div>
					<label class="col-md-3 control-label text-left" for="<?php echo ($k=='other') ? $k.'4' : $k; ?>"><?php echo $v; ?></label>
        <?php
            $j++;
          }
        ?>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Other:</label>
					<div class="col-md-6">
            <input type="text" name="<?php echo "inputEventMediaOther"?>" class="gui-input" value="<?php echo $Row['Event_media_other']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTxtOther2"][$_SESSION['Session_Admin_Language']]?>">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php //echo $Row['DitpMemberNo']; ?></p>
            </div>
					</div>
				</div>






      <?php } ?>

				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
