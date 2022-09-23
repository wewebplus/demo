<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid=0&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Addnew"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
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
  						<label for="inputGName" class="field prepend-icon">
  								<input type="text" name="inputCountryNameTH" id="inputCountryNameTH" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?> (TH)">
  								<label class="field-icon"><i class="fa fa-users"></i></label>
  						</label>
  					</div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?> (TH)</label>
  					<div class="col-md-9">
              <label for="inputGName" class="field prepend-icon">
                  <input type="text" name="inputCountryNameEN" id="inputCountryNameEN" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Country Name"][$_SESSION['Session_Admin_Language']]?> (TH)">
                  <label class="field-icon"><i class="fa fa-users"></i></label>
              </label>
  					</div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Shot Code"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-2">
              <label for="inputGName" class="field prepend-icon">
                  <input type="text" maxlength="2" name="inputCountryCode" id="inputCountryCode" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Country Shot Code"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Country Shot Code"][$_SESSION['Session_Admin_Language']]?>">
                  <label class="field-icon"><i class="fa fa-users"></i></label>
              </label>
  					</div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country Long Code"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-2">
              <label for="inputGName" class="field prepend-icon">
                  <input type="text" maxlength="3" name="inputCountryLongCode" id="inputCountryLongCode" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Country Long Code"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Country Long Code"][$_SESSION['Session_Admin_Language']]?>">
                  <label class="field-icon"><i class="fa fa-users"></i></label>
              </label>
  					</div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country ISD"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-2">
              <label for="inputGName" class="field prepend-icon">
                  <input type="text" maxlength="5" name="inputCountryISD" id="inputCountryISD" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Country ISD"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Country ISD"][$_SESSION['Session_Admin_Language']]?>">
                  <label class="field-icon"><i class="fa fa-users"></i></label>
              </label>
  					</div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Country ISONumeric"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-2">
              <label for="inputGName" class="field prepend-icon">
                  <input type="text" maxlength="3" name="inputISONumeric" id="inputISONumeric" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Country ISONumeric"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Country ISONumeric"][$_SESSION['Session_Admin_Language']]?>">
                  <label class="field-icon"><i class="fa fa-users"></i></label>
              </label>
  					</div>
  				</div>
          <div class="panel-footer">
            <p class="text-right">
              <button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
              <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
            </p>
          </div>
          <!-- end .form-footer section -->
        </form>
      </div>
    </div>
  </div>
</div>
