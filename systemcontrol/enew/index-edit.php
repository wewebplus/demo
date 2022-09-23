<?php
$FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
// $FolderGroupKey = $defaultdata[$Login_MenuID]["group"]["menuid"];
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
  $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS ID";
  $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_CreateDate AS CreateDate";
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS ListOrder";
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Name AS Name";
  $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Email AS Email";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_MAILLIST_." a";
  $sql .= " WHERE "._TABLE_MAIL_MAILLIST_."_ID = ".(int)$itemid;
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$Name = $Row["Name"];
$Email = $Row["Email"];
$NewID = $ID;
$SessionID = session_id();

$sql = "SELECT "._TABLE_MAIL_MAILLISTINGROUP_."_GroupID AS GroupID FROM "._TABLE_MAIL_MAILLISTINGROUP_." WHERE "._TABLE_MAIL_MAILLISTINGROUP_."_MailListID = ".intval($ID);
$z->sql($sql);
$RecordCountGroupList = $z->num();
$datagroup = array();
if($RecordCountGroupList>0){
	$vGroupList = $z->row();
	foreach($vGroupList as $rowG){
		$datagroup[] = $rowG["GroupID"];
	}
}

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&myflag=Enew&SessionID='.$SessionID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1200 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitForm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <input type="text" class="form-control fieldreqs" name="<?php echo "inputName"?>" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?>" value="<?php echo $Name?>" >
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <input type="text" class="form-control fieldreqs" name="<?php echo "inputEmail"?>" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>" value="<?php echo $Email?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
						<?php
						if(count($DataGroup)>0){
							$indexgroup = 0;
							foreach($DataGroup as $RowGroup){
								$indexgroup++;
								if (in_array($RowGroup["ID"], $datagroup)) {
									$datacheck = true;
								}else{
									$datacheck = false;
								}
								echo '<div class="mb10">';
									echo '<div class="checkbox-custom mb5">';
									  echo '<input type="checkbox" id="inputGroupID_'.$indexgroup.'" name="inputGroupID[]" '.($datacheck?'checked="checked"':'').' value="'.$RowGroup["ID"].'">';
									  echo '<label for="inputGroupID_'.$indexgroup.'">'.$RowGroup["Name"].'</label>';
									echo '</div>';
								echo '</div>';
							}
						}
						?>
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
