<?php
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$arrf = array();
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_ID AS ID";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_AName AS AName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_FName AS FName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_LName AS LName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Gender AS Gender";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Email AS Email	";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_EmailInfo AS EmailInfo";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Tel AS Tel";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Fax AS Fax";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Position AS Position";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Country AS Country";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_CountryCode AS CountryCode";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_CountryName AS CountryName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_StateID AS StateID";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_ZipCode AS ZipCode";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Address AS Address";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Territory AS _Territory";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_STAFF_." a";
$sql .= " WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$Gender = $Row["Gender"];
$Country = intval($Row["Country"]);
$CountryCode = $Row["CountryCode"];
$CountryName = $Row["CountryName"];
$_Territory = $Row["_Territory"];

$sql = "SELECT * FROM "._TABLE_THAIEMBASSY_CITY_." WHERE "._TABLE_THAIEMBASSY_CITY_."_EmbassyID = ".intval($ID);
$z->sql($sql);
$vCity = $z->row();
// echo '<pre>';
// print_r($vCity);
// echo '</pre>';
$vArrCity = array_column($vCity, 'thaiselect_thaiembassy_city_CityID');
// echo '<pre>';
// print_r($vArrCity);
// echo '</pre>';

$dataCountry = getListCountry($_SESSION['Session_Admin_Language']);
$ProvinceInfo = getListProvince($Country,$_SESSION['Session_Admin_Language']);
$Province = "";
$ProvinceID = explode(",",$Row["StateID"]);
// echo '<pre>';
// print_r($ProvinceID);
// echo '</pre>';

$CityInfo = getListCity(0,$Country,$_SESSION['Session_Admin_Language']);
// echo '<pre>';
// print_r($CityInfo);
// echo '</pre>';

