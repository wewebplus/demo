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
$ModKey = $Row["ModKey"];
$ListPosition = $Row["ListPosition"];
$startDate = ($Row['StartDate']=='0000-00-00'?'':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'':convertdatefromdb($Row['ExpireDate'],'English'));

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$DataCheckMemtype = "";
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
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
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-md-3">
              <div class="section">
                  <label for="datepickerFrom" class="field prepend-icon">
                      <input type="text" id="datepickerFrom" name="datepickerFrom" readonly="readonly" class="gui-input" value="<?php echo $startDate?>" placeholder="Datepicker From" data-msg-required="Datepicker From">
                      <label class="field-icon"><i class="fa fa-calendar-o"></i></label>
                  </label>
              </div>
          </div>
          <div class="col-md-3">
              <div class="section">
                  <label for="datepickerTo" class="field prepend-icon">
                      <input type="text" id="datepickerTo" name="datepickerTo" readonly="readonly" class="gui-input" value="<?php echo $endDate?>" placeholder="Datepicker To" data-msg-required="Datepicker To">
                      <label class="field-icon"><i class="fa fa-calendar-o"></i></label>
                  </label>
              </div>
          </div>
        </div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label">Select Position</label>
          <div class="col-md-6">
            <div class="section">
            <?php
            echo '<label class="field select">';
              echo '<select name="selectPosition" data-rule-required="true" data-msg-required="Select Position">';
              echo '<option value=""> - - Select Position - - </option>';
              foreach($defaultdata[$Login_MenuID]["Position"] as $gk=>$gv){
                echo '<option value="'.$gk.'" '.($ListPosition==$gk?'selected="selected"':'').'>'.$gv.'</option>';
              }
              echo '</select>';
              echo '<i class="arrow"></i>';
            echo '</label>';
            ?>
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
											echo '<div class="row section">';
            						echo '<div class="col-md-12">';
                          echo '<div class="checkbox-custom mb5">';
                            echo '<input name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" type="checkbox" title="'.$lkey.'" class="text checkLang" '.($Row['Status'.$lkey]=='Off'?'checked="checked"':'').' value="Off" />';
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
	                        echo '<input type="text" name="inputSubject'.$lkey.'" class="form-control" value="'.$Row['Subject'.$lkey].'" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
	                        ?>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="form-group">
	                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']]?></label>
	                    <div class="col-lg-10">
	                      <div class="bs-component">
	                        <?php
	                        echo '<input type="text" name="inputURL'.$lkey.'" class="form-control" value="'.$Row['URL'.$lkey].'" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
	                        ?>
	                      </div>
	                    </div>
	                  </div>
										<div class="form-group">
	                    <label for="inputStandard" class="col-lg-2 control-label">Select Target</label>
	                    <div class="col-lg-4">
	                      <div class="bs-component">
	                        <?php
	                        echo '<select name="selectTarget'.$lkey.'" class="form-control">';
	                          echo '<option value="_self" '.($Row['Target'.$lkey]=='_self'?'selected="selected"':'').'>_self</option>';
	                          echo '<option value="_blank" '.($Row['Target'.$lkey]=='_blank'?'selected="selected"':'').'>_blank</option>';
	                        echo '</select>';
	                        ?>
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
	                            echo '<input type="radio"  name="DocumentType'.$lkey.'" id="DocumentType'.$lkey.$gk.'" class="checkradiov" value="'.$gk.'" '.($DocumentType==$gk?'checked="checked"':'').'>';
	                            echo '<label for="DocumentType'.$lkey.$gk.'">'.$gv.'</label>';
	                          echo '</div>';
	                        echo '</div>';
	                      }
	                      ?>
	                    </div>
	                  </div>
										<div class="row fileads">
											<label for="inputStandard" class="col-lg-2 control-label"></label>
	                    <div class="col-md-10">
	                      <div class="section">
	                        <div class="boximg" id="loadingfile">
	                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfile"?>" value="" />
	                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfilename"?>" value="" />
	                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowpathfile"?>" value="" />

	                            <label class="field prepend-icon append-button file">
	                              <span class="button">Choose File</span>
	                              <input type="file" class="gui-file" name="<?php echo "ufileToUpload".$lkey?>" onChange="return ajaxuFileUploadProgress00(this);" accept="image/*">
	                              <input type="text" class="gui-input" id="<?php echo "ufileToUpload".$lkey."showfile"?>" placeholder="Please Select A File">
	                              <label class="field-icon">
	                                <i class="fa fa-upload"></i>
	                              </label>
	                            </label>

	                        </div>
	                        <div class="showrecommend"><span><?php echo "min size 1920 * 1080 px."?></span></div>
	                        <div id="<?php echo "ufileToUpload".$lkey."progress-wrp"?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
	                        <div class="showpreview" id="<?php echo "ufileToUpload".$lkey."popupoutput"?>"><!-- error or success results -->
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
	                      <div class="section"><textarea class="gui-textarea" name="<?php echo "inputEmbed".$lkey?>"><?php echo $Row["HtmlCode".$lkey]?></textarea></div>
	                    </div>
	                  </div>
										<!-- Text Areas -->
									</div>
								</div>
			        <?php }?>
						</div>
					</div>
				</div>
				<!-- end .form-body section -->
				<br />
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
