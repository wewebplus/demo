<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_CONTENT_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_RECIPES_."_ID AS ID";
$arrf[] = "a."._TABLE_RECIPES_."_Key AS ModKey";
$arrf[] = "a."._TABLE_RECIPES_."_GID AS GID";
$arrf[] = "a."._TABLE_RECIPES_."_DesDate AS DesDate";
$arrf[] = "a."._TABLE_RECIPES_."_Status AS status";
$arrf[] = "a."._TABLE_RECIPES_."_Ignore AS allignore";
$arrf[] = "a."._TABLE_RECIPES_."_Start AS StartDate";
$arrf[] = "a."._TABLE_RECIPES_."_End AS ExpireDate";
$arrf[] = "a."._TABLE_RECIPES_.'_PictureHome AS PictureHome';
$arrf[] = "a."._TABLE_RECIPES_."_Picture AS Picture";
$arrf[] = "a."._TABLE_RECIPES_."_PictureAlt AS PictureAlt";
$arrf[] = "a."._TABLE_RECIPES_."_StatusHome AS StatusHome";
$arrf[] = "a."._TABLE_RECIPES_."_Status AS ListStatus";
$arrf[] = "a."._TABLE_RECIPES_."_StatusRating AS ListRating";
$arrf[] = "a."._TABLE_RECIPES_."_StatusComment AS ListComment";
$arrf[] = "a."._TABLE_RECIPES_."_StatusRelate AS ListRelate";
$arrf[] = "a."._TABLE_RECIPES_."_Pin AS ListPin";
$arrf[] = "a."._TABLE_RECIPES_."_StatusContentPassword AS ListStatusContentPassword";
$arrf[] = "a."._TABLE_RECIPES_."_ContentPassword AS ContentPassword";
$arrf[] = "a."._TABLE_RECIPES_."_Public AS ContentPublic";
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_HTMLFileName AS HTMLFileName01".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Detail AS HTMLDetail".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_FitPeople AS FitPeople".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_PreparationTime AS PreparationTime".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_Difficulty AS Difficulty".$lkey;
	$arrf[] = $lkey."."._TABLE_RECIPES_DETAIL_."_YoutubeKey AS YoutubeKey".$lkey;
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
$StatusHome = $Row["StatusHome"];
$ListStatus = $Row["ListStatus"];
$ListRating = $Row["ListRating"];
$ListComment = $Row["ListComment"];
$ListRelate = $Row["ListRelate"];
$ListPin = $Row["ListPin"];
$ListStatusContentPassword = $Row["ListStatusContentPassword"];
$ContentPassword = $Row["ContentPassword"];
$ContentPublic = $Row["ContentPublic"];

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
							<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDesDate"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-md-3">
									<p class="form-control-static text-muted"><?php echo $startDate?></p>
							</div>
							<div class="col-md-3">
									<p class="form-control-static text-muted"><?php echo $endDate?></p>
							</div>
						</div>

				<div class="section-divider mb40" id="spy2">
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
								<?php
								$tabactive = ($lkey==$systemdefaultTab?'active':'');
								$SubjectID = $Row['SubjectID'.$lkey];
								$arrf = array();
								$arrf[] = _TABLE_RECIPES_DETAILRELATE_."_ID AS _ID";
								$arrf[] = _TABLE_RECIPES_DETAILRELATE_."_Detail AS _Detail";
								$arrf[] = _TABLE_RECIPES_DETAILRELATE_."_Order AS _Order";
								$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_RECIPES_DETAILRELATE_." WHERE "._TABLE_RECIPES_DETAILRELATE_."_ContentID = ".intval($ID);
								$sql .= " AND "._TABLE_RECIPES_DETAILRELATE_."_DetailID = ".intval($SubjectID);
								$sql .= " ORDER BY "._TABLE_RECIPES_DETAILRELATE_."_Order ASC";
								unset($arrf);
								$z->sql($sql);
								$RecordCountRelate = $z->num();
								$ArrRelate = array();
								if($RecordCountRelate>0){
									$vRelate = $z->row();
									foreach($vRelate as $RowRelate){
										$ar = array();
										$ar["_ID"] = $RowRelate["_ID"];
										$ar["_Detail"] = decodetxterea($RowRelate["_Detail"]);
										$ArrRelate[] = $ar;
									}
								}
								?>
								<div id="<?php echo 'tab'.$lkey?>" class="tab-pane <?php echo $tabactive?>">
									<div class="boxlang">
					        <input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $SubjectID; ?>" />
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
												$html = echoDetailToediter($Row['HTMLDetail'.$lkey]);
												// $html = "";
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

									<div class="row section">
							        	<div class="col-md-12">
							            	<h4><?php echo $Array_Mod_Lang["txt:Head Info"][$_SESSION['Session_Admin_Language']]; ?></h4>
							          	</div>
							        </div>
									<div class="form-group">
										<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:FitPeople"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-lg-10">
											<div class="viewtextinput"><?php echo $Row['FitPeople'.$lkey]; ?></div>
										</div>
									</div>
									<div class="form-group">
										<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:PreparationTime"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-lg-4">
											<div class="viewtextinput"><?php echo $Row['PreparationTime'.$lkey]; ?></div>
										</div>
									</div>
									<div class="form-group">
										<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Difficulty"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-10">
											<div class="viewtextinput"><?php echo $Row['Difficulty'.$lkey]; ?></div>
										</div>
									</div>
									<div class="form-group">
										<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:YoutubeKey"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-10">
											<div class="viewtextinput"><?php echo $Row['YoutubeKey'.$lkey]; ?></div>
										</div>
									</div>
									<?php
									if($RecordCountRelate>0){
										echo '<div class="row">';
											echo '<div class="col-md-12">';
												echo '<h4>'.$Array_Mod_Lang["txt:Head Cooking process"][$_SESSION['Session_Admin_Language']].'</h4>';
											echo '</div>';
										echo '</div>';
										foreach($ArrRelate as $KRelate=>$RowRelate){
											$_ID = $RowRelate["_ID"];
											$_Detail = $RowRelate["_Detail"];
											echo '<div class="form-group">';
												echo '<label class="col-lg-2 control-label">Step '.($KRelate+1).'</label>';
												echo '<div class="col-lg-8">';
													echo '<div class="viewtextinput">'.$_Detail.'</div>';
												echo '</div>';
											echo '</div>';
										}
									}
									?>

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
