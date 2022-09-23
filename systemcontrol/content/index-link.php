<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$arrf = array();
$arrf[] = "a."._TABLE_CONTENT_.'_ID AS ID';
$arrf[] = "a."._TABLE_CONTENT_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_CONTENT_.'_GID AS GID';
$arrf[] = "a."._TABLE_CONTENT_.'_Status AS status';
$arrf[] = "a."._TABLE_CONTENT_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_CONTENT_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_CONTENT_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_CONTENT_.'_Picture AS Picture';
$arrf[] = "a."._TABLE_CONTENT_.'_PictureAlt AS PictureAlt';
$arrf[] = "a."._TABLE_CONTENT_.'_BookingStart AS BookingStart';
$arrf[] = "a."._TABLE_CONTENT_.'_BookingEnd AS BookingEnd';
$arrf[] = "a."._TABLE_CONTENT_.'_FlagComment AS FlagComment';
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_HTMLFileName AS HTMLFileName01".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTENT_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_CONTENT_DETAIL_." ".$lkey." ON (a."._TABLE_CONTENT_."_ID = ".$lkey."."._TABLE_CONTENT_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTENT_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_CONTENT_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GID = $Row["GID"];
$ModKey = $Row["ModKey"];
$startDate = ($Row['StartDate']=='0000-00-00'?'':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'':convertdatefromdb($Row['ExpireDate'],'English'));
$DataCheckMemtype = "";
$SessionID = "";
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Link"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<!-- .section-divider -->
				<?php if(count($defaultdata[$Login_MenuID]["group"])>0){?>
					<div class="form-group">
						<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroup"][$_SESSION['Session_Admin_Language']]?></label>
						<div class="col-lg-8">
							<div class="bs-component">
								<p class="form-control-static text-muted">
									<?php
									$query = "ID='".$GID."'";
									$mydata = @ArraySearch($dataArrGroup,$query,1);
									echo $dataArrGroup[array_key_first($mydata)]["Name"];
									?>
								</p>
							</div>
						</div>
					</div>
				<?php }?>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-8">
						<div class="bs-component">
							<p class="form-control-static text-muted">
								<?php echo $Row['SubjectThai']; ?>
							</p>
						</div>
					</div>
				</div>
				<div class="section-divider mb40" id="spy2">
						<span><?php echo $Array_Mod_Lang["txt:Head 06"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php
				$KSub = 0;
				$sql = "";
				$ArrField = array();
				$ArrField[] = "a."._TABLE_CONTENT_LINK_."_ID AS ListID";
				$ArrField[] = "a."._TABLE_CONTENT_LINK_."_Order AS ListOrder";
				$ArrField[] = "a."._TABLE_CONTENT_LINK_."_Subject AS ListSubject";
				$ArrField[] = "a."._TABLE_CONTENT_LINK_."_URL AS ListURL";
				$sql .= "SELECT ".implode(',',$ArrField)." FROM "._TABLE_CONTENT_LINK_." a";
				$sql .= " WHERE "._TABLE_CONTENT_LINK_."_ContentID = ".(int)$itemid;
				$sql .= " ORDER BY "._TABLE_CONTENT_LINK_."_Order ASC";
				unset($ArrField);
				$z = new __webctrl;
				$z->sql($sql);
				$RecordCountSize = $z->num();
				$vSize = $z->row();
				?>
				<div class="form-group">
					<label for="maskedKey" class="col-lg-2 control-label">Link</label>
					<div id="boxMyLink" class="col-lg-10">
						<?php if($RecordCountSize>0){?>
							<?php foreach($vSize as $KSub=>$RowSub){?>
								<?php
								$inputLinkName = $RowSub["ListSubject"];
								$inputLinkURL = $RowSub["ListURL"];
								?>
								<div id="<?php echo ($KSub>0?"Clone_Type_".$KSub:"boxMyLinkMaster")?>" class="<?php echo ($KSub>0?'a item clone':'')?>">
								<input type="hidden" name="inputLinkDataID[]" value="<?php echo $RowSub["ListID"]?>" />
								<div class="form-group">
									<div class="col-lg-5">
										<input type="text" required name="inputLinkName[]" class="form-control" value="<?php echo $inputLinkName?>" autocomplete="off" placeholder="ชื่อ URL">
									</div>
									<div class="col-lg-5">
										<input type="url" required name="inputURL[]" class="form-control" value="<?php echo $inputLinkURL?>" autocomplete="off" placeholder="URL">
									</div>
									<div class="col-md-2 frmalert"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveLink(this)"><?php echo "+ Remove"?></button></div>
								</div>
							</div>
							<?php }?>
						<?php }else{?>
							<div id="boxMyLinkMaster" class="<?php echo ($KSub>0?'a item clone':'')?>">
								<input type="hidden" name="inputLinkDataID[]" value="0" />
								<div class="form-group">
									<div class="col-lg-5 frmalert">
										<input type="text" required name="inputLinkName[]" class="form-control fieldreqs" value="" autocomplete="off" placeholder="ชื่อ URL" dataalert="ชื่อ URL">
									</div>
									<div class="col-lg-5 frmalert">
										<input type="url" required name="inputURL[]" class="form-control fieldreqs" value="" autocomplete="off" placeholder="URL" dataalert="URL">
									</div>
									<div class="col-md-2 frmalert"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveLink(this)"><?php echo "+ Remove"?></button></div>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label"></label>
					<div class="col-lg-10">
						<div class="form-group">
							<div class="col-md-10 frmalert"></div>
							<div class="col-md-2 frmalert"><button type="button" class="btn btn-primary btn-block" onclick="clickThisAddLink(this)"><?php echo "+ Add"?></button></div>
						</div>
					</div>
				</div>

				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="button" class="button btn-primary" onclick="saveFrmData(this)"><?php echo "Save ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
