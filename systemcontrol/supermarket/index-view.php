<?php
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$DataArrDay = $defaultdata[$Login_MenuID]["day"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_CONTENT_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

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
if($Province>0){
	$query = "id='".$Province."'";
	$mydata = @ArraySearch($ProvinceInfo->data,$query,1);
	$Provincename = @$ProvinceInfo->data[array_key_first($mydata)]["name"];
}
$CityInfo = getListCity($Province,$Country,$_SESSION['Session_Admin_Language']);
if($City>0){
	$query = "DistrictID='".$City."'";
	$mydata = @ArraySearch($CityInfo->data,$query,1);
	$Cityname = @$CityInfo->data[array_key_first($mydata)]["Name"];
}

$TimeZoneText = "";
$TimeZone = $Row["Timezone"];
$ListTimeZoneInfo = ListTimeZone();
if($TimeZone>0){
	$query = "ID='".$TimeZone."'";
	$mydata = @ArraySearch($ListTimeZoneInfo->data,$query,1);
	$TimeZoneText = @$ListTimeZoneInfo->data[array_key_first($mydata)]["Name"];
}
// $ProvinceID = explode(",",$Row["StateID"]);
// echo '<pre>';
// print_r($CityInfo);
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
										<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-10 frmalert">
											<p class="form-control-static text-muted"><?php echo $Row['Subject'.$lkey]; ?></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?></label>
										<div class="col-md-10 frmalert">
											<p class="form-control-static text-muted"><?php echo echoDetailToediter($Row['Title'.$lkey]); ?></p>
										</div>
									</div>
					        		<!-- Text Areas -->
											<?php
							        $html = "";
											$html = $PathUploadHtml.$Row['HTMLFileName'.$lkey];
											if(is_file($html)){
												$html = file_get_contents($html);
												$html = str_replace("/upload/",_HTTP_PATH_UPLOAD_."/",$html);
											}else{
												$html = echoDetailToediter($Row['HTMLDetail'.$lkey]);
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
									</div>
								</div>
			        <?php }?>
						</div>
					</div>
				</div>
				<div class="section-divider mb40" id="spy3">
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
									  echo '<input disabled="disabled" type="checkbox" '.($GroupCheck?'checked="checked"':'').' id="checkboxGroup'.$gk.'" name="checkboxGroup[]" value="'.$gv["ID"].'">';
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
						<p class="form-control-static text-muted"><?php echo $CountryName?></p>
					</div>
				</div>
				<div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
							<p class="form-control-static text-muted"><?php echo $Provincename?></p>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDistrict"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-6">
            <div class="frmalert bs-component">
							<p class="form-control-static text-muted"><?php echo $Cityname?></p>
            </div>
          </div>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputAddress"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10">
						<p class="form-control-static text-muted"><?php echo echoDetailToediter($Row['Address'])?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<p class="form-control-static text-muted"><?php echo $Row['Email']?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<p class="form-control-static text-muted"><?php echo $Row['Phone']?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputShare_website"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<p class="form-control-static text-muted"><?php echo $Row['Share_website']?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputWebsite"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<p class="form-control-static text-muted"><?php echo $Row['Website']?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTimeZone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<p class="form-control-static text-muted"><?php echo $TimeZoneText?></p>
					</div>
				</div>
				<div class="section-divider mt40" id="spy4">
				  <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
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
				<div class="section-divider mt40" id="spy5">
				  <span><?php echo $Array_Mod_Lang["txt:Head 05"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php
				// echo count($arrayTime);
				if(count($arrayTime)>0){
					foreach($DataArrDay as $kkd=>$vvd){
						$DayID = $vvd["ID"];
						echo '<div class="row">';
							echo '<label class="col-md-2 control-label">'.$vvd["Name"].'</label>';
							echo '<div id="boxDay_'.$kkd.'" class="col-md-10 listarea">';
								foreach($arrayTime[$DayID] as $KRelate=>$DataTime){
									$Time_Open = ($DataTime["Time_Open"]!='00:00'?$DataTime["Time_Open"]:'-');
									$Time_Close = ($DataTime["Time_Close"]!='00:00'?$DataTime["Time_Close"]:'-');
									$_DivID = ($KRelate>0?'Clone_boxDay_'.$kkd.'_'.($KRelate-1):'boxDay_'.$kkd.'_Master');
									echo '<div class="row">';
										echo '<div class="col-md-3">';
											echo '<p class="form-control-static text-muted">'.$Time_Open.'</p>';
										echo '</div>';
										echo '<div class="col-md-3">';
											echo '<p class="form-control-static text-muted">'.$Time_Close.'</p>';
										echo '</div>';
									echo '</div>';
								}
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
