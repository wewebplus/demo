<?php
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$DataArrDay = $defaultdata[$Login_MenuID]["day"];
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
$Country = "";
$CountryInfo = getListCountry($_SESSION['Session_Admin_Language']);
$CountryName = "";
$ProvinceInfo = array();
$Provincename = "";
$CityInfo = array();
$Cityname = "";
$TimeZoneText = "";
$TimeZone = "";
$ListTimeZoneInfo = ListTimeZone();
$_Mapsearch = "";
$_Lat = '13.6899991';
$_Lng = '100.7501124';
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
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
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
                                  <input type="text" name="<?php echo "inputSubject".$lkey?>" class="gui-input" value="" data-rule-required="true" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
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
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
        <div class="section-divider mt40" id="spy3">
				  <span><?php echo $Array_Mod_Lang["txt:Head 03"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupTitle"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert">
						<?php
						if(count($DataGroup)>0){
							foreach($DataGroup as $gk=>$gv){
                $GroupCheck = false;
								echo '<div class="bs-component mb10">';
									echo '<div class="checkbox-custom checkbox-primary mb5">';
									  echo '<input type="checkbox" '.($GroupCheck?'checked="checked"':'').' id="checkboxGroup'.$gk.'" name="checkboxGroup[]" value="'.$gv["ID"].'">';
									  echo '<label for="checkboxGroup'.$gk.'">'.$gv["Name"].'</label>';
									echo '</div>';
								echo '</div>';
							}
						}
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6 frmalert bs-component">
						<?php
              echo '<input type="hidden" name="inputCountry" class="gui-input" value="'.$CountryName.'">';
							echo '<select name="selectCountry" class="form-control select2_single" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']].'" onchange="loadajaxstate(this)">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputCountry"][$_SESSION['Session_Admin_Language']].' - - </option>';
              if($CountryInfo->datacount>0){
                foreach($CountryInfo->data as $gk=>$gv){
  								echo '<option value="'.$gv["countryid"].'" '.($Country==$gv["countryid"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
  							}
              }
							echo '</select>';
						?>
					</div>
				</div>
				<div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
              <?php
                echo '<input type="hidden" name="inputProvince" class="gui-input" value="'.$Provincename.'">';
                echo '<select id="selectProvince" name="selectProvince" class="form-control select2_single" onchange="loadajaxdistrict($(this).val())">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputProvince"][$_SESSION['Session_Admin_Language']].' - - </option>';
                echo '</select>';
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
              <?php
                echo '<input type="hidden" name="inputDistrict" class="gui-input" value="'.$Cityname.'">';
                echo '<select id="selectDistrict" name="selectDistrict" class="form-control select2_single">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputDistrict"][$_SESSION['Session_Admin_Language']].' - - </option>';
                echo '</select>';
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10">
            <textarea class="form-control" name="<?php echo "inputAddress"?>" rows="3" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?>"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputShare_website"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputShare_website"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputShare_website"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputWebsite"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <?php
				if($ListTimeZoneInfo->num>0){
					echo '<div class="form-group">';
						echo '<label class="col-md-2 control-label">'.$Array_Mod_Lang["txtinput:inputTimeZone"][$_SESSION['Session_Admin_Language']].'</label>';
						echo '<div class="frmalert col-md-6">';
							echo '<input type="hidden" name="inputTimeZone" class="gui-input" value="'.$TimeZoneText.'">';
							echo '<select id="selectTimeZone" name="selectTimeZone" class="form-control select2_single">';
							echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputTimeZone"][$_SESSION['Session_Admin_Language']].' - - </option>';
							foreach($ListTimeZoneInfo->data as $gk=>$gv){
								echo '<option value="'.$gv["ID"].'" '.($TimeZone==$gv["ID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
							}
							echo '</select>';
						echo '</div>';
					echo '</div>';
				}
				?>
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
                <div class="img-preview preview-inpw hidden"><img src="../assets/img/stock/privilege.jpg"></div>
                <div class="boxcroppreview" id="boxcroppreview"><?php echo $showPicture?></div>
                <div class="boxcroptextsize">max size <?php echo $defaultdata[$Login_MenuID]["img"]["W"];?> * <?php echo $defaultdata[$Login_MenuID]["img"]["H"];?> px.</div>
								</div>
							</div>
						</div>
					</div>
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
                <!-- <button class="btn btn-primary btn-sm" data-method="disable" type="button" title="Disable">
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
                </button> -->
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
				</div>
        <div class="section-divider mt40" id="spy5">
				  <span><?php echo $Array_Mod_Lang["txt:Head 05"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
        <?php
        foreach($DataArrDay as $kkd=>$vvd){
          echo '<div class="row">';
            echo '<label class="col-md-2 control-label">'.$vvd["Name"].'</label>';
            echo '<div id="boxDay_'.$kkd.'" class="col-md-10 listarea">';
              echo '<div id="boxDay_'.$kkd.'_Master" class="listitem form-group">';
                echo '<input type="hidden" name="inputTimeDataID_'.$vvd["ID"].'[]" value="0" />';
                echo '<div class="col-md-3">';
                  echo '<input type="text" name="TIMEOPEN_'.$vvd["ID"].'[]" class="gui-input text-center time" value="" placeholder="00:00">';
                echo '</div>';
                echo '<div class="col-md-3">';
                  echo '<input type="text" name="TIMECLOSE_'.$vvd["ID"].'[]" class="gui-input text-center time" value="" placeholder="00:00">';
                echo '</div>';
                echo '<div class="col-md-2"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveTime(this)">- Remove</button></div>';
                echo '<div class="col-md-2">';
                  echo '<input type="hidden" name="inputDayName_'.$vvd["ID"].'" value="boxDay_'.$kkd.'" />';
                  echo '<button type="button" class="btn btn-primary btn-block" onclick="clickThisAddTime(this)">+ Add </button>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
        }
        ?>
        <div class="section-divider mt40" id="spy6">
				  <span><?php echo $Array_Mod_Lang["txt:Head 06"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
        <div class="form-group">
					<div class="col-sm-6">
							<label>Map <i class="red">*</i></label>
							<input id="pac-input" name="sup_search" class="form-control" type="text" value="<?php echo $_Mapsearch?>" placeholder="Search Box"	/>
					</div>
					<div class="col-sm-3">
						<label>latitude <i class="red">*</i></label>
						<input type="text" id="latitude" name="sup_lat" value="<?php echo $_Lat?>" class=" form-control">
					</div>
					<div class="col-sm-3">
						<label>longitude <i class="red">*</i></label>
						<input type="text" id="longitude" name="sup_lng" value="<?php echo $_Lng?>" class=" form-control">
					</div>
				</div>
				<div class="form-group">
					<div class="map-wrap">
						<div id="map"></div>
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
