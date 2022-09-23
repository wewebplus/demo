<?php
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$DataRegion = $defaultdata[$Login_MenuID]["region"];
$dataCountry = getListCountry($_SESSION['Session_Admin_Language']);

$arrf = array();
$arrf[] = _TABLE_ADMIN_TERRITORY_."_ID AS ID";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_RegionID AS _RegionID";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_RegionName AS _RegionName";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_Name AS _Name";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_CountryID AS CountryID";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_CountryName AS CountryName";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_CreateDate AS CreateDate";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_Order AS ListOrder";
$arrf[] = _TABLE_ADMIN_TERRITORY_."_Status AS ListStatus";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_TERRITORY_;
$sql .= " WHERE "._TABLE_ADMIN_TERRITORY_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$_RegionID = $Row["_RegionID"];
$_RegionName = $Row["_RegionName"];
$_Name = $Row["_Name"];
$inputCountry = $Row["CountryName"];
$selectCountry = $Row["CountryID"];

$sql = "SELECT * FROM "._TABLE_ADMIN_TERRITORY_."_internal WHERE "._TABLE_ADMIN_TERRITORY_."_internal_TerritoryID = ".intval($ID);
$z->sql($sql);
$vInternal = $z->row();
$Country_I = $vInternal[0][_TABLE_ADMIN_TERRITORY_."_internal_CountryID"];
$ProvinceInfo = getListProvince($Country_I,$_SESSION['Session_Admin_Language']);
// echo $Country_I;
// echo '<pre>';
// print_r($ProvinceInfo);
// echo '</pre>';
$vArrProvince_I = array_column($vInternal, 'thaiselect_territory_internal_StateID');
// echo '<pre>';
// print_r($vArrProvince);
// echo '</pre>';

$sql = "SELECT * FROM "._TABLE_ADMIN_TERRITORY_."_external WHERE "._TABLE_ADMIN_TERRITORY_."_external_TerritoryID = ".intval($ID);
$z->sql($sql);
$vExternal = $z->row();
$vArrCountru_E = array_column($vExternal, 'thaiselect_territory_external_CountryID');

// echo '<pre>';
// print_r($vInternal);
// echo '</pre>';
//
// echo '<pre>';
// print_r($vExternal);
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
        <input type="hidden" name="ListStatus" value="On" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTerritoryRegion"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
						<?php
              echo '<input type="hidden" name="inputRegion" class="gui-input" value="'.$_RegionName.'">';
							echo '<select name="selectRegion" class="form-control" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputTerritoryRegion"][$_SESSION['Session_Admin_Language']].'">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputTerritoryRegion"][$_SESSION['Session_Admin_Language']].' - - </option>';
              foreach($DataRegion as $RowRegion){
                echo '<option value="'.$RowRegion["ID"].'" '.($_RegionID==$RowRegion["ID"]?'selected="selected"':'').'>'.$RowRegion["Name"].'</option>';
              }
							echo '</select>';
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTerritoryName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputTerritoryName"?>" class="gui-input reqs" value="<?php echo $_Name?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTerritoryName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
						<?php
              echo '<input type="hidden" name="inputCountry" class="gui-input" value="'.$inputCountry.'">';
							echo '<select name="selectCountry" class="form-control select2_single" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']].'" onchange="loadajaxselectcountry(this)">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputCountry"][$_SESSION['Session_Admin_Language']].' - - </option>';
              if($dataCountry->datacount>0){
                foreach($dataCountry->data as $gk=>$gv){
  								echo '<option value="'.$gv["countryid"].'" '.($selectCountry==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
  							}
              }
							echo '</select>';
						?>
					</div>
				</div>
        <div class="section-divider mt40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 04_I"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
						<?php
              echo '<input type="hidden" name="inputCountry_I" class="gui-input" value="">';
							echo '<select name="selectCountry_I" class="form-control select2_single" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']].'" onchange="loadajaxstate_I(this)">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputCountry"][$_SESSION['Session_Admin_Language']].' - - </option>';
              if($dataCountry->datacount>0){
                foreach($dataCountry->data as $gk=>$gv){
  								echo '<option value="'.$gv["countryid"].'" '.($Country_I==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
  							}
              }
							echo '</select>';
						?>
					</div>
				</div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-9">
            <div class="bs-component frmalert">
              <?php
                echo '<select id="selectProvince_I" name="selectProvince_I[]" class="form-control select2_multiple" multiple="multiple">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputProvince"][$_SESSION['Session_Admin_Language']].' - - </option>';
                if($ProvinceInfo->datacount>0){
                  foreach($ProvinceInfo->data as $gk=>$gv){
                    if (in_array($gv["id"], $vArrProvince_I)){
                      echo '<option value="'.$gv["id"].'" selected="selected">'.$gv["name"].'</option>';
                    }else{
                      echo '<option value="'.$gv["id"].'">'.$gv["name"].'</option>';
                    }
                  }
                }
                echo '</select>';
              ?>
            </div>
          </div>
        </div>
        <div class="section-divider mt40" id="spy3">
            <span><?php echo $Array_Mod_Lang["txt:Head 04_E"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert bs-component">
						<?php
            // $vArrCountru_E
              echo '<input type="hidden" name="inputCountry_E" class="gui-input" value="">';
							echo '<select name="selectCountry_E[]" class="form-control select2_multiple" multiple="multiple" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']].'">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputCountry"][$_SESSION['Session_Admin_Language']].' - - </option>';
              if($dataCountry->datacount>0){
                foreach($dataCountry->data as $gk=>$gv){
                  if (in_array($gv["countryid"], $vArrCountru_E)){
                    echo '<option value="'.$gv["countryid"].'" selected="selected">'.$gv["name"].'</option>';
                  }else{
                    echo '<option value="'.$gv["countryid"].'">'.$gv["name"].'</option>';
                  }
  							}
              }
							echo '</select>';
						?>
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
