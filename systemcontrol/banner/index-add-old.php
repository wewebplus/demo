<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$GID = 0;
$showPicture = "";
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
			  <form method="post" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<div class="section-divider mb40" id="spy1">
				  <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<!-- .section-divider -->
        <div class="section">
<?php
$P = array();
$P["table"] = _TABLE_PRIVILEGE_GROUP_;
$P["lang"] = $systemLang;
$P["selectid"] = $GID;
$P["modkey"] = "Admin5";
$P["modtextselect"] = array('Thai'=>"Select Group ...",'English'=>"Select Group ...");
$arrgroup = getGroup($P);
?>
					<label class="field select">
							<?php
							echo '<select name="selectGroup">';
							if($arrgroup->num>0){
								foreach($arrgroup->data as $vall){
									echo '<option value="'.$vall["id"].'" '.($vall["selected"]?'selected="selected"':'').'>'.$vall["Subject".$_SESSION['Session_Admin_Language']].'</option>';
								}
							}
							echo '</select>';
							?>
						<i class="arrow double"></i>
					</label>
				</div>
        <?php
        $countlang = count($systemLang);
        foreach($systemLang as $lkey=>$lval){
        ?>
        <?php
        if($countlang>1){
          echo '<div class="row">';
            echo '<div class="col-md-12">';
              echo '<div class="section">';
                echo '<label><input name="inputIgnore'.$lkey.'" type="checkbox" title="'.$lkey.'" class="text checkLang" value="Off" /> ไม่ใช้งาน '.$lval.' Language</label>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
        }
        ?>
        <div class="row">
          <div class="col-md-12">
  					<div class="section">
  					  <label class="field prepend-icon">
    						<input type="text" name="<?php echo "inputSubject".$lkey?>" class="gui-input" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" data-rule-required="true" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
    						<label for="firstname" class="field-icon">
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
  						<textarea class="gui-textarea" name="<?php echo "inputTitle".$lkey?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>"></textarea>
  						<label for="comment" class="field-icon">
  						  <i class="fa fa-comments"></i>
  						</label>
					  </label>
					</div>
				  </div>
				</div>
      <?php }?>
        <div class="section-divider mb40" id="spy2">
				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
        <?php
        foreach($systemLang as $lkey=>$lval){
          if($countlang>1){
            echo '<div class="row">';
              echo '<div class="col-md-12">';
                echo '<div class="section">';
                  echo $lval.' Language';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          }
          echo '<div class="row">';
            echo '<div class="col-md-12">';
            echo '<div class="section">';
              echo '<textarea id="inputDetail'.$lkey.'" name="inputDetail'.$lkey.'" rows="12"></textarea>';
            echo '</div>';
            echo '</div>';
          echo '</div>';
        }
        ?>
        <div class="section-divider mb40" id="spy3">
				  <span><?php echo $Array_Mod_Lang["txt:Head 03"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="row">
          <div class="col-md-6">
						<div class="section">
							<label for="datepickerFrom" class="field prepend-icon">
								<input type="text" id="datepickerFrom" name="datepickerFrom" readonly="readonly" class="gui-input" value="" placeholder="Datepicker From">
								<label class="field-icon">
									<i class="fa fa-calendar-o"></i>
								</label>
							</label>
						</div>
				  </div>
          <div class="col-md-6">
						<div class="section">
							<label for="datepickerTo" class="field prepend-icon">
								<input type="text" id="datepickerTo" name="datepickerTo" readonly="readonly" class="gui-input" value="" placeholder="Datepicker To">
								<label class="field-icon">
									<i class="fa fa-calendar-o"></i>
								</label>
							</label>
						</div>
				  </div>
				</div>

        <div class="section-divider mb40" id="spy4">
				  <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="panel mt20">
					<div class="panel-body pn">
						<div class="row table-layout table-clear-xs">
							<div class="col-xs-8">
								<div class="img-container pv10">
									<img src="../assets/img/stock/privilege.jpg">
								</div>
							</div>
							<div class="col-xs-4 bg-light br-l br-grey va-t pv10">
								<div class="clearfix">
									<div class="img-preview preview-inpw"><img src="../assets/img/stock/privilege.jpg"></div>
                  &nbsp;
                  <div class="boxcroppreview" id="boxcroppreview"><?php echo $showPicture?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="docs-buttons">
							<div class="btn-group">
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

							<div class="btn-group">
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

						</div>
					</div>
				</div>

				<!-- end .form-body section -->
				<div class="panel-footer text-right">
				  <button type="submit" class="button btn-primary">Proceed to confirm</button>
          <button type="button" id="ListBtn" class="button btn-default"><?php echo "List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
