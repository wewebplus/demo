<?php
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$arrf = array();
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_ID AS ID";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_AName AS AName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_FName AS FName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_LName AS LName";
$arrf[] = "CONCAT("._TABLE_ADMIN_STAFF_."_AName,"._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Gender AS Gender";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Birthday AS Birthday";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Email AS Email";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_EmailInfo AS EmailInfo";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Tel AS Tel";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Fax AS Fax";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Position AS Position";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Country AS Country";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_CountryCode AS CountryCode";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_CountryName AS CountryName";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_ZipCode AS ZipCode";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Address AS Address";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
$arrf[] = "a."._TABLE_ADMIN_STAFF_."_Territory AS _Territory";
$arrf[] = "IF(TBTerritory.TName IS NULL or TBTerritory.TName = '', '-', TBTerritory.TName) AS TerritoryName";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_STAFF_." a";
$sql .= " LEFT JOIN (";
  $sql .= " SELECT "._TABLE_ADMIN_TERRITORY_."_ID AS TID,"._TABLE_ADMIN_TERRITORY_."_Name AS TName FROM "._TABLE_ADMIN_TERRITORY_;
$sql .= ") TBTerritory ON (a."._TABLE_ADMIN_STAFF_."_Territory = TBTerritory.TID)";
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
$_Territory = $Row["TerritoryName"];
$dataCountry = getListCountry($_SESSION['Session_Admin_Language']);
$ProvinceInfo = getListProvince($Country,$_SESSION['Session_Admin_Language']);
$Birthday = dateformat($Row["Birthday"]." 00:00:00",'j M Y',$_SESSION['Session_Admin_Language']);
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
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
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
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGender"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo (!empty($Gender)?$ArrayGender[$Gender]:'-');?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputBirthday"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Birthday; ?></p>
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
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmailInfo"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['EmailInfo']; ?></p>
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
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Fax']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Position']; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTerritoryName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <p class="form-control-static text-muted"><?php echo $_Territory; ?></p>
					</div>
				</div>

        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-3">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $CountryName; ?></p>
            </div>
          </div>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Row['Address']; ?></p>
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
              <div class="showoption" id="showoption<?php echo $lkeyindex?>">
                <?php
                $PictureFileHome = $PathUploadPicture.$Row["PictureFile"];
                if(is_file($PictureFileHome)){
                  echo '<div><img src="'.$PictureFileHome.'" alt="" /></div>';
                }
                ?>
              </div>
            </div>
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
