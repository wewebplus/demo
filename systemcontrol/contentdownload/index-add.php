<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$GID = 0;
$PartnerID = 0;
$showPicture = "";
$startDate = "";
$endDate = "";
$ListStatusContentPassword = 'No';
$ContentPassword = '';
$ContentPublic = 'Yes';
$DocumentDownloadType = "F";
$DataGroup = $defaultdata[$Login_MenuID]["group"];
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Addnew"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDateTime"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
							<div class="section">
									<label for="datepickerFrom" class="field prepend-icon">
											<input type="text" id="datepickerFrom" name="datepickerFrom" readonly="readonly" class="gui-input" value="<?php echo $startDate?>" placeholder="Datepicker From">
											<label class="field-icon"><i class="fa fa-calendar-o"></i></label>
									</label>
							</div>
					</div>
					<div class="col-md-3">
							<div class="section">
									<label for="datepickerTo" class="field prepend-icon">
											<input type="text" id="datepickerTo" name="datepickerTo" readonly="readonly" class="gui-input" value="<?php echo $endDate?>" placeholder="Datepicker To">
											<label class="field-icon"><i class="fa fa-calendar-o"></i></label>
									</label>
							</div>
					</div>
				</div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <?php if(count($DataGroup)>0){?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroup"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert">
						<?php
						echo '<label class="field select">';
							echo '<select name="selectGroup" data-rule-required="true" data-msg-required="Select Group">';
							echo '<option value=""> - - Select Group - - </option>';
							foreach($DataGroup as $gk=>$gv){
								echo '<option value="'.$gv["ID"].'">'.$gv["Name"].'</option>';
							}
							echo '</select>';
							echo '<i class="arrow"></i>';
						echo '</label>';
						?>
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
          <?php
          if($countlang>1){
            echo '<div class="checkbox-custom mb20">';
              echo '<input type="checkbox" class="checkLang" name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" title="'.$lkey.'" value="Off" '.($LangDisable[$lkey]?'checked':'').'>';
              echo '<label for="inputIgnore'.$lkey.'">??????????????????????????? '.$lval.' Language</label>';
            echo '</div>';
          }
          ?>
          <div class="row">
              <div class="col-md-12">
                  <div class="section">
                      <label class="field prepend-icon">
                          <input type="text" name="<?php echo "inputSubject".$lkey?>" class="gui-input" value="" data-rule-required="true" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
                          <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
                      </label>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="section">
                <label class="field prepend-icon">
                  <textarea class="gui-textarea" name="<?php echo "inputTitle".$lkey?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>"></textarea>
                  <label for="comment" class="field-icon">
                    <i class="fa fa-comments"></i>
                  </label>
                </label>
              </div>
            </div>
          </div>
          <div class="row section">
            <div class="col-md-3"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></div>
            <div class="col-md-9">
              <div class="col-md-5">
                <div class="radio-custom radio-primary mb5">
                  <input type="radio" name="<?php echo "DocumentDownloadType".$lkey?>" id="<?php echo "DocumentDownloadType".$lkey?>F" class="checkradiov" <?php echo ($DocumentDownloadType=='F'?'checked="checked"':'')?> value="F">
                  <label for="<?php echo "DocumentDownloadType".$lkey?>F"><?php echo $Array_Mod_Lang["txtinput:DocumentDownloadTypeF"][$_SESSION['Session_Admin_Language']]?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="radio-custom radio-primary mb5">
                  <input type="radio" name="<?php echo "DocumentDownloadType".$lkey?>" id="<?php echo "DocumentDownloadType".$lkey?>L" class="checkradiov" <?php echo ($DocumentDownloadType=='L'?'checked="checked"':'')?> value="L">
                  <label for="<?php echo "DocumentDownloadType".$lkey?>L"><?php echo $Array_Mod_Lang["txtinput:DocumentDownloadTypeL"][$_SESSION['Session_Admin_Language']]?></label>
                </div>
              </div>
            </div>
          </div>
          <div class="row embedvdo">
            <div class="col-md-12">
              <div class="section"><textarea class="gui-textarea" name="<?php echo "inputEmbed".$lkey?>"></textarea></div>
            </div>
          </div>
          <div class="row linkvdo">
            <div class="col-md-12">
              <div class="section"><input type="text" name="<?php echo "inputLink".$lkey?>" class="gui-input" value=""></div>
            </div>
          </div>
          <div class="row filevdo">
            <div class="col-md-12">
              <div class="section">
                <div class="boximg" id="loadingfile">
                    <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfile"?>" value="" />
                    <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfilename"?>" value="" />
                    <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowpathfile"?>" value="" />

                    <label class="field prepend-icon append-button file">
                      <span class="button">Choose File</span>
                      <input type="file" class="gui-file" name="<?php echo "ufileToUpload".$lkey?>" onChange="return ajaxuFileUploadProgress00(this);" accept="">
                      <input type="text" class="gui-input" id="<?php echo "ufileToUpload".$lkey."showfile"?>" placeholder="Please Select A File">
                      <label class="field-icon">
                        <i class="fa fa-upload"></i>
                      </label>
                    </label>
                </div>
                <div id="<?php echo "ufileToUpload".$lkey."progress-wrp"?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
                <div id="<?php echo "ufileToUpload".$lkey."popupoutput"?>"><!-- error or success results --></div>
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
				<div class="panel mt20">
					<div class="panel-footer">
						<div class="docs-buttons">
							<div class="btn-group btn-group-crop">
								<button class="btn btn-primary btn-sm" data-method="setDragMode" data-option="move" type="button" title="Move">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
										<span class="fa fa-arrows"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="setDragMode" data-option="crop" type="button" title="Crop">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
										<span class="fa fa-crop"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="zoom" data-option="0.1" type="button" title="Zoom In">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
										<span class="fa fa-search-plus"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
										<span class="fa fa-search-minus"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="rotate" data-option="-45" type="button" title="Rotate Left">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -45)">
										<span class="fa fa-rotate-left"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="rotate" data-option="45" type="button" title="Rotate Right">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 45)">
										<span class="fa fa-rotate-right"></span>
									</span>
								</button>
							</div>

							<div class="btn-group btn-group-crop">
								<button class="btn btn-primary btn-sm" data-method="disable" type="button" title="Disable">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;disable&quot;)">
										<span class="fa fa-lock"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="enable" type="button" title="Enable">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;enable&quot;)">
										<span class="fa fa-unlock"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="clear" type="button" title="Clear">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;clear&quot;)">
										<span class="fa fa-remove"></span>
									</span>
								</button>
								<button class="btn btn-primary btn-sm" data-method="reset" type="button" title="Reset">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">
										<span class="fa fa-refresh"></span>
									</span>
								</button>
								<label class="btn btn-primary btn-sm btn-upload" for="inputImage" title="Upload image file">
									<input class="sr-only" id="inputImage" name="file" type="file" accept="image/*">
									<span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
										<span class="fa fa-upload"></span>
									</span>
								</label>
								<button class="btn btn-primary btn-sm hidden" data-method="destroy" type="button" title="Destroy">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;destroy&quot;)">
										<span class="fa fa-power-off"></span>
									</span>
								</button>
							</div>

              <div class="btn-group btn-group-crop hidden">
                <label class="btn btn-primary btn-sm" data-method="setAspectRatio" data-option="1.7777777777777777" title="Set Aspect Ratio">
                  <input class="sr-only" id="aspestRatio1" name="aspestRatio" value="1.7777777777777777" type="radio">
                  <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 16 / 9)">
                    16:9
                  </span>
                </label>
                <label class="btn btn-primary btn-sm" data-method="setAspectRatio" data-option="1.3333333333333333" title="Set Aspect Ratio">
                  <input class="sr-only" id="aspestRatio2" name="aspestRatio" value="1.3333333333333333" type="radio">
                  <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 4 / 3)">
                    4:3
                  </span>
                </label>
                <label class="btn btn-primary btn-sm" data-method="setAspectRatio" data-option="1" title="Set Aspect Ratio">
                  <input class="sr-only" id="aspestRatio3" name="aspestRatio" value="1" type="radio">
                  <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 1 / 1)">
                    1:1
                  </span>
                </label>
                <label class="btn btn-primary btn-sm" data-method="setAspectRatio" data-option="NaN" title="Set Aspect Ratio">
                  <input class="sr-only" id="aspestRatio5" name="aspestRatio" value="NaN" type="radio">
                  <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, NaN)">
                    Free
                  </span>
                </label>
              </div>

							<div class="btn-group btn-group-crop">
								<button class="btn btn-primary btn-sm" data-method="getCroppedCanvas" type="button">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;)">Get Cropped</span>
								</button>
							</div>

							<input class="form-control mt5" id="putData" name="putData" type="hidden" placeholder="Get data to here or set data with this value">
							<input class="form-control mt5" id="putDataFile" name="putDataFile" type="hidden" readonly="readonly" />
              <input name="DataRatio" type="hidden" value="<?php echo $defaultdata[$Login_MenuID]["img"]["aspectRatio"];?>" />
              <input name="DataW" type="hidden" value="<?php echo $defaultdata[$Login_MenuID]["img"]["W"];?>" />
              <input name="DataH" type="hidden" value="<?php echo $defaultdata[$Login_MenuID]["img"]["H"];?>" />

						</div>
					</div>

					<div class="panel-body pn">
						<div class="row table-layout table-clear-xs">
							<div class="col-xs-8">
								<div class="img-container pv10">
									<img src="../assets/img/stock/privilege.jpg">
								</div>
							</div>
							<div class="col-xs-4 bg-light br-l br-grey va-t pv10">
								<div class="clearfix">
                <div class="img-preview preview-inpw hidden"><img src="../assets/img/stock/privilege.jpg"></div>
                <div class="boxcroppreview" id="boxcroppreview"><?php echo $showPicture?></div>
                <div class="boxcroptextsize">max size <?php echo $defaultdata[$Login_MenuID]["img"]["W"];?> * <?php echo $defaultdata[$Login_MenuID]["img"]["H"];?> px.</div>
								</div>
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
							<input type="checkbox" name="ListStatusContentPassword" id="ListStatusContentPassword" value="Yes" <?php echo ($ListStatusContentPassword=='Yes'?'checked="checked"':'')?> onclick="CheckRowInput(this)">
							<label for="ListStatusContentPassword" data-on="ON" data-off="OFF"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffPassword"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 frmalert">
						<input type="text" id="ContentPassword" name="ContentPassword" class="form-control" <?php echo ($ListStatusContentPassword=='Yes'?'required':'readonly')?> value="<?php echo $ContentPassword?>" placeholder="Type Here..."  data-msg-required="<?php echo $Array_Mod_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
            <label class="switch switch-primary block mt15">
							<input type="checkbox" name="StatusPublic" id="StatusPublic" value="Yes" <?php echo ($ContentPublic=='Yes'?'checked="checked"':'')?>>
							<label for="StatusPublic" data-on="YES" data-off="NO"></label>
							<span><?php echo $Array_Mod_Lang["txtinput:OnOffPublic"][$_SESSION['Session_Admin_Language']]?></span>
						</label>
					</div>
				</div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
