<?php
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ADS_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ADS_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_ADS_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_ADS_.'_ID AS ID';
$arrf[] = "a."._TABLE_ADS_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_ADS_.'_Status AS status';
$arrf[] = "a."._TABLE_ADS_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_ADS_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_ADS_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_ADS_.'_Position AS ListPosition';
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_URL AS URL".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_Target AS Target".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_DocumentType AS DocumentType".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_HtmlCode AS HtmlCode".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_File AS File".$lkey;
	$arrf[] = $lkey."."._TABLE_ADS_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADS_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_ADS_DETAIL_." ".$lkey." ON (a."._TABLE_ADS_."_ID = ".$lkey."."._TABLE_ADS_DETAIL_."_ContentID AND ".$lkey."."._TABLE_ADS_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_ADS_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$ListPosition = $Row["ListPosition"];
$startDate = ($Row['StartDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['ExpireDate'],'English'));
$ArrPosition = $defaultdata[$Login_MenuID]["Position"];
$ArrDimension = $defaultdata[$Login_MenuID]["Dimension"];
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
		          <label for="inputStandard" class="col-lg-2 control-label">วันที่แสดงผล</label>
		          <div class="col-md-3">
								<div class="bs-component">
									<p class="form-control-static text-muted"><?php echo $startDate?></p>
								</div>
		          </div>
		          <div class="col-md-3">
								<div class="bs-component">
									<p class="form-control-static text-muted"><?php echo $endDate?></p>
								</div>
		          </div>
		        </div>
				<div class="section-divider mb40" id="spy2">
				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-6">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $ArrPosition[$ListPosition]?></p>
						</div>
          </div>
        </div>
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
								$DocumentType = $Row['DocumentType'.$lkey];
								?>
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
								<div class="form-group">
									<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
									<div class="col-lg-10">
										<div class="bs-component">
											<p class="form-control-static text-muted"><?php echo $Row['Subject'.$lkey]; ?></p>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']]?></label>
									<div class="col-lg-10">
										<div class="bs-component">
											<p class="form-control-static text-muted"><?php echo $Row['URL'.$lkey]; ?></p>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:selectTarget"][$_SESSION['Session_Admin_Language']]?></label>
									<div class="col-lg-10">
										<div class="bs-component">
											<p class="form-control-static text-muted"><?php echo $Row['Target'.$lkey]; ?></p>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></label>
									<div class="col-md-10 mt10">
										<?php
										foreach($defaultdata[$Login_MenuID]["Type"] as $gk=>$gv){
											echo '<div class="col-md-3">';
												echo '<div class="radio-custom radio-primary mb5">';
													echo '<input type="radio"  name="DocumentType'.$lkey.'" id="DocumentType'.$lkey.$gk.'" disabled class="checkradiov" value="'.$gk.'" '.($DocumentType==$gk?'checked="checked"':'').'>';
													echo '<label for="DocumentType'.$lkey.$gk.'">'.$gv.'</label>';
												echo '</div>';
											echo '</div>';
										}
										?>
									</div>
								</div>
										<div class="row">
											<label for="inputStandard" class="col-lg-2 control-label"></label>
											<div class="col-md-10">
												<div class="section">
													<div class="showoption" id="showoption<?php echo $lkey?>">
													<?php
													$PictureFile = $PathUploadPicture.$Row["File".$lkey];
													if(is_file($PictureFile)){
														echo '<div><img src="'.$PictureFile.'" alt="" /></div>';
													}
													?>
													</div>
												</div>
											</div>
										</div>
										<div class="row htmlads">
											<label for="inputStandard" class="col-lg-2 control-label"></label>
											<div class="col-md-10">
												<div class="section"><?php echo $Row["HtmlCode".$lkey]?></div>
											</div>
										</div>
								</div>
								</div>
			        <?php }?>
						</div>
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
