<?php
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

$ID = 0;
$ModKey = "";
$MemberID = 0;
$InType = 0;

$sql = "";
$arrfuser = array();
$arrfuser[] = "a."._TABLE_MEMBER_."_ID AS MemberID";
$arrfuser[] = "a."._TABLE_MEMBER_."_Name AS FullName";
$arrfuser[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
$sql .= "SELECT  ".implode(',',$arrfuser)." FROM "._TABLE_MEMBER_." a";
$sql .= " WHERE a."._TABLE_MEMBER_."_MemberType = 'Company'";
$sql .= " ORDER BY "._TABLE_MEMBER_."_Name ASC";
unset($arrfuser);
$z->sql($sql);
$RecordCountUser = $z->num();
$arrayUser = array();
if($RecordCountUser>0){
	$vUser = $z->row();
	foreach($vUser as $RowUser){
		$UserID = $RowUser["MemberID"];
		$UserName = $RowUser["FullName"];
		$arr = array();
		$arr["UserID"] = $UserID;
		$arr["UserName"] = $UserName;
		$arrayUser[] = $arr;
	}
}
$SessionID = session_id();
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$saveDataImg = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=product&actiontype=update');
$saveDataFile_1 = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&SessionID='.$SessionID.'&myflag=renewal&actiontype=update');
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
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputMember"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<?php
						echo '<div class="field">';
						if(count($arrayUser)>0){
								echo '<select name="selectMember" class="form-control select2_single" data-rule-required="true" data-msg-required="Select Member">';
								echo '<option value=""> - - Select Member - - </option>';
								foreach($arrayUser as $gk=>$gv){
									echo '<option value="'.$gv["UserID"].'" '.($MemberID==$gv["UserID"]?'selected="selected"':'').'>'.$gv["UserName"].'</option>';
								}
								echo '</select>';
						}
						echo '</div>';
						?>
					</div>
				</div>
				<?php if(count($DataGroup)>0){?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<?php
						echo '<label class="field select">';
							echo '<select name="selectGroup" data-rule-required="true" data-msg-required="Select Group">';
							echo '<option value=""> - - Select Group - - </option>';
							foreach($DataGroup as $gk=>$gv){
								echo '<option value="'.$gv["ID"].'" '.($InType==$gv["ID"]?'selected="selected"':'').'>'.$gv["Name"].'</option>';
							}
							echo '</select>';
							echo '<i class="arrow"></i>';
						echo '</label>';
						?>
					</div>
				</div>
				<?php }?>
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
										  echo '<input type="checkbox" class="checkLang" name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" title="'.$lkey.'" value="Off" '.($LangDisable[$lkey]?'checked':'').'>';
										  echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
										echo '</div>';
									}
									?>
									<div class="form-group">
										<div class="col-md-12">
											<h4>Brand</h4>
										</div>
									</div>
					        <div class="form-group">
					            <div class="col-md-12">
					                <div class="section">
					                    <label class="field prepend-icon">
					                        <input type="text" name="<?php echo "inputSubject01".$lkey?>" data-rule-required="true" class="gui-input" value="" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
					                        <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
					                    </label>
					                </div>
					            </div>
					        </div>
									<div class="form-group">
										<div class="col-md-12">
											<h4>Product Name</h4>
										</div>
									</div>
									<div class="form-group">
					            <div class="col-md-12">
					                <div class="section">
					                    <label class="field prepend-icon">
					                        <input type="text" name="<?php echo "inputSubject02".$lkey?>" data-rule-required="true" class="gui-input" value="" data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
					                        <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
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
					        <!-- Text Areas -->
									</div>
								</div>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="showrecommend mb10 mt10"><span><?php echo "Product photos showing branding or labels/Product brochures and packaging samples"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label">Product image</label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "product";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataImg.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadPicture.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["filetype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" accept="image/*" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["imagestype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
						</div>
					</div>
				</div>
				<div class="showrecommend mb10"><span><?php echo "List of food ingredients by type of request for use/Renewal of thai select mark"?></span></div>
				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 mt10">
						<div class="bs-component">
							<?php
							$typeUpload = "renewal";
							echo '<input name="saveData'.$typeUpload.'" type="hidden" value="'.$saveDataFile_1.'" >';
							echo '<input name="PathAtt'.$typeUpload.'" type="hidden" value="'.$PathUploadFile.'" >';
							echo '<input name="UploadTo'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["fileupload"].'" >';
							echo '<input name="UploadFileType'.$typeUpload.'" type="hidden" value="'.$defaultdata[$Login_MenuID]["filetype"].'" >';
							echo '<table class="boxuploadfile">';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
									echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td class="colright">';
									echo '<div class="postuploadicon">';
										echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
											echo '<img src="./images/uploadnow.jpg" alt="" />';
										echo '</label>';
										echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
									echo '</div>';
									echo '<div class="Recommended">Recommended : extention file '.$defaultdata[$Login_MenuID]["filetype"].'</div>';
									echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
								echo '</td>';
							echo '</tr>';
							echo '</table>';
							?>
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
