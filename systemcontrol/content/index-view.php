<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_CONTENT_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_CONTENT_."_ID AS ID";
$arrf[] = "a."._TABLE_CONTENT_."_Key AS ModKey";
$arrf[] = "a."._TABLE_CONTENT_."_DealerCode AS DealerCode";
$arrf[] = "a."._TABLE_CONTENT_."_GID AS GID";
$arrf[] = "a."._TABLE_CONTENT_."_DesDate AS DesDate";
$arrf[] = "a."._TABLE_CONTENT_."_Status AS status";
$arrf[] = "a."._TABLE_CONTENT_."_Ignore AS allignore";
$arrf[] = "a."._TABLE_CONTENT_."_Start AS StartDate";
$arrf[] = "a."._TABLE_CONTENT_."_End AS ExpireDate";
$arrf[] = "a."._TABLE_CONTENT_.'_PictureHome AS PictureHome';
$arrf[] = "a."._TABLE_CONTENT_."_Picture AS Picture";
$arrf[] = "a."._TABLE_CONTENT_."_PictureAlt AS PictureAlt";
$arrf[] = "a."._TABLE_CONTENT_."_BookingStart AS BookingStart";
$arrf[] = "a."._TABLE_CONTENT_."_BookingEnd AS BookingEnd";
$arrf[] = "a."._TABLE_CONTENT_."_FlagComment AS FlagComment";
$arrf[] = "a."._TABLE_CONTENT_."_StatusHome AS StatusHome";
$arrf[] = "a."._TABLE_CONTENT_."_Status AS ListStatus";
$arrf[] = "a."._TABLE_CONTENT_."_StatusRating AS ListRating";
$arrf[] = "a."._TABLE_CONTENT_."_StatusComment AS ListComment";
$arrf[] = "a."._TABLE_CONTENT_."_StatusRelate AS ListRelate";
$arrf[] = "a."._TABLE_CONTENT_."_Pin AS ListPin";
$arrf[] = "a."._TABLE_CONTENT_."_StatusContentPassword AS ListStatusContentPassword";
$arrf[] = "a."._TABLE_CONTENT_."_ContentPassword AS ContentPassword";
$arrf[] = "a."._TABLE_CONTENT_."_Public AS ContentPublic";
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_HTMLFileName AS HTMLFileName01".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_By AS By".$lkey;
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
$selectDealer = $Row["DealerCode"];
$startDate = ($Row['StartDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['ExpireDate'],'English'));
$DesDate = convertdatefromdb(substr($Row['DesDate'],0,10),'English');
$Picture = $PathUploadPicture.$Row["Picture"];
if(is_file($Picture)){
	$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
	$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
}else{
	$showPicture = "";
}
$flagComment = $Row['FlagComment'];
$StatusHome = $Row["StatusHome"];
$ListStatus = $Row["ListStatus"];
$ListRating = $Row["ListRating"];
$ListComment = $Row["ListComment"];
$ListRelate = $Row["ListRelate"];
$ListPin = $Row["ListPin"];
$ListStatusContentPassword = $Row["ListStatusContentPassword"];
$ContentPassword = $Row["ContentPassword"];
$ContentPublic = $Row["ContentPublic"];
//_TABLE_CONTENT_RATING_
$sql = "SELECT SUM("._TABLE_CONTENT_RATING_."_Rating) AS Rating,AVG("._TABLE_CONTENT_RATING_."_Rating) AS AVG,COUNT(*) AS COUNTRating FROM "._TABLE_CONTENT_RATING_." WHERE "._TABLE_CONTENT_RATING_."_ContentID = ".(int)$itemid;
$z->sql($sql);
$vRating = $z->row();
$RowRating = $vRating[0];
$InRating = number_format($RowRating["AVG"],2);

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
							<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDateTime"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-md-10 frmalert">
								<p class="form-control-static text-muted"><?php echo $startDate?> - <?php echo $endDate?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDesDate"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-md-10 frmalert">
								<p class="form-control-static text-muted"><?php echo $DesDate?></p>
							</div>
						</div>
				<div class="section-divider mb40" id="spy2">
				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<!-- .section-divider -->
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
									<div class="row">
									  <div class="col-md-12">
										<div class="section">
											<label class="field prepend-icon">
					  						<div class="viewtextinput"><?php echo $Row['Subject'.$lkey]; ?></div>
					  						<label for="inputSubject" class="field-icon">
					  						  <i class="fa fa-bullhorn"></i>
					  						</label>
										  </label>
										</div>
									  </div>
									</div>
					        		<!-- Text Areas -->
											<div class="row">
											  <div class="col-md-12">
												<div class="section">
													<label class="field prepend-icon">
							  						<div class="viewtextinput"><?php echo echoDetailToediter($Row['Title'.$lkey]); ?></div>
							  						<label for="inputSubject" class="field-icon">
							  						  <i class="fa fa-bullhorn"></i>
							  						</label>
												  </label>
												</div>
											  </div>
											</div>
											<?php
							        $html = "";
											$html = $PathUploadHtml.$Row['HTMLFileName01'.$lkey];
											if(is_file($html)){
												$html = file_get_contents($html);
												$html = str_replace("/upload/",_HTTP_PATH_UPLOAD_."/",$html);
											}else{
												$html = "";
											}
							        echo '<div class="row section">';
							          echo '<div class="col-md-12">';
							            echo '<h4>'.$Array_Mod_Lang["txtinput:inputDetail"][$_SESSION['Session_Admin_Language']].'</h4>';
							          echo '</div>';
							        echo '</div>';
											echo '<div class="row">';
						            echo '<div class="col-md-12">';
						            echo '<div class="section showhtml">';
						              echo $html;
						            echo '</div>';
						            echo '</div>';
						          echo '</div>';
											?>
											<div class="row">
											  <div class="col-md-12">
												<div class="section">
													<label class="field prepend-icon">
							  						<div class="viewtextinput"><?php echo $Row['By'.$lkey]; ?></div>
							  						<label for="inputSubject" class="field-icon">
							  						  <i class="fa fa-bullhorn"></i>
							  						</label>
												  </label>
												</div>
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
				<?php
				$PictureFileHome = $PathUploadPicture.$Row["PictureHome"];
				if(is_file($PictureFileHome)){
					echo '<div class="row">';
						echo '<div class="panel-body pn">';
							echo '<div class="row table-layout table-clear-xs">';
								echo '<div class="col-xs-6">Thumbnail Top</div>';
								echo '<div class="col-xs-6 bxpreviewimg">';
									echo '<img src="'.$PictureFileHome.'" alt="" />';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
				?>
				<div class="row">
					<div class="panel-body pn">
						<div class="row table-layout table-clear-xs">
							<div class="col-xs-6">Thumbnail Inner</div>
							<div class="col-xs-6 bxpreviewimg">
								<?php echo $showPicture?>
							</div>
						</div>
					</div>
				</div>

				<div class="section-divider mb40" id="spy4">
				  <span><?php echo $Array_Mod_Lang["txt:Head 05"][$_SESSION['Session_Admin_Language']]?></span>
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
							<input type="checkbox" disabled name="ListRating" id="ListRating" value="Yes" <?php echo ($ListRating=='Yes'?'checked="checked"':'')?>>
							<label for="ListRating" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffRating"][$_SESSION['Session_Admin_Language']]?> (<?php echo $Array_Mod_Lang["txt:Rating"][$_SESSION['Session_Admin_Language']]." ".$InRating?>)</span>
						</label>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" disabled name="ListComment" id="ListComment" value="Yes" <?php echo ($ListComment=='Yes'?'checked="checked"':'')?>>
							<label for="ListComment" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffComment"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" disabled name="ListRelate" id="ListRelate" value="Yes" <?php echo ($ListRelate=='Yes'?'checked="checked"':'')?>>
							<label for="ListRelate" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffRelate"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" disabled name="ListStatus" id="ListStatus" value="On" <?php echo ($ListStatus=='On'?'checked="checked"':'')?>>
							<label for="ListStatus" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffStatus"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" disabled name="StatusHome" id="StatusHome" value="Yes" <?php echo ($StatusHome=='Yes'?'checked="checked"':'')?>>
							<label for="StatusHome" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffHomeStatus"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" disabled name="StatusPin" id="StatusPin" value="Yes" <?php echo ($ListPin=='Yes'?'checked="checked"':'')?>>
							<label for="StatusPin" data-on="YES" data-off="NO"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffPin"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
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
	        <div class="panel-footer text-right mt10">
						<?php if($btnaspma){?>
		          <button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
						<?php }?>
	          <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
	        </div>
	        <!-- end .form-footer section -->
	      </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
