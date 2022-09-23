<?php
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];

$sql = "";
$arrfield = array();
$arrfield[] = "TBmain.*";
$arrfield[] = "TBJoin.GSubject".$_SESSION['Session_Admin_Language']." AS GroupSubject";
$sql .= "SELECT ".implode(',',$arrfield)." FROM ";
$sql .= " (";
  $arrf = array();
  $arrf[] = "a."._TABLE_CONTACT_.'_ID AS ID';
  $arrf[] = "a."._TABLE_CONTACT_.'_GroupID AS GroupID';
  $arrf[] = "a."._TABLE_CONTACT_.'_Key AS ModKey';
  $arrf[] = "a."._TABLE_CONTACT_.'_Status AS status';
  $arrf[] = "a."._TABLE_CONTACT_.'_CreateDate AS CreateDate';
  $arrf[] = "a."._TABLE_CONTACT_.'_Name AS ContactName';
  $arrf[] = "a."._TABLE_CONTACT_.'_Subject AS ContactSubject';
  $arrf[] = "a."._TABLE_CONTACT_.'_Company AS ContactCompany';
  $arrf[] = "a."._TABLE_CONTACT_.'_Email AS ContactEmail';
  $arrf[] = "a."._TABLE_CONTACT_.'_Tel AS ContactTel';
  $arrf[] = "a."._TABLE_CONTACT_.'_Message AS ContactMessage';
  $sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTACT_." a";
  $sql .= " WHERE "._TABLE_CONTACT_."_ID = ".(int)$itemid;
  unset($arrf);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
	$sqlsub = "";
	foreach($systemLang as $lkey=>$lval){
		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS GSubject".$lkey;
		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS GStatus".$lkey;
	}
	$sql .= "SELECT b."._TABLE_CONTACT_GROUP_."_ID as groupid".$sqlsub." FROM "._TABLE_CONTACT_GROUP_." b";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (b."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE b."._TABLE_CONTACT_GROUP_."_Key IN ('".implode("','",$dataModuleKey)."')";
$sql .= ") TBJoin ON (TBmain.GroupID = TBJoin.groupid)";
$sql .= " WHERE 1";
unset($arrfield);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GID = $Row["GroupID"];
$GroupSubject = $Row["GroupSubject"];
$ContactName = $Row["ContactName"];
$ContactSubject = $Row["ContactSubject"];
$ContactCompany = $Row["ContactCompany"];
$ContactEmail = $Row["ContactEmail"];
$ContactMessage = $Row["ContactMessage"];
$ContactTel = $Row["ContactTel"];
$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');
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
			  <form method="post" action="?" class="form-horizontal" name="myFrm" id="myFrm" onsubmit="return submitFrm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactDate"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $CreateDate?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $GroupSubject?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $ContactName?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $ContactEmail?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactTel"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $ContactTel?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactCompany"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $ContactCompany?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $ContactSubject?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactMessage"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo echoDetailToediter($ContactMessage); ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
          <label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputContactMessageReply"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-8">
            <div class="bs-component">
              <textarea class="form-control" name="<?php echo "inputTextReply"?>" rows="4" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputContactMessageReply"][$_SESSION['Session_Admin_Language']]?> "></textarea>
            </div>
          </div>
          <div class="col-md-1">
            <div class="bs-component">
              <button type="button" id="ListBtnReply" class="btn btn-primary" onclick="ReplyMessage(this)">Reply</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <ul id="showhistory" class="showhistory">

            </ul>
          </div>
        </div>
			  </form>
				<form name="myFrmBtn" id="myFrmBtn" action="?" method="post" id="form-ui">
	        <input name="Permission" type="hidden" id="Permission" value="" />
	        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
	        <!-- end .form-body section -->
	        <div class="panel-footer text-right">
	          <button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
	        </div>
	        <!-- end .form-footer section -->
	      </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
