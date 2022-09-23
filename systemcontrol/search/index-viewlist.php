<?php
$arrf = array();
$arrf[] = _TABLE_SEARCH_LOGS_."_ID AS ID";
$arrf[] = _TABLE_SEARCH_LOGS_."_Keyword AS Keyword";
$arrf[] = _TABLE_SEARCH_LOGS_."_SearchDate AS CreateDate";
$arrf[] = _TABLE_SEARCH_LOGS_."_IP AS IP";
$arrf[] = _TABLE_SEARCH_LOGS_."_Browser AS Browser";
$arrf[] = _TABLE_SEARCH_LOGS_."_Platform AS Platform";
$arrf[] = _TABLE_SEARCH_LOGS_."_userAgent AS userAgent";
$sql = "SELECT  ".implode(',',$arrf)." FROM "._TABLE_SEARCH_LOGS_." a";
$sql .= " WHERE "._TABLE_SEARCH_LOGS_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$CreateDate = $Row["CreateDate"];
$CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
$Keyword = $Row["Keyword"];
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&Keyword='.$Keyword.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $mymenuname?></b></h2>
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
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Keyword"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Keyword; ?></p>
            </div>
					</div>
				</div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <div class="col-lg-12">
            <div class="bs-component">
              <div id="countline"></div>
              <div id="boxselectpage"></div>
              <div style="width:100%; overflow:auto;">
                <table cellspacing="1" cellpadding="4" border="0" class="tableDetail">
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
          <button type="button" id="ListExcel" class="button btn-primary" onclick="clicktoexport(this)"><?php echo "Export Excel"?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
