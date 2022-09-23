<?php
$sql="SELECT * FROM "._TABLE_ADMIN_USERGROUP_." WHERE "._TABLE_ADMIN_USERGROUP_."_ID = ".(int)$itemid;
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$num = $z->num();
$Row = $v[0];
$ID = $Row[_TABLE_ADMIN_USERGROUP_."_ID"];
$Name = $Row[_TABLE_ADMIN_USERGROUP_."_Name"];
$Title = echoDetailToediter($Row[_TABLE_ADMIN_USERGROUP_."_Title"]);

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));

?>

<div class="page-heading">
    <div class="media clearfix">
      <div class="media-body va-m">
        <h2 class="media-heading"><?php echo $Name?></h2>
        <p class="lead"><?php echo $Title?></p>
      </div>
    </div>
</div>
<!-- edit panel -->

<div class="admin-form theme-primary">
  <div class="panel heading-border panel-primary">
    <div class="panel-body bg-light">
      <form name="myFrm" id="myFrm" action="?" method="post" onsubmit="return submitFrm(this)">
        <input name="Permission" type="hidden" id="Permission" value="" />
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <div class="section-divider mt40 mb25" id="spy2">
          <span>Group User</span>
        </div>
        <div class="row">
          <div id="dualSelectCourse"></div>
        </div>
        <!-- .section-divider -->
        <div class="panel-footer mt10">
          <p class="text-right">
            <button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]?></button>
            <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
          </p>
        </div>
        <!-- end .form-footer section -->
      </form>
    </div>
  </div>
</div>