$DataRegion = $defaultdata[$Login_MenuID]["region"];
// echo '<pre>';
// print_r($DataRegion);
// echo '</pre>';
$DataSetSelect = array();
foreach($DataRegion as $RowRegion){
  $dataGroup = $RowRegion["ID"];
  $dataGroupName = $RowRegion["Name"];
  $sql = "";
  $sql .= "SELECT * FROM ";
  $sql .= "("	;
    $ArrField = array();
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_ID AS ID";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_RegionID AS _RegionID";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_RegionName AS _RegionName";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Name AS _Name";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_CountryName AS CountryName";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_CreateDate AS CreateDate";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Order AS ListOrder";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Status AS ListStatus";
    $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_;
    $sql .= " WHERE 1";
    $sql .= " AND "._TABLE_ADMIN_TERRITORY_."_RegionID = ".intval($dataGroup);
    unset($ArrField);
  $sql .= ") TBmain";
  $sql .= " WHERE 1";
  $z->sql($sql);
  $RecordCountT = $z->num();
  $vT = $z->row();
  $DataSet = array();
  if($RecordCountT>0) {
    foreach($vT as $RowT){
      $_ID = $RowT["ID"];
      $_Name = $RowT["_Name"];
      $arr = array();
      $arr["Type"] = "Select";
      $arr["ID"] = $_ID;
      $arr["Name"] = $_Name;
      $DataSet[] = $arr;
    }
  }
  $DataSetSelect[$dataGroup]["name"] = $dataGroupName;
  $DataSetSelect[$dataGroup]["data"] = $DataSet;
}
// echo '<pre>';
// print_r($DataSetSelect);
// echo '</pre>';
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
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
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<input type="text" name="<?php echo "inputAName"?>" class="gui-input reqs" value="<?php echo $Row['AName']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <div class="col-md-4">
						<input type="text" name="<?php echo "inputFName"?>" class="gui-input reqs" value="<?php echo $Row['FName']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <div class="col-md-4">
						<input type="text" name="<?php echo "inputLName"?>" class="gui-input reqs" value="<?php echo $Row['LName']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGender"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 mt10">
            <div class="radio-custom radio-primary mb5">
              <input type="radio" id="inputGenderM" name="inputGender" <?php echo ($Gender=='M'?'checked="checked"':'')?> value="M">
              <label for="inputGenderM">เพศชาย</label>
            </div>
					</div>
          <div class="col-md-3 mt10">
            <div class="radio-custom radio-primary mb5">
              <input type="radio" id="inputGenderF" name="inputGender" <?php echo ($Gender=='F'?'checked="checked"':'')?> value="F">
              <label for="inputGenderF">เพศหญิง</label>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputBirthday"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-1">
            <?php
            echo '<select class="form-control" name="BirthdaySelectDay">';
              echo '<option value="00">วัน</option>';
              for($i=1;$i<=31;$i++){
                echo '<option value="'.formatStringtoZero($i,2).'" '.($arrBirthday[2]==formatStringtoZero($i,2)?'selected="selected"':'').'>'.$i.'</option>';
              }
            echo '</select>';
            ?>
					</div>
          <div class="col-md-3">
            <?php
            echo '<select class="form-control" name="BirthdaySelectMonth">';
              foreach($Array_Lang['txt:monthNames'][$_SESSION['Session_Admin_Language']] as $km=>$vm){
                echo '<option value="'.formatStringtoZero($km,2).'" '.($arrBirthday[1]==formatStringtoZero($km,2)?'selected="selected"':'').'>'.$vm.'</option>';
              }
            echo '</select>';
            ?>
					</div>
          <div class="col-md-2">
            <?php
            $yearstart = date("Y")-10;
            $yearend = date("Y")-90;
            echo '<select class="form-control" name="BirthdaySelectYear">';
              echo '<option value="0000">ปี</option>';
              for($i=$yearstart;$i>=$yearend;$i--){
                echo '<option value="'.formatStringtoZero($i,4).'" '.($arrBirthday[0]==formatStringtoZero($i,4)?'selected="selected"':'').'>'.$i.'</option>';
              }
            echo '</select>';
            ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="<?php echo $Row['Email']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmailInfo"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputEmailInfo"?>" class="gui-input" value="<?php echo $Row['EmailInfo']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmailInfo"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="<?php echo $Row['Tel']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputFax"?>" class="gui-input" value="<?php echo $Row['Fax']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputPosition"?>" class="gui-input" value="<?php echo $Row['Position']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTerritoryName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <select class="form-control" name="SelectTerritory">
              <?php
              echo '<option value=""> - select - </option>';
              if(count($DataSetSelect)>0){
                foreach($DataSetSelect as $kM=>$vM){
                  echo '<optgroup label="'.$vM["name"].'">';
                    foreach($vM["data"] as $kkM=>$vvM){
                      echo '<option value="'.$vvM["ID"].'" '.($_Territory==$vvM["ID"]?'selected="selected"':'').'>'.$vvM["Name"].'</option>';
                    }
                  echo '</optgroup>';
                }
              }
              ?>
            </select>
					</div>
				</div>

        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
						<?php
              echo '<input type="hidden" name="inputCountry" class="gui-input" value="'.$CountryName.'">';
							echo '<select name="selectCountry" class="form-control select2_single" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']].'" onchange="loadajaxstate(this)">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputCountry"][$_SESSION['Session_Admin_Language']].' - - </option>';
              if($dataCountry->datacount>0){
                foreach($dataCountry->data as $gk=>$gv){
  								echo '<option value="'.$gv["countryid"].'" '.($Country==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
  							}
              }
							echo '</select>';
						?>
					</div>
				</div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-10">
            <div class="bs-component">
              <?php
              if($ProvinceInfo->datacount>0){
                echo '<input type="hidden" name="inputProvince" class="gui-input" value="'.$Province.'">';
                echo '<select id="selectProvince" name="selectProvince[]" class="form-control select2-multiple" multiple="multiple" onchange="loadajaxdistrict($(this).val())">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputProvince"][$_SESSION['Session_Admin_Language']].' - - </option>';
                foreach($ProvinceInfo->data as $gk=>$gv){
                  if (in_array($gv["id"], $ProvinceID)){
                    echo '<option value="'.$gv["id"].'" selected="selected">'.$gv["name"].'</option>';
                  }else{
                    echo '<option value="'.$gv["id"].'">'.$gv["name"].'</option>';
                  }
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-10">
            <div class="bs-component">
              <?php
              if($CityInfo->datacount>0){
                echo '<input type="hidden" name="inputDistrict" class="gui-input" value="'.$Province.'">';
                echo '<select id="selectDistrict" name="selectDistrict[]" class="form-control select2-multiple" multiple="multiple">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputDistrict"][$_SESSION['Session_Admin_Language']].' - - </option>';
                foreach($CityInfo->data as $gk=>$gv){
                  if (in_array($gv["DistrictID"], $vArrCity)){
                    echo '<option value="'.$gv["DistrictID"].'" selected="selected">'.$gv["Name"].'</option>';
                  }else{
                    echo '<option value="'.$gv["DistrictID"].'">'.$gv["Name"].'</option>';
                  }
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10">
            <textarea class="form-control" name="<?php echo "inputAddress"?>" rows="3" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?>"><?php echo decodetxterea($Row['Address']); ?></textarea>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<input type="text" maxlength="5" name="<?php echo "inputZipCode"?>" class="gui-input" value="<?php echo $Row['ZipCode']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label">Images</label>
          <div class="col-lg-8">
            <div class="bs-component">
              <?php
              $lkeyindex = "Home";
              ?>
              <div id="progress<?php echo $lkeyindex?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
              <div id="output<?php echo $lkeyindex?>"><!-- error or success results --></div>
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
