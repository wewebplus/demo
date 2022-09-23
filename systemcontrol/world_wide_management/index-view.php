<?php
$sql="SELECT * FROM "._TABLE_ADDRCOUNTRIES_." WHERE "._TABLE_ADDRCOUNTRIES_."_ID = ".(int)$itemid;
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$num = $z->num();
$Row = $v[0];
$ID = $Row[_TABLE_ADDRCOUNTRIES_."_ID"];
$CountryNameTH = $Row[_TABLE_ADDRCOUNTRIES_."_CountryNameTH"];
$CountryNameEN = $Row[_TABLE_ADDRCOUNTRIES_."_CountryNameEN"];
$CountryCode = $Row[_TABLE_ADDRCOUNTRIES_."_CountryCode"];
$CountryLongCode = $Row[_TABLE_ADDRCOUNTRIES_."_CountryLongCode"];
$CountryISD = $Row[_TABLE_ADDRCOUNTRIES_."_CountryISD"];
$ISONumeric = $Row[_TABLE_ADDRCOUNTRIES_."_ISONumeric"];
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1000 center-block">
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:View"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>


  <!-- edit panel -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
        <form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post" id="form-ui">
          <input name="Permission" type="hidden" id="Permission" value="" />
          <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
          <!-- start .section row  section -->
          <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
          </div>
          <!-- .section-divider -->
          <div class="form-group">
            <label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?> (EN)</label>
            <div class="col-md-9">
              <p class="form-control-static text-muted"><?php echo $CountryNameTH?></p>
            </div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?> (TH)</label>
            <div class="col-md-9">
              <p class="form-control-static text-muted"><?php echo $CountryNameEN?></p>
            </div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Shot Code"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-2">
              <p class="form-control-static text-muted"><?php echo $CountryCode?></p>
            </div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Long Code"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-2">
              <p class="form-control-static text-muted"><?php echo $CountryLongCode?></p>
            </div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country ISD"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-2">
              <p class="form-control-static text-muted"><?php echo $CountryISD?></p>
            </div>
          </div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country ISONumeric"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-2">
              <p class="form-control-static text-muted"><?php echo $ISONumeric?></p>
  					</div>
  				</div>

          <!-- end .form-body section -->
          <div class="panel-footer">
            <p class="text-right">
              <button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
              <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
            </p>
          </div>
          <!-- end .form-footer section -->
        </form>
      </div>
    </div>
  </div>

</div>
