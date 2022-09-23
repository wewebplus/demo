<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_RECIPES_.'_ID AS ID';
$arrf[] = "a."._TABLE_RECIPES_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_RECIPES_.'_GID AS GID';
$arrf[] = "a."._TABLE_RECIPES_.'_Status AS status';
$arrf[] = "a."._TABLE_RECIPES_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_RECIPES_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_RECIPES_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_RECIPES_.'_Picture AS Picture';
$arrf[] = "a."._TABLE_RECIPES_.'_PictureAlt AS PictureAlt';
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_HTMLFileName AS HTMLFileName01".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_RECIPES_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_RECIPES_DETAIL_." ".$lkey." ON (a."._TABLE_RECIPES_."_ID = ".$lkey."."._TABLE_RECIPES_DETAIL_."_ContentID AND ".$lkey."."._TABLE_RECIPES_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_RECIPES_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GID = $Row["GID"];
$ModKey = $Row["ModKey"];
$Picture = $PathUploadPicture.$Row["Picture"];
if(is_file($Picture)){
	$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
	$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
}else{
	$showPicture = "";
}

$startDate = ($Row['StartDate']=='0000-00-00'?'':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'':convertdatefromdb($Row['ExpireDate'],'English'));

$DataCheckMemtype = "";
$SessionID = session_id();

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&sessionid='.$SessionID.'&PathFile='.$PathUploadGallery.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));

?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Gallery"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" action="?" class="form-horizontal" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<!-- .section-divider -->
				<?php if(count($defaultdata[$Login_MenuID]["group"])>0){?>
					<div class="form-group">
						<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?></label>
						<div class="col-md-10 frmalert">
							<p class="form-control-static text-muted">
								<?php
								$query = "ID='".$GID."'";
								$mydata = @ArraySearch($dataArrGroup,$query,1);
								echo $dataArrGroup[array_key_first($mydata)]["Name"];
								?>
							</p>
						</div>
					</div>
				<?php }?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<p class="form-control-static text-muted">
							<?php echo $Row['Subject'.$_SESSION['Session_Admin_Language']]; ?>
						</p>
					</div>
				</div>
				<div class="section-divider mb40" id="spy2">
						<span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="section">
							<div id="progressuploadImages" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
							<div id="outputuploadImagesError"><!-- error or success results --></div>

							<div class="Recommended">Recommended : extention file *.jpg,*.png picture size as <?php echo $defaultdata[$Login_MenuID]["gallery"]["W"];?> X <?php echo $defaultdata[$Login_MenuID]["gallery"]["H"];?> pixel.</div>
							<div class="postuploadicon">
								<label for="uploadImages" class="labeluploadfile">
									<img src="./images/uploadnow.jpg" alt="" />
								</label>
								<input id="uploadImages" name="uploadImages" type="file" class="uploadFile" />
							</div>

							<script type="text/javascript">
							</script>
							<div id="outputuploadImages"></div>

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
