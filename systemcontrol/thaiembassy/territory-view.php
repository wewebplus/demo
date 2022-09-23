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
$sql = "SELECT * FROM "._TABLE_ADMIN_TERRITORY_."_external WHERE "._TABLE_ADMIN_TERRITORY_."_external_TerritoryID = ".intval($ID);
$z->sql($sql);
$vExternal = $z->row();

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
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
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitFrm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <input type="hidden" name="ListStatus" value="On" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTerritoryRegion"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
            <p class="form-control-static text-muted"><?php echo $_RegionName?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTerritoryName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <p class="form-control-static text-muted"><?php echo $_Name?></p>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
            <p class="form-control-static text-muted"><?php echo $inputCountry?></p>
					</div>
				</div>
        <div class="section-divider mt40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 04_I"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-9">
            <div class="bs-component frmalert">
              <?php
              if(count($vInternal)>0){
                foreach($vInternal as $RowInternal){
                  echo '<p class="form-control-static text-muted">'.$RowInternal[_TABLE_ADMIN_TERRITORY_."_internal_StateName"].'</p>';
                }
              }
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
            if(count($vExternal)>0){
              foreach($vExternal as $RowExternal){
                echo '<p class="form-control-static text-muted">'.$RowExternal[_TABLE_ADMIN_TERRITORY_."_external_CountryName"].'</p>';
              }
            }
            ?>
					</div>
				</div>
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
