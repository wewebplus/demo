<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$GID = 0;
$PartnerID = 0;
$showPicture = "";
$startDate = "";
$endDate = "";
$StatusHome = 'No';
$ListStatus = 'On';
$ListRating = 'No';
$ListComment = 'No';
$ListRelate = 'No';
$ListPin = 'No';
$ListStatusContentPassword = 'No';
$ContentPassword = '';
$ContentPublic = 'Yes';
$PreparationTime = '15';
$Difficulty = 'Easy';
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
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDesDate"][$_SESSION['Session_Admin_Language']]?></label>
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
        <?php if(count($defaultdata[$Login_MenuID]["group"])>0){?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<?php
						echo '<label class="field select">';
							echo '<select name="selectGroup" data-rule-required="true" data-msg-required="Select Group">';
							echo '<option value=""> - - Select Group - - </option>';
							foreach($defaultdata[$Login_MenuID]["group"] as $gk=>$gv){
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
        						  echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
        						echo '</div>';
          				}
          				?>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="section">
                              <label class="field prepend-icon">
                                  <input type="text" name="<?php echo "inputSubject".$lkey?>" class="gui-input" value="" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
                                  <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
                              </label>
                          </div>
                      </div>
                  </div>
                  <!-- Text Areas -->
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
                  <?php
                  $html = "";
                  echo '<div class="row section">';
                    echo '<div class="col-md-12">';
                      echo '<h4>'.$Array_Mod_Lang["txtinput:inputDetail"][$_SESSION['Session_Admin_Language']].'</h4>';
                    echo '</div>';
                  echo '</div>';
                  echo '<div class="row">';
                    echo '<div class="col-md-12">';
                    echo '<div class="section">';
                      echo '<textarea id="inputDetail'.$lkey.'" name="inputDetail'.$lkey.'" rows="12">'.$html.'</textarea>';
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
                      <div class="bs-component">
                        <?php
                        echo '<input type="text" name="inputFitPeople'.$lkey.'" class="form-control" value="" required data-msg-required="'.$Array_Mod_Lang["txt:FitPeople"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txt:FitPeople"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
                        ?>
                      </div>
					  <div class="showrecommend"><span><?php echo "Example: 1, 2, 3, 4 (Number)"?></span></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:PreparationTime"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-4">
                      <div class="bs-component">
                        <?php
                        echo '<select name="selectPreparationTime'.$lkey.'" class="form-control">';
						foreach($defaultdata[$Login_MenuID]["preparation_time"] as $gk=>$gv){
                          echo '<option value="'.$gk.'" '.($PreparationTime==$gk?'selected="selected"':'').'>'.$gv.'</option>';
						}
                        echo '</select>';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Difficulty"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-10 mt10">
                      <?php
                      foreach($defaultdata[$Login_MenuID]["difficulty"] as $gk=>$gv){
                        echo '<div class="col-md-3">';
                          echo '<div class="radio-custom radio-primary mb5">';
                            echo '<input type="radio"  name="inputDifficulty'.$lkey.'" id="inputDifficulty'.$lkey.$gk.'" value="'.$gk.'" '.($Difficulty==$gk?'checked="checked"':'').'>';
                            echo '<label for="inputDifficulty'.$lkey.$gk.'">'.$gv.'</label>';
                          echo '</div>';
                        echo '</div>';
                      }
                      ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:YoutubeKey"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<input type="text" name="inputYoutubeKey'.$lkey.'" class="form-control" value="" required data-msg-required="'.$Array_Mod_Lang["txt:YoutubeKey"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txt:YoutubeKey"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
                        ?>
                      </div>
					  <div class="showrecommend"><span><?php echo "(Youtube Key only) get key after 'v=...' , Example: input a 'oYOBM0aaxlI' only, from https://www.youtube.com/watch?v=oYOBM0aaxlI"?></span></div>
                    </div>
                  </div>

                  <div class="row section">
    								<div class="col-md-12">
    								<h4><?php echo $Array_Mod_Lang["txt:Head Cooking process"][$_SESSION['Session_Admin_Language']]; ?></h4>
    								</div>
    							</div>
    							<?php
    							echo '<div id="boxRecipe'.$lkey.'" class="listarea">';
                    echo '<div id="boxRecipe'.$lkey.'Master" class="listitem">';
                      echo '<input type="hidden" name="inputRecipeDataID'.$lkey.'[]" value="0" />';
                      echo '<div class="form-group">';
                        echo '<label class="col-lg-2 control-label">Step 1</label>';
                        echo '<div class="col-lg-8">';
                          echo '<textarea name="inputRecipeItem'.$lkey.'[]" class="gui-textarea" rows="3"></textarea>';
                        echo '</div>';
                        echo '<div class="col-lg-2"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveRecipe(this)">+ Remove</button></div>';
                      echo '</div>';
                    echo '</div>';
    							echo '</div>';
    							echo '<div>';
    								echo '<input type="hidden" name="inputRecipeName'.$lkey.'" value="boxRecipe'.$lkey.'" />';
    								echo '<button type="button" class="btn btn-primary btn-block" onclick="clickThisAddRecipe(this)">+ Add '.$Array_Mod_Lang["txt:Head Cooking process"][$_SESSION['Session_Admin_Language']].'</button>';
    							echo '</div>';
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
        <div class="panel">
					<div class="panel-body">
						<div class="form-group">
			        <label for="inputStandard" class="col-lg-3 control-label">Thumbnail Top</label>
			        <div class="col-lg-8">
			          <div class="bs-component">
									<?php
									$lkeyindex = "Home";
									?>
									<div id="progress<?php echo $lkeyindex?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
									<div id="output<?php echo $lkeyindex?>"><!-- error or success results --></div>
									<div class="showoption" id="showoption<?php echo $lkeyindex?>"></div>
									<div class="postuploadicon">
										<label for="fileToUpload<?php echo $lkeyindex?>" class="labeluploadfile">
											<img src="./images/uploadnow.jpg" />
										</label> <span><?php echo "min size ".$defaultdata[$Login_MenuID]["imghome"]["W"]." * ".$defaultdata[$Login_MenuID]["imghome"]["H"]." px."?></span>
										<input name="fileToUpload<?php echo $lkeyindex?>" class="uploadFile" type="file" id="fileToUpload<?php echo $lkeyindex?>" accept="image/png,image/jpeg" onChange="return ajaxuFileUploadProgressImg(this);" />
									</div>

			          </div>
			        </div>
			      </div>
					</div>
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
				<!-- end .form-body section -->
				<div class="panel-footer text-right mt10">
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
