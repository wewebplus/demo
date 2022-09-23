<?php
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$DataArrDay = $defaultdata[$Login_MenuID]["day"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_SUPERMARKET_."_ID AS ID";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Key AS ModKey";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Status AS status";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Ignore AS allignore";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Picture AS Picture";
$arrf[] = "a."._TABLE_SUPERMARKET_."_PictureAlt AS PictureAlt";
$arrf[] = "a."._TABLE_SUPERMARKET_."_StatusHome AS StatusHome";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Status AS ListStatus";
$arrf[] = "a."._TABLE_SUPERMARKET_."_StatusRating AS ListRating";
$arrf[] = "a."._TABLE_SUPERMARKET_."_StatusComment AS ListComment";
$arrf[] = "a."._TABLE_SUPERMARKET_."_StatusRelate AS ListRelate";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Pin AS ListPin";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Public AS ContentPublic";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Country AS Country";
$arrf[] = "a."._TABLE_SUPERMARKET_."_CountryCode AS CountryCode";
$arrf[] = "a."._TABLE_SUPERMARKET_."_CountryName AS CountryName";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Province AS Province";
$arrf[] = "a."._TABLE_SUPERMARKET_."_City AS City";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Address AS Address";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Email AS Email";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Phone AS Phone";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Share_website AS Share_website";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Website AS Website";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Timezone AS Timezone";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Mapsearch AS _Mapsearch";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Lat AS _Lat";
$arrf[] = "a."._TABLE_SUPERMARKET_."_Lng AS _Lng";
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_HTMLFileName AS HTMLFileName".$lkey;
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_HTMLDetail AS HTMLDetail".$lkey;
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_Status AS Status".$lkey;
	$arrf[] = $lkey."."._TABLE_SUPERMARKET_DETAIL_."_By AS By".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_SUPERMARKET_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_SUPERMARKET_DETAIL_." ".$lkey." ON (a."._TABLE_SUPERMARKET_."_ID = ".$lkey."."._TABLE_SUPERMARKET_DETAIL_."_ContentID AND ".$lkey."."._TABLE_SUPERMARKET_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_SUPERMARKET_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$ModKey = $Row["ModKey"];
$Picture = $PathUploadPicture.$Row["Picture"];
if(is_file($Picture)){
	$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
	$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
}else{
	$showPicture = "";
}
$CountryCode = $Row["CountryCode"];
$CountryName = $Row["CountryName"];
$StatusHome = $Row["StatusHome"];
$ListStatus = $Row["ListStatus"];
$_Mapsearch = $Row["_Mapsearch"];
$_Lat = (!empty($Row["_Lat"])?$Row["_Lat"]:'13.6899991');
$_Lng = (!empty($Row["_Lng"])?$Row["_Lng"]:'100.7501124');
$Country = $Row["Country"];
$Province = (!empty($Row["Province"])?$Row["Province"]:0);
$Provincename = "";
$City = (!empty($Row["City"])?$Row["City"]:0);
$Cityname = "";
$CountryInfo = getListCountry($_SESSION['Session_Admin_Language']);
$ProvinceInfo = getListProvince($Country,$_SESSION['Session_Admin_Language']);
$CityInfo = getListCity($Province,$Country,$_SESSION['Session_Admin_Language']);

$TimeZoneText = "";
$TimeZone = $Row["Timezone"];
$ListTimeZoneInfo = ListTimeZone();
// $ProvinceID = explode(",",$Row["StateID"]);
// echo '<pre>';
// print_r($DataGroup);
// echo '</pre>';
$sql = "SELECT "._TABLE_SUPERMARKET_GROUP_."_GroupID AS GroupID FROM "._TABLE_SUPERMARKET_GROUP_." WHERE "._TABLE_SUPERMARKET_GROUP_."_ContentID = ".intval($ID);
$z->sql($sql);
$vGroup = $z->row();
// echo '<pre>';
// print_r($vGroup);
// echo '</pre>';
$arrayGroup = array_column($vGroup, 'GroupID');
// echo '<pre>';
// print_r($arrayGroup);
// echo '</pre>';

$sql = "SELECT "._TABLE_SUPERMARKET_WTIME_."_Open AS _Open,"._TABLE_SUPERMARKET_WTIME_."_Close AS _Close,"._TABLE_SUPERMARKET_WTIME_."_DayID AS _DayID,TBJoin.DayName FROM "._TABLE_SUPERMARKET_WTIME_;
$sql .= " LEFT JOIN (";
	$sql .= "SELECT "._TABLE_ADMIN_WDAY_."_ID AS DayID,"._TABLE_ADMIN_WDAY_."_Name AS DayName FROM "._TABLE_ADMIN_WDAY_;
$sql .= ") TBJoin ON ("._TABLE_SUPERMARKET_WTIME_."_DayID = TBJoin.DayID)";
$sql .= " WHERE "._TABLE_SUPERMARKET_WTIME_."_ContentID = ".intval($ID);
$sql .= " ORDER BY "._TABLE_SUPERMARKET_WTIME_."_DayID ASC,"._TABLE_SUPERMARKET_WTIME_."_Order ASC";
$z->sql($sql);
$RecordCountTime = $z->num();
$arrayTime = array();
if($RecordCountTime>0){
	$vTime = $z->row();
	foreach($vTime as $RowTime){
		$DayID = $RowTime["_DayID"];
		$DayName = $RowTime["DayName"];
		$Time_Open = substr($RowTime["_Open"],0,5);
		$Time_Close = substr($RowTime["_Close"],0,5);
		$arr = array();
		$arr["DayID"] = $DayID;
		$arr["DayName"] = $DayName;
		$arr["Time_Open"] = $Time_Open;
		$arr["Time_Close"] = $Time_Close;
		$arrayTime[$DayID][] = $arr;
		unset($arr);
	}
}
// echo '<pre>';
// print_r($arrayTime);
// echo '</pre>';

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
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<!-- .section-divider -->
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
										echo '<div class="checkbox-custom mb20">';
										  echo '<input type="checkbox" class="checkLang" name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" title="'.$lkey.'" value="Off" '.($Row['Status'.$lkey]=='Off'?'checked="checked"':'').'>';
										  echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
										echo '</div>';
									}
									?>
					        <div class="row">
					            <div class="col-md-12">
					                <div class="section">
					                    <label class="field prepend-icon">
					                        <input type="text" name="<?php echo "inputSubject".$lkey?>" data-rule-required="true" class="gui-input" value="<?php echo $Row['Subject'.$lkey]; ?>" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
					                        <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
					                    </label>
					                </div>
					            </div>
					        </div>
					        <div class="row">
					          <div class="col-md-12">
					            <div class="section">
					              <label class="field prepend-icon">
					                <textarea class="gui-textarea" name="<?php echo "inputTitle".$lkey?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>"><?php echo decodetxterea($Row['Title'.$lkey]); ?></textarea>
					                <label for="comment" class="field-icon">
					                  <i class="fa fa-comments"></i>
					                </label>
					              </label>
					            </div>
					          </div>
					        </div>
									<?php
					        $html = "";
									$html = $PathUploadHtml.$Row['HTMLFileName'.$lkey];
									if(is_file($html)){
										$html = file_get_contents($html);
									}else{
										$html = $Row['HTMLDetail'.$lkey];
									}
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
					        <!-- Text Areas -->
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
								if (in_array($gv["ID"], $arrayGroup)) {
								   $GroupCheck = true;
								}else{
									$GroupCheck = false;
								}
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
              if($ProvinceInfo->datacount>0){
                echo '<input type="hidden" name="inputProvince" class="gui-input" value="'.$Provincename.'">';
                echo '<select id="selectProvince" name="selectProvince" class="form-control select2_single" onchange="loadajaxdistrict($(this).val())">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputProvince"][$_SESSION['Session_Admin_Language']].' - - </option>';
                foreach($ProvinceInfo->data as $gk=>$gv){
									echo '<option value="'.$gv["id"].'" '.($Province==$gv["id"]?'selected="selected"':'').'>'.$gv["name"].'</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
              <?php
              if($CityInfo->datacount>0){
                echo '<input type="hidden" name="inputDistrict" class="gui-input" value="'.$Cityname.'">';
                echo '<select id="selectDistrict" name="selectDistrict" class="form-control select2_single">';
                echo '<option value=""> - - '.$Array_Mod_Lang["txtselect:inputDistrict"][$_SESSION['Session_Admin_Language']].' - - </option>';
                foreach($CityInfo->data as $gk=>$gv){
									echo '<option value="'.$gv["DistrictID"].'" '.($City==$gv["DistrictID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10">
            <textarea class="form-control" name="<?php echo "inputAddress"?>" rows="3" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?>"><?php echo decodetxterea($Row['Address']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="<?php echo $Row['Email']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="<?php echo $Row['Phone']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputShare_website"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputShare_website"?>" class="gui-input" value="<?php echo $Row['Share_website']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputShare_website"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputWebsite"?>" class="gui-input" value="<?php echo $Row['Website']; ?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?>">
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
				<div class="section-divider mt40" id="spy4">
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
								<!-- <button class="btn btn-primary btn-sm hidden" data-method="destroy" type="button" title="Destroy">
									<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;destroy&quot;)">
										<span class="fa fa-power-off"></span>
									</span>
								</button> -->
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
				// echo count($arrayTime);
				if(count($arrayTime)>0){
					foreach($DataArrDay as $kkd=>$vvd){
						$DayID = $vvd["ID"];
						// print_r($arrayTime[$DayID]);
						echo '<div class="row">';
							echo '<label class="col-md-2 control-label">'.$vvd["Name"].'</label>';
							echo '<div id="boxDay_'.$kkd.'" class="col-md-10 listarea">';
								foreach($arrayTime[$DayID] as $KRelate=>$DataTime){
									$Time_Open = ($DataTime["Time_Open"]!='00:00'?$DataTime["Time_Open"]:'');
									$Time_Close = ($DataTime["Time_Close"]!='00:00'?$DataTime["Time_Close"]:'');
									$_DivID = ($KRelate>0?'Clone_boxDay_'.$kkd.'_'.($KRelate-1):'boxDay_'.$kkd.'_Master');
									$_ClassID = ($KRelate>0?'form-group listitem item clone':'listitem form-group');
									echo '<div id="'.$_DivID.'" class="'.$_ClassID.'">';
										echo '<input type="hidden" name="inputTimeDataID_'.$DayID.'[]" value="0" />';
										echo '<div class="col-md-3">';
											echo '<input type="text" name="TIMEOPEN_'.$DayID.'[]" class="gui-input text-center time" value="'.$Time_Open.'" placeholder="00:00">';
										echo '</div>';
										echo '<div class="col-md-3">';
											echo '<input type="text" name="TIMECLOSE_'.$DayID.'[]" class="gui-input text-center time" value="'.$Time_Close.'" placeholder="00:00">';
										echo '</div>';
										echo '<div class="col-md-2"><button type="button" class="btn btn-default btn-block" onclick="clickThisReomveTime(this)">- Remove</button></div>';
										if($KRelate==0){
											echo '<div class="col-md-2">';
												echo '<input type="hidden" name="inputDayName_'.$DayID.'" value="boxDay_'.$kkd.'" />';
												echo '<button type="button" class="btn btn-primary btn-block" onclick="clickThisAddTime(this)">+ Add </button>';
											echo '</div>';
										}
									echo '</div>';
								}
							echo '</div>';
						echo '</div>';
					}
				}else{
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
