<?php
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_VDO_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_VDO_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_VDO_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_VDO_.'_ID AS ID';
$arrf[] = "a."._TABLE_VDO_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_VDO_.'_DealerCode AS DealerCode';
$arrf[] = "a."._TABLE_VDO_.'_GID AS GID';
$arrf[] = "a."._TABLE_VDO_.'_SGID AS SGID';
$arrf[] = "a."._TABLE_VDO_.'_Status AS status';
$arrf[] = "a."._TABLE_VDO_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_VDO_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_VDO_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_VDO_.'_Picture AS Picture';
$arrf[] = "a."._TABLE_VDO_.'_PictureHome AS PictureHome';
$arrf[] = "a."._TABLE_VDO_.'_PictureAlt AS PictureAlt';
$arrf[] = "a."._TABLE_VDO_.'_BookingStart AS BookingStart';
$arrf[] = "a."._TABLE_VDO_.'_BookingEnd AS BookingEnd';
$arrf[] = "a."._TABLE_VDO_.'_FlagComment AS FlagComment';

foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_VdoType AS VdoType".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_VdoE AS VdoE".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_VdoL AS VdoL".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_VdoF AS VdoF".$lkey;
	$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_VDO_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_VDO_DETAIL_." ".$lkey." ON (a."._TABLE_VDO_."_ID = ".$lkey."."._TABLE_VDO_DETAIL_."_ContentID AND ".$lkey."."._TABLE_VDO_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_VDO_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GID = $Row["GID"];
