<?php
$itemid = (!empty($itemid)?intval($itemid):0);
if($itemid>0){

}
$date = date("Y-m-d H:i:s");
$DRStart = date("Y-m-1", strtotime($date));
$DREnd = date("Y-m-t", strtotime($date));
$showRangDate = dateformat($DRStart." 00:00:00",'d/m/Y')." - ".dateformat($DREnd." 00:00:00",'d/m/Y');
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&actiontype=report');
?>
<div class="mw1200 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitDate(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label" for="daterangepicker1">Date Select</label>
          <div class="col-md-6">
            <input type="text" readonly class="form-control pull-right" name="daterange" value="<?php echo (!empty($_GET["daterange"])?$_GET["daterange"]:$showRangDate)?>" id="daterangepicker1">
          </div>
          <div class="col-md-2">
            <button rel="1" type="submit" class="button btn-primary">Submit</button>
          </div>
        </div>

        <div class="form-group">
					<div class="col-md-12">
            <div class="panel" id="p10">
              <div class="panel-body myborder">
                <div id="high-lineregister" style="width: 100%; height: 350px; margin: 0 auto"></div>
              </div>
            </div>
					</div>
				</div>
        <div class="form-group">
					<div class="col-md-12">
            <div class="panel" id="p10">
              <div class="panel-heading">
                <span class="panel-title"><?php echo "Group Total";?></span>
              </div>
              <div class="panel-body myborder">
                <div id="high-pie-Level" style="width: 100%; height: 300px; margin: 0 auto"></div>
              </div>
            </div>
					</div>
				</div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="panel" id="p10">
              <div class="panel-heading">
                <span class="panel-title"><?php echo "Group Total";?></span>
                <span class="showDateText"></span>
              </div>
              <div class="panel-body myborder">
                <div id="high-pie-LevelFix" style="width: 100%; height: 300px; margin: 0 auto"></div>
              </div>
            </div>
					</div>
				</div>



				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
