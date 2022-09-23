<?php
$arrf = array();
$arrf[] = "a."._TABLE_MAIL_GROUP_.'_ID AS ID';
$arrf[] = "a."._TABLE_MAIL_GROUP_.'_Status AS status';
$arrf[] = "a."._TABLE_MAIL_GROUP_.'_GroupName AS GroupName';
$arrf[] = "a."._TABLE_MAIL_GROUP_.'_GroupShotname AS GroupShotname';
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_MAIL_GROUP_." a";
$sql .= " WHERE "._TABLE_MAIL_GROUP_."_ID = ".(int)$itemid;
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];

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
			  <form method="post" action="?" class="form-horizontal" name="myFrm" id="myFrm" onsubmit="return submitForm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<div class="section-divider mb40" id="spy1">
				  <span><?php echo $Array_Mod_Lang["txt:Group Head 01"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-8">
						<div class="bs-component frmalert">
							<input type="text" name="<?php echo "inputGroupSubject"?>" value="<?php echo $Row['GroupName']; ?>" class="form-control fieldreqs" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputShotGroupSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-8">
						<div class="bs-component">
							<input type="text" name="<?php echo "inputShotGroupSubject"?>" value="<?php echo $Row['GroupShotname']; ?>" class="form-control" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputShotGroupSubject"][$_SESSION['Session_Admin_Language']]?>">
						</div>
					</div>
				</div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
				  <button type="submit" class="button btn-primary"><?php echo "Save ".$mymenuname?></button>
          <button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
