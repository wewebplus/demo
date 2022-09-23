<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_DOWNLOAD_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_DOWNLOAD_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_DOWNLOAD_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_DOWNLOAD_.'_ID AS ID';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_DealerCode AS DealerCode';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_GID AS GID';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_SGID AS SGID';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_Status AS status';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_Picture AS Picture';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_PictureAlt AS PictureAlt';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_BookingStart AS BookingStart';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_BookingEnd AS BookingEnd';
$arrf[] = "a."._TABLE_DOWNLOAD_.'_FlagComment AS FlagComment';
$arrf[] = "a."._TABLE_DOWNLOAD_."_StatusContentPassword AS ListStatusContentPassword";
$arrf[] = "a."._TABLE_DOWNLOAD_."_ContentPassword AS ContentPassword";
$arrf[] = "a."._TABLE_DOWNLOAD_."_Public AS ContentPublic";
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Type AS Type".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_L AS L".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_F AS F".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_FName AS FName".$lkey;
	$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_DOWNLOAD_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_DOWNLOAD_DETAIL_." ".$lkey." ON (a."._TABLE_DOWNLOAD_."_ID = ".$lkey."."._TABLE_DOWNLOAD_DETAIL_."_ContentID AND ".$lkey."."._TABLE_DOWNLOAD_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_DOWNLOAD_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GID = $Row["GID"];
$SGID = $Row["SGID"];
$selectDealer = $Row["DealerCode"];
$startDate = ($Row['StartDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['ExpireDate'],'English'));
$ListStatusContentPassword = $Row["ListStatusContentPassword"];
$ContentPassword = $Row["ContentPassword"];
$ContentPublic = $Row["ContentPublic"];

$Picture = $PathUploadPicture.$Row["Picture"];
if(is_file($Picture)){
	$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
	$myImagesFull = $showPicture;
	$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
}else{
	$showPicture = "";
	$myImagesFull = "";
}
$flagComment = $Row['FlagComment'];
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
			  <form method="post" action="?" class="form-horizontal" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
            <div class="section-divider mb40" id="spy1">
                <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
            </div>
						<div class="form-group">
							<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDateTime"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-md-10">
								<p class="form-control-static text-muted"><?php echo $startDate?> - <?php echo $endDate?></p>
							</div>
						</div>

				<div class="section-divider mb40" id="spy2">
				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php if(count($dataArrGroup)>0){?>
					<div class="form-group">
						<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroup"][$_SESSION['Session_Admin_Language']]?></label>
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
				<?php if($SGID>0){?>
				<div class="row">
				    <div class="col-md-6">
				      <div class="section">
				      <?php
							echo '<label class="field prepend-icon">';
								echo '<div class="viewtextinput">'.$defaultdata[$Login_MenuID]["subgroup"][$GID][$SGID].'</div>';
								echo '<label for="inputSubject" class="field-icon">';
									echo '<i class="fa fa-cogs"></i>';
								echo '</label>';
							echo '</label>';
				      ?>
				      </div>
				    </div>
				    <div class="col-md-6"></div>
				</div>
				<?php }?>
				<?php $countlang = count($systemLang);?>
				<div class="row">
					<div class="paneltab">
				    <ul class="nav nav-tabs nav-justified nav-inline">
				      <?php
				      foreach($systemLang as $lkey=>$lval){
								$tabactive = ($lkey==$systemdefaultTab?'active':'');
								$tabflag = "flag-".strtolower($lkey);
				        echo '<li class="'.$tabactive.'">';
				          echo '<a href="#tab'.$lkey.'" data-toggle="tab" aria-expanded="true"><span class="flaglist-xs '.$tabflag.'"></span> '.$Array_Mod_Lang["tab:TabLang"][$lkey].'</a>';
				        echo '</li>';
				      }
				      ?>
				    </ul>
				  </div>
					<div class="paneltabbody">
						<div class="tab-content tab-validate pn br-n">
							<?php foreach($systemLang as $lkey=>$lval){?>
								<?php $tabactive = ($lkey==$systemdefaultTab?'active':'');?>
				        <div id="<?php echo 'tab'.$lkey?>" class="tab-pane <?php echo $tabactive?>">
									<div class="boxlang">
					        <input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $Row['SubjectID'.$lkey]; ?>" />
									<?php
									$DocumentDownloadType = $Row['Type'.$lkey];
									if($countlang>1){
										echo '<div class="row">';
											echo '<div class="col-md-12">';
												echo '<div class="section">';
													echo '<label>'.($Row['Status'.$lkey]=='Off'?'<i class="fas fa-check-square"></i>':'<i class="fas fa-square"></i>').' ไม่ใช้งาน '.$lval.' Language</label>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									}
									?>
									<div class="form-group">
										<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-10 frmalert">
											<p class="form-control-static text-muted"><?php echo $Row['Subject'.$lkey]; ?></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-10 frmalert">
											<p class="form-control-static text-muted"><?php echo $Row['Title'.$lkey]; ?></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-9 frmalert">
											<p class="form-control-static text-muted">
												<?php
												if($DocumentDownloadType=='L'){
													echo $Array_Mod_Lang["txtinput:DocumentDownloadTypeL"][$_SESSION['Session_Admin_Language']];
												}else{
													echo $Array_Mod_Lang["txtinput:DocumentDownloadTypeF"][$_SESSION['Session_Admin_Language']];
												}
												?>
											</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDownloadPreview"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-9 frmalert">
											<p class="form-control-static text-muted">
												<?php
												if($DocumentDownloadType=="L"){
													$Url = $Row['L'.$lkey];
												}else{
													$Url = $PathUploadFile.$Row['F'.$lkey];
													if(is_file($Url)){
														$showFile = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Url);
														echo '<a href="'.$showFile.'" target="_blank" download="'.$Row['FName'.$lkey].'">'.$Row['FName'.$lkey].'</a>';
													}
												}
												?>
											</p>
										</div>
									</div>


									</div>
								</div>
			        <?php }?>
						</div>
					</div>
				</div>
				<div class="section-divider mb40" id="spy3">
				  <span><?php echo $Array_Mod_Lang["txt:Head 03"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="row">
					<div class="panel-body pn">
						<div class="row table-layout table-clear-xs">
							<div class="col-xs-12 bxpreviewimg">
								<?php echo $showPicture?>
							</div>
						</div>
					</div>
				</div>
				<div class="section-divider mb40" id="spy4">
				  <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-3 frmalert">
            <label class="switch switch-primary block mt5">
							<input type="checkbox" disabled name="ListStatusContentPassword" id="ListStatusContentPassword" value="Yes" <?php echo ($ListStatusContentPassword=='Yes'?'checked="checked"':'')?> onclick="CheckRowInput(this)">
							<label for="ListStatusContentPassword" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffPassword"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 frmalert">
						<p class="form-control-static text-muted"><?php echo $ContentPassword?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" disabled name="StatusPublic" id="StatusPublic" value="Yes" <?php echo ($ContentPublic=='Yes'?'checked="checked"':'')?>>
							<label for="StatusPublic" data-on="YES" data-off="NO"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffPublic"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
				</div>
			  </form>

				<form name="myFrmBtn" id="myFrmBtn" action="?" method="post" id="form-ui">
	        <input name="Permission" type="hidden" id="Permission" value="" />
	        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
	        <!-- end .form-body section -->
	        <div class="panel-footer text-right">
	          <button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
	          <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
	        </div>
	        <!-- end .form-footer section -->
	      </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
