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
$arrf[] = "a."._TABLE_RESTAURANT_."_MemberID AS MemberID";
$arrf[] = "a."._TABLE_RESTAURANT_."_Key AS ModKey";
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
$arrf[] = "IF(TBMember.FullName IS NULL or TBMember.FullName = '', '-', TBMember.FullName) as FullMemberName";
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
$sql .= " LEFT JOIN (";
	$arrfuser = array();
	$arrfuser[] = "a."._TABLE_MEMBER_."_ID AS MemberID";
	$arrfuser[] = "a."._TABLE_MEMBER_."_Name AS FullName";
	$arrfuser[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
	$sql .= "SELECT  ".implode(',',$arrfuser)." FROM "._TABLE_MEMBER_." a";
	$sql .= " WHERE a."._TABLE_MEMBER_."_MemberType = 'Restaurant'";
	unset($arrfuser);
$sql .= ") TBMember ON (a."._TABLE_RESTAURANT_."_MemberID = TBMember.MemberID)";
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
$FullMemberName = $Row["FullMemberName"];

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
$SessionID = "";
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$DataCheckMemtype = "";
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
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMember"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<p class="form-control-static text-muted"><?php echo $FullMemberName?></p>
					</div>
				</div>
				<?php if(count($DataGroup)>0){?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<p class="form-control-static text-muted">
							<?php
							$query = "Key='".$InType."'";
							$mydata = @ArraySearch($DataGroup,$query,1);
							$GroupName = $DataGroup[array_key_first($mydata)]["Name"];
							echo $GroupName;
							?>
						</p>
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-10">
						<div class="bs-component">
							<?php
							echo '<p class="form-control-static text-muted">'.$InName.'</p>';
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputBranch"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-4">
						<div class="bs-component">
							<?php
							echo '<p class="form-control-static text-muted">'.$InBranch.'</p>';
							?>
						</div>
					</div>
				</div>
				<div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 08"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<div class="col-lg-12">
						<ul class="ResultHistory" id="ResultHistory"></ul>
					</div>
				</div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right mt10">
					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
