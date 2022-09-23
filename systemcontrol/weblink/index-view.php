<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_CONTENT_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_WEBLINK_.'_ID AS ID';
$arrf[] = "a."._TABLE_WEBLINK_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_WEBLINK_.'_Status AS status';
$arrf[] = "a."._TABLE_WEBLINK_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_WEBLINK_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_WEBLINK_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_WEBLINK_.'_GroupBanner AS GroupBanner';

foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_URL AS URL".$lkey;
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_Target AS Target".$lkey;
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_PictureFile AS PictureFile".$lkey;
	$arrf[] = $lkey."."._TABLE_WEBLINK_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_WEBLINK_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_WEBLINK_DETAIL_." ".$lkey." ON (a."._TABLE_WEBLINK_."_ID = ".$lkey."."._TABLE_WEBLINK_DETAIL_."_ContentID AND ".$lkey."."._TABLE_WEBLINK_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_WEBLINK_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$selectGroup = $Row["GroupBanner"];
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$query = "Key='".$selectGroup."'";
$mydata = @ArraySearch($DataGroup,$query,1);
$W = $DataGroup[array_key_first($mydata)]["W"];
$H = $DataGroup[array_key_first($mydata)]["H"];
$selectGroupName = $DataGroup[array_key_first($mydata)]["Name"];

$startDate = ($Row['StartDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['ExpireDate'],'English'));
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
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
            <div class="section-divider mb40" id="spy1">
                <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
            </div>
						<div class="form-group">
							<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDesDate"][$_SESSION['Session_Admin_Language']]?></label>
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
							<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:selectGroup"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-lg-6">
								<div class="bs-component">
									<p class="form-control-static text-muted"><?php echo $selectGroupName?></p>
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
										<?php $tabactive = ($lkey==$systemdefaultTab?'active':'');?>
		                <div id="<?php echo 'tab'.$lkey?>" class="tab-pane <?php echo $tabactive?>">
											<div class="boxlang">
								        <input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $Row['SubjectID'.$lkey]; ?>" />
												<?php
												if($countlang>1){
													echo '<div class="row section">';
		            						echo '<div class="col-md-12">';
		                          echo '<div class="checkbox-custom mb5">';
		                            echo '<input disabled name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" type="checkbox" title="'.$lkey.'" class="text checkLang" '.($Row['Status'.$lkey]=='Off'?'checked="checked"':'').' value="Off" />';
		                            echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
		                          echo '</div>';
		            						echo '</div>';
		            					echo '</div>';
												}
												?>
												<div class="form-group">
													<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
													<div class="col-lg-10">
														<div class="bs-component">
		                          <?php
															echo '<p class="form-control-static text-muted">'.$Row['Subject'.$lkey].'</p>';
		                          ?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?></label>
													<div class="col-lg-10">
														<div class="bs-component">
															<?php
															echo '<p class="form-control-static text-muted">'.echoDetailToediter($Row['Title'.$lkey]).'</p>';
		                          ?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']]?></label>
													<div class="col-lg-10">
														<div class="bs-component">
															<?php
															echo '<p class="form-control-static text-muted">'.$Row['URL'.$lkey].'</p>';
		                          ?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:selectTarget"][$_SESSION['Session_Admin_Language']]?></label>
													<div class="col-lg-10">
														<div class="bs-component">
															<?php
															echo '<p class="form-control-static text-muted">'.$Row['Target'.$lkey].'</p>';
		                          ?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPicture"][$_SESSION['Session_Admin_Language']]?></label>
													<div class="col-lg-10">
														<div class="section">
															<div id="progress<?php echo $lkey?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
															<div id="output<?php echo $lkey?>"><!-- error or success results --></div>
															<div class="showoption" id="showoption<?php echo $lkey?>">
																<?php
																$PictureFile = $PathUploadPicture."crop-".$Row["PictureFile".$lkey];
																if(is_file($PictureFile)){
																	echo '<div><img src="'.$PictureFile.'" alt="" /></div>';
																}
																?>
															</div>
														</div>
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
