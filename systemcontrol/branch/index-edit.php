<?php
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$DataArrDay = $defaultdata[$Login_MenuID]["day"];
$DataArrService = $defaultdata[$Login_MenuID]["service"];
$DataArrEstimatedPrice = $defaultdata[$Login_MenuID]["estimatedprice"];
$DataArrIngredients = $defaultdata[$Login_MenuID]["ingredients"];
$DataArrPurchaseofraw = $defaultdata[$Login_MenuID]["purchaseofraw"];
$DataArrPrmarketing = $defaultdata[$Login_MenuID]["prmarketing"];

$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_RESTAURANT_."_ID AS ID";
$arrf[] = "a."._TABLE_RESTAURANT_."_Key AS ModKey";
$arrf[] = "a."._TABLE_RESTAURANT_."_MemberID AS MemberID";
$arrf[] = "a."._TABLE_RESTAURANT_."_Branch AS InBranch";
$arrf[] = "a."._TABLE_RESTAURANT_."_Type AS InType";
$arrf[] = "a."._TABLE_RESTAURANT_."_Name AS InName";
$arrf[] = "a."._TABLE_RESTAURANT_."_Ignore AS allignore";
$arrf[] = "a."._TABLE_RESTAURANT_."_Status AS ListStatus";
$arrf[] = "a."._TABLE_RESTAURANT_."_Lat AS _Lat";
$arrf[] = "a."._TABLE_RESTAURANT_."_Long AS _Long";
$arrf[] = "a."._TABLE_RESTAURANT_."_Time_zone AS Timezone";
$arrf[] = "a."._TABLE_RESTAURANT_."_Address1 AS Address1";
$arrf[] = "a."._TABLE_RESTAURANT_."_Address2 AS Address2";
$arrf[] = "a."._TABLE_RESTAURANT_."_Zipcode AS ZipCode";
$arrf[] = "a."._TABLE_RESTAURANT_."_Country AS Country";
$arrf[] = "a."._TABLE_RESTAURANT_."_Province AS Province";
$arrf[] = "a."._TABLE_RESTAURANT_."_District AS District";
$arrf[] = "a."._TABLE_RESTAURANT_."_Phone AS Phone";
$arrf[] = "a."._TABLE_RESTAURANT_."_Fax AS Fax";
$arrf[] = "a."._TABLE_RESTAURANT_."_Email AS Email";
$arrf[] = "a."._TABLE_RESTAURANT_."_Website AS Website";
$arrf[] = "a."._TABLE_RESTAURANT_."_Contact_person AS Contact_person";
$arrf[] = "a."._TABLE_RESTAURANT_."_Contact_position AS Contact_position";
$arrf[] = "a."._TABLE_RESTAURANT_."_Currency AS Currency";
$arrf[] = "a."._TABLE_RESTAURANT_."_Registered_no_of_juristic_person AS Registered_no_of_juristic_person";
$arrf[] = "a."._TABLE_RESTAURANT_."_Month_year_of_establishment AS Month_year_of_establishment";
$arrf[] = "a."._TABLE_RESTAURANT_."_Restaurant_services AS Restaurant_services";
$arrf[] = "a."._TABLE_RESTAURANT_."_Estimated_price AS EstimatedPrice";
$arrf[] = "a."._TABLE_RESTAURANT_."_Certificate_of_hygenic AS Certificate_of_hygenic";
$arrf[] = "a."._TABLE_RESTAURANT_."_Number_of_chef_thai AS _Number_of_chef_thai";
$arrf[] = "a."._TABLE_RESTAURANT_."_Thai_cooking_experience AS _Thai_cooking_experience";
$arrf[] = "a."._TABLE_RESTAURANT_."_Number_of_chef_foreign AS _Number_of_chef_foreign";
$arrf[] = "a."._TABLE_RESTAURANT_."_Foreign_with_thai_experience AS _Foreign_with_thai_experience";
$arrf[] = "a."._TABLE_RESTAURANT_."_Front_officer AS _Front_officer";
$arrf[] = "a."._TABLE_RESTAURANT_."_Front_officer_with_thai_experience AS _Front_officer_with_thai_experience";
$arrf[] = "a."._TABLE_RESTAURANT_."_Seat AS _Seat";
$arrf[] = "a."._TABLE_RESTAURANT_."_Space AS _Space";
$arrf[] = "a."._TABLE_RESTAURANT_."_Branch_in_country AS _Branch_in_country";
$arrf[] = "a."._TABLE_RESTAURANT_."_Branch_in_overseas AS _Branch_in_overseas";
$arrf[] = "a."._TABLE_RESTAURANT_."_Percentage_of_customer_thai AS _Percentage_of_customer_thai";
$arrf[] = "a."._TABLE_RESTAURANT_."_Percentage_of_customer_non_thai AS _Percentage_of_customer_non_thai";
$arrf[] = "a."._TABLE_RESTAURANT_."_Non_thai_product AS _Non_thai_product";
$arrf[] = "a."._TABLE_RESTAURANT_."_Ingredients_used AS _Ingredients_used";
$arrf[] = "a."._TABLE_RESTAURANT_."_Purchase_of_raw_materials AS _Purchase_of_raw_materials";
$arrf[] = "a."._TABLE_RESTAURANT_."_Purchase_of_raw_materials_other AS _Purchase_of_raw_materials_other";
$arrf[] = "a."._TABLE_RESTAURANT_."_Pr_marketing_promotion_activities AS _Pr_marketing_promotion_activities";
$arrf[] = "a."._TABLE_RESTAURANT_."_Pr_marketing_promotion_activities_other AS _Pr_marketing_promotion_activities_other";
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_RESTAURANT_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_RESTAURANT_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_RESTAURANT_DETAIL_."_Detail AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_RESTAURANT_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_RESTAURANT_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_RESTAURANT_DETAIL_." ".$lkey." ON (a."._TABLE_RESTAURANT_."_ID = ".$lkey."."._TABLE_RESTAURANT_DETAIL_."_ContentID AND ".$lkey."."._TABLE_RESTAURANT_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$ModKey = $Row["ModKey"];
$InBranch = $Row["InBranch"];
$InType = $Row["InType"];
$InName = $Row["InName"];
$MemberID = $Row["MemberID"];

$Restaurant_services = $Row["Restaurant_services"];
$arrRestaurant_services = explode(",",$Restaurant_services);

$InEstimatedPrice = $Row["EstimatedPrice"];
$Certificate_of_hygenic = $Row["Certificate_of_hygenic"];

$_Number_of_chef_thai = $Row["_Number_of_chef_thai"];
$_Thai_cooking_experience = $Row["_Thai_cooking_experience"];
$_Number_of_chef_foreign = $Row["_Number_of_chef_foreign"];
$_Foreign_with_thai_experience = $Row["_Foreign_with_thai_experience"];
$_Front_officer = $Row["_Front_officer"];
$_Front_officer_with_thai_experience = $Row["_Front_officer_with_thai_experience"];
$_Seat = $Row["_Seat"];
$_Space = $Row["_Space"];
$_Branch_in_country = $Row["_Branch_in_country"];
$_Branch_in_overseas = $Row["_Branch_in_overseas"];
$_Percentage_of_customer_thai = $Row["_Percentage_of_customer_thai"];
$_Percentage_of_customer_non_thai = $Row["_Percentage_of_customer_non_thai"];
$_Non_thai_product = $Row["_Non_thai_product"];

$arrIngredientsUsed = explode(",",$Row["_Ingredients_used"]);
$arrPurchaseofraw = explode(",",$Row["_Purchase_of_raw_materials"]);
$_Purchase_of_raw_materials_other = $Row["_Purchase_of_raw_materials_other"];
$arrPrmarketing = explode(",",$Row["_Pr_marketing_promotion_activities"]);
$_Pr_marketing_promotion_activities_other = $Row["_Pr_marketing_promotion_activities_other"];
// echo $Restaurant_services;
// $Picture = $PathUploadPicture.$Row["Picture"];
// if(is_file($Picture)){
// 	$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
// 	$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
// }else{
// 	$showPicture = "";
// }
$showPicture = "";
// echo $showPicture;
$_Mapsearch = "";
$_Lat = (!empty($Row["_Lat"])?$Row["_Lat"]:'13.6899991');
$_Lng = (!empty($Row["_Long"])?$Row["_Long"]:'100.7501124');

$TimeZoneText = "";
$TimeZone = $Row["Timezone"];
$ListTimeZoneInfo = ListTimeZone();

$Country = $Row["Country"];
$CountryName = "";
$Province = (!empty($Row["Province"])?$Row["Province"]:0);
$Provincename = "";
$District = (!empty($Row["District"])?$Row["District"]:0);
$Districtname = "";
$CountryInfo = getListCountry($_SESSION['Session_Admin_Language']);
$ProvinceInfo = getListProvince($Country,$_SESSION['Session_Admin_Language']);
$CityInfo = getListCity($Province,$Country,$_SESSION['Session_Admin_Language']);

$sql = "SELECT "._TABLE_RESTAURANT_WORK_."_Open AS _Open,"._TABLE_RESTAURANT_WORK_."_Close AS _Close,"._TABLE_RESTAURANT_WORK_."_Day AS _Day,TBJoin.DayName FROM "._TABLE_RESTAURANT_WORK_;
$sql .= " LEFT JOIN (";
	$sql .= "SELECT "._TABLE_ADMIN_WDAY_."_ID AS DayID,"._TABLE_ADMIN_WDAY_."_Name AS DayName FROM "._TABLE_ADMIN_WDAY_;
$sql .= ") TBJoin ON ("._TABLE_RESTAURANT_WORK_."_Day = TBJoin.DayID)";
$sql .= " WHERE "._TABLE_RESTAURANT_WORK_."_ContentID = ".intval($ID);
$sql .= " ORDER BY "._TABLE_RESTAURANT_WORK_."_Day ASC,"._TABLE_RESTAURANT_WORK_."_Order ASC";
$z->sql($sql);
$RecordCountTime = $z->num();
$arrayTime = array();
if($RecordCountTime>0){
	$vTime = $z->row();
	foreach($vTime as $RowTime){
		$DayID = $RowTime["_Day"];
		$DayName = $RowTime["DayName"];
		$Time_Open = substr($RowTime["_Open"],0,5);
		$Time_Close = substr($RowTime["_Close"],0,5);
		$arr = array();
		$arr["DayID"] = $DayID;
		$arr["DayName"] = $DayName;
		$arr["Time_Open"] = $Time_Open;
		$arr["Time_Close"] = $Time_Close;
		$arrayTime[$DayID][] = $arr;
		unset($arr);
	}
}
$sql = "";
$arrfuser = array();
$arrfuser[] = "a."._TABLE_MEMBER_."_ID AS MemberID";
$arrfuser[] = "a."._TABLE_MEMBER_."_Name AS FullName";
$arrfuser[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
$sql .= "SELECT  ".implode(',',$arrfuser)." FROM "._TABLE_MEMBER_." a";
$sql .= " WHERE a."._TABLE_MEMBER_."_MemberType = 'Restaurant'";
$sql .= " ORDER BY "._TABLE_MEMBER_."_Name ASC";
unset($arrfuser);
$z->sql($sql);
$RecordCountUser = $z->num();
$arrayUser = array();
if($RecordCountUser>0){
	$vUser = $z->row();
	foreach($vUser as $RowUser){
		$UserID = $RowUser["MemberID"];
		$UserName = $RowUser["FullName"];
		$arr = array();
		$arr["UserID"] = $UserID;
		$arr["UserName"] = $UserName;
		$arrayUser[] = $arr;
	}
}
$SessionID = "";
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$saveDataImg = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=restaurant_image&actiontype=update');
$saveDataFile_1 = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=certificate_of_business_registration&actiontype=update');
$saveDataFile_2 = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=certificate_of_the_branch&actiontype=update');
$saveDataFile_3 = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=menu_with_photographs&actiontype=update');
$saveDataFile_4 = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=restaurant_exterior_photographs&actiontype=update');
$saveDataFile_5 = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=restaurant_interior_photographs&actiontype=update');
$DataCheckMemtype = "";
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
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMember"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<?php
						if(count($arrayUser)>0){
								echo '<select name="selectMember" class="form-control select2_single" data-rule-required="true" data-msg-required="Select Group">';
								echo '<option value=""> - - Select Member - - </option>';
								foreach($arrayUser as $gk=>$gv){
									echo '<option value="'.$gv["UserID"].'" '.($MemberID==$gv["UserID"]?'selected="selected"':'').'>'.$gv["UserName"].'</option>';
								}
								echo '</select>';
						}
						?>
					</div>
				</div>
				<?php if(count($DataGroup)>0){?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<?php
						echo '<label class="field select">';
							echo '<select name="selectGroup" data-rule-required="true" data-msg-required="Select Group">';
							echo '<option value=""> - - Select Group - - </option>';
							foreach($DataGroup as $gk=>$gv){
								echo '<option value="'.$gv["Key"].'" '.($InType==$gv["Key"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
							}
							echo '</select>';
							echo '<i class="arrow"></i>';
						echo '</label>';
						?>
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-10">
						<div class="bs-component">
							<?php
							echo '<input type="text" name="inputName" class="form-control reqs" value="'.$InName.'" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']].'" placeholder="'.$Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']].'">';
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputBranch"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-4">
						<div class="bs-component">
							<?php
							echo '<input type="text" name="inputBranch" class="form-control" value="'.$InBranch.'" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputBranch"][$_SESSION['Session_Admin_Language']].'" placeholder="'.$Array_Mod_Lang["txtinput:inputBranch"][$_SESSION['Session_Admin_Language']].'">';
							?>
						</div>
					</div>
				</div>
				<div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?> 1</label>
					<div class="col-lg-10">
						<div class="bs-component">
							<?php
							echo '<input type="text" name="inputAddress_1" class="form-control" value="'.$Row["Address1"].'" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']].'" placeholder="'.$Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']].'">';
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?> 2</label>
					<div class="col-lg-10">
						<div class="bs-component">
							<?php
							echo '<input type="text" name="inputAddress_2" class="form-control" value="'.$Row["Address2"].'" placeholder="'.$Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']].'">';
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
						<?php
              echo '<input type="hidden" name="inputCountry" class="gui-input" value="'.$CountryName.'">';
							echo '<select name="selectCountry" class="form-control select2_single" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']].'" onchange="loadajaxstate(this)">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputCountry"][$_SESSION['Session_Admin_Language']].' - - </option>';
              if($CountryInfo->datacount>0){
                foreach($CountryInfo->data as $gk=>$gv){
  								echo '<option value="'.$gv["countryid"].'" '.($Country==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
  							}
              }
							echo '</select>';
						?>
					</div>
				</div>
				<div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
              <?php
              if($ProvinceInfo->datacount>0){
                echo '<input type="hidden" name="inputProvince" class="gui-input" value="'.$Provincename.'">';
                echo '<select id="selectProvince" name="selectProvince" class="form-control select2_single" onchange="loadajaxdistrict($(this).val())">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputProvince"][$_SESSION['Session_Admin_Language']].' - - </option>';
                foreach($ProvinceInfo->data as $gk=>$gv){
									echo '<option value="'.$gv["id"].'" '.($Province==$gv["id"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
              <?php
              if($CityInfo->datacount>0){
                echo '<input type="hidden" name="inputDistrict" class="gui-input" value="'.$Districtname.'">';
                echo '<select id="selectDistrict" name="selectDistrict" class="form-control select2_single">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputDistrict"][$_SESSION['Session_Admin_Language']].' - - </option>';
                foreach($CityInfo->data as $gk=>$gv){
									echo '<option value="'.$gv["DistrictID"].'" '.($District==$gv["DistrictID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<input type="text" maxlength="5" name="<?php echo "inputZipCode"?>" class="gui-input" value="<?php echo $Row['ZipCode']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="section-divider mb40" id="spy3">
            <span><?php echo $Array_Mod_Lang["txt:Head 03"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<div class="col-sm-6">
							<label>Map <i class="red">*</i></label>
							<input id="pac-input" name="sup_search" class="form-control" type="text" value="<?php echo $_Mapsearch?>" placeholder="Search Box"	/>
					</div>
					<div class="col-sm-3">
						<label>latitude <i class="red">*</i></label>
						<input type="text" id="latitude" name="sup_lat" value="<?php echo $_Lat?>" class=" form-control">
					</div>
					<div class="col-sm-3">
						<label>longitude <i class="red">*</i></label>
						<input type="text" id="longitude" name="sup_lng" value="<?php echo $_Lng?>" class=" form-control">
					</div>
				</div>
				<div class="form-group">
					<div class="map-wrap">
						<div id="map"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="<?php echo $Row['Phone']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputFax"?>" class="gui-input" value="<?php echo $Row['Fax']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="<?php echo $Row['Email']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputWebsite"?>" class="gui-input" value="<?php echo $Row['Website']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContact_person"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-5">
						<input type="text" name="<?php echo "inputContact_person"?>" class="gui-input" value="<?php echo $Row['Contact_person']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputContact_person"][$_SESSION['Session_Admin_Language']]?>">
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContact_position"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
						<input type="text" name="<?php echo "inputContact_position"?>" class="gui-input" value="<?php echo $Row['Contact_position']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputContact_position"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCurrency"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputCurrency"?>" class="gui-input" value="<?php echo $Row['Currency']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputCurrency"][$_SESSION['Session_Admin_Language']]?>">
							<div class="showrecommend"><span><?php echo "Registered Capital (Please specify the currency) "?></span></div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"></label>
					<div class="col-md-5">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputRegistered_no_of_juristic_person"?>" class="gui-input" value="<?php echo $Row['Registered_no_of_juristic_person']; ?>" placeholder="<?php echo "Registered No. of Juristic Person"?>">
							<div class="showrecommend"><span><?php echo "Registered No. of Juristic Person"?></span></div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputMonth_year_of_establishment"?>" class="gui-input" value="<?php echo $Row['Month_year_of_establishment']; ?>" placeholder="<?php echo "Month/Year of establishment "?>">
							<div class="showrecommend"><span><?php echo "Month/Year of establishment "?></span></div>
						</div>
					</div>
				</div>
				<div class="section-divider mt40" id="spy4">
				  <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php
				// echo '<pre>';
				// print_r($DataArrService);
				// echo '</pre>';
				foreach($DataArrService as $ValService){
					$inkey = $ValService["Key"];
					$inChild = $ValService["Child"];
					$inCheck = (in_array($inkey, $arrRestaurant_services)?true:false);
					// $arrRestaurant_services
					echo '<div class="form-group">';
						echo '<label class="col-md-2 control-label"></label>';
						echo '<div class="col-md-5">';
							echo '<div class="checkbox-custom checkbox-primary mb5">';
								echo '<input type="checkbox" '.($inCheck?'checked="checked"':'').' id="checkService'.$inkey.'" name="checkService'.$inkey.'" value="'.$inkey.'">';
								echo '<label for="checkService'.$inkey.'">'.$ValService["Name"].'</label>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
					if(count($inChild)>0){
						foreach($inChild as $ChildVal){
							$inkey = $ChildVal["Key"];
							$inCheck = (in_array($inkey, $arrRestaurant_services)?true:false);
							echo '<div class="form-group">';
								echo '<label class="col-md-3 control-label"></label>';
								echo '<div class="col-md-5">';
									echo '<div class="checkbox-custom checkbox-primary mb5">';
										echo '<input type="checkbox" '.($inCheck?'checked="checked"':'').' id="checkService'.$inkey.'" name="checkService'.$inkey.'" value="'.$inkey.'">';
										echo '<label for="checkService'.$inkey.'">'.$ChildVal["Name"].'</label>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
					}
				}
				?>
				<div class="form-group">
					<label class="col-md-2 control-label">Restaurant image</label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "restaurant_image";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataImg.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadPicture.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["filetype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" accept="image/*" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["imagestype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>
				<!-- .section-divider -->
				<?php $countlang = count($systemLang);?>
				<div class="row">
					<div class="paneltab">
						<ul class="nav nav-tabs nav-justified nav-inline">
							<?php
							foreach($systemLang as $lkey=>$lval){
								$tabactive = ($lkey==$systemdefaultTab?'active':'');
								$tabflag = "flag-".strtolower($lkey);
								echo '<li class="'.$tabactive.'">';
									echo '<a href="#tab'.$lkey.'" data-toggle="tab" aria-expanded="true"><span class="flaglist-xs '.$tabflag.'"></span> '.$Array_Mod_Lang["tab:TabLang"][$lkey].'</a>';
								echo '</li>';
							}
							?>
						</ul>
					</div>
					<div class="paneltabbody">
						<div class="tab-content tab-validate pn br-n">
							<?php foreach($systemLang as $lkey=>$lval){?>
								<?php $tabactive = ($lkey==$systemdefaultTab?'active':'');?>
								<div id="<?php echo 'tab'.$lkey?>" class="tab-pane <?php echo $tabactive?>">
									<div class="boxlang">
					        <input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $Row['SubjectID'.$lkey]; ?>" />
									<?php
									if($countlang>1){
										echo '<div class="checkbox-custom mb20">';
										  echo '<input type="checkbox" class="checkLang" name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" title="'.$lkey.'" value="Off" '.($Row['Status'.$lkey]=='Off'?'checked="checked"':'').'>';
										  echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
										echo '</div>';
									}
									?>
					        <div class="row">
					            <div class="col-md-12">
					                <div class="section">
					                    <label class="field prepend-icon">
					                        <input type="text" name="<?php echo "inputSubject".$lkey?>" data-rule-required="true" class="gui-input" value="<?php echo $Row['Subject'.$lkey]; ?>" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
					                        <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
					                    </label>
					                </div>
					            </div>
					        </div>
									<?php
									$html = echoDetailToediter($Row['Title'.$lkey]);
					        echo '<div class="row section">';
					          echo '<div class="col-md-12">';
					            echo '<h4>'.$Array_Mod_Lang["txtinput:inputDetail"][$_SESSION['Session_Admin_Language']].'</h4>';
					          echo '</div>';
					        echo '</div>';
					        echo '<div class="row">';
					          echo '<div class="col-md-12">';
					          echo '<div class="section">';
					            echo '<textarea id="inputDetail'.$lkey.'" name="inputDetail'.$lkey.'" rows="12">'.$html.'</textarea>';
					          echo '</div>';
					          echo '</div>';
					        echo '</div>';
									?>
					        <!-- Text Areas -->
									</div>
								</div>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="section-divider mt40" id="spy5">
				  <span><?php echo $Array_Mod_Lang["txt:Head 05"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php
				if($ListTimeZoneInfo->num>0){
					echo '<div class="form-group">';
						echo '<label class="col-md-2 control-label">'.$Array_Mod_Lang["txtinput:inputTimeZone"][$_SESSION['Session_Admin_Language']].'</label>';
						echo '<div class="frmalert col-md-6">';
							echo '<input type="hidden" name="inputTimeZone" class="gui-input" value="'.$TimeZoneText.'">';
							echo '<select id="selectTimeZone" name="selectTimeZone" class="form-control select2_single">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputTimeZone"][$_SESSION['Session_Admin_Language']].' - - </option>';
							foreach($ListTimeZoneInfo->data as $gk=>$gv){
								echo '<option value="'.$gv["ID"].'" '.($TimeZone==$gv["ID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
							}
							echo '</select>';
						echo '</div>';
					echo '</div>';
				}
				if(count($arrayTime)>0){
					foreach($DataArrDay as $kkd=>$vvd){
						$DayID = $vvd["ID"];
						// print_r($arrayTime[$DayID]);
						echo '<div class="row">';
							echo '<label class="col-md-2 control-label">'.$vvd["Name"].'</label>';
							echo '<div id="boxDay_'.$kkd.'" class="col-md-10 listarea">';
								foreach($arrayTime[$DayID] as $KRelate=>$DataTime){
									$Time_Open = ($DataTime["Time_Open"]!='00:00'?$DataTime["Time_Open"]:'');
									$Time_Close = ($DataTime["Time_Close"]!='00:00'?$DataTime["Time_Close"]:'');
									$_DivID = ($KRelate>0?'Clone_boxDay_'.$kkd.'_'.($KRelate-1):'boxDay_'.$kkd.'_Master');
									$_ClassID = ($KRelate>0?'form-group listitem item clone':'listitem form-group');
									echo '<div id="'.$_DivID.'" class="'.$_ClassID.'">';
										echo '<input type="hidden" name="inputTimeDataID_'.$DayID.'[]" value="0" />';
										echo '<div class="col-md-3">';
											echo '<input type="text" name="TIMEOPEN_'.$DayID.'[]" class="gui-input text-center time" value="'.$Time_Open.'" placeholder="00:00">';
										echo '</div>';
										echo '<div class="col-md-3">';
											echo '<input type="text" name="TIMECLOSE_'.$DayID.'[]" class="gui-input text-center time" value="'.$Time_Close.'" placeholder="00:00">';
										echo '</div>';
										echo '<div class="col-md-2"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveTime(this)">- Remove</button></div>';
										if($KRelate==0){
											echo '<div class="col-md-2">';
												echo '<input type="hidden" name="inputDayName_'.$DayID.'" value="boxDay_'.$kkd.'" />';
												echo '<button type="button" class="btn btn-primary btn-block" onclick="clickThisAddTime(this)">+ Add </button>';
											echo '</div>';
										}
									echo '</div>';
								}
							echo '</div>';
						echo '</div>';
					}
				}else{
					foreach($DataArrDay as $kkd=>$vvd){
						echo '<div class="row">';
							echo '<label class="col-md-2 control-label">'.$vvd["Name"].'</label>';
							echo '<div id="boxDay_'.$kkd.'" class="col-md-10 listarea">';
								echo '<div id="boxDay_'.$kkd.'_Master" class="listitem form-group">';
									echo '<input type="hidden" name="inputTimeDataID_'.$vvd["ID"].'[]" value="0" />';
									echo '<div class="col-md-3">';
										echo '<input type="text" name="TIMEOPEN_'.$vvd["ID"].'[]" class="gui-input text-center time" value="" placeholder="00:00">';
									echo '</div>';
									echo '<div class="col-md-3">';
										echo '<input type="text" name="TIMECLOSE_'.$vvd["ID"].'[]" class="gui-input text-center time" value="" placeholder="00:00">';
									echo '</div>';
									echo '<div class="col-md-2"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveTime(this)">- Remove</button></div>';
									echo '<div class="col-md-2">';
										echo '<input type="hidden" name="inputDayName_'.$vvd["ID"].'" value="boxDay_'.$kkd.'" />';
										echo '<button type="button" class="btn btn-primary btn-block" onclick="clickThisAddTime(this)">+ Add </button>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
				}
				?>
				<?php if(count($DataArrEstimatedPrice)>0){?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEstimated_price"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4 frmalert">
						<?php
						echo '<label class="field select">';
							echo '<select name="selectEstimated" data-msg-required="Select Estimated Price">';
							echo '<option value=""> - - Select Estimated Price - - </option>';
							foreach($DataArrEstimatedPrice as $gk=>$gv){
								echo '<option value="'.$gv["ID"].'" '.($InEstimatedPrice==$gv["ID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
							}
							echo '</select>';
							echo '<i class="arrow"></i>';
						echo '</label>';
						?>
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCertificate_of_hygenic"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputCertificate_of_hygenic"?>" class="gui-input" value="<?php echo $Certificate_of_hygenic; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputCertificate_of_hygenic"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="showrecommend mb10"><span><?php echo "Personnel, Please inform the number of Chef"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputnumber_of_chef_thai"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputnumber_of_chef_thai"?>" class="gui-input number" value="<?php echo $_Number_of_chef_thai; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:with_Thai_Cooking_Experience"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputthai_cooking_experience"?>" class="gui-input number" value="<?php echo $_Thai_cooking_experience; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Year"][$_SESSION['Session_Admin_Language']]?></label>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputnumber_of_chef_foreign"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputnumber_of_chef_foreign"?>" class="gui-input number" value="<?php echo $_Number_of_chef_foreign; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:with_Thai_Cooking_Experience"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputforeign_with_thai_experience"?>" class="gui-input number" value="<?php echo $_Foreign_with_thai_experience; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Year"][$_SESSION['Session_Admin_Language']]?></label>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputfront_officer"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputfront_officer"?>" class="gui-input number" value="<?php echo $_Front_officer; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:with_Thai_Cooking_Experience"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputfront_officer_with_thai_experience"?>" class="gui-input number" value="<?php echo $_Front_officer_with_thai_experience; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Year"][$_SESSION['Session_Admin_Language']]?></label>
				</div>
				<div class="showrecommend mb10"><span><?php echo "Seat, Please inform number of seats"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSeat"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputSeat"?>" class="gui-input number" value="<?php echo $_Seat; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSpace"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputSpace"?>" class="gui-input" value="<?php echo $_Space; ?>" placeholder="">
						</div>
					</div>
				</div>
				<div class="section-divider mt40" id="spy6">
				  <span><?php echo $Array_Mod_Lang["txt:Head 06"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="showrecommend mb10"><span><?php echo "No. of branches"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputInCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-4">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputInCountry"?>" class="gui-input" value="<?php echo $_Branch_in_country; ?>" placeholder="">
						</div>
					</div>
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputOverseas"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputOverseas"?>" class="gui-input" value="<?php echo $_Branch_in_overseas; ?>" placeholder="">
						</div>
					</div>
				</div>
				<div class="showrecommend mb10"><span><?php echo "Percentage of Customers"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPercentage_of_customer_thai"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputPercentage_of_customer_thai"?>" class="gui-input number" value="<?php echo $_Percentage_of_customer_thai; ?>" placeholder="%">
						</div>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPercentage_of_customer_non_thai"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputPercentage_of_customer_non_thai"?>" class="gui-input number" value="<?php echo $_Percentage_of_customer_non_thai; ?>" placeholder="%">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputnon_thai_products_please_specify"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputnon_thai_products_please_specify"?>" class="gui-input" value="<?php echo $_Non_thai_product; ?>" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:Ingredients_used"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<div class="bs-component mt10">
							<?php
							// echo '<pre>';
							// print_r($DataArrIngredients);
							// echo '</pre>';
							foreach($DataArrIngredients as $ValIngredients){
								$inkey = $ValIngredients["Key"];
								$inCheck = (in_array($inkey, $arrIngredientsUsed)?true:false);
								// $arrRestaurant_services
								echo '<div class="form-group">';
									echo '<div class="col-md-5">';
										echo '<div class="checkbox-custom checkbox-primary mb5">';
											echo '<input type="checkbox" '.($inCheck?'checked="checked"':'').' id="checkIngredients'.$inkey.'" name="checkIngredients[]" value="'.$inkey.'">';
											echo '<label for="checkIngredients'.$inkey.'">'.$ValIngredients["Name"].'</label>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:purchase_of_raw_material"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<div class="bs-component mt10">
							<?php
							// echo '<pre>';
							// print_r($DataArrIngredients);
							// echo '</pre>';
							foreach($DataArrPurchaseofraw as $ValPurchaseofraw){
								$inkey = $ValPurchaseofraw["Key"];
								$inCheck = (in_array($inkey, $arrPurchaseofraw)?true:false);
								// $arrRestaurant_services
								echo '<div class="form-group">';
									echo '<div class="col-md-5">';
										echo '<div class="checkbox-custom checkbox-primary mb5">';
											echo '<input type="checkbox" '.($inCheck?'checked="checked"':'').' id="checkPurchaseofraw'.$inkey.'" name="checkPurchaseofraw[]" value="'.$inkey.'">';
											echo '<label for="checkPurchaseofraw'.$inkey.'">'.$ValPurchaseofraw["Name"].'</label>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								if($inkey=='D'){
									echo '<div class="form-group">';
										echo '<div class="col-md-10">';
											echo '<div class="bs-component">';
												echo '<input type="text" name="purchase_of_raw_materials_other" class="gui-input" value="'.$_Purchase_of_raw_materials_other.'" placeholder="">';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								}
							}
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:prmarketing_promotion"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<div class="bs-component mt10">
							<?php
							// echo '<pre>';
							// print_r($DataArrIngredients);
							// echo '</pre>';
							foreach($DataArrPrmarketing as $ValPrmarketing){
								$inkey = $ValPrmarketing["Key"];
								$inCheck = (in_array($inkey, $arrPrmarketing)?true:false);
								// $arrRestaurant_services
								echo '<div class="form-group">';
									echo '<div class="col-md-3">';
										echo '<div class="checkbox-custom checkbox-primary mb5">';
											echo '<input type="checkbox" '.($inCheck?'checked="checked"':'').' id="checkPrmarketing'.$inkey.'" name="checkPrmarketing[]" value="'.$inkey.'">';
											echo '<label for="checkPrmarketing'.$inkey.'">'.$ValPrmarketing["Name"].'</label>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								if($inkey=='D'){
									echo '<div class="form-group">';
										echo '<div class="col-md-10">';
											echo '<div class="bs-component">';
												echo '<input type="text" name="pr_marketing_promotion_activities_other" class="gui-input" value="'.$_Pr_marketing_promotion_activities_other.'" placeholder="">';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php //echo strlen('certificate_of_business_registration')?>
				<div class="showrecommend mb10"><span><?php echo "Copy of certificate of business registration"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "certificate_of_business_registration";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataFile_1.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadFile.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["filetype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["filetype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>

				<div class="showrecommend mb10"><span><?php echo "Copy of Standard Certificates (the certificate of the branch that apply for Thai SELECT)"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "certificate_of_the_branch";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataFile_2.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadFile.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["filetype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["filetype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>
				<div class="showrecommend mb10"><span><?php echo "Copy of menu with photographs of at least three recommended dishes"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "menu_with_photographs";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataFile_3.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadFile.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["filetype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["filetype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>
				<div class="showrecommend mb10"><span><?php echo "Restaurant’s exterior photographs showing restaurant name"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "restaurant_exterior_photographs";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataFile_4.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadPicture.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["imagestype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["filetype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>
				<div class="showrecommend mb10"><span><?php echo "Restaurant’s interior photographs"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "restaurant_interior_photographs";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataFile_5.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadPicture.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["imagestype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["filetype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right mt10">
					<button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