$SGID = $Row["SGID"];
$selectDealer = $Row["DealerCode"];
$startDate = ($Row['StartDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['StartDate'],'English'));
$endDate = ($Row['ExpireDate']=='0000-00-00'?'N/A':convertdatefromdb($Row['ExpireDate'],'English'));

$Picture = $PathUploadPicture.$Row["Picture"];
if(is_file($Picture)){
	$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
	$myImagesFull = $showPicture;
	$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
}else{
	$showPicture = "";
	$myImagesFull = "";
}
$flagComment = $Row['FlagComment'];
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
							<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDateTime"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-md-10">
								<p class="form-control-static text-muted"><?php echo $startDate?> - <?php echo $endDate?></p>
							</div>
						</div>

				<div class="section-divider mb40" id="spy2">
				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<!-- .section-divider -->
				<?php if(count($dataArrGroup)>0){?>
					<div class="form-group">
						<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroup"][$_SESSION['Session_Admin_Language']]?></label>
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
				<?php if($SGID>0){?>
				<div class="row">
				    <div class="col-md-6">
				      <div class="section">
				      <?php
							echo '<label class="field prepend-icon">';
								echo '<div class="viewtextinput">'.$defaultdata[$Login_MenuID]["subgroup"][$GID][$SGID].'</div>';
								echo '<label for="inputSubject" class="field-icon">';
									echo '<i class="fa fa-cogs"></i>';
								echo '</label>';
							echo '</label>';
				      ?>
				      </div>
				    </div>
				    <div class="col-md-6"></div>
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
				<input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $Row['SubjectID'.$lkey]; ?>" />
				<?php
				$VDOType = $Row['VdoType'.$lkey];
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
						<p class="form-control-static text-muted"><?php echo $Row['Title'.$lkey]; ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputVDOType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<p class="form-control-static text-muted">
							<?php
							if($VDOType=='E'){
								echo $Array_Mod_Lang["txtinput:VDOTypeE"][$_SESSION['Session_Admin_Language']];
							}else if($VDOType=='E'){
								echo $Array_Mod_Lang["txtinput:VDOTypeL"][$_SESSION['Session_Admin_Language']];
							}else{
								echo $Array_Mod_Lang["txtinput:VDOTypeF"][$_SESSION['Session_Admin_Language']];
							}
							?>
						</p>
					</div>
				</div>

						<div class="form-group">
							<label class="col-md-2 control-label"></label>
							<div class="col-md-10">
								<div class="section">
									<label class="field prepend-icon">
										<div class="viewtextinput"><?php echo ($VDOType=='E'?$Row['VdoE'.$lkey]:$Row['VdoL'.$lkey]); ?></div>
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputVDOPreview"][$_SESSION['Session_Admin_Language']]?></label>
							<div class="col-md-10">
								<div class="section">
	<?php
	if($VDOType=="E"){
		$Embed = $Row['VdoE'.$lkey];
		echo setObjectWH(htmlspecialchars_decode($Embed),$defaultdata[$Login_MenuID]["img"]["W"],$defaultdata[$Login_MenuID]["img"]["H"]);
	}else if($VDOType=="L"){
		$Url = $Row['VdoL'.$lkey];
		$typeurl = videoType($Url);
		if($typeurl=='youtube'){
			echo setObjectWH(checkBBCodeVDO(rechangeQuot($Url)),$defaultdata[$Login_MenuID]["img"]["W"],$defaultdata[$Login_MenuID]["img"]["H"]);
		}else{
			$arrFileType = explode(".",$Url);
			$FileType = strtolower($arrFileType[count($arrFileType)-1]);
			echo '<script src="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/mediaelement-and-player.min.js"></script>';
			echo '<link rel="stylesheet" href="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/mediaelementplayer.min.css" />';
			echo '<video width="'.$defaultdata[$Login_MenuID]["img"]["W"].'" height="'.$defaultdata[$Login_MenuID]["img"]["H"].'" id="mediaplayer_'.$lkey.$ID.'" poster="'.$myImagesFull.'" controls="controls" preload="none">';
				echo '<source type="video/'.$FileType.'" src="'.$Url.'" />';
				echo '<object width="'.$defaultdata[$Login_MenuID]["img"]["W"].'" height="'.$defaultdata[$Login_MenuID]["img"]["H"].'" type="application/x-shockwave-flash" data="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/flashmediaelement.swf">';
					echo '<param name="movie" value="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/flashmediaelement.swf" />';
					echo '<param name="flashvars" value="controls=true&amp;file='.$Url.'" />';
					echo '<img src="'.$myImagesFull.'" width="'.$defaultdata[$Login_MenuID]["img"]["W"].'" height="'.$defaultdata[$Login_MenuID]["img"]["H"].'" alt="Here we are" title="No video playback capabilities" />';
				echo '</object>';
			echo '</video>';
			//echo '<span id="mediaplayer_'.$RowV["VID"].'-mode"></span>';
			echo '<script>';
				echo '$(\'audio,video\').mediaelementplayer({';
					//mode: 'shim',
					echo 'success: function(player, node) {';
						echo '$(\'#\' + node.id + \'-mode\').html(\'mode: \' + player.pluginType);';
					echo '}';
				echo '});';
			echo '</script>';
		}
	}else{
		$Url = $PathUploadFile.$Row['VdoF'.$lkey];
		$arrFileType = explode(".",$Url);
		$FileType = strtolower($arrFileType[count($arrFileType)-1]);
		echo '<script src="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/mediaelement-and-player.min.js"></script>';
		echo '<link rel="stylesheet" href="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/mediaelementplayer.min.css" />';
		echo '<video width="'.$defaultdata[$Login_MenuID]["img"]["W"].'" height="'.$defaultdata[$Login_MenuID]["img"]["H"].'" id="mediaplayer_'.$lkey.$ID.'" poster="'.$myImagesFull.'" controls="controls" preload="none">';
			echo '<source type="video/'.$FileType.'" src="'.$Url.'" />';
			echo '<object width="'.$defaultdata[$Login_MenuID]["img"]["W"].'" height="'.$defaultdata[$Login_MenuID]["img"]["H"].'" type="application/x-shockwave-flash" data="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/flashmediaelement.swf">';
				echo '<param name="movie" value="'._HTTP_PATH_.'/'._MAIN_FOLDER_SYSTEM_.'/vendor/plugins/media-element/build/flashmediaelement.swf" />';
				echo '<param name="flashvars" value="controls=true&amp;file='.$Url.'" />';
				echo '<img src="'.$myImagesFull.'" width="'.$defaultdata[$Login_MenuID]["img"]["W"].'" height="'.$defaultdata[$Login_MenuID]["img"]["H"].'" alt="Here we are" title="No video playback capabilities" />';
			echo '</object>';
		echo '</video>';
		//echo '<span id="mediaplayer_'.$RowV["VID"].'-mode"></span>';
		echo '<script>';
			echo '$(\'audio,video\').mediaelementplayer({';
				//mode: 'shim',
				echo 'success: function(player, node) {';
					echo '$(\'#\' + node.id + \'-mode\').html(\'mode: \' + player.pluginType);';
				echo '}';
			echo '});';
		echo '</script>';
	}
	?>
								</div>
							</div>
						</div>

				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>
				<?php $countlang = count($systemLang);?>
				<div class="section-divider mb40" id="spy3">
				  <span><?php echo $Array_Mod_Lang["txt:Head 03"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<div class="panel">
					<div class="panel-body">
						<div class="form-group">
			        <label for="inputStandard" class="col-lg-2 control-label">Thumbnail Home</label>
			        <div class="col-lg-10">
			          <div class="bs-component">
									<div class="showoption" id="showoption">
										<?php
										$PictureFileHome = $PathUploadPicture.$Row["PictureHome"];
										if(is_file($PictureFileHome)){
											echo '<div><img src="'.$PictureFileHome.'" alt="" /></div>';
										}
										?>
									</div>
			          </div>
			        </div>
			      </div>
					</div>
				</div>
				<div class="panel">
					<div class="panel-body">
						<div class="form-group">
			        <label for="inputStandard" class="col-lg-2 control-label">Thumbnail</label>
			        <div class="col-lg-10">
			          <div class="bs-component">
									<div class="showoption" id="showoption">
										<?php echo $showPicture?>
									</div>
			          </div>
			        </div>
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
